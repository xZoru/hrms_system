<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Employee extends Model
{
    use HasFactory;
    protected $connection = 'mysql';

    protected $fillable = [
        'employee_number',
        'company_id',
        'classification_id',
        'full_name',
        'position',
        'gender',
        'department',
        'photo',
        'date_of_birth',
        'joining_date',
        'end_date',
        'base_salary',
        'hourly_rate',
        'nasfund_number',
        'nasfund_dependents',
        'marital_status',
        'deployment_date',
        'passport_number',
        'passport_expiry_date',
        'work_permit_number',
        'work_permit_expiry_date',
        'visa_number',
        'visa_expiry_date',
        'is_active',
        'payment_method',
        'workshift',
        'allowance',
        'default_pay',
        'nasfund_collect',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'end_date' => 'date',
        'deployment_date' => 'date',
        'passport_expiry_date' => 'date',
        'work_permit_expiry_date' => 'date',
        'visa_expiry_date' => 'date',
        'is_active' => 'boolean',
        'nasfund_dependents' => 'array',
        'base_salary' => 'decimal:2',
        'hourly_rate' => 'decimal:2',
    ];

    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->age;
        }
        return null;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function classification()
    {
        return $this->belongsTo(EmployeeClassification::class, 'classification_id');
    }

    public function bankAccounts()
    {
        return $this->hasMany(EmployeeBankAccount::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function leaveRecords()
    {
        return $this->hasMany(EmployeeLeaveRecord::class);
    }

    public function loans()
    {
        return $this->hasMany(EmployeeLoan::class);
    }

    public function payIncreases()
    {
        return $this->hasMany(EmployeePayIncrease::class);
    }

    public function disciplineRecords()
    {
        return $this->hasMany(DisciplineRecord::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function getPrimaryBankAccount()
    {
        return $this->bankAccounts()->where('is_preferred', true)->first();
    }

    public function isExpatriate()
    {
        return $this->classification_id === 2;
    }

    public function isNational()
    {
        return $this->classification_id === 1;
    }

    public function getLeaveBalance()
    {
        $monthsWorked = Carbon::parse($this->joining_date)->diffInMonths(now());
        $earned = floor($monthsWorked / 1.5);
        $taken = $this->leaveRecords()->where('leave_type', 'annual')->sum('days_taken');
        $balance = min($earned, 9) - $taken;
        return max(0, $balance);
    }
}