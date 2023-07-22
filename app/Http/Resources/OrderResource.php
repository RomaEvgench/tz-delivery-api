<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'status' => $this->status,
            'cargos' => CargoResource::collection($this->cargos),
            'deliveryPoints' => DeliveryPointResource::collection($this->deliveryPoints),
            'pickupPoint' => new PickupPointResource($this->pickupPoint),
            'returnPoint' => new ReturnPointResource ($this->returnPoint),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
