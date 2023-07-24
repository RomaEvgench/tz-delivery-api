<?php

namespace App\Repositories;

use App\Models\ReturnPoint;

class ReturnPointRepository
{
    public function create($data, $returnPointCoordinates, $orderId): void
    {
        ReturnPoint::create([
            'latitude' => $returnPointCoordinates[1],
            'longitude' => $returnPointCoordinates[0],
            'address' => $data['address'],
            'receiver_name' => $data['receiver_name'],
            'receiver_phone' => $data['receiver_phone'],
            'order_id' => $orderId,
        ]);
    }

}
