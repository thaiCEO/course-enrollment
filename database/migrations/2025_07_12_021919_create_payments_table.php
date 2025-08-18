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
        Schema::create('payments', function (Blueprint $table) {

            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->string('status', 20);
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->timestamp('paid_at')->nullable();

            $table->foreignId('created_by_admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('updated_by_admin_id')->nullable()->constrained('admins'); // no onDelete cascade

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
