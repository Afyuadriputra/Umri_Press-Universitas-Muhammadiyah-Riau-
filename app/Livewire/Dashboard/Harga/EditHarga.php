<?php

namespace App\Livewire\Dashboard\Harga;

use App\Models\PaketPenerbit;
use Livewire\Component;
use Illuminate\Support\Str;

class EditHarga extends Component
{
    public $paketId;
    public $nama;
    public $deskripsi;
    public $active;
    public $slug;

    protected $listeners = ['set-konten' => 'setKonten'];

    protected function rules()
    {
        return [
            'nama' => 'required|string|min:3|max:255',
            'deskripsi' => 'required|string|min:10',
            'active' => 'boolean',
        ];
    }

    protected $messages = [
        'nama.required' => 'Nama paket harus diisi.',
        'nama.min' => 'Nama paket minimal 3 karakter.',
        'deskripsi.required' => 'Deskripsi paket harus diisi.',
        'deskripsi.min' => 'Deskripsi paket minimal 10 karakter.',
    ];

    public function setKonten($content)
    {
        if (is_array($content) && isset($content['content'])) {
            $this->deskripsi = $content['content'];
        } else {
            $this->deskripsi = $content;
        }
    }

    public function mount($slug)
    {
        $paket = PaketPenerbit::where('slug', $slug)->firstOrFail();
        $this->paketId = $paket->id;
        $this->nama = $paket->nama;
        $this->deskripsi = $paket->deskripsi;
        $this->active = $paket->active;
        $this->slug = $paket->slug;
    }

    public function save()
    {
        $this->validate();

        try {
            $paket = PaketPenerbit::find($this->paketId);

            $paket->update([
                'nama' => $this->nama,
                'slug' => $this->generateSlug($this->nama),
                'deskripsi' => $this->deskripsi,
                'active' => $this->active
            ]);

            session()->flash('success', 'Paket berhasil diperbarui!');
            return $this->redirect(route('semuaPaket'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('notify', message: "Gagal memperbarui paket. {$e->getMessage()}", type: 'error');
        }
    }

    private function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = PaketPenerbit::where('slug', 'like', "$slug%")->count();

        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }

    public function render()
    {
        return view('livewire.dashboard.harga.edit-harga');
    }
}