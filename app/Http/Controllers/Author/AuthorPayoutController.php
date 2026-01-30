<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use App\Models\RoyaltyTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorPayoutController extends Controller
{
    public function index()
    {
        $author = Auth::user()?->author;
        if (! $author) {
            abort(403, 'Author profile not found.');
        }

        $availableCredits = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'credit')
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $reservedDebits = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'debit')
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->sum('amount');

        $availableBalance = $availableCredits - $reservedDebits;

        $payouts = PayoutRequest::where('author_id', $author->id)
            ->latest()
            ->paginate(15);

        return view('author.payouts.index', [
            'title' => 'Pencairan',
            'author' => $author,
            'availableBalance' => $availableBalance,
            'payouts' => $payouts,
        ]);
    }

    public function store(Request $request)
    {
        $author = Auth::user()?->author;
        if (! $author) {
            abort(403, 'Author profile not found.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        if (! $author->bank_name || ! $author->bank_account_name || ! $author->bank_account_number) {
            return back()->withErrors(['amount' => 'Lengkapi info rekening terlebih dahulu.']);
        }

        $availableCredits = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'credit')
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $reservedDebits = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'debit')
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->sum('amount');

        $availableBalance = $availableCredits - $reservedDebits;
        $amount = (float) $validated['amount'];

        if ($amount > $availableBalance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi untuk pencairan.']);
        }

        $bankDetails = "{$author->bank_name} - {$author->bank_account_number} a.n {$author->bank_account_name}";

        $payout = PayoutRequest::create([
            'author_id' => $author->id,
            'amount' => $amount,
            'bank_details' => $bankDetails,
            'status' => 'pending',
        ]);

        RoyaltyTransaction::create([
            'author_id' => $author->id,
            'order_id' => null,
            'amount' => $amount,
            'type' => 'debit',
            'status' => 'pending',
            'description' => "Permintaan pencairan #PR-{$payout->id}",
        ]);

        return back()->with('success', 'Permintaan pencairan berhasil dikirim.');
    }
}
