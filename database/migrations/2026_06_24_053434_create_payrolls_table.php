<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('fortnight_number');
            $table->integer('year');
            $table->date('period_start');
            $table->date('period_end');
            $table->date('payment_date')->nullable();
            $table->enum('status', ['draft', 'processing', 'completed', 'paid'])->default('draft');
            $table->decimal('total_gross', 15, 2)->default(0);
            $table->decimal('total_tax', 15, 2)->default(0);
            $table->decimal('total_nasfund_ee', 15, 2)->default(0);
            $table->decimal('total_nasfund_er', 15, 2)->default(0);
            $table->decimal('total_net', 15, 2)->default(0);
            $table->integer('employee_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};