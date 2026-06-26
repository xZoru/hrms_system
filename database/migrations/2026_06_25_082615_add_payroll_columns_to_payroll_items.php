<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('payroll_items', 'fn_rate')) {
                $table->decimal('fn_rate', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'basic_pay')) {
                $table->decimal('basic_pay', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'regular_pay')) {
                $table->decimal('regular_pay', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'sunday_pay')) {
                $table->decimal('sunday_pay', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'holiday_pay')) {
                $table->decimal('holiday_pay', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'leave_pay')) {
                $table->decimal('leave_pay', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'other_allowances')) {
                $table->decimal('other_allowances', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'cash_advance')) {
                $table->decimal('cash_advance', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'other_deductions')) {
                $table->decimal('other_deductions', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'npf_percent')) {
                $table->decimal('npf_percent', 5, 2)->default(6.00);
            }
            if (!Schema::hasColumn('payroll_items', 'ncsl')) {
                $table->decimal('ncsl', 15, 2)->default(0);
            }

            // Only rename if the column exists and the new name doesn't exist
            if (Schema::hasColumn('payroll_items', 'allowance') && !Schema::hasColumn('payroll_items', 'other_allowances')) {
                $table->renameColumn('allowance', 'other_allowances');
            }
            if (Schema::hasColumn('payroll_items', 'loan_deduction') && !Schema::hasColumn('payroll_items', 'cash_advance')) {
                $table->renameColumn('loan_deduction', 'cash_advance');
            }
        });
    }

    public function down(): void
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            $table->dropColumn([
                'fn_rate', 'basic_pay', 'regular_pay', 'sunday_pay', 'holiday_pay',
                'leave_pay', 'other_allowances', 'cash_advance', 'other_deductions',
                'npf_percent', 'ncsl'
            ]);
        });
    }
};