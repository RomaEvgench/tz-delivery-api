<?php

namespace App\Repositories;

use App\Models\PickupPoint;

class PickupPointRepository
{
    public function create($data, $pickupPointCoordinates, $orderId) : void
    {
        PickupPoint::create([
            'latitude' => $pickupPointCoordinates[1],
            'longitude' => $pickupPointCoordinates[0],
            'address' => $data['address'],
            'sender_name' => $data['sender_name'],
            'sender_phone' => $data['sender_phone'],
            'order_id' => $orderId,
        ]);
    }

}
