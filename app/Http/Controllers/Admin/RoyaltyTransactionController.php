<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoyaltyTransaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoyaltyTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = RoyaltyTransaction::with(['author.user', 'order.buku'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->toString());
        }

        if ($request->filled('author')) {
            $author = $request->string('author')->toString();
            $query->whereHas('author', function ($authorQuery) use ($author) {
                $authorQuery->where('name', 'like', '%' . $author . '%');
            });
        }

        if ($request->filled('order')) {
            $query->where('order_id', $request->integer('order'));
        }

        $transactions = $query->paginate(20)->withQueryString();

        return view('dashboard.royalty.index', [
            'title' => 'Royalti Penulis',
            'transactions' => $transactions,
        ]);
    }

    public function update(Request $request, RoyaltyTransaction $transaction)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'paid'])],
        ]);

        $transaction->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status royalti diperbarui.');
    }
}
