<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\DirectOrder;
use Illuminate\Support\Facades\Auth;

class AuthorSalesController extends Controller
{
    public function index()
    {
        $author = Auth::user()?->author;
        if (! $author) {
            abort(403, 'Author profile not found.');
        }

        $sales = DirectOrder::with('buku')
            ->where('status', DirectOrder::STATUS_COMPLETED)
            ->whereHas('buku.authors', function ($query) use ($author) {
                $query->where('authors.id', $author->id);
            })
            ->latest()
            ->paginate(20);

        return view('author.sales.index', [
            'title' => 'Penjualan',
            'sales' => $sales,
        ]);
    }
}
