<?php

namespace App\Livewire\Dashboard\Artikel;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class TambahArtikel extends Component
{
    use WithFileUploads;

    public $image;
    public $thumbnail;
    public $judul = '';
    public $slug = '';
    public $konten = '';
    public $kategori_id;
    public $draft = false;
    public $categories;

    protected $listeners = ['set-konten' => 'setKonten'];

    protected function rules()
    {
        return [
            'image' => 'required|image|max:2048',
            'thumbnail' => 'nullable|image|max:1024',
            'judul' => 'required|min:3',
            'slug' => 'required|unique:artikel,slug',
            'konten' => 'required|min:100',
            'kategori_id' => 'required',
        ];
    }

    protected $messages = [
        'image.required' => 'Gambar artikel harus diunggah.',
        'image.image' => 'File harus berupa gambar.',
        'image.max' => 'Ukuran gambar maksimal 2MB.',
        'judul.required' => 'Judul artikel harus diisi.',
        'judul.min' => 'Judul artikel minimal 3 karakter.',
        'konten.required' => 'Konten artikel harus diisi.',
        'konten.min' => 'Konten artikel minimal 100 karakter.',
        'kategori_id.required' => 'Kategori harus dipilih.',
    ];

    public function mount()
    {
        $this->categories = KategoriArtikel::all();
    }

    public function updatedJudul($value)
    {
        $this->slug = Str::slug($value);
    }

    public function setKonten($content)
    {
        if (is_array($content) && isset($content['content'])) {
            $this->konten = $content['content'];
        } else {
            $this->konten = $content; 
        }
    }

    public function save()
    {
        $this->validate();

        try {
            if ($this->image) {
                $imagePath = $this->image->store('assets/img/artikel', 'public');
            }

            if ($this->thumbnail) {
                $thumbnailPath = $this->thumbnail->store('assets/img/artikel/thumbnails', 'public');
            } else {
                $thumbnailPath = $imagePath;
            }

            Artikel::create([
                'user_id' => auth()->id(),
                'kategori_id' => $this->kategori_id,
                'judul' => $this->judul,
                'slug' => $this->generateSlug($this->judul),
                'konten' => $this->konten,
                'image' => $imagePath,
                'thumbnail' => $thumbnailPath,
                'status' => $this->draft ? 'draft' : 'publish'
            ]);

            session()->flash('success', 'Artikel berhasil ditambahkan!');
            return $this->redirect(route('semuaArtikel'));

        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    private function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = Artikel::where('slug', 'like', "$slug%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.dashboard.artikel.tambah-artikel');
    }
}