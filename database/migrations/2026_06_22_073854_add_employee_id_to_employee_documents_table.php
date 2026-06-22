<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix employee_leave_records
        if (Schema::hasTable('employee_leave_records') && !Schema::hasColumn('employee_leave_records', 'employee_id')) {
            Schema::table('employee_leave_records', function (Blueprint $table) {
                $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            });
        }

        // Fix employee_loans
        if (Schema::hasTable('employee_loans') && !Schema::hasColumn('employee_loans', 'employee_id')) {
            Schema::table('employee_loans', function (Blueprint $table) {
                $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            });
        }

        // Fix loan_payments
        if (Schema::hasTable('loan_payments') && !Schema::hasColumn('loan_payments', 'employee_loan_id')) {
            Schema::table('loan_payments', function (Blueprint $table) {
                $table->foreignId('employee_loan_id')->nullable()->constrained('employee_loans')->onDelete('cascade');
            });
        }

        // Fix employee_pay_increases
        if (Schema::hasTable('employee_pay_increases') && !Schema::hasColumn('employee_pay_increases', 'employee_id')) {
            Schema::table('employee_pay_increases', function (Blueprint $table) {
                $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            });
        }

        // Fix discipline_records
        if (Schema::hasTable('discipline_records') && !Schema::hasColumn('discipline_records', 'employee_id')) {
            Schema::table('discipline_records', function (Blueprint $table) {
                $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            });
        }

        // Fix payrolls
        if (Schema::hasTable('payrolls') && !Schema::hasColumn('payrolls', 'employee_id')) {
            Schema::table('payrolls', function (Blueprint $table) {
                $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        // Remove the columns if needed
        if (Schema::hasTable('payrolls') && Schema::hasColumn('payrolls', 'employee_id')) {
            Schema::table('payrolls', function (Blueprint $table) {
                $table->dropForeign(['employee_id']);
                $table->dropColumn('employee_id');
            });
        }
        // Add similar drops for other tables if needed
    }
};