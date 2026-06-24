<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function calculatePayroll($employee, $periodStart, $periodEnd)
    {
        $company = $employee->company;
        $standardHours = $company->standard_hours_per_fortnight ?? 84;
        $hourlyRate = $employee->hourly_rate ?? 0;

        $regularPay = $standardHours * $hourlyRate;
        $overtimeHours = 0;
        $overtimePay = $overtimeHours * ($hourlyRate * 1.5);
        $holidayPay = 0;
        $sundayPay = 0;
        $allowance = $employee->allowance ?? 0;

        $grossPay = $regularPay + $overtimePay + $holidayPay + $sundayPay + $allowance;
        $tax = $this->calculateTax($employee, $grossPay);

        $nasfundEnabled = $employee->nasfund_collect !== 'NO';
        $nasfundEE = $nasfundEnabled ? $grossPay * 0.06 : 0;
        $nasfundER = $nasfundEnabled ? $grossPay * 0.084 : 0;
        $loanDeduction = 0;

        $netPay = $grossPay - $tax - $nasfundEE - $loanDeduction;

        return [
            'employee_id' => $employee->id,
            'regular_hours' => $standardHours,
            'overtime_hours' => $overtimeHours,
            'hourly_rate' => $hourlyRate,
            'regular_pay' => $regularPay,
            'overtime_pay' => $overtimePay,
            'holiday_pay' => $holidayPay,
            'sunday_pay' => $sundayPay,
            'allowance' => $allowance,
            'gross_pay' => $grossPay,
            'tax' => $tax,
            'nasfund_enabled' => $nasfundEnabled,
            'nasfund_ee' => $nasfundEE,
            'nasfund_er' => $nasfundER,
            'loan_deduction' => $loanDeduction,
            'net_pay' => $netPay,
        ];
    }

    public function calculateTax($employee, $grossPay)
    {
        $taxRates = [
            ['min' => 0, 'max' => 1000, 'rate' => 0],
            ['min' => 1000, 'max' => 5000, 'rate' => 0.10],
            ['min' => 5000, 'max' => 15000, 'rate' => 0.20],
            ['min' => 15000, 'max' => null, 'rate' => 0.30],
        ];

        $tax = 0;
        foreach ($taxRates as $rate) {
            if ($grossPay > $rate['min']) {
                $taxable = $rate['max'] ? min($grossPay, $rate['max']) - $rate['min'] : $grossPay - $rate['min'];
                $tax += $taxable * $rate['rate'];
            }
        }

        return $tax;
    }

    public function generateFortnightNumber($date)
    {
        $year = $date->format('y');
        $weekOfYear = $date->weekOfYear;
        $fortnight = ceil($weekOfYear / 2);
        return $year . str_pad($fortnight, 2, '0', STR_PAD_LEFT);
    }

    public function processPayroll($companyId, $periodStart, $periodEnd)
    {
        return DB::transaction(function () use ($companyId, $periodStart, $periodEnd) {
            $company = Company::findOrFail($companyId);

            $fortnightNumber = $this->generateFortnightNumber($periodStart);
            $year = $periodStart->year;

            $payroll = Payroll::forceCreate([
                'company_id' => $companyId,
                'fortnight_number' => $fortnightNumber,
                'year' => $year,
                'period_start' => $periodStart,
                'period_end' => $periodEnd,
                'status' => 'processing',
            ]);

            $employees = Employee::where('company_id', $companyId)
                ->where('is_active', true)
                ->get();

            $totalGross = 0;
            $totalTax = 0;
            $totalNasfundEE = 0;
            $totalNasfundER = 0;
            $totalNet = 0;

            foreach ($employees as $employee) {
                $result = $this->calculatePayroll($employee, $periodStart, $periodEnd);

                PayrollItem::create(array_merge($result, [
                    'payroll_id' => $payroll->id,
                    'payment_method' => $employee->payment_method,
                ]));

                $totalGross += $result['gross_pay'];
                $totalTax += $result['tax'];
                $totalNasfundEE += $result['nasfund_ee'];
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