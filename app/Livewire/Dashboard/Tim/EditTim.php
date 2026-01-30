<?php

namespace App\Livewire\Dashboard\Tim;

use App\Models\Tim;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditTim extends Component
{
    use WithFileUploads;

    public $timId;
    public $tim;
    public $nama;
    public $jabatan;
    public $foto;
    public $deskripsi;
    public $instagram;
    public $facebook;
    public $twitter;
    public $linkedin;
    public $oldFoto;

    public function mount($slug)
    {
        $this->tim = Tim::where('slug', $slug)->firstOrFail();
        $this->timId = $this->tim->id;
        $this->nama = $this->tim->nama;
        $this->jabatan = $this->tim->jabatan;
        $this->deskripsi = $this->tim->deskripsi;
        $this->instagram = $this->tim->instagram;
        $this->facebook = $this->tim->facebook;
        $this->twitter = $this->tim->twitter;
        $this->linkedin = $this->tim->linkedin;
        $this->oldFoto = $this->tim->foto;
    }

    protected function rules()
    {
        return [
            'foto' => 'nullable|image|max:2048',
            'nama' => 'required|min:3',
            'jabatan' => 'required',
            'deskripsi' => 'required|min:50',
            'instagram' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            $tim = Tim::findOrFail($this->timId);
            
            $data = [
                'nama' => $this->nama,
                'jabatan' => $this->jabatan,
                'deskripsi' => $this->deskripsi,
                'instagram' => $this->instagram,
                'facebook' => $this->facebook,
                'twitter' => $this->twitter,
                'linkedin' => $this->linkedin,
            ];

            if ($this->foto) {
                if ($tim->foto) {
                    Storage::disk('public')->delete($tim->foto);
                }
                $data['foto'] = $this->foto->store('assets/img/tim', 'public');
            }

            $tim->update($data);

            session()->flash('success', 'Anggota tim berhasil diperbarui!');
            return redirect()->route('semuaTim');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.dashboard.tim.edit-tim');
    }
}