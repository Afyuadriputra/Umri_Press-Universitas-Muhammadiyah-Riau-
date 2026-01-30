<?php

namespace App\Livewire\Dashboard\Harga;

use App\Models\PaketPenerbit;
use Livewire\Component;
use Livewire\WithPagination;

class SemuaHarga extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'position';
    public $selectedId;
    public $trashCount = 0;

    public function mount()
    {
        $this->trashCount = PaketPenerbit::onlyTrashed()->count();
    }

    public function getPackages()
    {
        return PaketPenerbit::when($this->search, function ($query) {
            $query->where('nama', 'like', '%' . $this->search . '%');
        })
            ->when($this->sortBy, function ($query) {
                switch ($this->sortBy) {
                    case 'newest':
                        $query->latest();
                        break;
                    case 'oldest':
                        $query->oldest();
                        break;
                    case 'name_asc':
                        $query->orderBy('nama', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('nama', 'desc');
                        break;
                    default:
                        $query->orderBy('position');
                }
            })
            ->paginate(10);
    }

    public function updateOrder($items)
    {
        foreach ($items as $item) {
            PaketPenerbit::find($item['value'])->update([
                'position' => $item['order']
            ]);
        }

        $this->dispatch('notify', message: 'Urutan paket berhasil diperbarui!', type: 'success');
    }

    public function toggleActive($id)
    {
        $package = PaketPenerbit::find($id);
        $package->active = !$package->active;
        $package->save();

        $this->dispatch('notify', message: 'Status paket berhasil diperbarui!', type: 'success');
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete()
    {
        $package = PaketPenerbit::find($this->selectedId);

        if ($package) {
            $package->delete();
            $this->dispatch('notify', message: 'Paket berhasil dihapus!', type: 'success');

            $this->trashCount = PaketPenerbit::onlyTrashed()->count();
        }

        $this->dispatch('close-modal', 'confirmDelete');
    }

    public function render()
    {
        return view('livewire.dashboard.harga.semua-harga', [
            'packages' => $this->getPackages()
        ]);
    }
}
