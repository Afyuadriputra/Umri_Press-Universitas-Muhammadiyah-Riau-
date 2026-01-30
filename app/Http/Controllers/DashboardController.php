<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Buku;
use App\Models\DirectOrder;
use App\Models\PaketPenerbit;
use App\Models\Pengaturan;
use App\Models\Tim;
use App\Actions\CalculateRoyaltyAction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'totalBuku' => Buku::count(),
            'totalArtikel' => Artikel::count(),
            'totalPaket' => PaketPenerbit::count(),
            'totalTim' => Tim::count(),
            'recentBooks' => Buku::latest()->take(5)->get(),
            'recentArticles' => Artikel::latest()->take(5)->get(),
        ]);
    }

    public function semuaKategori()
    {
        return view('dashboard.kategori.semua-kategori', [
            'title' => 'Semua Kategori',
        ]);
    }

    public function semuaBuku()
    {
        return view('dashboard.buku.semua-buku', [
            'title' => 'Semua Buku',
        ]);
    }

    public function tambahBuku()
    {
        return view('dashboard.buku.tambah-buku', [
            'title' => 'Tambah Buku',
        ]);
    }

    public function editBuku($slug)
    {
        $buku = Buku::where('slug', $slug)->first();
        if (!$buku) {
            return redirect()->route('semuaBuku');
        }

        return view('dashboard.buku.edit-buku', [
            'title' => 'Edit Buku',
            'buku' => $buku,
        ]);
    }

    public function semuaAuthors()
    {
        return view('dashboard.authors.semua-authors', [
            'title' => 'Semua Authors',
        ]);
    }

    public function tempatSampah()
    {
        return view('dashboard.buku.tempat-sampah', [
            'title' => 'Tempat Sampah',
        ]);
    }

    public function semuaArtikel()
    {
        return view('dashboard.artikel.semua-artikel', [
            'title' => 'Semua Artikel',
        ]);
    }

    public function tambahArtikel()
    {
        return view('dashboard.artikel.tambah-artikel', [
            'title' => 'Tambah Artikel',
        ]);
    }

    public function editArtikel($slug)
    {
        $artikel = Artikel::where('slug', $slug)->first();
        if (!$artikel) {
            return redirect()->route('semuaArtikel');
        }

        return view('dashboard.artikel.edit-artikel', [
            'title' => 'Edit Artikel',
            'artikel' => $artikel,
        ]);
    }

    public function tempatSampahArtikel()
    {
        return view('dashboard.artikel.tempat-sampah', [
            'title' => 'Tempat Sampah Artikel',
        ]);
    }

    public function kategoriArtikel()
    {
        return view('dashboard.artikel.kategori', [
            'title' => 'Kategori Artikel',
        ]);
    }

    public function semuaTim()
    {
        return view('dashboard.tim.semua-tim', [
            'title' => 'Semua Tim',
        ]);
    }

    public function semuaSertifikat()
    {
        return view('dashboard.sertifikat.index', [
            'title' => 'Sertifikat Kerja Sama',
        ]);
    }

    public function tambahTim()
    {
        return view('dashboard.tim.tambah-tim', [
            'title' => 'Tambah Tim',
        ]);
    }

    public function editTim($slug)
    {
        return view('dashboard.tim.edit-tim', [
            'title' => 'Edit Tim',
            'slug' => $slug
        ]);
    }

    public function tempatSampahTim()
    {
        return view('dashboard.tim.tempat-sampah', [
            'title' => 'Tempat Sampah Tim',
        ]);
    }

    public function updateStructureImage(Request $request)
    {
        $request->validate([
            'structure_image' => 'required|image|max:5120',
        ]);

        $setting = Pengaturan::firstOrCreate(
            ['key' => 'naskah_structure_image'],
            [
                'display_name' => 'Gambar Struktur Kirim Naskah',
                'type' => 'image',
                'group' => 'kirim-naskah',
                'keterangan' => 'Ukuran disarankan: 1280x719 (24-bit, 96 dpi)',
            ]
        );

        // Hapus file lama jika ada
        if ($setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        $ext = $request->file('structure_image')->getClientOriginalExtension();
        $filename = 'naskah_structure_image.' . $ext;
        $path = $request->file('structure_image')->storeAs('assets/img/settings', $filename, 'public');

        $setting->update(['value' => $path]);

        return back()->with('success', 'Gambar struktur kirim naskah berhasil diperbarui.');
    }

    public function updateAdminWhatsapp(Request $request)
    {
        $request->validate([
            'admin_wa_number' => 'required|string|min:8|max:20',
        ]);

        $raw = $request->string('admin_wa_number')->toString();
        $digits = preg_replace('/\D+/', '', $raw);

        $number = Str::startsWith($digits, '0')
            ? '62' . ltrim($digits, '0')
            : $digits;

        Pengaturan::updateOrCreate(
            ['key' => 'admin_wa_number'],
            [
                'value' => $number,
                'display_name' => 'Nomor WhatsApp Admin',
                'type' => 'text',
                'group' => 'kirim-naskah',
                'keterangan' => 'Nomor WhatsApp untuk pesanan dan kirim naskah',
            ]
        );

        return back()->with('success', 'Nomor WhatsApp admin berhasil diperbarui.');
    }

    public function semuaPaket()
    {
        return view('dashboard.harga.semua-paket', [
            'title' => 'Semua Paket',
        ]);
    }

    public function tambahPaket()
    {
        return view('dashboard.harga.tambah-paket', [
            'title' => 'Tambah Paket',
        ]);
    }

    public function editPaket($slug)
    {
        return view('dashboard.harga.edit-paket', [
            'title' => 'Edit Paket',
            'slug' => $slug
        ]);
    }

    public function tempatSampahPaket()
    {
        return view('dashboard.harga.tempat-sampah', [
            'title' => 'Tempat Sampah Paket',
        ]);
    }

    public function metodePembayaran()
    {
        return view('dashboard.pembayaran.metode', [
            'title' => 'Metode Pembayaran',
        ]);
    }

    public function pesananLangsung()
    {
        return view('dashboard.transaksi.pesanan-langsung', [
            'title' => 'Pesanan Langsung',
        ]);
    }

    public function detailPesanan(DirectOrder $order)
    {
        $order->load(['buku', 'paymentMethod']);

        return view('dashboard.transaksi.detail-pesanan', [
            'title' => 'Detail Pesanan',
            'order' => $order,
            'statuses' => DirectOrder::STATUS_LABELS,
        ]);
    }

    public function updatePesanan(Request $request, DirectOrder $order)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(DirectOrder::STATUS_LABELS))],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $order->update([
            'status' => $validated['status'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ]);

        if ($validated['status'] === DirectOrder::STATUS_COMPLETED) {
            app(CalculateRoyaltyAction::class)->execute($order->fresh());
        }

        return redirect()
            ->route('pesananLangsung.detail', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function semuaUsers()
    {
        return view('dashboard.users.semua-users', [
            'title' => 'Semua Users',
        ]);
    }

    public function pengaturanWeb()
    {
        return view('dashboard.pengaturan', [
            'title' => 'Pengaturan Web',
        ]);
    }

    public function semuaKomentar()
    {
        return view('dashboard.komentar.semua-komentar', [
            'title' => 'Semua Komentar',
        ]);
    }
}
