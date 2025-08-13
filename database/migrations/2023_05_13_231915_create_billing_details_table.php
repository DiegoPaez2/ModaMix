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
        Schema::create('billing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('country')->nullable();
            $table->string('billing_address');
            $table->string('city')->nullable();
            $table->string('parroquia_barrio')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('payment_method');
            $table->text('order_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_details');
    }
};
