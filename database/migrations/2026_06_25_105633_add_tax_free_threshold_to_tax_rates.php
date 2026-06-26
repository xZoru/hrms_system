<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            // Add tax_free_threshold if it doesn't exist
            if (!Schema::hasColumn('tax_rates', 'tax_free_threshold')) {
                $table->decimal('tax_free_threshold', 15, 2)->default(0)->after('fixed_tax');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            if (Schema::hasColumn('tax_rates', 'tax_free_threshold')) {
                $table->dropColumn('tax_free_threshold');
            }
        });
    }
};