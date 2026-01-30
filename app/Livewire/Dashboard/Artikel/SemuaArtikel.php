<?php

namespace App\Livewire\Dashboard\Artikel;

use App\Models\Artikel;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class SemuaArtikel extends Component
{
    use WithPagination;

    public $selectedArticle = null;
    public $search = '';
    public $sortBy = 'newest';
    public $status = '';
    public $selectedId;
    public $trashCount = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
        'status' => ['except' => ''],
    ];

    public function mount()
    {
        $this->trashCount = Artikel::onlyTrashed()->count();
    }

    public function getArticles()
    {
        $query = Artikel::with(['user', 'kategori']);

        // Search
        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        // Status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
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

        return $query->paginate(10);
    }

    public function changeStatus($slug)
    {
        $article = Artikel::where('slug', $slug)->first();
        if ($article) {
            $article->status = $article->status === 'publish' ? 'draft' : 'publish';
            $article->save();

            $this->dispatch('notify', message: "Status artikel berhasil diubah!", type: "success");
        }
    }

    public function showDetail($slug)
    {
        $this->selectedArticle = Artikel::with(['user', 'kategori'])->where('slug', $slug)->first();
        $this->dispatch('open-modal', 'detailModal');
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete()
    {
        $article = Artikel::find($this->selectedId);
        
        if ($article) {
            $article->delete();
            
            $this->dispatch('notify', message: "Artikel berhasil dihapus!", type: "success");
        }

        $this->dispatch('close-modal', 'confirmDelete');
        $this->selectedId = null;
        $this->trashCount = Artikel::onlyTrashed()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.artikel.semua-artikel', [
            'articles' => $this->getArticles()
        ]);
    }
}