# Ringkasan Eksekutif Arsitektur

Sistem ini dibangun di atas **Laravel 11** dan menggunakan perpaduan pola **Action-Domain & Observer Pattern** untuk menangani proses transaksi otomatis, serta sistem **Fine-Grained Dynamic RBAC (Role-Based Access Control)** yang memisahkan izin ke dalam 3 modul utama^^.

Sistem backend terbagi menjadi  **3 Domain Bisnis Utama** :

1. **E-Commerce & Penerbitan Buku (Katalog Publik, Direct Order, Preview Generator)**
   ^^
2. **Finansial & Portal Royalti Penulis (Royalty Automation & Payout)**
   ^^
3. **E-Office & Tata Kelola Persuratan Digital (Incoming/Outgoing Letter, Disposisi, Template Engine, & Audit Log)**
   ^^

## 2. Analisis Modul & Alur Bisnis (Business Workflows)

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

### A. Alur Transaksi & Automasi Royalti Penulis (E-Commerce Domain)

1. **Pemesanan Buku (`DirectOrder`):**
   * Konsumen memesan buku fisik/digital melalui form order langsung^^.
   * Model `Buku` memiliki kalkulasi dinamis untuk diskon hardcover dan softcover via Accessor (`harga_setelah_diskon` & `harga_soft_setelah_diskon`).
2. **Event Trigger (`DirectOrderObserver`):**
   * Saat status pesanan berubah menjadi `DirectOrder::STATUS_COMPLETED` (baik melalui manual admin patch di `DashboardController::updatePesanan` maupun auto trigger), Observer menangkap event `updated`.
3. **Perhitungan Bagi Hasil (`CalculateRoyaltyAction`):**
   * Sistem membaca relasi *Many-to-Many* antara `Buku` dan `Authors` yang memiliki pivot `royalty_percentage`.
   * Menghitung nominal royalti: `round(harga_setelah_diskon * (royalty_percentage / 100), 2)`.
   * Membuat rekaman `RoyaltyTransaction` dengan tipe `credit` dan status `pending` secara atomik di dalam Database Transaction.
4. **Penarikan Saldo (`AuthorPayoutController`):**
   * Penulis hanya bisa menarik saldo jika data rekening lengkap.
   * **Formula Saldo Tersedia:**
     $$
     \text{Available Balance} = \sum \text{Credit}_{\{\text{approved, paid}\}} - \sum \text{Debit}_{\{\text{pending, approved, paid}\}}
     $$
   * Mengajukan pencairan secara otomatis mencatat `PayoutRequest` dan membuat transaksi debit penahan saldo.

### B. Alur Tata Kelola Persuratan & Disposisi (E-Office Domain)

```
 ┌─────────────────┐       ┌─────────────────┐       ┌──────────────────┐
 │ Surat Masuk/Out │ ────> │ Multi-level CC  │ ────> │  In-App Notice   │
 │   Agenda Gen    │       │   Disposisi     │       │    & Audit Log   │
 └─────────────────┘       └─────────────────┘       └──────────────────┘
```

1. **Surat Masuk (`IncomingLetterController`):**
   * **Auto Numbering Agenda:** Nomor agenda dibuat otomatis per tahun takwim dengan padding 4 digit (`0001`, `0002`, dst.).
   * Mendukung penyimpanan berkas scan fisik (`scan_path`) dan lampiran (`attachment_path`).
2. **Disposisi Multi-Penerima (`DispositionController`):**
   * Pimpinan dapat mendisposisikan surat ke staf utama (`role: to`) dan tembusan (`role: cc`).
   * Setiap disposisi mentrigger `SuratNotification` dan tercatat dalam `AuditLog`.
   * Saat penerima menyelesaikan disposisi, notifikasi balik dikirim ke pembuat disposisi.
3. **Surat Keluar & Generator Template (`OutgoingLetterController`):**
   * **Dynamic Format Generator:** Format nomor surat mendukung placeholder terkonfigurasi:
     `{sequence}/{instansi}/{jenis}/{unit}/{bulan_roman}/{tahun}`.
   * **Variable Replacement Engine:** Template surat dapat merender tag dinamis seperti `{{nomor}}`, `{{tanggal}}`, `{{penerima}}`, `{{jabatan}}`, `{{perihal}}`, `{{isi}}`.
   * **Public Verification QR/Code:** Surat yang keluar menghasilkan kode heksadesimal unik 16 karakter (`generateVerificationCode()`) yang dapat diverifikasi publik tanpa login via `/surat/verify/{code}`^^.

### C. Generator Pratinjau Buku (`PdfPreviewGenerator`)

* Memanfaatkan pustaka `setasign/fpdi` dan `fpdf`^^.
* Mengambil sejumlah **$N$** halaman awal dari file PDF master buku, menggabungkannya menjadi satu file preview baru di storage publik, dan mencegah kebocoran full-content naskah.

## 3. Sistem Otorisasi & Hak Akses (Security & RBAC Matrix)

Sistem menggunakan kontrol hak akses berbasis atribut JSON pada tabel `users` dan fallback ke relasi `roles`:

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

### Matriks Hak Akses & Middleware

| **Middleware**                            | **Target Area** | **Cakupan Izin**                                                                             |
| ----------------------------------------------- | --------------------- | -------------------------------------------------------------------------------------------------- |
| `IsAdmin`                                     | Root Admin            | Memastikan kolom`role === 'admin'`.                                                              |
| `EnsureDashboardPermission`                   | Dashboard Utama       | Mengecek`buku.*`,`artikel.*`,`tim.*`,`harga.*`,`transaksi.*`,`royalty.manage`, dll^^.  |
| `EnsureAuthorPermission`                      | Portal Penulis        | Memeriksa izin penulis (`author.dashboard.view`, pengaturan bank, request pencairan).            |
| `EnsureSuratAccess`&`EnsureSuratPermission` | Modul Persuratan      | Memeriksa apakah user memiliki akses ke persuratan (`can_access_surat`) dan permission per aksi. |

> **Catatan Keamanan:** Middleware di sistem ini menerapkan tindakan defensif ketat: jika user yang login gagal melewati guard permission, session langsung di-invalidate dan di-logout otomatis (`Auth::logout()`).

## 4. Struktur Relasi Database (Entity Relationships)

```
  [User] 1 ────── 1 [Authors] 1 ────── N [AuthorBuku] N ────── 1 [Buku]
    │                                                              │
    ├─ 1:N ── [AuditLog]                                           ├─ 1:N ── [Comment]
    ├─ 1:N ── [SuratNotification]                                 └─ 1:N ── [DirectOrder]
    ├─ 1:N ── [IncomingLetter] 1 ── N [Disposition] 1 ── N [DispositionRecipient]
    └─ 1:N ── [OutgoingLetter]
```

* **User **$\leftrightarrow$** Authors **$\leftrightarrow$** Buku:** Relasi polimorfik/pivot yang memungkinkan 1 buku ditulis oleh banyak penulis (`author_buku`) dengan pembagian persentase royalti yang fleksibel.
* **DirectOrder **$\leftrightarrow$** RoyaltyTransaction:** Setiap pesanan sukses (`DirectOrder`) yang melibatkan penulis terhubung langsung ke mutasi kredit royalti.
* **IncomingLetter **$\leftrightarrow$** Disposition **$\leftrightarrow$** DispositionRecipient:** Relasi 1-ke-banyak berjenjang untuk mendistribusikan surat ke banyak staf/pejabat sekaligus.

## 5. Ringkasan Kunci untuk Kebutuhan Dokumentasi (README)

1. **Stack Inti:** Laravel 11, SQLite/MySQL support, Livewire + Volt, FPDI/FPDF^^.
2. **Karakteristik Backend:**
   * Database-agnostic monthly reporting queries (`strftime` untuk SQLite, `DATE_FORMAT` untuk MySQL, `to_char` untuk PostgreSQL).
   * Transaksi finansial atomik (`DB::transaction`).
   * Audit trail lengkap pada domain persuratan (`AuditLog`).
   * Integrasi file stream untuk ekspor CSV dan PDF Agenda Surat.
