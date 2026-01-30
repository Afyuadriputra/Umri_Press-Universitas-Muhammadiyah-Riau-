<?php

namespace App\Livewire\Home;

use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TokoBuku extends Component
{
    use WithPagination;

    public $search = '';
    public $year = '';
    public $sortBy = 'newest';
    public $selectedBook = null;
    public $marketplaceLinks = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'year' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
    ];

    public function showDetail($slug)
    {
        $this->selectedBook = Buku::where('slug', $slug)->firstOrFail();
        $this->dispatch('open-modal', 'detailModal');
    }

    public function showMarketplaces($slug)
    {
        $book = Buku::where('slug', $slug)->firstOrFail();
        $this->marketplaceLinks = json_decode($book->marketplace_links, true);
        $this->selectedBook = $book;
        $this->dispatch('open-modal', 'marketplacesModal');
    }

    public function getBooks()
    {
        $query = Buku::where('status', true);

        if ($this->year) {
            $yearValue = $this->year;
            if (is_string($yearValue) && preg_match('/^\d{4}-\d{2}$/', $yearValue)) {
                $yearValue = substr($yearValue, 0, 4);
            }

            if (preg_match('/^\d{4}$/', (string) $yearValue)) {
                $query->whereYear('tanggal_terbit', (int) $yearValue);
            }
        }

        // Search
        if ($this->search) {
            $search = trim($this->search);
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('isbn', 'like', '%' . $this->search . '%');

                if (preg_match('/^\d{4}$/', $search)) {
                    $q->orWhereYear('tanggal_terbit', (int) $search);
                }
            });
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('judul', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('judul', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate(20);
    }

    public function getYears(): array
    {
        $driver = DB::getDriverName();
        $yearSelect = $driver === 'sqlite'
            ? "strftime('%Y', tanggal_terbit) as year"
            : 'YEAR(tanggal_terbit) as year';

        return Buku::where('status', true)
            ->selectRaw($yearSelect)
            ->whereNotNull('tanggal_terbit')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter()
            ->values()
            ->all();
    }

    public function render()
    {
        return view('livewire.home.toko-buku', [
            'books' => $this->getBooks(),
            'years' => $this->getYears(),
        ]);
    }
}
