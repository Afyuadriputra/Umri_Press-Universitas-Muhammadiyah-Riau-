<?php

namespace App\Livewire\Dashboard\Tim;

use App\Models\Tim;
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

    public function getTrashedTeam()
    {
        $query = Tim::onlyTrashed();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('jabatan', 'like', '%' . $this->search . '%');
            });
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
        $tim = Tim::onlyTrashed()->find($this->selectedId);

        if ($tim) {
            $tim->restore();
            $this->dispatch('notify', message: 'Anggota tim berhasil dipulihkan!', type: 'success');
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
        // Get all active team members with position greater than the deleted position
        Tim::where('position', '>', $deletedPosition)
            ->orderBy('position')
            ->each(function ($tim) {
                $tim->decrement('position');
            });
    }

    public function forceDelete()
    {
        $tim = Tim::onlyTrashed()->find($this->selectedId);

        if ($tim) {
            $deletedPosition = $tim->position;

            if ($tim->foto) {
                Storage::disk('public')->delete($tim->foto);
            }

            $tim->forceDelete();

            // Update positions after deletion
            $this->updatePositions($deletedPosition);

            $this->dispatch('notify', message: 'Anggota tim berhasil dihapus permanen!', type: 'success');
        }

        $this->dispatch('close-modal', 'confirmForceDelete');
    }

    public function confirmRestoreAll()
    {
        if (Tim::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmRestoreAll');
        }
    }

    public function restoreAll()
    {
        try {
            $count = Tim::onlyTrashed()->count();
            Tim::onlyTrashed()->restore();

            $this->dispatch('notify', message: "$count anggota tim berhasil dipulihkan!", type: 'success');
            $this->dispatch('close-modal', 'confirmRestoreAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat memulihkan tim', type: 'error');
        }
    }

    public function confirmForceDeleteAll()
    {
        if (Tim::onlyTrashed()->count() > 0) {
            $this->dispatch('open-modal', 'confirmForceDeleteAll');
        }
    }

    public function forceDeleteAll()
    {
        try {
            $teams = Tim::onlyTrashed()->orderBy('position')->get();
            $positions = $teams->pluck('position')->toArray();

            foreach ($teams as $tim) {
                if ($tim->foto) {
                    Storage::disk('public')->delete($tim->foto);
                }
            }

            $count = $teams->count();
            Tim::onlyTrashed()->forceDelete();

            Tim::whereIn('position', function ($query) use ($positions) {
                $query->select('position')
                    ->from('tim')
                    ->whereNotIn('position', $positions)
                    ->where('position', '>', min($positions));
            })->orderBy('position')
                ->each(function ($tim) use ($positions) {
                    $decrementBy = count(array_filter($positions, function ($pos) use ($tim) {
                        return $pos < $tim->position;
                    }));
                    $tim->decrement('position', $decrementBy);
                });

            $this->dispatch('notify', message: "$count anggota tim berhasil dihapus permanen!", type: 'success');
            $this->dispatch('close-modal', 'confirmForceDeleteAll');
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan saat menghapus tim ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.tim.tempat-sampah', [
            'trashedTeam' => $this->getTrashedTeam()
        ]);
    }
}
