<?php

namespace App\Livewire\Dashboard\Buku;

use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class SemuaBuku extends Component
{
    use WithPagination;

    public $selectedBook = null;
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
        $this->trashCount = Buku::onlyTrashed()->count();
        $this->dispatch('on', 'close-modal', function () {
            $this->selectedBook = null;
        });
    }

    public function getBooks()
    {
        $query = Buku::with('authors');

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                    ->orWhere('isbn', 'like', '%' . $this->search . '%');
            });
        }

        // Status filter
        if ($this->status) {
            if ($this->status === 'active') {
                $query->where('status', 1);
            } elseif ($this->status === 'inactive') {
                $query->where('status', 0);
            }
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
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        return $query->paginate(20);
    }

    public function changeStatus($slug)
    {
        $buku = Buku::where('slug', $slug)->first();
        $buku->status = !$buku->status;
        $buku->save();

        $this->dispatch('notify', message: 'Status buku berhasil diubah mejadi ' . ($buku->status ? 'aktif' : 'tidak aktif'), type: 'success');
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete()
    {
        $buku = Buku::find($this->selectedId);

        if ($buku) {
            $buku->delete();

            $this->dispatch('notify', message: 'Buku berhasil dihapus', type: 'success');
        }

        $this->trashCount = Buku::onlyTrashed()->count();
        $this->dispatch('close-modal', 'confirmDelete');
    }

    public function showDetail($slug)
    {
        $this->selectedBook = Buku::with('authors')->where('slug', $slug)->first();
        $this->dispatch('open-modal', 'detailModal');
    }

    public function edit($id)
    {
        return redirect()->route('editBuku', $id);
    }

    public function render()
    {
        return view('livewire.dashboard.buku.semua-buku', [
            'books' => $this->getBooks()
        ]);
    }
}
