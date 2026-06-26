<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalPay extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'employee_id',
        'company_id',
        'termination_date',
        'last_working_day',
        'reason',
        'outstanding_salary',
        'accrued_leave_pay',
        'notice_pay',
        'severance_pay',
        'gross_total',
        'tax',
        'nasfund',
        'outstanding_loans',
        'other_deductions',
        'net_total',
        'status',
    ];

    protected $casts = [
        'termination_date' => 'date',
        'last_working_day' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}