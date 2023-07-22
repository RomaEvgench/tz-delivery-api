<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrderRepository
{
    public function getOrder($id, $loadRelations)
    {
        $query = Order::where('id', $id);

        if ($loadRelations) {
            $query->with('cargos', 'deliveryPoints', 'pickupPoint',
                'returnPoint');
        }

        return $query->firstOrFail();
    }

    public function getAllOrders(): Collection
    {
        return Order::with([
            'cargos',
            'deliveryPoints',
            'pickupPoint',
            'returnPoint'
        ])->get();
    }

    public function create($data): Order
    {
        $order = new Order($data);
        $order->save();
        $order->refresh();
        return $order;
    }
}
