<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add company_id if it doesn't exist
            if (!Schema::hasColumn('users', 'company_id')) {
                $table->foreignId('company_id')->nullable()->constrained('companies')->onDelete('set null');
            }

            // Add role if it doesn't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['super_admin', 'admin', 'hr_manager', 'payroll_officer', 'employee'])->default('employee');
            }

            // Add allowed_companies if it doesn't exist
            if (!Schema::hasColumn('users', 'allowed_companies')) {
                $table->json('allowed_companies')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop columns if they exist
            if (Schema::hasColumn('users', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'allowed_companies')) {
                $table->dropColumn('allowed_companies');
            }
        });
    }
};