<?php

use App\Enums\CargoStatusEnum;
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
        Schema::create('cargos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->integer('weight');
            $table->string('size');
            $table->enum('status', CargoStatusEnum::values())->default(CargoStatusEnum::UNDELIVERED->value);

            $table->uuid('order_id');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->uuid('delivery_point_id');
            $table->foreign('delivery_point_id')->references('id')->on('delivery_points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
