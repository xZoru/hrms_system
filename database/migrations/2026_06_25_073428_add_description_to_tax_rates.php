<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            if (!Schema::hasColumn('tax_rates', 'description')) {
                $table->string('description')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tax_rates', function (Blueprint $table) {
            if (Schema::hasColumn('tax_rates', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};