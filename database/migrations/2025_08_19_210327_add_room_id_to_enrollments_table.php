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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->foreignId('room_id')->nullable()->constrained('rooms')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('room_id');
        });
    }
};
