<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('standard_hours_per_fortnight')->default(84);
            $table->timestamps();
        });

        DB::table('companies')->insert([
            ['name' => 'Larkin Enterprises Ltd - Port Moresby', 'code' => 'LE-POM', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => 'Larkin Enterprises Ltd - Lae', 'code' => 'LE-LAE', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => 'Ad Focus', 'code' => 'ADFOCUS', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => 'Yellow Jacket Security Ltd - Port Moresby', 'code' => 'YJ-POM', 'standard_hours_per_fortnight' => 144, 'created_at' => now()],
            ['name' => 'Yellow Jacket Security Ltd - Lae', 'code' => 'YJ-LAE', 'standard_hours_per_fortnight' => 144, 'created_at' => now()],
            ['name' => 'Wave Restaurant', 'code' => 'WAVE', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => "Caroline's Diner", 'code' => 'CAROLINE', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => 'Paragon Tech Limited', 'code' => 'PARAGON', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => 'Le Ferge Investments', 'code' => 'LEFERGE', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
            ['name' => 'Hive', 'code' => 'HIVE', 'standard_hours_per_fortnight' => 84, 'created_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};