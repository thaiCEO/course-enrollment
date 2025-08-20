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
        Schema::create('study_times', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('room_id'); // link to room

            // Day type: weekday or weekend
            $table->enum('day_type', ['weekday', 'weekend']); 
            
            $table->time('start_time');
            $table->time('end_time');
            
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('course_id')
                  ->references('id')
                  ->on('courses')
                  ->onDelete('cascade');

            $table->foreign('room_id')
                  ->references('id')
                  ->on('rooms')
                  ->onDelete('cascade');
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('study_times');
    }


};
