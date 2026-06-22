<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('employee_classifications')->insert([
            ['name' => 'National Employee', 'code' => 'NAT', 'description' => 'Tax calculated directly from wages', 'created_at' => now()],
            ['name' => 'Expatriate Employee', 'code' => 'EXP', 'description' => 'Tax calculated from net wages and added to gross wage', 'created_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_classifications');
    }
};