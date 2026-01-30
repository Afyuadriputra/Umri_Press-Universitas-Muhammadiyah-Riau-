<?php

namespace App\Livewire\Home\Artikel;

use App\Models\Artikel;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $articles = Artikel::with(['kategori', 'user'])
        ->where('status', 'publish')
        ->latest()
        ->paginate(10);
        
        return view('livewire.home.artikel.index', [
            'articles' => $articles
        ]);
    }
}
