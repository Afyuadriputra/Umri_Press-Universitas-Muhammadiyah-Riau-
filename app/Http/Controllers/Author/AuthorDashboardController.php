<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\DirectOrder;
use App\Models\RoyaltyTransaction;
use Illuminate\Support\Facades\Auth;

class AuthorDashboardController extends Controller
{
    public function index()
    {
        $author = Auth::user()?->author;
        if (! $author) {
            abort(403, 'Author profile not found.');
        }

        $totalIncome = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'credit')
            ->sum('amount');

        $totalPaid = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'debit')
            ->where('status', 'paid')
            ->sum('amount');

        $availableCredits = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'credit')
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $reservedDebits = RoyaltyTransaction::where('author_id', $author->id)
            ->where('type', 'debit')
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->sum('amount');

        $availableBalance = $availableCredits - $reservedDebits;

        $recentTransactions = RoyaltyTransaction::where('author_id', $author->id)
            ->latest()
            ->take(10)
            ->get();

        $dateExpression = $this->monthlyDateExpression();
        $monthlySales = RoyaltyTransaction::selectRaw($dateExpression . " as month, SUM(amount) as total")
            ->where('author_id', $author->id)
            ->where('type', 'credit')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $books = $author->buku()
            ->withCount([
                'directOrders as completed_orders_count' => function ($query) {
                    $query->where('status', DirectOrder::STATUS_COMPLETED);
                }
            ])
            ->withSum([
                'directOrders as completed_revenue' => function ($query) {
                    $query->where('status', DirectOrder::STATUS_COMPLETED);
                }
            ], 'harga_setelah_diskon')
            ->get();

        return view('author.index', [
            'title' => 'Dashboard Royalti',
            'author' => $author,
            'totalIncome' => $totalIncome,
            'totalPaid' => $totalPaid,
            'availableBalance' => $availableBalance,
            'recentTransactions' => $recentTransactions,
            'monthlySales' => $monthlySales,
            'books' => $books,
        ]);
    }

    private function monthlyDateExpression(): string
    {
        $driver = \DB::getDriverName();

        return $driver === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";
    }
}
