<?php

namespace App\Livewire\Dashboard\Buku;

use App\Models\Buku;
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

    public function getTrashedBooks()
    {
        $query = Buku::onlyTrashed();

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('isbn', 'like', '%' . $this->search . '%');
            });
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
        $buku = Buku::onlyTrashed()->find($this->selectedId);

        if ($buku) {
            $buku->restore();
            $this->dispatch('notify', message: 'Buku berhasil dipulihkan!', type: 'success');
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
        $buku = Buku::onlyTrashed()->find($this->selectedId);

        if ($buku) {
            // Delete image files
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            if ($buku->cover_thumbnail) {
                Storage::disk('public')->delete($buku->cover_thumbnail);
            }

            $buku->forceDelete();

            $this->dispatch('notify', message: 'Buku berhasil dihapus permanen!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmForceDelete');
    }

    public function confirmRestoreAll()
    {
        if (Buku::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmRestoreAll');
        }
    }

    public function restoreAll()
    {
        try {
            $count = Buku::onlyTrashed()->count();
            Buku::onlyTrashed()->restore();

            $this->dispatch('notify', message: "$count buku berhasil dipulihkan!", type: 'success');

            $this->dispatch('close-modal', 'confirmRestoreAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat memulihkan buku', type: 'error');
        }
    }

    public function confirmForceDeleteAll()
    {
        if (Buku::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmForceDeleteAll');
        }
    }

    public function forceDeleteAll()
    {
        try {
            $books = Buku::onlyTrashed()->get();

            foreach ($books as $book) {
                if ($book->cover) {
                    Storage::disk('public')->delete($book->cover);
                }
                if ($book->cover_thumbnail) {
                    Storage::disk('public')->delete($book->cover_thumbnail);
                }
            }

            $count = $books->count();
            Buku::onlyTrashed()->forceDelete();

            $this->dispatch('notify', message: "$count buku berhasil dihapus permanen!", type: 'success');

            $this->dispatch('close-modal', 'confirmForceDeleteAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat menghapus buku', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.buku.tempat-sampah', [
            'trashedBooks' => $this->getTrashedBooks()
        ]);
    }
}
