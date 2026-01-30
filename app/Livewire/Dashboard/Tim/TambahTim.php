<?php

namespace App\Livewire\Dashboard\Tim;

use App\Models\Tim;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class TambahTim extends Component
{
    use WithFileUploads;

    public $nama = '';
    public $jabatan = '';
    public $foto;
    public $deskripsi = '';
    public $instagram;
    public $facebook;
    public $twitter;
    public $linkedin;

    protected function rules()
    {
        return [
            'foto' => 'required|image|max:2048',
            'nama' => 'required|min:3',
            'jabatan' => 'required',
            'deskripsi' => 'required|min:20',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ];
    }

    protected $messages = [
        'foto.required' => 'Foto harus diunggah.',
        'foto.image' => 'File harus berupa gambar.',
        'foto.max' => 'Ukuran foto maksimal 2MB.',
        'nama.required' => 'Nama harus diisi.',
        'nama.min' => 'Nama minimal 3 karakter.',
        'jabatan.required' => 'Jabatan harus diisi.',
        'deskripsi.required' => 'Deskripsi harus diisi.',
        'deskripsi.min' => 'Deskripsi minimal 20 karakter.',
        'instagram.url' => 'URL Instagram tidak valid.',
        'facebook.url' => 'URL Facebook tidak valid.',
        'twitter.url' => 'URL Twitter tidak valid.',
        'linkedin.url' => 'URL LinkedIn tidak valid.',
    ];

    public function save()
    {
        $this->validate();

        try {
            $lastPosition = Tim::max('position') ?? 0;

            Tim::create([
                'nama' => $this->nama,
                'slug' => $this->generateSlug($this->nama),
                'jabatan' => $this->jabatan,
                'foto' => $this->foto->store('assets/img/tim', 'public'),
                'deskripsi' => $this->deskripsi,
                'instagram' => $this->instagram,
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'linkedin' => $this->linkedin,
                'position' => $lastPosition + 1,
            ]);

            session()->flash('success', 'Anggota tim berhasil ditambahkan!');
            return $this->redirect(route('semuaTim'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('notify', message: "Terjadi kesalahan: {$e->getMessage()}", type: 'error');
        }
    }

    private function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = 1;

        while (Tim::where('slug', $slug)->exists()) {
            $slug = Str::slug($name) . '-' . $count;
            $count++;
        }

        return $slug;
    }

    public function render()
    {
        return view('livewire.dashboard.tim.tambah-tim');
    }
}
