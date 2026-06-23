<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('workshift')->nullable()->after('department');
            $table->string('allowance')->nullable()->after('hourly_rate');
            $table->string('default_pay')->nullable()->after('allowance');
            $table->string('nasfund_collect')->default('NO')->after('default_pay');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['workshift', 'allowance', 'default_pay', 'nasfund_collect']);
        });
    }
};