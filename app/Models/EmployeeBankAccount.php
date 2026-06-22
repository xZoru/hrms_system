<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'account_name',
        'account_number',
        'bank_name',
        'bsb_code',
        'is_preferred',
        'is_active'
    ];

    protected $casts = [
        'is_preferred' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}