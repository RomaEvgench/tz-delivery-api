<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;


class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service
    ) {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $offset = (int)$request->get('offset');
        $limit = (int)$request->get('limit');
        $status = $request->get('status');

        $dateStart = $request->get('date_start')
            ? Carbon::parse(str_replace(' ', '+',
                $request->get('date_start')))->utc()->format('Y-m-d H:i:s')
            : null;
        $dateEnd = $request->get('date_end') ? Carbon::parse(str_replace(' ',
            '+',
            $request->get('date_end')))->utc()->format('Y-m-d H:i:s') : null;

        $orders = $this->service->getAllOrders($offset, $limit, $status,
            $dateStart, $dateEnd);

        return OrderResource::collection($orders);
    }

    public function cansel($id): JsonResponse
    {
        $message = $this->service->cansel($id);
        return response()->json($message);
    }

    public function store(StoreRequest $request): OrderResource|JsonResponse
    {
        $data = $request->validated();
        $order = $this->service->store($data);
        return new OrderResource($order);
    }

    public function getOrder($id): OrderResource
    {
        $order = $this->service->getOrder($id);
        return new OrderResource($order);
    }
}
