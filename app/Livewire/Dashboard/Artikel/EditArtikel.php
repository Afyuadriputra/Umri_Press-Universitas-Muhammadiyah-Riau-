<?php

namespace App\Livewire\Dashboard\Artikel;

use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditArtikel extends Component
{
    use WithFileUploads;

    public $artikel;
    public $articleId;
    public $image;
    public $thumbnail;
    public $judul = '';
    public $slug = '';
    public $konten = '';
    public $kategori_id;
    public $draft = false;
    public $categories;
    public $oldImage;
    public $oldThumbnail;

    protected $listeners = ['set-konten' => 'setKonten'];

    protected function rules()
    {
        return [
            'image' => 'nullable|image|max:2048',
            'thumbnail' => 'nullable|image|max:1024',
            'judul' => 'required|min:3',
            'slug' => 'required|unique:artikel,slug,' . $this->articleId,
            'konten' => 'required|min:100',
            'kategori_id' => 'required',
        ];
    }

    public function mount(Artikel $artikel)
    {
        $this->artikel = $artikel;
        $this->articleId = $artikel->id;
        $this->judul = $artikel->judul;
        $this->slug = $artikel->slug;
        $this->konten = $artikel->konten;
        $this->kategori_id = $artikel->kategori_id;
        $this->draft = $artikel->status === 'draft';
        $this->oldImage = $artikel->image;
        $this->oldThumbnail = $artikel->thumbnail;
        $this->categories = KategoriArtikel::all();
    }

    public function updatedJudul($value)
    {
        if ($this->judul !== $value) {
            $baseSlug = Str::slug($value);
            $slug = $baseSlug;
            $counter = 1;

            while (Artikel::where('slug', $slug)->where('id', '!=', $this->articleId)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $this->slug = $slug;
        }
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
                if ($this->oldImage) {
                    Storage::disk('public')->delete($this->oldImage);
                }
                $imagePath = $this->image->store('assets/img/artikel', 'public');
            }

            if ($this->thumbnail) {
                if ($this->oldThumbnail) {
                    Storage::disk('public')->delete($this->oldThumbnail);
                }
                $thumbnailPath = $this->thumbnail->store('assets/img/artikel/thumbnails', 'public');
            }

            $this->artikel->update([
                'judul' => $this->judul,
                'slug' => $this->slug,
                'konten' => $this->konten,
                'kategori_id' => $this->kategori_id,
                'status' => $this->draft ? 'draft' : 'publish',
                'image' => $this->image ? $imagePath : $this->oldImage,
                'thumbnail' => $this->thumbnail ? $thumbnailPath : $this->oldThumbnail,
            ]);

            session()->flash('success', 'Artikel berhasil diperbarui!');
            return $this->redirect(route('semuaArtikel'));
        } catch (\Exception $e) {
            $this->dispatch('notify', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.artikel.edit-artikel');
    }
}
