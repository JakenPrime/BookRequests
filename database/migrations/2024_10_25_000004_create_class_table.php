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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('name')->nullable();
            $table->string('department')->nullable();
            $table->timestamps();
        });

        Schema::create('classes', function(Blueprint $table){
            $table->id();
            $table->string('class_id')->nullable();

            $table->integer('course_id');
            $table->foreign('course_id')
                ->references('id')
                ->on('courses');

            $table->integer('school_year');
            $table->foreign('school_year')
                ->references('id')
                ->on('school_years'); 

            $table->integer('teacher_id');
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users');

            $table->integer('students');
            $table->integer('max');
            $table->timestamps();
        });

        Schema::create('school_years', function(Blueprint $table){
            $table->id();
            $table->string('year');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_years');

        Schema::dropIfExists('classes');

        Schema::dropIfExists('courses');
    }
};
