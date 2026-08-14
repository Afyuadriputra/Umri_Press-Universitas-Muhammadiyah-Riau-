# UMRI Press - Sistem Informasi Penerbitan & E-Office

UMRI Press adalah platform berbasis web terintegrasi yang dirancang untuk mengelola ekosistem penerbitan buku di Universitas Muhammadiyah Riau. Sistem ini mencakup toko buku digital (*E-Commerce*), portal manajemen royalti penulis otomatis, serta sistem tata kelola persuratan digital (*E-Office*) yang dilengkapi alur disposisi dan pelacakan audit terperinci.

---

## 1. Ringkasan Eksekutif Arsitektur

Sistem ini dibangun di atas **Laravel 11** dan mengimplementasikan arsitektur modular yang menggabungkan pola **Action-Domain & Observer Pattern** untuk menangani proses transaksi otomatis. Keamanan sistem dikawal oleh arsitektur **Fine-Grained Dynamic RBAC (Role-Based Access Control)** yang memisahkan izin akses ke dalam 3 domain bisnis utama:

1. **E-Commerce & Penerbitan Buku**: Manajemen katalog buku publik, pemesanan langsung (*Direct Order*), artikel, dan generator pratinjau PDF.
2. **Finansial & Portal Royalti Penulis**: Otomatisasi perhitungan royalti per buku, dasbor mutasi kredit/debit, dan alur pencairan (*payout*).
3. **E-Office & Tata Kelola Persuratan Digital**: Manajemen surat masuk, surat keluar otomatis, alur disposisi multi-penerima, mesin templat dinamis, jejak audit (*Audit Log*), dan verifikasi publik.

---

## 2. Tumpukan Teknologi (Tech Stack)

* **Bahasa Pemrograman**: PHP ^8.2
* **Kerangka Kerja Backend**: Laravel ^11.31
* **Komponen Reaktif UI**: Livewire ^3.4 & Livewire Volt ^1.0
* **Manipulasi Dokumen PDF**: `setasign/fpdf` (^1.8) & `setasign/fpdi` (^2.6)
* **Basis Data**: Kompatibel dengan SQLite, MySQL, dan PostgreSQL via *database-agnostic queries*

---

## 3. Analisis Alur Bisnis (Business Workflows)

### A. Alur Transaksi & Otomatisasi Royalti Penulis (E-Commerce Domain)

```
                       ┌───────────────────────────────┐
                       │       Front Store / Web       │
                       └──────────────┬────────────────┘
                                      │ Submit Order Langsung
                                      ▼
                       ┌───────────────────────────────┐
                       │     DirectOrder (Pending)     │
                       └──────────────┬────────────────┘
                                      │ Admin Approve (Status: Completed)
                                      ▼
                       ┌───────────────────────────────┐
                       │      DirectOrderObserver      │
                       └──────────────┬────────────────┘
                                      │ Trigger
                                      ▼
                       ┌───────────────────────────────┐
                       │    CalculateRoyaltyAction     │
                       └──────────────┬────────────────┘
                                      │ Split % Pivot author_buku
                                      ▼
                       ┌───────────────────────────────┐
                       │   RoyaltyTransaction (Credit) │
                       └──────────────┬────────────────┘
                                      │ Request Payout (Author)
                                      ▼
                       ┌───────────────────────────────┐
                       │ PayoutRequest & Debit Balance │
                       └───────────────────────────────┘

```

1. **Pemesanan Buku (`DirectOrder`)**:

* Konsumen memesan buku cetak (*hardcover*/*softcover*) atau digital melalui form pembelian langsung.
* Model `Buku` memiliki kalkulasi dinamis untuk potongan harga via *Accessor* (`harga_setelah_diskon` & `harga_soft_setelah_diskon`).

2. **Pemicu Event (`DirectOrderObserver`)**:

* Ketika status pesanan diperbarui menjadi `DirectOrder::STATUS_COMPLETED` (baik melalui panel admin maupun otomasi), *Observer* menangkap event `updated`.

3. **Perhitungan Bagi Hasil (`CalculateRoyaltyAction`)**:

* Sistem membaca relasi *Many-to-Many* antara `Buku` dan `Authors` melalui tabel perantara `author_buku` yang menyimpan kolom `royalty_percentage`.
* Formula perhitungan royalti per penulis:

$$
\text{Nominal Royalti} = \text{round}\left(\text{harga\_setelah\_diskon} \times \frac{\text{royalty\_percentage}}{100}, 2\right)
$$

* Sistem membuat rekaman data pada `RoyaltyTransaction` bertipe `credit` dan status `pending` secara atomik di dalam `DB::transaction`.

4. **Penarikan Saldo Penulis (`AuthorPayoutController`)**:

* Penulis hanya dapat mengajukan pencairan jika data perbankan telah dilengkapi pada profil.
* **Formula Saldo Tersedia (*Available Balance*)**:

$$
\text{Available Balance} = \sum \text{Credit}_{\{\text{approved, paid}\}} - \sum \text{Debit}_{\{\text{pending, approved, paid}\}}
$$

* Pengajuan penarikan dana akan membuat entri `PayoutRequest` baru dan sekaligus mencatat mutasi `debit` bertaraf `pending` di `RoyaltyTransaction` untuk menahan saldo aktif.

---

### B. Alur Tata Kelola Persuratan & Disposisi (E-Office Domain)

```
 ┌─────────────────┐       ┌─────────────────┐       ┌──────────────────┐
 │ Surat Masuk/Out │ ────> │ Multi-level CC  │ ────> │  In-App Notice   │
 │   Agenda Gen    │       │   Disposisi     │       │    & Audit Log   │
 └─────────────────┘       └─────────────────┘       └──────────────────┘

```

1. **Surat Masuk (`IncomingLetterController`)**:

* **Auto Numbering Agenda**: Nomor agenda surat di-generate otomatis per tahun takwim dengan format padding 4 digit (`0001`, `0002`, dst.).
* Mendukung manajemen berkas digital untuk hasil pemindaian fisik (`scan_path`) dan lampiran (`attachment_path`).

2. **Disposisi Berjenjang (`DispositionController`)**:

* Pimpinan dapat mendisposisikan surat masuk kepada penerima utama (`role: to`) dan banyak penerima tembusan (`role: cc`) disertai instruksi kerja dan batas waktu (*due date*).
* Setiap instruksi baru memicu pembuatan notifikasi internal (`SuratNotification`) dan dicatat pada `AuditLog`.
* Saat status disposisi ditandai `selesai` oleh penerima, sistem mengirimkan notifikasi balik kepada pihak pembuat disposisi.

3. **Surat Keluar & Mesin Templat (`OutgoingLetterController`)**:

* **Dynamic Format Generator**: Mendukung konfigurasi penomoran surat fleksibel berbasis *placeholder*:
  `{sequence}/{instansi}/{jenis}/{unit}/{bulan_roman}/{tahun}`
* **Variable Replacement Engine**: Konten surat dapat disusun menggunakan *template* dengan rendering variabel dinamis (`{{nomor}}`, `{{tanggal}}`, `{{penerima}}`, `{{jabatan}}`, `{{perihal}}`, `{{isi}}`).
* **Public Verification Code**: Setiap surat keluar yang disetujui menghasilkan token verifikasi heksadesimal unik 16 karakter (`verification_code`) yang dapat divalidasi keasliannya oleh publik tanpa perlu login melalui rute `/surat/verify/{code}`.

---

### C. Generator Pratinjau Naskah (`PdfPreviewGenerator`)

* Memanfaatkan pustaka `setasign/fpdi` dan `fpdf`.
* Mengambil sejumlah $N$ halaman awal dari file PDF master buku, menggabungkannya secara terisolasi ke direktori penyimpanan publik, dan melindungi integritas seluruh naskah dari unduhan tidak resmi.

---

## 4. Keamanan & Matriks Akses (RBAC Matrix)

Sistem menggunakan hierarki otorisasi dinamis yang membaca izin berbasis JSON pada entitas `users` dan fallback ke relasi tabel `roles`:

```
                     ┌──────────────────┐
                     │ User Authenticated│
                     └────────┬─────────┘
                              │
               Is Admin? ─────┴───── Has Direct Permission (User)?
                  │                          │
                  ├─ YES ──> [Allow]         ├─ YES ──> [Allow]
                  │                          │
                  └─ NO ───> Check Role Permissions in DB
                                             │
                                             ├─ YES ──> [Allow]
                                             └─ NO ───> [Deny & Invalidate Session]

```

### Matriks Middleware & Hak Akses

| Middleware  | Target Area     | Cakupan Izin                            |
| ----------- | --------------- | --------------------------------------- |
| `IsAdmin` | Pengaturan Root | Memastikan atribut`role === 'admin'`. |

 |
| `EnsureDashboardPermission` | Dasbor Utama | Validasi izin granular per fitur (`buku.*`, `artikel.*`, `tim.*`, `harga.*`, `transaksi.*`, `royalty.manage`, dll.).

 |
| `EnsureAuthorPermission` | Portal Penulis | Memeriksa izin penulis (`author.dashboard.view`, pengaturan bank, penarikan royalti).

 |
| `EnsureSuratAccess` & `EnsureSuratPermission` | Modul Persuratan | Memeriksa apakah user memiliki akses persuratan (`can_access_surat`) dan permission granular terkait.

 |

> **Catatan Keamanan**: Middleware menerapkan kebijakan *zero-tolerance*: jika pengguna yang terautentikasi mencoba mengakses rute di luar batas izinnya, sistem akan melakukan *force-logout* serta menginvalitkan sesi dan token CSRF secara otomatis.

---

## 5. Struktur Relasi Basis Data (Entity Relationships)

```
  [User] 1 ────── 1 [Authors] 1 ────── N [AuthorBuku] N ────── 1 [Buku]
    │                                                              │
    ├─ 1:N ── [AuditLog]                                           ├─ 1:N ── [Comment]
    ├─ 1:N ── [SuratNotification]                                 └─ 1:N ── [DirectOrder]
    ├─ 1:N ── [IncomingLetter] 1 ── N [Disposition] 1 ── N [DispositionRecipient]
    └─ 1:N ── [OutgoingLetter]

```

* **User $\leftrightarrow$ Authors $\leftrightarrow$ Buku**: Relasi *Many-to-Many* melalui tabel pivot `author_buku` yang memungkinkan sebuah buku disusun oleh banyak penulis dengan porsi royalti yang berbeda.
* **DirectOrder $\leftrightarrow$ RoyaltyTransaction**: Setiap pesanan langsung berstatus `completed` menghasilkan mutasi kredit royalti ke akun penulis terkait.
* **IncomingLetter $\leftrightarrow$ Disposition $\leftrightarrow$ DispositionRecipient**: Relasi berjenjang yang memungkinkan satu surat masuk didisposisikan ke beberapa staf internal secara bersamaan.

---

## 6. Karakteristik Backend Unggulan

* **Database-Agnostic Reporting**: Agregasi data laporan bulanan kompatibel lintas DBMS (`strftime` untuk SQLite, `DATE_FORMAT` untuk MySQL, dan `to_char` untuk PostgreSQL).
* **Transaksi Finansial Atomik**: Seluruh proses kredit dan debit royalti dieksekusi di dalam blok `DB::transaction` untuk mencegah inkonsistensi data saldo.
* **Jejak Audit Komprehensif**: Pencatatan histori perubahan status surat, mutasi templat, dan unit kerja melalui model `AuditLog`.
* **Ekspor Data Stream**: Ekspor buku agenda surat masuk/keluar ke format CSV dan PDF cetak menggunakan *stream response* efisien memori.

---

## 7. Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk mengonfigurasi proyek di lingkungan lokal:

**1. Kloning Repositori**

```bash
git clone <url-repositori-anda>
cd Umri_Press-Universitas-Muhammadiyah-Riau-

```

**2. Instalasi Dependensi**

```bash
composer install
npm install

```

**3. Konfigurasi Environment**

```bash
cp .env.example .env
php artisan key:generate

```

**4. Migrasi Basis Data & Storage Link**

```bash
php artisan migrate
php artisan storage:link

```

**5. Menjalankan Aplikasi**
Gunakan skrip dev bawaan untuk menjalankan web server, database queue worker, dan aset Vite secara simultan:

```bash
composer dev

```

Atau jalankan secara terpisah melalui terminal:

```bash
php artisan serve
npm run dev
php artisan queue:listen

```
