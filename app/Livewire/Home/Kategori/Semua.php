<?php

namespace App\Livewire\Home\Kategori;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Semua extends Component
{
    use WithPagination;

    public $search = '';
    public $name = '';
    public $slug = '';
    public $editingCategoryId = null;
    public $selectedId = null;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'slug' => 'required|unique:kategori,slug,' . $this->editingCategoryId
        ];
    }

    protected $messages = [
        'name.required' => 'Nama kategori harus diisi.',
        'name.min' => 'Nama kategori minimal 3 karakter.',
        'slug.required' => 'Slug tidak boleh kosong.',
        'slug.unique' => 'Slug sudah digunakan.',
    ];

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
        $category = Kategori::find($id);
        
        if ($category) {
            $this->name = $category->nama; // Changed from name to nama
            $this->slug = $category->slug;
        }
        
        $this->dispatch('open-modal', 'categoryModal');
    }

    public function save()
    {
        $this->validate();

        try {
            Kategori::updateOrCreate(
                ['id' => $this->editingCategoryId],
                [
                    'nama' => $this->name, // Changed from name to nama
                    'slug' => $this->slug
                ]
            );

            $this->dispatch('notify', [
                'type' => 'success',
                'message' => $this->editingCategoryId ? 'Kategori berhasil diperbarui!' : 'Kategori berhasil ditambahkan!'
            ]);

            $this->dispatch('close-modal', 'categoryModal');
            $this->resetForm();

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
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
            $category = Kategori::findOrFail($this->selectedId);
            
            if ($category->buku()->count() > 0) {
                throw new \Exception('Kategori tidak dapat dihapus karena masih memiliki buku.');
            }
            
            $category->delete();
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Kategori berhasil dihapus!'
            ]);

            $this->dispatch('close-modal', 'confirmDelete');
            $this->selectedId = null;

        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
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
        $query = Kategori::with('buku');

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%') 
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
        }

        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.home.kategori.semua', [
            'categories' => $this->getCategories()
        ]);
    }
}