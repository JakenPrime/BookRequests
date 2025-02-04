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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('course');
            $table->string('name');
            $table->integer('students');
            $table->timestamps();
        });

        Schema::create('user_classes', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->integer('class_id');
            $table->foreign('class_id')
                ->references('id')
                ->on('classes');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_classes');

        Schema::dropIfExists('classes');
    }
};
