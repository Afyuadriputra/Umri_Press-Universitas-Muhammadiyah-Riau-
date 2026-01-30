<?php

namespace App\Livewire\Dashboard\Artikel;

use App\Models\Artikel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class TempatSampah extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'newest';
    public $selectedId;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'newest']
    ];

    public function getTrashedArticles()
    {
        $query = Artikel::onlyTrashed();

        // Search
        if ($this->search) {
            $query->where('judul', 'like', '%' . $this->search . '%');
        }

        // Sorting
        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('deleted_at', 'asc');
                break;
            case 'title_asc':
                $query->orderBy('judul', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('judul', 'desc');
                break;
            default:
                $query->orderBy('deleted_at', 'desc');
                break;
        }

        return $query->paginate(10);
    }

    public function confirmRestore($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmRestore');
    }

    public function restore()
    {
        $article = Artikel::onlyTrashed()->find($this->selectedId);

        if ($article) {
            $article->restore();
            $this->dispatch('notify', message: 'Artikel berhasil dipulihkan!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmRestore');
    }

    public function confirmForceDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmForceDelete');
    }

    public function forceDelete()
    {
        $article = Artikel::onlyTrashed()->find($this->selectedId);

        if ($article) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            if ($article->thumbnail) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            $article->forceDelete();

            $this->dispatch('notify', message: 'Artikel berhasil dihapus permanen!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmForceDelete');
    }

    public function confirmRestoreAll()
    {
        if (Artikel::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmRestoreAll');
        }
    }

    public function restoreAll()
    {
        try {
            $count = Artikel::onlyTrashed()->count();
            Artikel::onlyTrashed()->restore();

            $this->dispatch('notify', message: "$count artikel berhasil dipulihkan!", type: 'success');

            $this->dispatch('close-modal', 'confirmRestoreAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat memulihkan artikel', type: 'error');
        }
    }

    public function confirmForceDeleteAll()
    {
        if (Artikel::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmForceDeleteAll');
        }
    }

    public function forceDeleteAll()
    {
        try {
            $articles = Artikel::onlyTrashed()->get();

            foreach ($articles as $article) {
                if ($article->image) {
                    Storage::disk('public')->delete($article->image);
                }
                if ($article->thumbnail) {
                    Storage::disk('public')->delete($article->thumbnail);
                }
            }

            $count = $articles->count();
            Artikel::onlyTrashed()->forceDelete();

            $this->dispatch('notify', message: "$count artikel berhasil dihapus permanen!", type: 'success');

            $this->dispatch('close-modal', 'confirmForceDeleteAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat menghapus artikel', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.artikel.tempat-sampah', [
            'trashedArticles' => $this->getTrashedArticles()
        ]);
    }
}