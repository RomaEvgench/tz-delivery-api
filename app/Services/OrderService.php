<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Jobs\CancelDeliveringOrderJob;
use App\Jobs\CancelNewOrderJob;
use App\Models\Order;
use App\Repositories\CargoRepository;
use App\Repositories\DeliveryPointRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PickupPointRepository;
use App\Repositories\ReturnPointRepository;
use Illuminate\Support\Collection;

class OrderService
{
    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly DeliveryPointRepository $deliveryPointRepository,
        private readonly CargoRepository $cargoRepository,
        private readonly GeocoderService $geocoderService,
        private readonly PickupPointRepository $pickupPointRepository,
        private readonly ReturnPointRepository $returnPointRepository
    ) {

    }

    public function cansel($id): string
    {
        $order = $this->orderRepository->getOrder($id, false);
        $message = "Заказ отменен";

        switch ($order->status) {
            case OrderStatusEnum::CREATED->value:
                dispatch(new CancelNewOrderJob($order));
                break;
            case OrderStatusEnum::DELIVERING->value:
                dispatch(new CancelDeliveringOrderJob($order));
                break;
            case OrderStatusEnum::COMPLETED->value:
                $message = "Заказ уже был выполнен";
                break;
            default:
                $message = "Неизвестный статус заказа";
                break;
        }

        return $message;
    }

    public function getOrder($id): Order
    {
        return $this->orderRepository->getOrder($id, true);
    }

    public function getAllOrders(): Collection
    {
        return $this->orderRepository->getAllOrders();
    }

    public function store($data)
    {
        $deliveriesData = $data['deliveries'];
        $returnPointData = $data['return_point'];
        $pickupPointData = $data['pickup_point'];

        unset($data['deliveries']);
        unset($data['return_point']);
        unset($data['pickup_point']);

        $data['price'] = intval($data['price']);
        $order = $this->orderRepository->create($data);
        $pickupPointAddress = $pickupPointData['address'];
        $pickupPointCoordinates
            = $this->geocoderService->getCoordinates($pickupPointAddress);

        $returnPointAddress = $returnPointData['address'];
        $returnPointCoordinates
            = $this->geocoderService->getCoordinates($returnPointAddress);

        $this->pickupPointRepository->create($pickupPointData,
            $pickupPointCoordinates, $order->id);
        $this->returnPointRepository->create($returnPointData,
            $returnPointCoordinates, $order->id);

        foreach ($deliveriesData as $deliveryData) {
            $deliveryPointAddress = $deliveryData['address'];
            $deliveryPointCoordinates
                = $this->geocoderService->getCoordinates($deliveryPointAddress);

            $delivery
                = $this->deliveryPointRepository->create($deliveryPointCoordinates,
                $deliveryData, $order->id);

            foreach ($deliveryData['cargo'] as $cargoData) {
                $this->cargoRepository->create($cargoData, $delivery->id,
                    $order->id);
            }
        }

        $order->load('cargos', 'deliveryPoints', 'pickupPoint', 'returnPoint');
        return $order;
    }
}
