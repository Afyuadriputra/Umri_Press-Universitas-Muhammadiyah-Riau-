<?php

namespace App\Actions;

use App\Models\DirectOrder;
use App\Models\RoyaltyTransaction;
use Illuminate\Support\Facades\DB;

class CalculateRoyaltyAction
{
    public function execute(DirectOrder $order): void
    {
        $order->loadMissing(['buku.authors']);

        if (! $order->buku) {
            return;
        }

        $price = (float) ($order->harga_setelah_diskon ?? 0);
        if ($price <= 0) {
            return;
        }

        $authors = $order->buku->authors;
        if ($authors->isEmpty()) {
            return;
        }

        DB::transaction(function () use ($order, $authors, $price) {
            foreach ($authors as $author) {
                $percent = (float) ($author->pivot->royalty_percentage ?? 0);
                if ($percent <= 0) {
                    continue;
                }

                $amount = round($price * ($percent / 100), 2);
                if ($amount <= 0) {
                    continue;
                }

                RoyaltyTransaction::firstOrCreate(
                    [
                        'author_id' => $author->id,
                        'order_id' => $order->id,
                        'type' => 'credit',
                    ],
                    [
                        'amount' => $amount,
                        'status' => 'pending',
                        'description' => "Royalti buku {$order->buku->judul} #ORDER-{$order->id}",
                    ]
                );
            }
        });
    }
}
