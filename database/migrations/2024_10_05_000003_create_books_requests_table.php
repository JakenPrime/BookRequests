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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('publisher');
            $table->string('isbn')->unique();
            $table->foreignId('notes_id')
                ->nullable()
                ->constrained('notes');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('orders', function(Blueprint $table){
            $table->id();
            $table->integer('status')->default(0);
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->integer('class_id');
            $table->foreign('class_id')
                ->references('id')
                ->on('classes');
            $table->foreignId('notes_id')
                ->nullable()
                ->constrained('notes');
            $table->timestamps();
        });

        Schema::create('book_requests', function(Blueprint $table){
            $table->id();
            $table->integer('book_id');
            $table->foreign('book_id')
                ->references('id')
                ->on('books');
            $table->integer('order_id');
            $table->foreign('order_id')
                ->references('id')
                ->on('orders');
            $table->integer('quantity');
            $table->integer('ordered')->default(0);
            $table->string('date')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('book_requests', function (Blueprint $table){
        //     $table->dropForeign('book_id');
        //     $table->dropForeign('request_id');
        // });
        Schema::dropIfExists('book_requests');

        Schema::dropIfExists('books');

        // Schema::table('requests', function (Blueprint $table){
        //     $table->dropForeign('teacher_id');            
        // });
        Schema::dropIfExists('orders');
    }
};
