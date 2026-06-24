<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee_bank_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('employee_bank_accounts', 'employee_id')) {
                $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('employee_bank_accounts', 'account_name')) {
                $table->string('account_name');
            }
            if (!Schema::hasColumn('employee_bank_accounts', 'account_number')) {
                $table->string('account_number');
            }
            if (!Schema::hasColumn('employee_bank_accounts', 'bank_name')) {
                $table->string('bank_name');
            }
            if (!Schema::hasColumn('employee_bank_accounts', 'bsb_code')) {
                $table->string('bsb_code')->nullable();
            }
            if (!Schema::hasColumn('employee_bank_accounts', 'is_preferred')) {
                $table->boolean('is_preferred')->default(false);
            }
            if (!Schema::hasColumn('employee_bank_accounts', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('employee_bank_accounts', function (Blueprint $table) {
            $table->dropColumn([
                'employee_id', 'account_name', 'account_number', 
                'bank_name', 'bsb_code', 'is_preferred', 'is_active'
            ]);
        });
    }
};