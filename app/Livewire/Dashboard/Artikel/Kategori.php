<?php

namespace App\Livewire\Dashboard\Artikel;

use App\Models\KategoriArtikel;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Kategori extends Component
{
    use WithPagination;

    public $name = '';
    public $slug = '';
    public $search = '';
    public $selectedId;
    public $editingCategoryId;

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'slug' => 'required|unique:kategori_artikel,slug,' . $this->editingCategoryId
        ];
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'categoryModal');
    }

    public function edit($id)
    {
        $this->editingCategoryId = $id;
        $category = KategoriArtikel::find($id);
        
        if ($category) {
            $this->name = $category->nama;
            $this->slug = $category->slug;
        }
        
        $this->dispatch('open-modal', 'categoryModal');
    }

    public function save()
    {
        $this->validate();

        try {
            KategoriArtikel::updateOrCreate(
                ['id' => $this->editingCategoryId],
                [
                    'nama' => $this->name,
                    'slug' => $this->slug
                ]
            );

            $this->dispatch('notify', message: 'Kategori berhasil disimpan!', type: 'success');

            $this->dispatch('close-modal', 'categoryModal');
            $this->resetForm();

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    public function confirmDelete($id)
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'confirmDelete');
    }

    public function delete()
    {
        try {
            $category = KategoriArtikel::findOrFail($this->selectedId);
            
            if ($category->artikel()->count() > 0) {
                throw new \Exception('Kategori tidak dapat dihapus karena masih memiliki artikel.');
            }
            
            $category->delete();
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Kategori berhasil dihapus!'
            ]);

            $this->dispatch('close-modal', 'confirmDelete');
            $this->selectedId = null;

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Terjadi kesalahan: ' . $e->getMessage(), type: 'error');
        }
    }

    private function resetForm()
    {
        $this->editingCategoryId = null;
        $this->name = '';
        $this->slug = '';
    }

    public function getCategories()
    {
        $query = KategoriArtikel::withCount('artikel');

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.dashboard.artikel.kategori', [
            'categories' => $this->getCategories()
        ]);
    }
}