<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Company;
use App\Models\TaxRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    /**
     * Calculate payroll for a single employee
     * Both nationals and expats use the same tax table
     */
    public function calculatePayroll($employee, $periodStart, $periodEnd, $overtimeHours = 0, $sundayHours = 0, $holidayHours = 0, $leavePay = 0, $otherAllowances = 0, $cashAdvance = 0, $otherDeductions = 0)
    {
        $company = Company::on('mysql')->find($employee->company_id);
        $standardHours = $company->standard_hours_per_fortnight ?? 84;

        $monthlyRate = ($employee->monthly_rate ?? 0) + ($employee->pay_raise ?? 0);
        $fortnightlyRate = $monthlyRate * 12 / 26;
        $hourlyRate = $fortnightlyRate / $standardHours;

        $fnRate = $fortnightlyRate;
        $basicPay = $fnRate;
        $regularPay = $basicPay;

        $overtimePay = $overtimeHours * ($hourlyRate * 1.5);
        $sundayPay = $sundayHours * ($hourlyRate * 2);
        $holidayPay = $holidayHours * ($hourlyRate * 2);
        $leavePay = $leavePay;
        $otherAllowances = $otherAllowances;

        $grossTotal = $regularPay + $overtimePay + $sundayPay + $holidayPay + $leavePay + $otherAllowances;

        $npfPercent = 6.00;
        $nasfundEnabled = $employee->nasfund_collect !== 'NO';
        $ncsl = $nasfundEnabled ? $grossTotal * ($npfPercent / 100) : 0;
        $nasfundER = $nasfundEnabled ? $grossTotal * 0.084 : 0;

        // TAX CALCULATION - SAME FOR BOTH NATIONAL AND EXPAT
        // Tax is calculated on FN RATE (fortnightly rate), not gross total
        $tax = $this->calculateTax($employee, $fnRate);

        $netPay = $grossTotal - $tax - $ncsl - $cashAdvance - $otherDeductions;

        return [
            'employee_id' => $employee->id,
            'fn_rate' => $fnRate,
            'basic_pay' => $basicPay,
            'regular_pay' => $regularPay,
            'overtime_pay' => $overtimePay,
            'sunday_pay' => $sundayPay,
            'holiday_pay' => $holidayPay,
            'leave_pay' => $leavePay,
            'other_allowances' => $otherAllowances,
            'gross_pay' => $grossTotal,
            'tax' => $tax,
            'npf_percent' => $npfPercent,
            'ncsl' => $ncsl,
            'nasfund_ee' => $ncsl,
            'nasfund_er' => $nasfundER,
            'cash_advance' => $cashAdvance,
            'other_deductions' => $otherDeductions,
            'net_pay' => $netPay,
            'payment_method' => $employee->payment_method,
        ];
    }

    /**
     * Calculate tax based on FN RATE
     * SAME for both National and Expatriate employees
     * 
     * PNG Tax Table (Fortnightly):
     * - 0%: 0 - 769.00
     * - 30%: 769.01 - 1,269.00
     * - 35%: 1,269.01 - 2,692.00
     * - 40%: 2,692.01 - 9,615.00
     * - 42%: 9,615.01+
     */
public function calculateTax($employee, $grossPay)
{
    $taxRates = TaxRate::where('is_active', true)
        ->where(function ($query) use ($employee) {
            $query->where('company_id', $employee->company_id)
                ->orWhere('is_global', true);
        })
        ->orderBy('min_income')
        ->get();

    if ($taxRates->isEmpty()) {
        return $this->getDefaultTax($grossPay);
    }

    $tax = 0;
    foreach ($taxRates as $rate) {
        // Check if gross pay falls in this bracket
        if ($grossPay > $rate->min_income && ($rate->max_income === null || $grossPay <= $rate->max_income)) {
            // Calculate tax using tax_free_threshold
            if ($grossPay > $rate->tax_free_threshold) {
                $tax = ($grossPay - $rate->tax_free_threshold) * ($rate->rate / 100);
            } else {
                $tax = 0;
            }
            break;
        }
    }

    return max(0, round($tax, 2));
}

    /**
     * Default PNG Tax Table
     * Used when no tax rates exist in database
     * SAME for both National and Expatriate
     */
    private function getDefaultTax($grossPay)
    {
        // PNG Tax Table based on FN RATE (fortnightly pay)
        // Tax-free threshold: K769.00 per fortnight
        
        if ($grossPay <= 769) {
            // 0% bracket
            return 0;
        } elseif ($grossPay <= 1269) {
            // 30% bracket
            return round(($grossPay - 769) * 0.30, 2);
        } elseif ($grossPay <= 2692) {
            // 35% bracket
            return round(($grossPay - 769) * 0.35, 2);
        } elseif ($grossPay <= 9615) {
            // 40% bracket
            return round(($grossPay - 769) * 0.40, 2);
        } else {
            // 42% bracket
            return round(($grossPay - 769) * 0.42, 2);
        }
    }

    public function generateFortnightNumber($date)
    {
        $year = $date->format('y');
        $weekOfYear = $date->weekOfYear;
        $fortnight = ceil($weekOfYear / 2);
        return $year . str_pad($fortnight, 2, '0', STR_PAD_LEFT);
    }

    public function processPayroll($companyId, $periodStart, $periodEnd, $selectedEmployees = [])
    {
        return DB::transaction(function () use ($companyId, $periodStart, $periodEnd, $selectedEmployees) {
            $company = Company::on('mysql')->findOrFail($companyId);

            $fortnightNumber = $this->generateFortnightNumber($periodStart);
            $year = $periodStart->year;

            $payroll = Payroll::on('mysql')->forceCreate([
                'company_id' => $companyId,
                'fortnight_number' => $fortnightNumber,
                'year' => $year,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'status' => 'processing',
            ]);

            $query = Employee::on('mysql')
                ->where('company_id', $companyId)
                ->where('is_active', true);

            if (!empty($selectedEmployees)) {
                $query->whereIn('id', $selectedEmployees);
            }

            $employees = $query->get();

            $totalGross = 0;
            $totalTax = 0;
            $totalNasfundEE = 0;
            $totalNasfundER = 0;
            $totalNet = 0;

            foreach ($employees as $employee) {
                $result = $this->calculatePayroll($employee, $periodStart, $periodEnd);

                PayrollItem::on('mysql')->create(array_merge($result, [
                    'payroll_id' => $payroll->id,
                    'payment_method' => $employee->payment_method,
                ]));

                $totalGross += $result['gross_pay'];
                $totalTax += $result['tax'];
                $totalNasfundEE += $result['ncsl'];
                $totalNasfundER += $result['nasfund_er'];
                $totalNet += $result['net_pay'];
            }

            $payroll->update([
                'total_gross' => $totalGross,
                'total_tax' => $totalTax,
                'total_nasfund_ee' => $totalNasfundEE,
                'total_nasfund_er' => $totalNasfundER,
                'total_net' => $totalNet,
                'employee_count' => $employees->count(),
                'status' => 'completed',
            ]);

            return $payroll;
        });
    }
}