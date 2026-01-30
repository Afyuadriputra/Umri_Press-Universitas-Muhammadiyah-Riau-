<?php

namespace App\Observers;

use App\Actions\CalculateRoyaltyAction;
use App\Models\DirectOrder;

class DirectOrderObserver
{
    public function updated(DirectOrder $order): void
    {
        if (! $order->wasChanged('status')) {
            return;
        }

        if ($order->status !== DirectOrder::STATUS_COMPLETED) {
            return;
        }

        $action = app(CalculateRoyaltyAction::class);
        $action->execute($order);
    }
}
