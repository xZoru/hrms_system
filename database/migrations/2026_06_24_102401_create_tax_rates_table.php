<?php
// database/migrations/2026_06_26_create_tax_rates_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->string('annual_description')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->decimal('min_income', 15, 2)->default(0);
            $table->decimal('max_income', 15, 2)->nullable();
            $table->decimal('rate', 5, 2)->default(0);
            $table->decimal('fixed_tax', 15, 2)->default(0);
            $table->decimal('tax_free_threshold', 15, 2)->default(0);
            $table->date('effective_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_global')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_rates');
    }
};