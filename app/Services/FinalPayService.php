<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\FinalPay;
use App\Models\PayrollItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinalPayService
{
    public function calculateFinalPay($employeeId, $terminationDate, $lastWorkingDay, $reason = null)
    {
        return DB::transaction(function () use ($employeeId, $terminationDate, $lastWorkingDay, $reason) {
            $employee = Employee::on('mysql')->findOrFail($employeeId);
            $company = $employee->company;

            $monthlyRate = ($employee->monthly_rate ?? 0) + ($employee->pay_raise ?? 0);
            $dailyRate = $monthlyRate / 26;

            $lastPayroll = PayrollItem::on('mysql')
                ->where('employee_id', $employeeId)
                ->orderBy('created_at', 'desc')
                ->first();

            $outstandingSalary = $this->calculateOutstandingSalary($employee, $lastPayroll, $terminationDate);
            $accruedLeave = 0;
            $noticePay = 0;
            $severancePay = 0;

            $grossFinalPay = $outstandingSalary + $accruedLeave + $noticePay + $severancePay;
            $tax = $this->calculateFinalTax($grossFinalPay);
            $nasfund = $grossFinalPay * 0.06;
            $outstandingLoans = 0;

            $totalDeductions = $tax + $nasfund + $outstandingLoans;
            $netFinalPay = $grossFinalPay - $totalDeductions;

            $finalPay = FinalPay::on('mysql')->create([
                'employee_id' => $employeeId,
                'company_id' => $employee->company_id,
                'termination_date' => $terminationDate,
                'last_working_day' => $lastWorkingDay,
                'reason' => $reason,
                'outstanding_salary' => $outstandingSalary,
                'accrued_leave_pay' => $accruedLeave,
                'notice_pay' => $noticePay,
                'severance_pay' => $severancePay,
                'gross_total' => $grossFinalPay,
                'tax' => $tax,
                'nasfund' => $nasfund,
                'outstanding_loans' => $outstandingLoans,
                'other_deductions' => 0,
                'net_total' => $netFinalPay,
                'status' => 'draft',
            ]);

            return $finalPay;
        });
    }

    private function calculateOutstandingSalary($employee, $lastPayroll, $terminationDate)
    {
        if (!$lastPayroll) {
            $startDate = Carbon::parse($employee->joining_date);
            $daysWorked = $startDate->diffInDays(Carbon::parse($terminationDate));
            return ($employee->monthly_rate / 26) * ($daysWorked / 14);
        }

        $lastPayrollEnd = Carbon::parse($lastPayroll->created_at);
        $daysSinceLastPayroll = $lastPayrollEnd->diffInDays(Carbon::parse($terminationDate));
        $dailyRate = ($employee->monthly_rate ?? 0) / 26;

        return $dailyRate * ($daysSinceLastPayroll / 14);
    }

    private function calculateFinalTax($amount)
    {
        $taxRates = [
            ['min' => 0, 'max' => 20000, 'rate' => 0, 'fixed' => 0],
            ['min' => 20000, 'max' => 33000, 'rate' => 30, 'fixed' => 0],
            ['min' => 33000, 'max' => 70000, 'rate' => 35, 'fixed' => 3900],
            ['min' => 70000, 'max' => 250000, 'rate' => 40, 'fixed' => 16850],
            ['min' => 250000, 'max' => null, 'rate' => 42, 'fixed' => 88850],
        ];

        $tax = 0;
        foreach ($taxRates as $rate) {
            if ($amount > $rate['min']) {
                $taxable = $rate['max']
                    ? min($amount, $rate['max']) - $rate['min']
                    : $amount - $rate['min'];
                $tax = $rate['fixed'] + ($taxable * ($rate['rate'] / 100));
            }
        }

        return $tax;
    }
}