<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            if (!Schema::hasColumn('tax_rates', 'fixed_tax')) {
                $table->decimal('fixed_tax', 15, 2)->default(0)->after('rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->dropColumn('fixed_tax');
        });
    }
};