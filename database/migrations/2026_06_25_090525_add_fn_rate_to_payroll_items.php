<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            if (!Schema::hasColumn('payroll_items', 'fn_rate')) {
                $table->decimal('fn_rate', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('payroll_items', 'basic_pay')) {
                $table->decimal('basic_pay', 15, 2)->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            $table->dropColumn(['fn_rate', 'basic_pay']);
        });
    }
};