<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $fillable = [
        'company_id',
        'fortnight_number',
        'year',
        'period_start',
        'period_end',
        'payment_date',
        'status',
        'total_gross',
        'total_tax',
        'total_nasfund_ee',
        'total_nasfund_er',
        'total_net',
        'employee_count',
    ];

    protected $casts = [
        'period_start' => 'date',
        'period_end' => 'date',
        'payment_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'payroll_items');
    }
}