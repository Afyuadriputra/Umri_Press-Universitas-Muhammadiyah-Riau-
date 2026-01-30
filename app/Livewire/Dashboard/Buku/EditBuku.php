<?php

namespace App\Livewire\Dashboard\Buku;

use App\Models\Authors;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use App\Services\PdfPreviewGenerator;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditBuku extends Component
{
    use WithFileUploads;

    public $bukuId;
    public $cover;
    public $thumbnail;
    public $judul = '';
    public $keywords = '';
    public $slug = '';
    public $deskripsi = '';
    public $sinopsis = '';
    public $isbn;
    public $eisbn;
    public $harga;
    public $harga_soft;
    public $diskon_hard = 0;
    public $diskon_soft = 0;
    public $stock = 0;
    public $jumlah_halaman;
    public $tanggal_terbit;
    public $tempImage;
    public $draft;
    public $kategori_id;
    public $institusi;
    public $ukuran;
    public $ketersediaan = true;
    public $is_hard_available = true;
    public $is_soft_available = false;
    public $ebook;
    public $oldEbook;
    public $preview_pdf;
    public $oldPreview;
    public $preview_pages;
    public $is_coming_soon = false;
    public $allow_umri_press_payment = true;
    public $categories;
    public $oldCover;
    public $authorList = [];
    public $allAuthors = [];
    public $daftar_isi = '';
    public $oldThumbnail;
    public $authorRoyalties = [];
    public $marketplaces = [
        'shopee' => ['active' => false, 'link' => ''],
        'tokopedia' => ['active' => false, 'link' => ''],
    ];

    protected $listeners = [
        'set-deskripsi' => 'setDeskripsi',
        'set-sinopsis' => 'setSinopsis',
        'set-daftar-isi' => 'setDaftarIsi',
        'item-selected' => 'handleAuthorSelected'
    ];

    public function mount(Buku $buku)
    {
        $this->bukuId = $buku->id;
        $this->judul = $buku->judul;
        $this->keywords = $buku->keywords;
        $this->slug = $buku->slug;
        $this->deskripsi = $buku->deskripsi;
        $this->sinopsis = $buku->sinopsis;
        $this->isbn = $buku->isbn;
        $this->eisbn = $buku->eisbn;
        $this->harga = $buku->harga;
        $this->harga_soft = $buku->harga_soft;
        $this->diskon_hard = $buku->diskon_hard ?? $buku->diskon;
        $this->diskon_soft = $buku->diskon_soft ?? 0;
        $this->stock = $buku->stock ?? 0;
        $this->jumlah_halaman = $buku->jumlah_halaman;
        $this->tanggal_terbit = $buku->tanggal_terbit;
        $this->kategori_id = $buku->kategori_id;
        $this->institusi = $buku->institusi;
        $this->ukuran = $buku->ukuran;
        $this->ketersediaan = $buku->ketersediaan;
        $this->is_hard_available = $buku->is_hard_available;
        $this->is_soft_available = $buku->is_soft_available;
        $this->oldEbook = $buku->ebook_path;
        $this->oldPreview = $buku->preview_pdf;
        $this->preview_pages = $buku->preview_pages;
        $this->is_coming_soon = $buku->is_coming_soon;
        $this->allow_umri_press_payment = $buku->allow_umri_press_payment;
        $this->draft = !$buku->status;
        $this->oldCover = $buku->cover;
        $this->oldThumbnail = $buku->cover_thumbnail;
        $this->categories = Kategori::all();

        if ($buku->marketplace_links) {
            $marketplaceLinks = json_decode($buku->marketplace_links, true);
            foreach ($marketplaceLinks as $platform => $link) {
                if (isset($this->marketplaces[$platform])) {
                    $this->marketplaces[$platform] = [
                        'active' => true,
                        'link' => $link
                    ];
                }
            }
        }

        $this->allAuthors = Authors::all()->pluck('name', 'id')->toArray();
        $this->authorList = $buku->authors()->pluck('authors.id')->toArray();
        $this->authorRoyalties = $buku->authors()
            ->withPivot('royalty_percentage')
            ->pluck('author_buku.royalty_percentage', 'authors.id')
            ->toArray();
        $this->daftar_isi = $buku->daftar_isi;
    }

    protected function rules()
    {
        return [
            'cover' => 'nullable|image|max:2048',
            'thumbnail' => 'nullable|image|max:1024',
            'judul' => 'required|min:3',
            'keywords' => 'nullable|string',
            'slug' => 'required|unique:buku,slug,' . $this->bukuId,
            'deskripsi' => 'required|min:50',
            'sinopsis' => 'required|min:50',
            'daftar_isi' => 'required|min:10',
            'isbn' => 'required|unique:buku,isbn,' . $this->bukuId,
            'eisbn' => 'nullable|unique:buku,eisbn,' . $this->bukuId,
            'harga' => 'required|numeric|min:0',
            'harga_soft' => [
                Rule::requiredIf($this->is_soft_available),
                'nullable',
                'numeric',
                'min:0',
            ],
            'diskon_hard' => 'nullable|integer|min:0|max:100',
            'diskon_soft' => 'nullable|integer|min:0|max:100',
            'stock' => 'required|integer|min:0',
            'jumlah_halaman' => 'required|integer|min:1',
            'tanggal_terbit' => 'required|date',
            'kategori_id' => 'required',
            'ukuran' => 'required',
            'marketplaces' => 'nullable',
            'authorList' => 'required|array|min:1',
            'authorRoyalties' => 'nullable|array',
            'authorRoyalties.*' => 'nullable|numeric|min:0|max:100',
            'allow_umri_press_payment' => 'boolean',
            'is_hard_available' => 'boolean',
            'is_soft_available' => 'boolean',
            'is_coming_soon' => 'boolean',
            'ebook' => [
                Rule::requiredIf($this->is_soft_available && !$this->oldEbook),
                'nullable',
                'mimes:pdf',
                'max:20480'
            ],
            'preview_pdf' => 'nullable|mimes:pdf|max:10240',
            'preview_pages' => 'nullable|integer|min:1|max:50',
        ];
    }

    public function updatedJudul($value)
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        // Check if slug exists and increment counter if needed
        while (Buku::where('slug', $slug)->where('id', '!=', $this->bukuId)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $this->slug = $slug;
    }

    public function setDeskripsi($content)
    {
        $this->deskripsi = $content;
    }

    public function handleAuthorSelected($data)
    {
        if ($data['name'] === 'authors') {
            $this->authorList = is_array($data['value']) ? array_map('intval', $data['value']) : [];
            $royalties = $this->authorRoyalties;

            foreach ($this->authorList as $authorId) {
                if (! array_key_exists($authorId, $royalties)) {
                    $royalties[$authorId] = 0;
                }
            }

            foreach (array_keys($royalties) as $authorId) {
                if (! in_array((int) $authorId, $this->authorList, false)) {
                    unset($royalties[$authorId]);
                }
            }

            $this->authorRoyalties = $royalties;
        }
    }

    public function setDaftarIsi($content)
    {
        $this->daftar_isi = $content;
    }


    public function setSinopsis($content)
    {
        $this->sinopsis = $content;
    }

    public function save()
    {
        try {
            $this->validate();

            DB::beginTransaction();

            $buku = Buku::find($this->bukuId);

            $marketplaceLinks = [];
            foreach ($this->marketplaces as $platform => $data) {
                if ($data['active']) {
                    $marketplaceLinks[$platform] = $data['link'];
                }
            }

            if ($this->cover) {
                if ($buku->cover) {
                    Storage::disk('public')->delete($buku->cover);
                }
                $coverPath = $this->cover->store('assets/img/books/covers', 'public');
            }

            if ($this->thumbnail) {
                if ($buku->cover_thumbnail) {
                    Storage::disk('public')->delete($buku->cover_thumbnail);
                }
                $thumbnailPath = $this->thumbnail->store('assets/img/books/thumbnails', 'public');
            }

            $ebookPath = $buku->ebook_path;
            if ($this->ebook) {
                if ($buku->ebook_path) {
                    Storage::disk('public')->delete($buku->ebook_path);
                }
                $ebookPath = $this->ebook->store('assets/ebooks', 'public');
            }

            $previewPath = $buku->preview_pdf;
            $previewSourcePath = $buku->preview_pdf_source;
            $shouldGeneratePreview = false;

            if ($this->preview_pdf) {
                if ($buku->preview_pdf) {
                    Storage::disk('public')->delete($buku->preview_pdf);
                }
                if ($buku->preview_pdf_source) {
                    Storage::disk('local')->delete($buku->preview_pdf_source);
                }

                $previewSourcePath = $this->preview_pdf->store('book-previews/source', 'local');
                $shouldGeneratePreview = true;
            } elseif ($this->preview_pages && $this->preview_pages !== $buku->preview_pages) {
                if ($previewSourcePath) {
                    $shouldGeneratePreview = true;
                } elseif ($buku->preview_pdf) {
                    $legacySource = 'book-previews/source/legacy_' . uniqid() . '.pdf';
                    Storage::disk('local')->put($legacySource, Storage::disk('public')->get($buku->preview_pdf));
                    $previewSourcePath = $legacySource;
                    $shouldGeneratePreview = true;
                }
            }

            if ($shouldGeneratePreview) {
                $previewPages = $this->preview_pages ?: 5;
                try {
                    $previewPath = (new PdfPreviewGenerator())->generate(
                        'local',
                        $previewSourcePath,
                        $previewPages,
                        'public',
                        'assets/book-previews/previews'
                    );
                    if ($buku->preview_pdf) {
                        Storage::disk('public')->delete($buku->preview_pdf);
                    }
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->dispatch('notify', message: "Gagal membuat preview PDF: {$e->getMessage()}", type: 'error');
                    return;
                }
            }

            $buku->update([
                'judul' => $this->judul,
                'keywords' => $this->keywords,
                'slug' => $this->slug,
                'deskripsi' => $this->deskripsi,
                'sinopsis' => $this->sinopsis,
                'daftar_isi' => $this->daftar_isi,
                'isbn' => $this->isbn,
                'eisbn' => $this->eisbn,
                'harga' => $this->harga,
                'harga_soft' => $this->is_soft_available ? $this->harga_soft : null,
                'institusi' => $this->institusi,
                'ukuran' => $this->ukuran,
                'ketersediaan' => $this->ketersediaan,
                'stock' => $this->stock,
                'jumlah_halaman' => $this->jumlah_halaman,
                'tanggal_terbit' => $this->tanggal_terbit,
                'kategori_id' => $this->kategori_id,
                'marketplace_links' => json_encode($marketplaceLinks),
                'allow_umri_press_payment' => (bool) $this->allow_umri_press_payment,
                'status' => $this->draft ? false : true,
                'cover' => $this->cover ? $coverPath : $buku->cover,
                'cover_thumbnail' => $this->thumbnail ? $thumbnailPath : $buku->cover_thumbnail,
                'is_hard_available' => $this->is_hard_available,
                'is_soft_available' => $this->is_soft_available,
                'is_coming_soon' => $this->is_coming_soon,
                'ebook_path' => $ebookPath,
                'preview_pdf' => $previewPath,
                'preview_pdf_source' => $previewSourcePath,
                'preview_pages' => $previewPath ? ($this->preview_pages ?: 5) : null,
                'harga_soft' => $this->is_soft_available ? $this->harga_soft : null,
                'diskon' => $this->diskon_hard ?? 0, // legacy fallback
                'diskon_hard' => $this->diskon_hard ?? 0,
                'diskon_soft' => $this->is_soft_available ? ($this->diskon_soft ?? 0) : 0,
            ]);

            if ($this->totalRoyaltyPercent() > 100) {
                DB::rollBack();
                $this->dispatch('notify', message: 'Total royalti melebihi 100%.', type: 'error');
                return;
            }

            $syncData = [];
            foreach ($this->authorList as $authorId) {
                $syncData[$authorId] = [
                    'royalty_percentage' => (float) ($this->authorRoyalties[$authorId] ?? 0),
                ];
            }

            $buku->authors()->sync($syncData);

            DB::commit();

            session()->flash('success', 'Buku berhasil diperbarui.');
            return $this->redirect(route('semuaBuku'));
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', message: "Terjadi kesalahan saat memperbarui buku: {$e->getMessage()}", type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.buku.edit-buku');
    }

    private function totalRoyaltyPercent(): float
    {
        return collect($this->authorRoyalties)
            ->only($this->authorList)
            ->sum();
    }
}
