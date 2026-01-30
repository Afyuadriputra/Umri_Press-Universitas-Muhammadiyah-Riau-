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

class Tambah extends Component
{
    use WithFileUploads;

    public $naskah_id;
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
    public $naskahList;
    public $draft;
    public $kategori_id;
    public $institusi;
    public $ukuran;
    public $ketersediaan = true;
    public $is_hard_available = true;
    public $is_soft_available = false;
    public $ebook;
    public $preview_pdf;
    public $preview_pages;
    public $is_coming_soon = false;
    public $allow_umri_press_payment = true;
    public $authorList = [];
    public $categories;
    public $marketplaces = [
        'shopee' => ['active' => false, 'link' => ''],
        'tokopedia' => ['active' => false, 'link' => ''],
    ];
    public $allAuthors = [];
    public $daftar_isi = '';
    public $selectedAuthors = [];
    public $authorRoyalties = [];

    protected $listeners = [
        'set-deskripsi' => 'setDeskripsi',
        'set-sinopsis' => 'setSinopsis',
        'set-daftar-isi' => 'setDaftarIsi',
        'item-selected' => 'handleAuthorSelected'
    ];

    protected function rules()
    {
        $rules = [
            'cover' => 'required|image|max:2048',
            'thumbnail' => 'nullable|image|max:1024',
            'judul' => 'required|min:3',
            'keywords' => 'nullable|string',
            'slug' => 'required|unique:buku,slug',
            'deskripsi' => 'required|min:50',
            'sinopsis' => 'required|min:50',
            'daftar_isi' => 'required|min:10',
            'isbn' => 'required|unique:buku,isbn',
            'eisbn' => 'nullable|unique:buku,eisbn',
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
            'institusi' => 'nullable|string',
            'ukuran' => 'required|string',
            'ketersediaan' => 'boolean',
            'is_hard_available' => 'boolean',
            'is_soft_available' => 'boolean',
            'is_coming_soon' => 'boolean',
            'ebook' => [
                Rule::requiredIf($this->is_soft_available),
                'nullable',
                'mimes:pdf',
                'max:20480'
            ],
            'preview_pdf' => 'nullable|mimes:pdf|max:10240',
            'preview_pages' => 'nullable|integer|min:1|max:50',
            'jumlah_halaman' => 'required|integer|min:1',
            'tanggal_terbit' => 'required|date',
            'draft' => 'nullable|boolean',
            // 'marketplaces' => ['nullable', function ($attribute, $value, $fail) {
            //     $activeMarketplaces = collect($value)->filter(fn($m) => $m['active'])->count();
            //     if ($activeMarketplaces === 0) {
            //         $fail('Pilih minimal 1 marketplace.');
            //     }
            // }],
            'marketplaces' => 'nullable',
            'authorList' => 'required|array|min:1',
            'authorRoyalties' => 'nullable|array',
            'authorRoyalties.*' => 'nullable|numeric|min:0|max:100',
            'allow_umri_press_payment' => 'boolean',
        ];

        foreach ($this->marketplaces as $marketplace => $data) {
            if ($data['active']) {
                $rules["marketplaces.{$marketplace}.link"] = 'required|url';
            }
        }

        return $rules;
    }

    protected $messages = [
        'cover.required' => 'Cover buku harus diunggah.',
        'cover.image' => 'Cover buku harus berupa gambar.',
        'cover.max' => 'Ukuran gambar cover buku maksimal 2MB.',
        'thumbnail.image' => 'Thumbnail buku harus berupa gambar.',
        'thumbnail.max' => 'Ukuran gambar thumbnail buku maksimal 1MB.',
        'judul.required' => 'Judul buku harus diisi.',
        'judul.min' => 'Judul buku minimal 3 karakter.',
        'keywords.string' => 'Keyword harus berupa teks.',
        'slug.required' => 'Slug tidak boleh kosong.',
        'slug.unique' => 'Slug sudah digunakan.',
        'deskripsi.required' => 'Deskripsi buku harus diisi.',
        'deskripsi.min' => 'Deskripsi buku minimal 100 karakter.',
        'sinopsis.required' => 'Sinopsis buku harus diisi.',
        'sinopsis.min' => 'Sinopsis buku minimal 100 karakter.',
        'isbn.required' => 'ISBN buku harus diisi.',
        'isbn.unique' => 'ISBN buku sudah digunakan.',
        'eisbn.unique' => 'E-ISBN buku sudah digunakan.',
        'harga.required' => 'Harga buku harus diisi.',
        'harga.numeric' => 'Harga buku harus berupa angka.',
        'harga.min' => 'Harga buku minimal adalah Rp. 10.000.',
        'diskon_hard.integer' => 'Diskon hardfile harus berupa angka.',
        'diskon_hard.min' => 'Diskon hardfile minimal 0%.',
        'diskon_hard.max' => 'Diskon hardfile maksimal 100%.',
        'diskon_soft.integer' => 'Diskon softfile harus berupa angka.',
        'diskon_soft.min' => 'Diskon softfile minimal 0%.',
        'diskon_soft.max' => 'Diskon softfile maksimal 100%.',
        'stock.required' => 'Stok buku harus diisi.',
        'stock.integer' => 'Stok buku harus berupa angka.',
        'stock.min' => 'Stok buku minimal 0.',
        'jumlah_halaman.required' => 'Jumlah halaman buku harus diisi.',
        'jumlah_halaman.integer' => 'Jumlah halaman buku harus berupa angka.',
        'jumlah_halaman.min' => 'Jumlah halaman buku minimal adalah 1.',
        'tanggal_terbit.required' => 'Tanggal terbit buku harus diisi.',
        'tanggal_terbit.date' => 'Tanggal terbit buku harus berupa tanggal.',
        'marketplaces.*.link.required' => 'Link marketplace harus diisi.',
        'marketplaces.*.link.url' => 'Link marketplace harus berupa URL yang valid.',
        'kategori_id.required' => 'Kategori harus dipilih.',
        'ukuran.required' => 'Ukuran buku harus diisi.',
        'authorList.required' => 'Penulis buku harus diisi.',
        'authorList.min' => 'Pilih minimal 1 penulis.',
        'daftar_isi.required' => 'Daftar isi buku harus diisi.',
        'daftar_isi.min' => 'Daftar isi buku minimal 10 karakter.',
        'preview_pages.integer' => 'Jumlah halaman preview harus berupa angka.',
        'preview_pages.min' => 'Jumlah halaman preview minimal 1.',
        'preview_pages.max' => 'Jumlah halaman preview maksimal 50.',
    ];

    public function mount()
    {
        $this->categories = Kategori::all();
        $this->authorList = [];
        $this->authorRoyalties = [];
        $this->allAuthors = Authors::all()->pluck('name', 'id')->toArray();
    }

    public function updatedJudul($value)
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        while (Buku::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $this->slug = $slug;
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

    public function setDeskripsi($content)
    {
        $this->deskripsi = $content;
    }

    public function setSinopsis($content)
    {
        $this->sinopsis = $content;
    }

    public function setDaftarIsi($content)
    {
        $this->daftar_isi = $content;
    }

    public function save()
    {
        try {
            $this->validate();
        } catch (ValidationException $e) {
            $this->dispatch('notify', message: $e->validator->errors()->first(), type: 'error');
            return;
        }

        try {
            DB::beginTransaction();

            $coverPath = null;
            $thumbnailPath = null;
            $ebookPath = null;

            if ($this->cover) {
                $coverPath = $this->cover->store('assets/img/books/covers', 'public');
            }

            if ($this->thumbnail) {
                $thumbnailPath = $this->thumbnail->store('assets/img/books/covers/thumbnails', 'public');
            }

            if ($this->ebook) {
                $ebookPath = $this->ebook->store('assets/ebooks', 'public');
            }
            $previewPath = null;
            $previewSourcePath = null;
            if ($this->preview_pdf) {
                $previewPages = $this->preview_pages ?: 5;
                $previewSourcePath = $this->preview_pdf->store('book-previews/source', 'local');
                try {
                    $previewPath = (new PdfPreviewGenerator())->generate(
                        'local',
                        $previewSourcePath,
                        $previewPages,
                        'public',
                        'assets/book-previews/previews'
                    );
                } catch (\Exception $e) {
                    if ($previewSourcePath) {
                        Storage::disk('local')->delete($previewSourcePath);
                    }
                    DB::rollBack();
                    $this->dispatch('notify', message: "Gagal membuat preview PDF: {$e->getMessage()}", type: 'error');
                    return;
                }
            }

            $marketplaceLinks = collect($this->marketplaces)
                ->filter(fn($m) => $m['active'])
                ->map(fn($m) => $m['link'])
                ->toArray();

            $buku = Buku::create([
                'kategori_id' => $this->kategori_id,
                'cover' => $coverPath,
                'cover_thumbnail' => $thumbnailPath,
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
                'diskon' => $this->diskon_hard ?? 0, // legacy fallback
                'diskon_hard' => $this->diskon_hard ?? 0,
                'diskon_soft' => $this->is_soft_available ? ($this->diskon_soft ?? 0) : 0,
                'institusi' => $this->institusi,
                'ukuran' => $this->ukuran,
                'ketersediaan' => $this->ketersediaan,
                'stock' => $this->stock,
                'is_hard_available' => $this->is_hard_available,
                'is_soft_available' => $this->is_soft_available,
                'is_coming_soon' => $this->is_coming_soon,
                'ebook_path' => $ebookPath,
                'preview_pdf' => $previewPath,
                'preview_pdf_source' => $previewSourcePath,
                'preview_pages' => $this->preview_pdf ? ($this->preview_pages ?: 5) : null,
                'jumlah_halaman' => $this->jumlah_halaman,
                'tanggal_terbit' => $this->tanggal_terbit,
                'marketplace_links' => json_encode($marketplaceLinks),
                'allow_umri_press_payment' => (bool) $this->allow_umri_press_payment,
                'status' => $this->draft ? false : true
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

            $this->reset([
                'cover',
                'thumbnail',
                'judul',
                'keywords',
                'slug',
                'deskripsi',
                'sinopsis',
                'isbn',
                'eisbn',
                'harga',
                'harga_soft',
                'diskon_hard',
                'diskon_soft',
                'stock',
                'preview_pages',
                'jumlah_halaman',
                'tanggal_terbit',
                'tempImage',
                'ebook',
                'preview_pdf',
                'authorRoyalties',
            ]);

            $this->allow_umri_press_payment = true;
            $this->is_hard_available = true;
            $this->is_soft_available = false;
            $this->diskon_hard = 0;
            $this->diskon_soft = 0;
            $this->is_coming_soon = false;

            session()->flash('success', 'Buku berhasil disimpan.');

            return $this->redirect(route('semuaBuku'));
        } catch (\Exception $e) {
            DB::rollBack();

            $this->dispatch('notify', message: "Terjadi kesalahan saat menyimpan buku: {$e->getMessage()}", type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.buku.tambah');
    }

    private function totalRoyaltyPercent(): float
    {
        return collect($this->authorRoyalties)
            ->only($this->authorList)
            ->sum();
    }
}
