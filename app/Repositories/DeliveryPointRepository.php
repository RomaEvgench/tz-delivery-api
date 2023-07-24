<?php

namespace App\Repositories;

use App\Models\DeliveryPoint;

class DeliveryPointRepository
{
    public function create($deliveryPointCoordinates, $deliveryData, $orderId) : DeliveryPoint
    {
        return DeliveryPoint::create([
            'latitude' => $deliveryPointCoordinates[1],
            'longitude' => $deliveryPointCoordinates[0],
            'address' => $deliveryData['address'],
            'receiver_name' => $deliveryData['receiver_name'],
            'receiver_phone' => $deliveryData['receiver_phone'],
            'order_id' => $orderId,
        ]);
    }

}
