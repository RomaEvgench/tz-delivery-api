<?php

namespace App\Http\Controllers;

use App\Services\OrderService;


class BaseController extends Controller
{
    public OrderService $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

}
