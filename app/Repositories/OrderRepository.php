<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
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

    public function getAllOrders(
        int $offset = 0,
        int $limit = 5,
        string $status = null,
        string $dateStart = null,
        string $dateEnd = null
    ): Collection {
        return Order::with([
            'cargos',
            'deliveryPoints',
            'pickupPoint',
            'returnPoint'
        ])
            ->offset($offset)
            ->limit($limit)
            ->when($status, function (Builder $query) use ($status) {
                $query->where('status', '=', $status);
            })
            ->when($dateStart, function (Builder $query) use ($dateStart) {
                $query->where('created_at', '>=', $dateStart);
            })
            ->when($dateEnd, function (Builder $query) use ($dateEnd) {
                $query->where('created_at', '<=', $dateEnd);
            })
            ->get();
    }

    public function create($data): Order
    {
        $order = new Order($data);
        $order->save();
        $order->refresh();
        return $order;
    }
}
