<?php

namespace App\Livewire\Dashboard\Tim;

use App\Models\Tim;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class SemuaTim extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedId;
    public $trashCount = 0;

    public function mount()
    {
        $this->trashCount = Tim::onlyTrashed()->count();
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            Tim::find($item['value'])->update(['position' => $item['order']]);
        }

        $this->dispatch('notify', message: 'Urutan tim berhasil diperbarui!', type: 'success');
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete()
    {
        $tim = Tim::find($this->selectedId);

        if ($tim) {
            $tim->delete();
            $this->dispatch('notify', message: 'Tim berhasil dihapus.', type: 'success');
        }

        $this->trashCount = Tim::onlyTrashed()->count();

        $this->dispatch('close-modal', 'confirmDelete');
    }

    public function getTeamMembers()
    {
        return Tim::when($this->search, function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('jabatan', 'like', '%' . $this->search . '%');
        })
            ->orderBy('position')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.tim.semua-tim', [
            'teamMembers' => $this->getTeamMembers()
        ]);
    }
}
