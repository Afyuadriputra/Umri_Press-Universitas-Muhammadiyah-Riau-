<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportDataLamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nonaktifkan Foreign Key Check sementara agar tidak error saat truncate/insert
        Schema::disableForeignKeyConstraints();

        // ---------------------------------------------------------
        // 1. TABEL: USERS
        // ---------------------------------------------------------
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'email' => 'umripres@umri.ac.id',
                'email_verified_at' => '2025-07-20 08:29:14',
                'role' => 'admin', // Sesuaikan dengan enum baru
                'password' => '$2y$12$nEKzxQfHZVqHhbA0n..2mOtytkSzPhkZSx2XobLcZ7L2CA9Hw7dkG', // Hash dari DB lama
                'remember_token' => 'wwpjdD3IBlZubYwC7P4RURFW0FwowXKtRJn4NEJRAUTbvoRuq8vcd5qpyFXv',
                'created_at' => '2025-07-20 08:29:14',
                'updated_at' => '2025-07-20 08:29:14',
                // Kolom Baru (Default Value)
                'can_access_surat' => 1, 
                'surat_permissions' => null,
                'dashboard_permissions' => null,
            ]
        ]);

        // ---------------------------------------------------------
        // 2. TABEL: KATEGORI
        // ---------------------------------------------------------
        DB::table('kategori')->truncate();
        DB::table('kategori')->insert([
            ['id' => 1, 'nama' => 'Buku Ajar', 'slug' => 'buku-ajar', 'created_at' => '2025-07-20 08:29:14', 'updated_at' => '2025-07-20 08:29:14'],
            ['id' => 2, 'nama' => 'Buku Referensi', 'slug' => 'buku-referensi', 'created_at' => '2025-08-08 07:02:59', 'updated_at' => '2025-08-08 07:02:59'],
            ['id' => 3, 'nama' => 'Monograf', 'slug' => 'monograf', 'created_at' => '2025-08-08 07:03:07', 'updated_at' => '2025-08-08 07:03:07'],
        ]);

        // ---------------------------------------------------------
        // 3. TABEL: AUTHORS
        // ---------------------------------------------------------
        DB::table('authors')->truncate();
        $authorsData = [
            [1, 'authors/dr-dr-m-yulis-hamidy-mkes-mpd-ked-sp-1753000357.jpg', 'Dr. dr. M. Yulis Hamidy, M.Kes., M.Pd. Ked., Sp.', 'dr-dr-m-yulis-hamidy-mkes-mpd-ked-sp', 'KKLP merupakan dosen di Fakultas Kedokteran Universitas Riau...', '2025-07-20 08:32:37'],
            [2, 'authors/dr-darmawi-mbiomed-phd-1753000400.jpg', 'dr. Darmawi, M.Biomed, PhD', 'dr-darmawi-mbiomed-phd', 'Lahir di Duri pada tanggal 20 September 1987...', '2025-07-20 08:33:20'],
            [3, 'authors/wirawan-adikusuma-1753000455.jpg', 'Wirawan Adikusuma ', 'wirawan-adikusuma', 'adalah seorang peneliti yang mengkhususkan diri...', '2025-07-20 08:34:15'],
            [4, 'authors/lalu-muhammad-irham-mfarm-phd-1753000471.png', 'Lalu Muhammad Irham, M.Farm., Ph.D. ', 'lalu-muhammad-irham-mfarm-phd', 'adalah dosen tetap di Fakultas Farmasi...', '2025-07-20 08:34:31'],
            [5, 'authors/dr-eka-bebasari-msc-1753000486.jpg', 'dr. Eka Bebasari, M.Sc ', 'dr-eka-bebasari-msc', 'menyelesaikan pendidikan Sarjana Kedokteran...', '2025-07-20 08:34:46'],
            [6, 'authors/nurul-azizah-ssi-mbiomed-1753000505.jpg', 'Nurul Azizah, S.Si., M.Biomed', 'nurul-azizah-ssi-mbiomed', 'lahir di Balai Tangah pada 28 Maret 1999...', '2025-07-20 08:35:05'],
            [7, 'authors/dr-lian-pajrianti-1753000519.jpg', 'dr. Lian Pajrianti', 'dr-lian-pajrianti', 'lahir di Taluk kuantan pada tanggal 15 juni 1988...', '2025-07-20 08:35:19'],
            [8, 'authors/dr-annisa-abdi-ghifari-1753000531.jpg', 'dr. Annisa Abdi Ghifari', 'dr-annisa-abdi-ghifari', 'lahir di Bangkinang, 20 November 1993...', '2025-07-20 08:35:31'],
            [9, 'authors/assoc-prof-dr-harun-mukhtar-skom-mkom-1754363548.jpg', 'Assoc. Prof. Dr. Harun Mukhtar, S.Kom., M.Kom', 'assoc-prof-dr-harun-mukhtar-skom-mkom', 'Harun Mukhtar adalah Associate Professor...', '2025-08-05 03:12:28'],
            [10, 'authors/sarah-nabila-1754637182.png', 'Sarah Nabila', 'sarah-nabila', 'Sarah Nabilla adalah seorang mahasiswa...', '2025-08-08 07:13:02'],
            [11, 'authors/ridho-irawan-1754637305.png', 'Ridho Irawan', 'ridho-irawan', 'Ridho Irawan adalah seorang mahasiswa...', '2025-08-08 07:15:05'],
            [12, 'authors/budi-istana-1754637413.png', 'Dr. Budi Istana, ST., M.Eng', 'dr-budi-istana-st-meng', 'Meraih gelar Sarjana Teknik Mesin...', '2025-08-08 07:16:53'],
            [13, 'authors/yulia-fatma-s-kom-m-cs-1754637618.png', 'Yulia Fatma, S. Kom, M. Cs', 'yulia-fatma-s-kom-m-cs', 'Menyelesaikan pendidikan Sarjana pada Jurusan Teknik...', '2025-08-08 07:20:18'],
            [15, 'authors/dr-santoso-ss-msi-1757296163.png', 'Dr. Santoso, S.S., M.Si', 'dr-santoso-ss-msi', 'Dr. Santoso, S.S., M.Si adalah seorang akademisi...', '2025-09-08 01:49:23'],
        ];

        foreach ($authorsData as $auth) {
            DB::table('authors')->insert([
                'id' => $auth[0],
                'image' => $auth[1],
                'name' => $auth[2],
                'slug' => $auth[3],
                'description' => $auth[4],
                'created_at' => $auth[5],
                'updated_at' => $auth[5],
                // Kolom Baru Author (Default)
                'user_id' => null,
                'bank_name' => null,
                'bank_account_name' => null,
                'bank_account_number' => null,
            ]);
        }

        // ---------------------------------------------------------
        // 4. TABEL: BUKU
        // ---------------------------------------------------------
        DB::table('buku')->truncate();
        
        // Data buku kita definisikan satu per satu karena kontennya panjang
        $buku1 = [
            'id' => 1, 'kategori_id' => 3, 
            'judul' => 'Long Short-Term Memory (LSTM) dengan Algoritma Pemrosesan untuk Peramalan Kedatangan Wisatawan pada Data Time Series',
            'slug' => 'long-short-term-memory-lstm-dengan-algoritma-pemrosesan-untuk-peramalan-kedatangan-wisatawan-pada-data-time-series',
            'isbn' => '978-634-04-2588-8', 'harga' => 112000, 'institusi' => 'UmriPress', 'ukuran' => '15.5 × 23 cm',
            'jumlah_halaman' => 205, 'tanggal_terbit' => '2025-08-25', 'created_at' => '2025-08-05 03:16:22',
            'cover' => 'assets/img/books/covers/ABHbRNuAFFQkKfN1RmRLsXRGcIFR8R6XUdJIEtRD.jpg',
            'cover_thumbnail' => 'assets/img/books/thumbnails/A9n0E9Eb1TmnaPdWmLuVSLnhZEV8wbsdZwTE9s3S.jpg',
            // Isian teks panjang (dipotong untuk keringkasan kode, tapi bisa Anda isi penuh dari dump)
            'deskripsi' => '<p>Buku Long Short-Term Memory (LSTM)...</p>',
            'sinopsis' => '<p>Bahwa peramalan memiliki dasar dalam Al- Qur’an...</p>',
            'daftar_isi' => '<p>Kata Pengantar...</p>',
            'marketplace_links' => '[]',
        ];

        $buku2 = [
            'id' => 2, 'kategori_id' => 1, 
            'judul' => 'Peluang Terapi Metformin Selain Sebagai Obat Diabetes',
            'slug' => 'peluang-terapi-metformin-selain-sebagai-obat-diabetes',
            'isbn' => '978-634-04-2610-6 (PDF)', 'harga' => 60000, 'institusi' => 'UmriPress', 'ukuran' => '165 × 250 mm',
            'jumlah_halaman' => 68, 'tanggal_terbit' => '2025-08-10', 'created_at' => '2025-08-05 03:27:18',
            'cover' => 'assets/img/books/covers/CSUlaUCH6RF8T0ScZzRQBZuCyhTIzgjYKlUX5Zuc.jpg',
            'cover_thumbnail' => 'assets/img/books/thumbnails/ngCGDnUizfW1jF9pfHVc3ZkmZ5HSsH8bwRvO3PRg.jpg',
            'deskripsi' => '<p>Metformin, yang selama ini digunakan...</p>',
            'sinopsis' => '<p>Metformin telah lama dikenal sebagai obat utama...</p>',
            'daftar_isi' => '<p>Kata Pengantar...</p>',
            'marketplace_links' => '[]',
        ];

        $buku3 = [
            'id' => 3, 'kategori_id' => 2, 
            'judul' => 'Cloud Computing',
            'slug' => 'cloud-computing',
            'isbn' => '978-634-04-2975-6; E-ISBN: 978-634-04-2611-3 (PDF)', 'harga' => 135000, 'institusi' => 'UmriPress', 'ukuran' => '165 × 250 mm',
            'jumlah_halaman' => 230, 'tanggal_terbit' => '2025-07-08', 'created_at' => '2025-08-05 03:43:26',
            'cover' => 'assets/img/books/covers/YqdWAxGwFKecnETuJbiC40lliJJuyriBGeoo5r8B.jpg',
            'cover_thumbnail' => 'assets/img/books/thumbnails/bhrE10iNKKNL5QvM4QonvV7elP7mD5mzYUQrP5Hc.jpg',
            'deskripsi' => '<p>Tiga model utama layanan cloud computing...</p>',
            'sinopsis' => '<p>Tiga model utama layanan cloud computing...</p>',
            'daftar_isi' => '<p>Kata Pengantar...</p>',
            'marketplace_links' => '[]',
        ];

        $buku4 = [
            'id' => 4, 'kategori_id' => 2, 
            'judul' => 'Buku Tanaman Obat Sekolah Alam',
            'slug' => 'buku-tanaman-obat-sekolah-alam',
            'isbn' => 'xxxxxxxxxx', 'harga' => 0, 'institusi' => 'UmriPress', 'ukuran' => '15,50 × 23cm',
            'jumlah_halaman' => 57, 'tanggal_terbit' => '2025-12-09', 'created_at' => '2025-10-20 08:55:50',
            'cover' => 'assets/img/books/covers/fYAvObQqXXldqYBFkcyBXqv3sxMBpvjaLzNqCr2V.jpg',
            'cover_thumbnail' => 'assets/img/books/thumbnails/SDBwiWFg4h7K8grXvj7OsTMNYmSxm1YD0WTUBV8A.jpg',
            'deskripsi' => '<p>Tanaman obat merupakan tanaman yang sangat popular...</p>',
            'sinopsis' => '<p>Buku tanaman obat sekolah alam ini disusun...</p>',
            'daftar_isi' => '<p>Daftar Isi...</p>',
            'marketplace_links' => '[]',
        ];

        $buku5 = [
            'id' => 5, 'kategori_id' => 1, 
            'judul' => 'Metode Penelitian Psikologi Kualitatif',
            'slug' => 'metode-penelitian-psikologi-kualitatif',
            'isbn' => '-', 'harga' => 0, 'institusi' => 'UmriPress', 'ukuran' => '165 × 250 mm',
            'jumlah_halaman' => 101, 'tanggal_terbit' => '0001-01-01', 'created_at' => '2025-09-08 01:55:39',
            'cover' => 'assets/img/books/covers/IYuZvtMixGREdKvMFZQ32tiWVpEZ27G8mSc36Qoa.jpg',
            'cover_thumbnail' => 'assets/img/books/thumbnails/tTmWkdTUDtXqGF5e63jbYdRevWWNYENXmDQnUrIt.jpg',
            'deskripsi' => '<p>Penelitian adalah aktifitas terstruktur...</p>',
            'sinopsis' => '<p>Bila dicermati dari tujuannya...</p>',
            'daftar_isi' => '<p>-</p>',
            'marketplace_links' => '[]',
        ];

        $allBooks = [$buku1, $buku2, $buku3, $buku4, $buku5];

        foreach ($allBooks as $book) {
            DB::table('buku')->insert(array_merge($book, [
                'ketersediaan' => 1,
                'status' => 1,
                'updated_at' => now(),
                // Kolom Baru DB (Default)
                'eisbn' => null,
                'diskon' => 0,
                'allow_umri_press_payment' => 1,
                'is_hard_available' => 1,
                'is_soft_available' => 0,
                'ebook_path' => null,
                'harga_soft' => 0,
                'diskon_hard' => 0,
                'diskon_soft' => 0,
                'is_coming_soon' => 0,
                'stock' => 100, // Default stok
                'keywords' => null,
                'preview_pdf' => null,
                'preview_pages' => 0,
            ]));
        }

        // ---------------------------------------------------------
        // 5. TABEL: AUTHOR_BUKU (Relasi Pivot)
        // ---------------------------------------------------------
        DB::table('author_buku')->truncate();
        $pivotData = [
            [1, 9, 1],
            [2, 8, 2],
            [3, 9, 3],
            [4, 1, 2],
            [5, 2, 2],
            [6, 3, 2],
            [7, 4, 2],
            [8, 5, 2],
            [9, 6, 2],
            [10, 7, 2],
            [11, 13, 1],
            [12, 12, 1],
            [13, 10, 1],
            [14, 11, 1],
            [16, 15, 5],
        ];

        foreach ($pivotData as $p) {
            DB::table('author_buku')->insert([
                'id' => $p[0],
                'author_id' => $p[1],
                'buku_id' => $p[2],
                'created_at' => now(),
                'updated_at' => now(),
                // Kolom Baru
                'royalty_percentage' => 0, 
            ]);
        }

        // ---------------------------------------------------------
        // 6. TABEL: PENGATURAN
        // ---------------------------------------------------------
        DB::table('pengaturan')->truncate();
        $pengaturan = [
            [1, 'logo', 'assets/img/logo.png', 'Logo Website', 'image', 'umum', 'Logo utama website'],
            [2, 'logo-white', 'assets/img/logo-white.png', 'Logo Website', 'image', 'umum', 'Logo untuk darkmode'],
            [3, 'favicon', 'assets/img/favicon.png', 'Favicon', 'image', 'umum', 'Icon website'],
            [4, 'address', 'Jl. Tuanku Tambusai, Delima, Kec. Tampan, Kota Pekanbaru, Riau', 'Alamat', 'textarea', 'kontak', 'Alamat lengkap'],
            [5, 'phone', '+628783715150', 'Nomor Telepon', 'text', 'kontak', 'Nomor telepon'],
            [6, 'email', 'umripres@umri.ac.id', 'Email', 'text', 'kontak', 'Alamat email'],
            [7, 'template-buku-a4', 'assets/template-buku/a4.docx', 'Template Buku A4', 'docx', 'template-buku', 'Template buku A4'],
            // ... Tambahkan pengaturan lain jika perlu
            [12, 'gform', 'https://docs.google.com/forms/...', 'Link Kirim Naskah', 'text', 'gform', 'Link gform'],
            [13, 'progress-isbn', 'https://docs.google.com/spreadsheets/...', 'Link Progress ISBN', 'text', 'progress-isbn', 'Link progress'],
        ];

        foreach ($pengaturan as $setting) {
            DB::table('pengaturan')->insert([
                'id' => $setting[0],
                'key' => $setting[1],
                'value' => $setting[2],
                'display_name' => $setting[3],
                'type' => $setting[4],
                'group' => $setting[5],
                'keterangan' => $setting[6],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}