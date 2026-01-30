<?php

namespace App\Livewire\Dashboard\Harga;

use App\Models\PaketPenerbit;
use Livewire\Component;
use Livewire\WithPagination;

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

    public function getTrashedPackages()
    {
        $query = PaketPenerbit::onlyTrashed();

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        }

        switch ($this->sortBy) {
            case 'oldest':
                $query->orderBy('deleted_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama', 'desc');
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
        $package = PaketPenerbit::onlyTrashed()->find($this->selectedId);

        if ($package) {
            $package->restore();
            $this->dispatch('notify', message: 'Paket berhasil dipulihkan!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmRestore');
    }

    public function confirmForceDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmForceDelete');
    }

    public function updatePositions($deletedPosition) 
    {
        PaketPenerbit::where('position', '>', $deletedPosition)
            ->orderBy('position')
            ->each(function ($package) {
                $package->decrement('position');
            });
    }

    public function forceDelete()
    {
        $package = PaketPenerbit::onlyTrashed()->find($this->selectedId);

        if ($package) {
            $deletedPosition = $package->position;
            
            $package->forceDelete();
            
            $this->updatePositions($deletedPosition);
            
            $this->dispatch('notify', message: 'Paket berhasil dihapus permanen!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmForceDelete');
    }

    public function confirmRestoreAll()
    {
        if (PaketPenerbit::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmRestoreAll');
        }
    }

    public function restoreAll()
    {
        try {
            $count = PaketPenerbit::onlyTrashed()->count();
            PaketPenerbit::onlyTrashed()->restore();

            $this->dispatch('notify', message: "$count paket berhasil dipulihkan!", type: 'success');
            $this->dispatch('close-modal', 'confirmRestoreAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat memulihkan paket', type: 'error');
        }
    }

    public function confirmForceDeleteAll()
    {
        if (PaketPenerbit::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmForceDeleteAll');
        }
    }

    public function forceDeleteAll()
    {
        try {
            $packages = PaketPenerbit::onlyTrashed()->orderBy('position')->get();
            $positions = $packages->pluck('position')->toArray();
            $count = $packages->count();

            PaketPenerbit::onlyTrashed()->forceDelete();

            PaketPenerbit::whereIn('position', function($query) use ($positions) {
                $query->select('position')
                    ->from('paket_penerbit')
                    ->whereNotIn('position', $positions)
                    ->where('position', '>', min($positions));
            })->orderBy('position')
                ->each(function($package) use ($positions) {
                    $decrementBy = count(array_filter($positions, function($pos) use ($package) {
                        return $pos < $package->position;
                    }));
                    $package->decrement('position', $decrementBy);
                });

            $this->dispatch('notify', message: "$count paket berhasil dihapus permanen!", type: 'success');
            $this->dispatch('close-modal', 'confirmForceDeleteAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat menghapus paket', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.harga.tempat-sampah', [
            'trashedPackages' => $this->getTrashedPackages()
        ]);
    }
}