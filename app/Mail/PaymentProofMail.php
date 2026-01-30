<?php

namespace App\Mail;

use App\Models\DirectOrder;
use App\Models\PaymentMethod;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PaymentProofMail extends Mailable
{
    use Queueable, SerializesModels;

    public DirectOrder $order;
    public ?PaymentMethod $paymentMethod;
    public ?string $proofPath;
    public ?string $proofUrl;

    public function __construct(DirectOrder $order, ?PaymentMethod $paymentMethod, ?string $proofPath, ?string $proofUrl)
    {
        $this->order = $order;
        $this->paymentMethod = $paymentMethod;
        $this->proofPath = $proofPath;
        $this->proofUrl = $proofUrl;
    }

    public function build()
    {
        $email = $this->subject('Bukti Pembayaran Pesanan #' . $this->order->id)
            ->view('emails.payment-proof');

        if ($this->proofPath && Storage::disk('public')->exists($this->proofPath)) {
            $email->attach(Storage::disk('public')->path($this->proofPath));
        }

        return $email;
    }
}
