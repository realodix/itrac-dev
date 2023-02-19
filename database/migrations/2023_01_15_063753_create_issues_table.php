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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('title');
            $table->longText('description');
            $table->foreignId('closed_by')->nullable()
                ->constrained('users');
            $table->dateTime('closed_at')->nullable();
            $table->foreignId('locked_by')->nullable()
                ->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
