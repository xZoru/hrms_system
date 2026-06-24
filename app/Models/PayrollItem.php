<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'payroll_id',
        'employee_id',
        'regular_hours',
        'overtime_hours',
        'hourly_rate',
        'regular_pay',
        'overtime_pay',
        'holiday_pay',
        'sunday_pay',
        'allowance',
        'gross_pay',
        'tax',
        'nasfund_enabled',
        'nasfund_ee',
        'nasfund_er',
        'loan_deduction',
        'net_pay',
        'payment_method',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}