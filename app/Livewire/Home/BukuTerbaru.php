<?php

namespace App\Livewire\Home;

use App\Models\Buku;
use Livewire\Component;
use Livewire\WithPagination;

class BukuTerbaru extends Component
{
    use WithPagination;

    public $selectedBook = null;
    public $marketplaceLinks = null;

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
    
    public function render()
    {
        $books = Buku::where('status', true)
            ->latest()
            ->limit(5)
            ->get();

        return view('livewire.home.buku-terbaru', [
            'books' => $books
        ]);
    }
}
