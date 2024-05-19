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
        Schema::create('search_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('search_history_id')->constrained('search_histories');
            $table->string('title');
            $table->string('authors')->nullable();
            $table->text('description')->nullable();
            $table->string('info_link');
            $table->string('small_thumbnail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
