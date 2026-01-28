<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->unsignedBigInteger('priority_id')->default(2)->after('category_id');
            $table->dropColumn('priority'); // remove old int column
        });

        // Optional: add foreign key
        Schema::table('todos', function (Blueprint $table) {
            $table->foreign('priority_id')->references('id')->on('priorities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('todos', function (Blueprint $table) {
            $table->integer('priority')->default(2)->after('category_id');
            $table->dropForeign(['priority_id']);
            $table->dropColumn('priority_id');
        });
    }
};
