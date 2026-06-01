<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('genre');
            $table->integer('episodes')->default(0);
            $table->integer('episodes_watched')->default(0);
            $table->enum('status', ['Watching', 'Completed', 'On Hold', 'Dropped', 'Plan to Watch'])->default('Plan to Watch');
            $table->tinyInteger('rating')->nullable()->comment('1-10');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anime_list');
    }
};
