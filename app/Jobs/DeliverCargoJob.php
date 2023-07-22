<?php

namespace App\Jobs;

use App\Enums\CargoStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeliverCargoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $cargo = $this->order->cargos()->where('status', '!=', CargoStatusEnum::DELIVERED->value)->firstOrFail();

        if($cargo) {
            $cargo->update(['status' => CargoStatusEnum::DELIVERED->value]);
        }

        if($this->order->cargos()->where('status', '!=', CargoStatusEnum::DELIVERED->value)->doesntExist()) {
            $this->order->update(['status' => OrderStatusEnum::COMPLETED->value, 'price' => 100]);
        }
    }
}
