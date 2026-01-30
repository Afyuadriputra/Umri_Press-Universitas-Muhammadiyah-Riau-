<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PayoutRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = PayoutRequest::with(['author.user'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('author')) {
            $author = $request->string('author')->toString();
            $query->whereHas('author', function ($authorQuery) use ($author) {
                $authorQuery->where('name', 'like', '%' . $author . '%');
            });
        }

        $payouts = $query->paginate(20)->withQueryString();

        return view('dashboard.payouts.index', [
            'title' => 'Pencairan Penulis',
            'payouts' => $payouts,
        ]);
    }

    public function update(Request $request, PayoutRequest $payout)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'paid'])],
        ]);

        $payout->update([
            'status' => $validated['status'],
        ]);

        return back()->with('success', 'Status pencairan diperbarui.');
    }
}
