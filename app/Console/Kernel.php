<?php

namespace App\Console;

use App\Enums\CargoStatusEnum;
use App\Enums\OrderStatusEnum;
use App\Jobs\DeliverCargoJob;
use App\Jobs\UpdateNewOrdersJob;
use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {

        $schedule->job(new UpdateNewOrdersJob())->everyMinute();

        $schedule->call(function () {
            $orders = Order::where('status', OrderStatusEnum::DELIVERING->value)
                ->whereHas('cargos', function ($query) {
                    $query->where('status', '!=', CargoStatusEnum::DELIVERED->value);
                })->get();

            foreach ($orders as $order) {
                dispatch(new DeliverCargoJob($order));
            }
        })->everyMinute();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
