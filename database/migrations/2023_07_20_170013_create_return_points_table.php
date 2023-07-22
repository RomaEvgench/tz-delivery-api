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
        Schema::create('return_points', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('address');
            $table->string('receiver_name');
            $table->string('receiver_phone');

            $table->uuid('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_points');
    }
};
