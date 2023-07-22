<?php

namespace App\Repositories;

use App\Models\Cargo;

class CargoRepository
{
    public function create($cargoData, $deliveryId, $orderId): void
    {
        Cargo::create([
            'name' => $cargoData['name'],
            'weight' => $cargoData['weight'],
            'size' => $cargoData['size'],
            'delivery_point_id' => $deliveryId,
            'order_id' => $orderId,
        ]);
    }
}
