<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/tentang/tim', 'team')->name('team');
    Route::get('/layanan/daftar-jadi-penulis-buku', 'daftarPenulis')->name('daftarPenulis');
    Route::get('/layanan/kirim-naskah', 'kirimNaskah')->name('kirimNaskah');
    Route::get('/harga', 'harga')->name('harga');
    Route::get('/toko-buku', 'tokoBuku')->name('tokoBuku');
    Route::get('/detail-buku/{slug}', 'detailBuku')->name('detailBuku');
    Route::get('/kontak', 'kontak')->name('kontak');
    Route::get('/artikel', 'artikel')->name('artikel');
    Route::get('/artikel/{slug}', 'detailArtikel')->name('detailArtikel');
    Route::get('/penjelasan-layanan', 'penjelasanLayanan')->name('penjelasanLayanan');
    Route::get('/progress-isbn', 'progressISBN')->name('progressISBN');
    Route::get('/tentang-kami', 'tentangKami')->name('tentangKami');
    Route::get('/kategori', 'kategoriBuku')->name('kategori');

    // auhtor
    Route::get('/penulis/{slug}', 'detailAuthor')->name('author');

    // Komentar Buku
    Route::post('/buku/{buku}/komentar', 'submitComment')->name('buku.comment');
    Route::post('/buku/{buku}/komentar/{parent}', 'submitReply')->name('buku.comment.reply');
});


Route::middleware(['auth'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard')->middleware('dashboard.permission:dashboard.view');


        // buku
        Route::get('/dashboard/buku/semua-buku', 'semuaBuku')->name('semuaBuku')->middleware('dashboard.permission:buku.view');
        Route::get('/dashboard/buku/tambah-buku', 'tambahBuku')->name('tambahBuku')->middleware('dashboard.permission:buku.create');
        Route::get('/dashboard/buku/edit-buku/{slug}', 'editBuku')->name('editBuku')->middleware('dashboard.permission:buku.update');
        Route::get('/dashboard/buku/tempat-sampah', 'tempatSampah')->name('tempatSampah')->middleware('dashboard.permission:buku.trash');

        // kategori buku
        Route::get('/dashboard/buku/kategori/semua-kategori', 'semuaKategori')->name('semuaKategori')->middleware('dashboard.permission:buku.category.view');

        // authors
        Route::get('/dashboard/authors/semua-authors', 'semuaAuthors')->name('semuaAuthors')->middleware('dashboard.permission:authors.manage');

        // artikel
        Route::get('/dashboard/artikel/semua-artikel', 'semuaArtikel')->name('semuaArtikel')->middleware('dashboard.permission:artikel.view');
        Route::get('/dashboard/artikel/tambah-artikel', 'tambahArtikel')->name('tambahArtikel')->middleware('dashboard.permission:artikel.create');
        Route::get('/dashboard/artikel/edit-artikel/{slug}', 'editArtikel')->name('editArtikel')->middleware('dashboard.permission:artikel.update');
        Route::get('/dashboard/artikel/tempat-sampah', 'tempatSampahArtikel')->name('tempatSampahArtikel')->middleware('dashboard.permission:artikel.trash');

        // kategori artikel
        Route::get('/dashboard/artikel/kategori/semua-kategori', 'kategoriArtikel')->name('kategoriArtikel')->middleware('dashboard.permission:artikel.category.manage');

        // tim
        Route::get('/dashboard/tim/semua-tim', 'semuaTim')->name('semuaTim')->middleware('dashboard.permission:tim.view');
        Route::get('/dashboard/tim/tambah-tim', 'tambahTim')->name('tambahTim')->middleware('dashboard.permission:tim.create');
        Route::get('/dashboard/tim/edit-tim/{slug}', 'editTim')->name('editTim')->middleware('dashboard.permission:tim.update');
        Route::get('/dashboard/tim/tempat-sampah', 'tempatSampahTim')->name('tempatSampahTim')->middleware('dashboard.permission:tim.trash');
        Route::post('/dashboard/tim/struktur', 'updateStructureImage')->name('tim.updateStructure')->middleware('dashboard.permission:tim.structure.update');
        Route::post('/dashboard/tim/admin-wa', 'updateAdminWhatsapp')->name('tim.updateAdminWa')->middleware('dashboard.permission:tim.adminwa.update');

        // sertifikat
        Route::get('/dashboard/sertifikat', 'semuaSertifikat')->name('semuaSertifikat')->middleware('dashboard.permission:sertifikat.manage');

        // harga paket
        Route::get('/dashboard/harga-paket/semua-paket', 'semuaPaket')->name('semuaPaket')->middleware('dashboard.permission:harga.view');
        Route::get('/dashboard/harga-paket/tambah-paket', 'tambahPaket')->name('tambahPaket')->middleware('dashboard.permission:harga.create');
        Route::get('/dashboard/harga-paket/edit-paket/{slug}', 'editPaket')->name('editPaket')->middleware('dashboard.permission:harga.update');
        Route::get('/dashboard/harga-paket/tempat-sampah', 'tempatSampahPaket')->name('tempatSampahPaket')->middleware('dashboard.permission:harga.trash');
        Route::get('/dashboard/pembayaran/metode', 'metodePembayaran')->name('metodePembayaran')->middleware('dashboard.permission:pembayaran.manage');
        Route::get('/dashboard/transaksi/pesanan-langsung', 'pesananLangsung')->name('pesananLangsung')->middleware('dashboard.permission:transaksi.view');
        Route::get('/dashboard/transaksi/pesanan-langsung/{order}', 'detailPesanan')->name('pesananLangsung.detail')->middleware('dashboard.permission:transaksi.detail');
        Route::patch('/dashboard/transaksi/pesanan-langsung/{order}', 'updatePesanan')->name('pesananLangsung.update')->middleware('dashboard.permission:transaksi.update');

        // users
        Route::get('/dashboard/users/semua-users', 'semuaUsers')->name('semuaUsers')->middleware('dashboard.permission:users.manage');

        // pengaturan
        Route::get('/dashboard/pengaturan', 'pengaturanWeb')->name('pengaturanWeb')->middleware('dashboard.permission:settings.manage');

        // roles
        Route::get('/dashboard/roles', function () {
            return view('dashboard.roles.index', ['title' => 'Manajemen Role']);
        })->name('roles.index')->middleware('dashboard.permission:roles.manage');

        // komentar
        Route::get('/dashboard/buku/komentar', 'semuaKomentar')->name('semuaKomentar')->middleware('dashboard.permission:komentar.manage');
    });
});

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/royalty', [\App\Http\Controllers\Admin\RoyaltyTransactionController::class, 'index'])
        ->name('royalty.index')
        ->middleware('dashboard.permission:royalty.manage');
    Route::patch('/royalty/{transaction}', [\App\Http\Controllers\Admin\RoyaltyTransactionController::class, 'update'])
        ->name('royalty.update')
        ->middleware('dashboard.permission:royalty.manage');
    Route::get('/payouts', [\App\Http\Controllers\Admin\PayoutRequestController::class, 'index'])
        ->name('payouts.index')
        ->middleware('dashboard.permission:payouts.manage');
    Route::patch('/payouts/{payout}', [\App\Http\Controllers\Admin\PayoutRequestController::class, 'update'])
        ->name('payouts.update')
        ->middleware('dashboard.permission:payouts.manage');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/surat/verify/{code}', [\App\Http\Controllers\Surat\VerificationController::class, 'show'])
    ->name('surat.verify');

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard-surat.php';
require __DIR__ . '/author.php';
