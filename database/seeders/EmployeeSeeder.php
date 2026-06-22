<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Company;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::where('code', 'LE-POM')->first();

        if ($company) {
            Employee::create([
                'employee_number' => 'EMP001',
                'company_id' => $company->id,
                'classification_id' => 1,
                'full_name' => 'John Doe',
                'position' => 'Manager',
                'gender' => 'Male',
                'department' => 'Operations',
                'date_of_birth' => '1990-05-15',
                'joining_date' => '2023-01-01',
                'base_salary' => 3000.00,
                'hourly_rate' => 17.86,
                'nasfund_number' => 'NAS12345',
                'is_active' => true,
                'payment_method' => 'bank_transfer'
            ]);

            Employee::create([
                'employee_number' => 'EMP002',
                'company_id' => $company->id,
                'classification_id' => 2,
                'full_name' => 'Jane Smith',
                'position' => 'Technical Lead',
                'gender' => 'Female',
                'department' => 'IT',
                'date_of_birth' => '1985-08-20',
                'joining_date' => '2023-06-01',
                'deployment_date' => '2023-05-15',
                'base_salary' => 5000.00,
                'hourly_rate' => 29.76,
                'passport_number' => 'P12345',
                'passport_expiry_date' => '2025-12-31',
                'work_permit_number' => 'WP12345',
                'work_permit_expiry_date' => '2025-06-30',
                'visa_number' => 'V12345',
                'visa_expiry_date' => '2025-06-30',
                'marital_status' => 'Married',
                'is_active' => true,
                'payment_method' => 'bank_transfer'
            ]);

            $this->command->info('✅ Sample employees created!');
        }
    }
}