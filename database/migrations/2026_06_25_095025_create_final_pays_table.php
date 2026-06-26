<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_pays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->date('termination_date');
            $table->date('last_working_day');
            $table->string('reason')->nullable();
            $table->decimal('outstanding_salary', 15, 2)->default(0);
            $table->decimal('accrued_leave_pay', 15, 2)->default(0);
            $table->decimal('notice_pay', 15, 2)->default(0);
            $table->decimal('severance_pay', 15, 2)->default(0);
            $table->decimal('gross_total', 15, 2)->default(0);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('nasfund', 15, 2)->default(0);
            $table->decimal('outstanding_loans', 15, 2)->default(0);
            $table->decimal('other_deductions', 15, 2)->default(0);
            $table->decimal('net_total', 15, 2)->default(0);
            $table->enum('status', ['draft', 'completed', 'paid'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_pays');
    }
};