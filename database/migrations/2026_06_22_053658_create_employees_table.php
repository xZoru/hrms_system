<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('classification_id')->constrained('employee_classifications');
            
            $table->string('full_name');
            $table->string('position');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('department')->nullable();
            $table->string('photo')->nullable();
            $table->date('date_of_birth');
            $table->date('joining_date');
            $table->date('end_date')->nullable();
            
            $table->decimal('base_salary', 15, 2)->nullable();
            $table->decimal('hourly_rate', 15, 2)->nullable();
            
            $table->string('nasfund_number')->nullable();
            $table->json('nasfund_dependents')->nullable();
            
            $table->string('marital_status')->nullable();
            $table->date('deployment_date')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->string('work_permit_number')->nullable();
            $table->date('work_permit_expiry_date')->nullable();
            $table->string('visa_number')->nullable();
            $table->date('visa_expiry_date')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->enum('payment_method', ['bank_transfer', 'cash'])->default('bank_transfer');
            
            $table->timestamps();
            
            $table->index(['company_id', 'is_active']);
            $table->index('employee_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};