<?php

namespace App\Repositories;

use App\Models\DeliveryPoint;

class DeliveryPointRepository
{
    public function create($deliveryPointCoordinates, $deliveryData, $orderId) : DeliveryPoint
    {
        return DeliveryPoint::create([
            'latitude' => $deliveryPointCoordinates[0],
            'longitude' => $deliveryPointCoordinates[1],
            'address' => $deliveryData['address'],
            'receiver_name' => $deliveryData['receiver_name'],
            'receiver_phone' => $deliveryData['receiver_phone'],
            'order_id' => $orderId,
        ]);
    }

}
