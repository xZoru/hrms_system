<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLeaveRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'leave_type',
        'leave_date',
        'days_taken',
        'balance_after',
        'reason',
        'status'
    ];

    protected $casts = [
        'leave_date' => 'date',
        'days_taken' => 'decimal:1',
        'balance_after' => 'decimal:1',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}