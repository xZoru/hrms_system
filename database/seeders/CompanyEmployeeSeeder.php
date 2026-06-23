<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CompanyEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $databaseName = 'hrms_' . strtolower(str_replace('-', '_', $company->code));

            Config::set('database.connections.company.database', $databaseName);
            Config::set('database.default', 'company');

            DB::purge('company');
            DB::connection('company')->reconnect();

            $this->command->info("Seeding: {$databaseName}");

            // Check if employees already exist
            $existing = DB::table('employees')->where('employee_number', 'EMP001')->first();

            if (!$existing) {
                DB::table('employees')->insert([
                    [
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
                        'is_active' => true,
                        'payment_method' => 'bank_transfer',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'employee_number' => 'EMP002',
                        'company_id' => $company->id,
                        'classification_id' => 2,
                        'full_name' => 'Jane Smith',
                        'position' => 'Technical Lead',
                        'gender' => 'Female',
                        'department' => 'IT',
                        'date_of_birth' => '1985-08-20',
                        'joining_date' => '2023-06-01',
                        'base_salary' => 5000.00,
                        'hourly_rate' => 29.76,
                        'is_active' => true,
                        'payment_method' => 'bank_transfer',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]);

                $this->command->info("✅ Seeded employees for {$databaseName}");
            } else {
                $this->command->info("⏭️ Skipped {$databaseName} (employees already exist)");
            }
        }
    }
}