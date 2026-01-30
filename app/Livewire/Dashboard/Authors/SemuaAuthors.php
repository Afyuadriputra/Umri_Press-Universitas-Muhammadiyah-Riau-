<?php

namespace App\Livewire\Dashboard\Authors;

use App\Models\Authors;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SemuaAuthors extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortBy = 'newest';
    public $showDeleteModal = false;
    public $authorId;
    public $name;
    public $description;
    public $image;
    public $imagePreview;
    public $user_id;
    public $authorUsers = [];

    protected function rules()
    {
        return [
            'name' => 'required|min:3',
            'description' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'nullable|exists:users,id|unique:authors,user_id',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama penulis harus diisi.',
        'name.min' => 'Nama penulis minimal 3 karakter.',
        'description.required' => 'Deskripsi penulis harus diisi.',
        'description.min' => 'Deskripsi penulis minimal 10 karakter.',
        'image.required' => 'Gambar penulis harus diisi.',
        'image.image' => 'Gambar penulis harus berupa gambar.',
        'image.mimes' => 'Gambar penulis harus berupa gambar (jpeg, png, jpg, gif, svg).',
        'image.max' => 'Gambar penulis maksimal 2MB.',
    ];

    public function save()
    {
        $this->validate();

        try {
            $imageName = Str::slug($this->name) . '-' . time() . '.' . $this->image->getClientOriginalExtension();
            $path = $this->image->storeAs('authors', $imageName, 'public');

            Authors::create([
                'name' => $this->name,
                'slug' => $this->generateSlug($this->name),
                'description' => $this->description,
                'image' => $path,
                'user_id' => $this->user_id ?: null,
            ]);

            $this->syncAuthorRole($this->user_id);

            $this->reset(['name', 'description']);
            $this->dispatch('notify', message: "Penulis berhasil ditambahkan.", type: 'success');
            $this->dispatch('close-modal', 'authorModal');
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('notify', message: "Terjadi kesalahan saat menambahkan penulis.", type: 'error');
            $this->dispatch('close-modal', 'authorModal');
        }
    }

    public function edit($id)
    {
        $author = Authors::find($id);
        $this->authorId = $author->id;
        $this->name = $author->name;
        $this->description = $author->description;
        $this->imagePreview = $author->image;
        $this->user_id = $author->user_id;
    }

    public function update()
    {
        $rules = $this->rules();
        $rules['user_id'] = 'nullable|exists:users,id|unique:authors,user_id,' . $this->authorId;
        $this->validate($rules);

        try {
            $author = Authors::find($this->authorId);

            if ($this->image) {
                if ($author->image) {
                    Storage::disk('public')->delete($author->image);
                }
                $imageName = Str::slug($this->name) . '-' . time() . '.' . $this->image->getClientOriginalExtension();
                $path = $this->image->storeAs('authors', $imageName, 'public');
                $author->image = $path;
            }

            $author->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'image' => $author->image,
                'user_id' => $this->user_id ?: null,
            ]);

            $this->syncAuthorRole($this->user_id);

            $this->reset(['authorId', 'name', 'description']);
            $this->dispatch('close-modal', 'authorModal');
            $this->dispatch('notify', message: "Penulis berhasil diperbarui.", type: 'success');
        } catch (\Exception $e) {
            report($e);
            $this->dispatch('notify', message: "Terjadi kesalahan saat memperbarui penulis.", type: 'error');
            $this->dispatch('close-modal', 'authorModal');
        }

    }

    public function resetForm()
    {
        $this->reset(['authorId', 'name', 'description', 'image', 'imagePreview', 'user_id']);
        $this->resetValidation();
    }

    public function confirmDelete($id)
    {
        $this->authorId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        try {
            $author = Authors::find($this->authorId);
            if ($author->image) {
                Storage::disk('public')->delete($author->image);
            }
            $author->delete();
            $this->reset(['authorId']);
            $this->dispatch('close-modal', 'showDeleteModal');
            $this->dispatch('notify', message: "Penulis berhasil dihapus.", type: 'success');
        } catch (\Exception $e) {
            $this->dispatch('close-modal', 'showDeleteModal');
            $this->dispatch('notify', message: "Terjadi kesalahan saat menghapus penulis.", type: 'error');
        }
    }

    public function closeModal()
    {
        $this->reset(['authorId', 'name', 'description', 'image', 'user_id']);
        $this->resetValidation();
    }

    public function render()
    {
        $query = Authors::with(['user'])->withCount('buku');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $this->authorUsers = User::whereIn('role', ['author', 'user', 'editor'])
            ->where(function ($query) {
                $query->whereDoesntHave('author');
                if ($this->user_id) {
                    $query->orWhere('id', $this->user_id);
                }
            })
            ->orderBy('name')
            ->get(['id', 'name', 'email'])
            ->toArray();

        switch ($this->sortBy) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        return view('livewire.dashboard.authors.semua-authors', [
            'authors' => $query->paginate(10)
        ]);
    }

    private function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = 1;
        while (Authors::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . $count;
            $count++;
        }
        return $slug;
    }

    private function syncAuthorRole(?int $userId): void
    {
        if (! $userId) {
            return;
        }

        $user = User::find($userId);
        if (! $user || $user->role === 'admin') {
            return;
        }

        if ($user->role !== 'author') {
            $user->update(['role' => 'author']);
        }
    }
}
