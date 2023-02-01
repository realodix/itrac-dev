<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('issue_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('type');
            $table->string('action');
            $table->string('old_value')->nullable();
            $table->string('new_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issue_history');
    }
};
