<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends BaseController
{
    public function index(): AnonymousResourceCollection
    {
        $orders = $this->service->getAllOrders();
        return OrderResource::collection($orders);
    }

    public function cansel($id): JsonResponse
    {
        $message = $this->service->cansel($id);
        return response()->json($message);
    }

    public function store(StoreRequest $request): OrderResource
    {
        $data = $request->validated();
        $order = $this->service->store($data);
        return new OrderResource($order);
    }

    public function getOrder($id): JsonResponse
    {
        $order = $this->service->getOrder($id);
        return response()->json($order);
    }

}
