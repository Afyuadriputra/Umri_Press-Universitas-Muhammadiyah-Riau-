<?php

namespace App\Livewire\Dashboard\Sertifikat;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class SemuaSertifikat extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $certificateId;
    public $title = '';
    public $description = '';
    public $file;
    public $currentFile = '';
    public $preview_image;
    public $currentPreview = '';
    public $position;
    public $selectedId;

    protected $listeners = ['refreshCertificates' => '$refresh'];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:500',
            'position' => 'nullable|integer|min:0',
            'file' => [
                Rule::requiredIf(!$this->certificateId),
                'nullable',
                'mimes:pdf',
                'max:10240',
            ],
            'preview_image' => [
                Rule::requiredIf(!$this->certificateId),
                'nullable',
                'image',
                'max:4096',
            ],
        ];
    }

    protected $messages = [
        'title.required' => 'Judul sertifikat wajib diisi.',
        'title.min' => 'Judul minimal 3 karakter.',
        'description.max' => 'Deskripsi maksimal 500 karakter.',
        'file.required' => 'File sertifikat (PDF) wajib diunggah.',
        'file.mimes' => 'File harus berformat PDF.',
        'file.max' => 'Ukuran maksimal file adalah 10MB.',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->dispatch('open-modal', 'certificate-form');
    }

    public function openEdit(int $id): void
    {
        $certificate = Certificate::findOrFail($id);

        $this->certificateId = $certificate->id;
        $this->title = $certificate->title;
        $this->description = $certificate->description;
        $this->position = $certificate->position;
        $this->currentFile = $certificate->file_path;
        $this->currentPreview = $certificate->preview_image;
        $this->file = null;
        $this->preview_image = null;

        $this->dispatch('open-modal', 'certificate-form');
    }

    public function save(): void
    {
        $this->certificateId ? $this->updateCertificate() : $this->createCertificate();
    }

    protected function createCertificate(): void
    {
        $this->validate();

        $path = $this->storeFile($this->file);
        $previewPath = $this->preview_image ? $this->storePreview($this->preview_image) : null;

        $nextPosition = Certificate::max('position') + 1;

        Certificate::create([
            'title' => $this->title,
            'description' => $this->description,
            'file_path' => $path,
            'preview_image' => $previewPath,
            'position' => $this->position ?? $nextPosition,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'certificate-form');
        $this->dispatch('notify', message: 'Sertifikat berhasil ditambahkan.', type: 'success');
        $this->resetPage();
    }

    protected function updateCertificate(): void
    {
        $this->validate();

        $certificate = Certificate::findOrFail($this->certificateId);

        $path = $certificate->file_path;
        $previewPath = $certificate->preview_image;

        if ($this->file) {
            $path = $this->storeFile($this->file);
            $this->deleteFileIfExists($certificate->file_path);
        }

        if ($this->preview_image) {
            $previewPath = $this->storePreview($this->preview_image);
            $this->deleteFileIfExists($certificate->preview_image);
        }

        $certificate->update([
            'title' => $this->title,
            'description' => $this->description,
            'file_path' => $path,
            'preview_image' => $previewPath,
            'position' => $this->position ?? $certificate->position,
        ]);

        $this->resetForm();
        $this->dispatch('close-modal', 'certificate-form');
        $this->dispatch('notify', message: 'Sertifikat berhasil diperbarui.', type: 'success');
    }

    public function confirmDelete(int $id): void
    {
        $this->selectedId = $id;
        $this->dispatch('open-modal', 'delete-certificate');
    }

    public function delete(): void
    {
        $certificate = Certificate::find($this->selectedId);

        if ($certificate) {
            $this->deleteFileIfExists($certificate->file_path);
            $certificate->delete();
        }

        $this->selectedId = null;
        $this->dispatch('close-modal', 'delete-certificate');
        $this->dispatch('notify', message: 'Sertifikat berhasil dihapus.', type: 'success');
    }

    public function updateOrder($items): void
    {
        foreach ($items as $item) {
            Certificate::where('id', $item['value'])
                ->update(['position' => $item['order']]);
        }

        $this->dispatch('notify', message: 'Urutan sertifikat diperbarui.', type: 'success');
    }

    protected function storeFile($file): string
    {
        $filename = 'sertifikat_' . now()->format('Ymd_His') . '_' . uniqid() . '.pdf';
        return $file->storeAs('assets/documents/sertifikat', $filename, 'public');
    }

    protected function deleteFileIfExists(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    protected function resetForm(): void
    {
        $this->reset(['certificateId', 'title', 'description', 'file', 'currentFile', 'position']);
        $this->reset(['preview_image', 'currentPreview']);
        $this->resetValidation();
    }

    public function getCertificates()
    {
        return Certificate::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('position')
            ->orderByDesc('id')
            ->paginate(10);
    }

    protected function storePreview($image): string
    {
        $filename = 'sertifikat_preview_' . now()->format('Ymd_His') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        return $image->storeAs('assets/img/certificates/previews', $filename, 'public');
    }

    public function render()
    {
        return view('livewire.dashboard.sertifikat.semua-sertifikat', [
            'certificates' => $this->getCertificates(),
        ]);
    }
}
