<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('priorities', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Low, Medium, High, etc.
            $table->integer('value'); // optional numeric value for sorting
            $table->timestamps();
        });

        // Seed initial priorities
        DB::table('priorities')->insert([
            ['name' => 'Low', 'value' => 1],
            ['name' => 'Medium', 'value' => 2],
            ['name' => 'High', 'value' => 3],
            ['name' => 'Urgent', 'value' => 4],
            ['name' => 'Critical', 'value' => 5],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('priorities');
    }
};
