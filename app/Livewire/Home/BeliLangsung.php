<?php

namespace App\Livewire\Home;

use App\Models\Buku;
use App\Models\DirectOrder;
use App\Models\PaymentMethod;
use App\Mail\PaymentProofMail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengaturan;
use Illuminate\Support\Facades\Mail;

class BeliLangsung extends Component
{
    use WithFileUploads;

    public Buku $book;

    public $tipe_order = 'hard';
    public $recipient_name = '';
    public $country_code = '+62';
    public $recipient_phone = '';
    public $recipient_email = '';
    public $address_label = '';
    public $provinsi = '';
    public $kota = '';
    public $kecamatan = '';
    public $kelurahan = '';
    public $kode_pos = '';
    public $alamat_lengkap = '';
    public $payment_method_id = '';
    public $catatan_pengguna = '';
    public $bukti_pembayaran;

    public $successMessage = '';
    public $proofDownloadUrl = '';
    public $waLink = '';
    public $paymentMethods = [];

    public const COUNTRY_CODES = [
        ['code' => '+62', 'label' => 'Indonesia'],
        ['code' => '+60', 'label' => 'Malaysia'],
        ['code' => '+65', 'label' => 'Singapura'],
        ['code' => '+1',  'label' => 'USA/Canada'],
        ['code' => '+44', 'label' => 'Inggris'],
        ['code' => '+61', 'label' => 'Australia'],
    ];

    protected $rules = [
        'tipe_order'          => 'required|in:hard,soft',
        'recipient_name'      => 'required|string|min:3',
        'country_code'        => 'required|in:+62,+60,+65,+1,+44,+61',
        'recipient_phone'     => 'required|string|min:6|max:20',
        'recipient_email'     => 'required|email',
        'address_label'       => 'nullable|string|max:100',
        'provinsi'            => 'required|string|max:150',
        'kota'                => 'required|string|max:150',
        'kecamatan'           => 'required|string|max:150',
        'kelurahan'           => 'required|string|max:150',
        'kode_pos'            => 'nullable|string|max:10',
        'alamat_lengkap'      => 'required|string|min:10',
        'payment_method_id'   => 'required|exists:payment_methods,id',
        'catatan_pengguna'    => 'nullable|string|max:1000',
        'bukti_pembayaran'    => 'required|file|mimes:jpg,jpeg,png,pdf|max:20480',
    ];

    protected $messages = [
        'tipe_order.required' => 'Pilih tipe pesanan.',
        'tipe_order.in'       => 'Tipe pesanan tidak valid.',
        'recipient_name.required'  => 'Nama penerima wajib diisi.',
        'country_code.required'    => 'Pilih kode negara.',
        'recipient_phone.required' => 'Nomor HP wajib diisi.',
        'recipient_email.required' => 'Email penerima wajib diisi.',
        'provinsi.required'        => 'Provinsi wajib diisi.',
        'kota.required'            => 'Kota/Kabupaten wajib diisi.',
        'kecamatan.required'       => 'Kecamatan wajib diisi.',
        'kelurahan.required'       => 'Kelurahan/Desa wajib diisi.',
        'alamat_lengkap.required'  => 'Alamat lengkap wajib diisi.',
        'payment_method_id.required' => 'Pilih salah satu metode pembayaran.',
        'bukti_pembayaran.required' => 'Bukti pembayaran wajib diunggah.',
        'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa JPG, PNG, atau PDF.',
        'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 20MB.',
    ];

    public function mount(Buku $book)
    {
        if (! $book->allow_umri_press_payment) {
            abort(404);
        }

        if ($book->is_coming_soon) {
            abort(404);
        }

        $this->book = $book;
        $this->tipe_order = $this->book->is_hard_available ? 'hard' : 'soft';
        $this->loadPaymentMethods();
    }

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function submit()
    {
        $this->successMessage = '';
        $this->waLink = '';
        $this->proofDownloadUrl = '';

        $validated = $this->validate();

        if ($validated['tipe_order'] === 'soft' && ! $this->book->is_soft_available) {
            $this->addError('tipe_order', 'Softfile tidak tersedia untuk buku ini.');
            return;
        }

        if ($validated['tipe_order'] === 'hard' && ! $this->book->is_hard_available) {
            $this->addError('tipe_order', 'Hardfile tidak tersedia untuk buku ini.');
            return;
        }

        $formattedPhone = $this->formatPhone($validated['country_code'], $validated['recipient_phone']);
        $paymentMethod = $this->paymentMethods
            ? $this->paymentMethods->firstWhere('id', (int) $validated['payment_method_id'])
            : PaymentMethod::find($validated['payment_method_id']);

        $buktiPath = $this->bukti_pembayaran
            ? $this->bukti_pembayaran->store('payments/proofs', 'public')
            : null;
        $buktiUrl = $buktiPath ? url(Storage::url($buktiPath)) : null;
        $this->proofDownloadUrl = $buktiUrl ?: '';

        $basePrice = $validated['tipe_order'] === 'soft' && $this->book->harga_soft !== null
            ? $this->book->harga_soft
            : $this->book->harga;

        $diskonPercent = $validated['tipe_order'] === 'soft'
            ? ($this->book->diskon_soft ?? $this->book->diskon ?? 0)
            : ($this->book->diskon_hard ?? $this->book->diskon ?? 0);

        $hargaSetelahDiskon = $diskonPercent
            ? max(0, $basePrice - ($basePrice * ($diskonPercent / 100)))
            : $basePrice;

        $order = DirectOrder::create([
            'buku_id'             => $this->book->id,
            'payment_method_id'   => $validated['payment_method_id'],
            'tipe_order'          => $validated['tipe_order'],
            'recipient_name'      => $validated['recipient_name'],
            'recipient_phone'     => $formattedPhone,
            'recipient_email'     => $validated['recipient_email'],
            'address_label'       => $validated['address_label'] ?? null,
            'provinsi'            => $validated['provinsi'],
            'kota'                => $validated['kota'],
            'kecamatan'           => $validated['kecamatan'],
            'kelurahan'           => $validated['kelurahan'],
            'kode_pos'            => $validated['kode_pos'] ?? null,
            'alamat_lengkap'      => $validated['alamat_lengkap'],
            'harga_asli'          => $basePrice,
            'harga_setelah_diskon'=> $hargaSetelahDiskon,
            'catatan_pengguna'    => $validated['catatan_pengguna'] ?? null,
            'bukti_pembayaran'    => $buktiPath,
        ]);

        $message = $this->buildWhatsappMessage(
            $order->id,
            $validated,
            $formattedPhone,
            $paymentMethod,
            $buktiUrl
        );

        $waNumber = $this->getAdminWaNumber();
        $this->waLink = "https://wa.me/{$waNumber}?text={$message}";

        $adminEmail = $this->getAdminEmail();
        if ($adminEmail) {
            try {
                $order->loadMissing('buku', 'paymentMethod');
                Mail::to($adminEmail)->send(
                    new PaymentProofMail($order, $paymentMethod, $buktiPath, $buktiUrl)
                );
            } catch (\Exception $e) {
                $this->dispatch('notify', message: 'Gagal mengirim bukti ke email admin: ' . $e->getMessage(), type: 'error');
            }
        }

        $this->successMessage = 'Pesanan berhasil dikirim. WhatsApp akan terbuka untuk meneruskan data ke admin UMRI Press.';
        $this->dispatch('notify', message: $this->successMessage, type: 'success');
        $this->dispatch('open-wa-link', url: $this->waLink);
        $this->dispatch('close-modal', 'direct-purchase');
        $this->resetForm();
        $this->loadPaymentMethods();
    }

    protected function formatPhone(string $dialCode, string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone ?? '');
        $digits = ltrim($digits, '0');

        return $dialCode . $digits;
    }

    public function resetForm(): void
    {
        $this->reset([
            'tipe_order',
            'recipient_name',
            'country_code',
            'recipient_phone',
            'recipient_email',
            'address_label',
            'provinsi',
            'kota',
            'kecamatan',
            'kelurahan',
            'kode_pos',
            'alamat_lengkap',
            'payment_method_id',
            'catatan_pengguna',
            'bukti_pembayaran',
        ]);

        $this->tipe_order = $this->book->is_hard_available ? 'hard' : 'soft';
        $this->country_code = '+62';
    }

    public function loadPaymentMethods(): void
    {
        $this->paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    protected function getAdminWaNumber(): string
    {
        $number = Pengaturan::where('key', 'admin_wa_number')->value('value');

        return $number ?: '6287837151510';
    }

    protected function getAdminEmail(): ?string
    {
        $email = Pengaturan::where('key', 'admin_email')->value('value');

        if (! $email) {
            $email = Pengaturan::where('key', 'email')->value('value');
        }

        return $email ?: null;
    }

    public function render()
    {
        $adminEmail = $this->getAdminEmail();

        return view('livewire.home.beli-langsung', [
            'paymentMethods' => $this->paymentMethods,
            'countryCodes'   => self::COUNTRY_CODES,
            'adminEmail'     => $adminEmail,
        ]);
    }

    protected function buildWhatsappMessage(
        int $orderId,
        array $data,
        string $formattedPhone,
        ?PaymentMethod $paymentMethod,
        ?string $buktiUrl
    ): string {
        $alamatSingkat = trim("{$data['alamat_lengkap']} ({$data['kelurahan']}, {$data['kecamatan']}, {$data['kota']}, {$data['provinsi']})");

        $paymentLine = $paymentMethod
            ? $paymentMethod->name . ($paymentMethod->account_number ? " - {$paymentMethod->account_number} ({$paymentMethod->account_name})" : '')
            : 'Belum dipilih';

        $buktiLine = $buktiUrl
            ? "Bukti pembayaran: {$buktiUrl}"
            : 'Bukti pembayaran belum diunggah.';

        $text = "Halo UMRI Press, ada pesanan baru:\n"
            . "\nBuku: {$this->book->judul}"
            . "\nFormat: " . strtoupper($data['tipe_order'])
            . "\nNama: {$data['recipient_name']}"
            . "\nHP: {$formattedPhone}"
            . "\nEmail: {$data['recipient_email']}"
            . "\nAlamat: {$alamatSingkat}"
            . "\nLabel alamat: " . ($data['address_label'] ?: '-')
            . "\nKode Pos: " . ($data['kode_pos'] ?: '-')
            . "\nPembayaran: {$paymentLine}"
            . "\nCatatan: " . ($data['catatan_pengguna'] ?: '-')
            . "\n{$buktiLine}"
            . "\nKode Pesanan: #{$orderId}";

        return rawurlencode($text);
    }
}
