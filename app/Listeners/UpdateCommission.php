<?php

namespace App\Listeners;

use App\Events\OrderCommissionProcessed;
use App\Services\CommissionService;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;

class UpdateCommission
{
    /**
     * Create the event listener.
     */
    public function __construct(private CommissionService $commissionService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCommissionProcessed $event): void
    {
        $this->commissionService->calculateCommissions($event->order);
    }
}
