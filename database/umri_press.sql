-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 13 Nov 2025 pada 20.22
-- Versi server: 10.3.39-MariaDB
-- Versi PHP: 8.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `umri_press`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `status` enum('publish','draft') NOT NULL DEFAULT 'draft',
  `views` int(11) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `authors`
--

CREATE TABLE `authors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `authors`
--

INSERT INTO `authors` (`id`, `image`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'authors/dr-dr-m-yulis-hamidy-mkes-mpd-ked-sp-1753000357.jpg', 'Dr. dr. M. Yulis Hamidy, M.Kes., M.Pd. Ked., Sp.', 'dr-dr-m-yulis-hamidy-mkes-mpd-ked-sp', 'KKLP merupakan dosen di Fakultas Kedokteran Universitas Riau, lahir di Air Tiris, Kampar, Riau dan besar di Pekanbaru. Pendidikan SD sampai SMA ditempuh di Pekanbaru, kemudian melanjutkan kuliah di Fakultas Kedokteran Universitas Andalas Padang. Setelah menjadi dokter kemudian mengabdi sebagai Dokter PTT di Puskesmas Senayang, Kepulauan Riau. Setelah menyelesaikan program PTT kemudian diangkat sebagai dosen dan melanjutkan pendidikan S2 di Universitas Padjadjaran Bandung. Setelah tamat S2 kemudian mengajar mata kuliah farmakologi di FK UNRI. Tidak puas dengan S2 farmakologi, kemudian mengikuti pendidikan S2 di bidang pendidikan kedokteran di Universitas Indonesia dan kemudian menyelesaikan pendidikan S3 di Universitas Andalas Padang.', '2025-07-20 08:32:37', '2025-07-20 08:32:37'),
(2, 'authors/dr-darmawi-mbiomed-phd-1753000400.jpg', 'dr. Darmawi, M.Biomed, PhD', 'dr-darmawi-mbiomed-phd', 'Lahir di Duri pada tanggal 20 September 1987 dari orang tua yang berlatar belakang pendidik, bekerja sebagai guru agama Islam. Dr. Darmawi mengenyam pendidikan dasar sampai menengah atas di tanah kelahirannya sampai tahun 2005. Pada awal tahun 2012, dr. Darmawi menyelesaikan pendidikan dokter umum dari Fakultas Kedokteran Universitas Riau. Pada tahun 2014, beliau memulai kariernya sebagai seorang tenaga pendidik di departemen histologi Fakultas Kedokteran Universitas Riau. Lalu beliau menyelesaikan program magister ilmu biomedik dari Fakultas Kedokteran Universitas Indonesia pada tahun 2018. Tahun 2022, Dr. Darmawi menyelesaikan pendidikan doktoral di International PhD Program in Medicine, Taipei Medical University. Pada saat pendidikan PhD ini, dr. Darmawi melakukan riset di laboratorium Translational Epigenetic Center (TEC) Shuang Ho Hospital-Taipei Medical University, New Taipei City dengan advisor Prof. Hung-Cheng Lai, MD, PhD. Pada saat ini, Dr. Darmawi adalah koordinator Program Studi Ilmu Biomedis Fakultas Kedokteran Universitas Riau. Fokus riset Dr. Darmawi adalah bionformatika, genomik, transkriptomik dan rekayasa genetika yang terutama pada keganasan. Pembaca dapat menghubungi beliau melalui email darmawi@lecturer.unri.ac.id.', '2025-07-20 08:33:20', '2025-07-20 08:33:20'),
(3, 'authors/wirawan-adikusuma-1753000455.jpg', 'Wirawan Adikusuma ', 'wirawan-adikusuma', 'adalah seorang peneliti yang mengkhususkan diri di bidang genomika, bioinformatika, dan farmasi klinis, dengan fokus pada identifikasi varian genetik dan pengembangan pendekatan bioinformatika untuk menemukan peluang penggunaan kembali obat (drug repurposing) pada berbagai penyakit. Minat penelitiannya meliputi genomika, bioinformatika, dan farmasi klinis, khususnya terkait penyakit alergi dan kanker. Dia juga aktif menerbitkan artikel di jurnal ilmiah bereputasi, yang menggambarkan kontribusinya yang signifikan di bidang tersebut. Sebagai peneliti yang terafiliasi dengan Badan Riset dan Inovasi Nasional (BRIN), karyanya turut mendorong kemajuan pemahaman mengenai peran varian genetik dan pengembangan pendekatan inovatif untuk penggunaan kembali obat.', '2025-07-20 08:34:15', '2025-07-20 08:34:15'),
(4, 'authors/lalu-muhammad-irham-mfarm-phd-1753000471.png', 'Lalu Muhammad Irham, M.Farm., Ph.D. ', 'lalu-muhammad-irham-mfarm-phd', 'adalah dosen tetap di Fakultas Farmasi, Universitas Ahmad Dahlan (UAD), Yogyakarta, Indonesia. Ia menyelesaikan pendidikan profesi apoteker dan Magister Farmasi Klinik di UAD dengan predikat cumlaude. Sejak tahun 2016, Irham aktif mengajar dan melakukan penelitian di institusi yang sama. Gelar doktor (Ph.D.) ia raih dari School of Pharmacy, Taipei Medical University, Taiwan, dengan fokus pada strategi drug repurposing berbasis genomik. Penelitian terkini yang digelutinya meliputi bidang farmakogenomik, genomik, dan pendekatan bioinformatika dalam pengembangan serta reposisi obat untuk penyakit kompleks seperti hepatitis B kronis, karsinoma hepatoseluler, kanker kolorektal, dan osteoporosis. Irham dikenal luas atas keahliannya dalam memanfaatkan studi asosiasi genom luas (GWAS) dan analisis variasi genomik untuk mengidentifikasi target terapeutik baru serta reposisi obat yang sudah ada. Kontribusinya dalam literatur ilmiah sangat signifikan, dengan lebih dari 5.000 sitasi di Scopus dan lebih dari 6.000 sitasi di Google Scholar, mencerminkan dampak besar di bidang farmakogenomik dan pengobatan presisi. Sejak tahun 2024, Irham juga menjabat sebagai Kepala Publikasi di Universitas Ahmad Dahlan, bertanggung jawab atas pengelolaan diseminasi riset dan aktivitas publikasi akademik. Keahliannya yang multidisipliner, yang menggabungkan farmasi klinik, genomik, dan biologi komputasi, menempatkannya sebagai salah satu tokoh terkemuka dalam pengembangan penemuan dan reposisi obat berbasis genomik, baik di Indonesia maupun di tingkat internasional. Selain itu, Irham aktif dalam pengelolaan jurnal ilmiah sebagai editor di beberapa jurnal nasional dan internasional, antara lain BMC Medical Genomics, Media Farmasi, Current Pharmacogenomics and Personalized Medicine, dan Narra J. Ia juga berperan sebagai reviewer di lebih dari 50 jurnal internasional bereputasi, yang menunjukkan komitmennya dalam menjaga kualitas publikasi ilmiah.', '2025-07-20 08:34:31', '2025-07-20 08:34:31'),
(5, 'authors/dr-eka-bebasari-msc-1753000486.jpg', 'dr. Eka Bebasari, M.Sc ', 'dr-eka-bebasari-msc', 'menyelesaikan pendidikan Sarjana Kedokteran di Fakultas Kedokteran Universitas Sumatera Utara pada tahun 2005. Setelah itu, melanjutkan studi Magister Sains di bidang Ilmu Kedokteran Dasar dan Biomedis di Fakultas Kedokteran Universitas Gadjah Mada, yang diselesaikan pada tahun 2010. Dalam lima tahun terakhir, dr. Eka Bebasari, M.Sc aktif melakukan penelitian di bidang kesehatan masyarakat, khususnya yang berkaitan dengan penyakit tidak menular seperti hipertensi, diabetes mellitus, serta kualitas hidup pasien. Beberapa penelitian yang dipimpin antara lain: “Hubungan Senam Prolanis dengan Kualitas Hidup Pasien Diabetes Mellitus Tipe 2” (2019), dan “Hubungan Aktivitas Fisik, Kekuatan Otot, dan Densitas Tulang dengan Kualitas Hidup Wanita Pascamenopause” (2016). Selain itu, dr. Eka Bebasari, M.Sc juga aktif dalam kegiatan pengabdian kepada masyarakat di berbagai daerah di Provinsi Riau, seperti skrining hiperglikemia, edukasi mengenai diabetes mellitus, dan promosi perilaku hidup bersih dan sehat. Karya ilmiah dr. Eka Bebasari, M.Sc telah diterbitkan dalam beberapa jurnal nasional, di antaranya: “Korelasi Lama Senam Asma dengan Faal Paru pada Pasien Asma” (2016), dan “Analisis Faktor Risiko Stroke di RSUD Arifin Achmad Provinsi Riau” (2018). Ia juga telah menulis buku berjudul Farmakologi Hipertensi yang terbit pada tahun 2019 dan telah memperoleh Hak Kekayaan Intelektual (HKI). Atas dedikasinya dalam bidang pendidikan dan pengabdian, dr. Eka Bebasari, M.Sc menerima penghargaan Satya Lencana 10 Tahun dari Presiden Republik Indonesia pada tahun 2017. ', '2025-07-20 08:34:46', '2025-07-20 08:34:46'),
(6, 'authors/nurul-azizah-ssi-mbiomed-1753000505.jpg', 'Nurul Azizah, S.Si., M.Biomed', 'nurul-azizah-ssi-mbiomed', 'lahir di Balai Tangah pada 28 Maret 1999 dan dibesarkan dalam keluarga wiraswasta yang menjunjung tinggi nilai kerja keras. Ia mengawali pendidikan dasarnya di Pekanbaru, melanjutkan jenjang SMP dan SMA di Sumatera Barat, lalu kembali ke Pekanbaru untuk menempuh pendidikan tinggi. Pada tahun 2022, Nurul meraih gelar Sarjana Sains dari Program Studi Biologi, Fakultas MIPA dan Kesehatan, Universitas Muhammadiyah Riau. Ketertarikannya terhadap ilmu biomedis membawanya melanjutkan studi magister di Fakultas Kedokteran Universitas Riau dan menyelesaikannya pada tahun 2024. Sejak tahun yang sama, ia aktif sebagai tenaga kependidikan di Fakultas Kedokteran Universitas Muhammadiyah Riau, dengan fokus pada bidang Biokimia dan Farmakologi. Dalam bidang penelitian, ia pernah terlibat dalam studi mengenai hemoroid dan inflamasi, yang dilaksanakan di Laboratorium Biomedik Terpadu Universitas Riau serta Laboratorium Farmasi Universitas Muhammadiyah Riau. Fokus risetnya saat ini berada di ranah biologi molekuler dan biokimia, dengan minat khusus pada mekanisme biologis dalam proses penyakit. Ia terus berkomitmen untuk mendukung pengembangan ilmu pengetahuan di lingkungan akademik. Untuk keperluan akademik dan kolaborasi, Nurul dapat dihubungi melalui email: nurulazizah28399@gmail.com.', '2025-07-20 08:35:05', '2025-07-20 08:35:05'),
(7, 'authors/dr-lian-pajrianti-1753000519.jpg', 'dr. Lian Pajrianti', 'dr-lian-pajrianti', 'lahir di Taluk kuantan pada tanggal 15 juni 1988. Pendidikan dasar hingga menengah pertama di selesaikan di kota kelahiran Teluk Kuantan, Riau. Kemudian melanjutkan SMA di SMAN 8 Pekanbaru, Riau. Tahun 2006 berkuliah di Program Studi Studi Ilmu Kedokteran, Fakultas Kedoteran Universitas Riau, memperoleh gelar S.ked tahun 2010. Profesi dokter diselesaikan di Fakultas  yang sama tahun 2012 dan memperoleh gelar dr. Karir sebagai dokter dimulai di RSUD Taluk Kuantan selama 2 tahun. Selanjutnya, selama tiga tahun berdomisili di Jepang mendampingi suami yang sedang menempuh Pendidikan Doktoral (S3) di Hiroshima University, Jepang. Selama di Jepang aktif sebagai pengisi kegiatan mahasiswa dan komunitas Indonesia seputar permasalahan kesehatan. Tahun 2021 menjadi Dokter Ahli Pertama di Rumah Sakit Universitas Riau. Studi lanjut Magister ditempuh pada tahun 2023 pada Program Studi Magister  Biomedis dengan konsentrasi Farmakologi di Fakultas kedokteran universitas Riau, selasai tahun 2025. Pembaca dapat menghubungi beliau melalui email lianpajrianti.dr@gmail.com', '2025-07-20 08:35:19', '2025-07-20 08:35:19'),
(8, 'authors/dr-annisa-abdi-ghifari-1753000531.jpg', 'dr. Annisa Abdi Ghifari', 'dr-annisa-abdi-ghifari', 'lahir di Bangkinang, 20 November 1993 merupakan seorang mahasiswa S2 Ilmu Biomedis di Bidang Farmakologi. Pendidikan SD ditempuh di Bangkinang, SMP-SMA di Pekanbaru yang diselesaikan pada tahun 2011. Kemudian menamatkan pendidikan S1 Pendidikan Dokter dan Profesi Dokter di Fakultas Kedokteran Universitas Riau pada tahun 2016. Pernah menjadi Kepala Instalasi Rawat Jalan di sebuah RS Swasta di Pekanbaru, saat ini fokus menyelesaikan pendidikan di Program Magister S2 Ilmu Biomedis di Fakultas Kedokteran Universitas Riau.', '2025-07-20 08:35:31', '2025-07-20 08:35:31'),
(9, 'authors/assoc-prof-dr-harun-mukhtar-skom-mkom-1754363548.jpg', 'Assoc. Prof. Dr. Harun Mukhtar, S.Kom., M.Kom', 'assoc-prof-dr-harun-mukhtar-skom-mkom', 'Harun Mukhtar adalah Associate Professor pada Program Studi Teknik Informatika, Universitas Muhammadiyah Riau. Saat ini beliau menjabat sebagai Dosen Utama dan memiliki latar belakang pendidikan yang kuat di bidang Teknologi Informasi. Gelar Sarjana diperoleh dari STMIK AMIK Riau pada tahun 2007, gelar Magister dari Universitas Putra Indonesia \"YPTK\" Padang pada tahun 2010, serta gelar Doktor dari Universiti Malaysia Kelantan (UMK), Malaysia pada tahun 2024. Keahlian utama beliau terletak pada bidang Ilmu Data (Data Science), dengan fokus pada analisis data, pembelajaran mesin (machine learning), serta aplikasi big data. Dr. Harun Mukhtar aktif terlibat dalam berbagai proyek penelitian dan telah mempublikasikan sejumlah artikel ilmiah di jurnal bereputasi dan prosiding konferensi nasional maupun internasional. Hal ini mencerminkan komitmen beliau terhadap pengembangan ilmu pengetahuan dan inovasi akademik. Minat penelitian beliau mencakup pengembangan metode dan teknik baru dalam pemrosesan dan analisis data yang efektif untuk menjawab berbagai tantangan dunia nyata, termasuk di dalamnya topik-topik seperti kriptografi, komputasi awan (cloud computing), ilmu data, jaringan komputer, serta aplikasi open source. Dalam bidang pengajaran, beliau mengampu sejumlah mata kuliah inti seperti Jaringan Komputer, Keamanan Jaringan Komputer, Basis Data, Smart City, Data Sains, serta mata kuliah lain yang berkaitan dengan sistem dan teknologi informasi. Selain itu, beliau juga aktif sebagai penulis artikel ilmiah, pemakalah, dan narasumber dalam berbagai seminar, khususnya di bidang Linux dan teknologi open source lainnya.', '2025-08-05 03:12:28', '2025-08-05 05:21:08'),
(10, 'authors/sarah-nabila-1754637182.png', 'Sarah Nabila', 'sarah-nabila', 'Sarah Nabilla adalah seorang mahasiswa Universitas Muhammadiyah Riau jurusan Teknik Informatika. Saat ini, ia sedang menempuh semester 6 dan aktif terlibat dalam berbagai kegiatan kampus, termasuk menjadi panitia dan peserta acara, serta terlibat dalam organisasi internal kampus. Sarah memiliki minat yang kuat di bidang jaringan, dengan fokus khusus pada\nforensik digital dan keamanan data. Kecintaannya pada bidang ini mendorongnya untuk mengeksplorasi aspek-aspek penting teknologi informasi yang terkait dengan perlindungan data dan investigasi digital.', '2025-08-08 07:13:02', '2025-08-08 07:13:02'),
(11, 'authors/ridho-irawan-1754637305.png', 'Ridho Irawan', 'ridho-irawan', 'Ridho Irawan adalah seorang mahasiswa Universitas Muhammadiyah Riau yang sedang menempuh pendidikan di program studi Teknik Informatika. Saat ini, ia tengah menempuh pendidikan di semester 6 dan aktif mengikuti berbagai kegiatan kampus, yaitu menjadi panitia dan peserta acara, serta mengikuti organisasi internal kampus. Ridho memiliki ketertarikan di bidang\njaringan komputer, dengan minat khusus pada forensik digital dan keamanan data. Ketertarikannya tersebut mendorongnya untuk mendalami aspek-aspek penting dalam dunia teknologi informasi yang terkait dengan perlindungan data dan investigasi digital.', '2025-08-08 07:15:05', '2025-08-08 07:15:05'),
(12, 'authors/budi-istana-1754637413.png', 'Dr. Budi Istana, ST., M.Eng', 'dr-budi-istana-st-meng', 'Meraih gelar Sarjana Teknik Mesin dari Politeknik Negeri Bandung (ST., 2009), Universitas Gadjah Mada (M.Eng., 2011), dan Institut Teknologi Sepuluh Nopember (Dr., 2023). Penelitiannya berfokus pada pemanfaatan limbah pelepah kelapa sawit untuk panel akustik berkelanjutan, yang menunjukkan komitmennya terhadap keberlanjutan lingkungan. Ia telah\nmemimpin berbagai proyek penelitian, termasuk studi tentang bantalan rem sepeda motor dan peramalan kedatangan wisatawan menggunakan algoritma hibrida. Karyanya dipublikasikan di jurnal terkemuka, dan ia menerima juara pertama dalam Kompetisi Inovasi Provinsi Riau 2014.\nKontribusinya bermanfaat bagi akademisi dan industri, terutama dalam bahan otomotif dan akustik.', '2025-08-08 07:16:53', '2025-08-27 14:50:04'),
(13, 'authors/yulia-fatma-s-kom-m-cs-1754637618.png', 'Yulia Fatma, S. Kom, M. Cs', 'yulia-fatma-s-kom-m-cs', 'Menyelesaikan pendidikan Sarjana pada Jurusan Teknik Informatika, Universitas Amikom Yogyakarta, dan melanjutkan studi Magister pada Program Magister Ilmu Komputer di Universitas Gadjah Mada. Saat ini, beliau aktif mengabdi sebagai dosen pada Jurusan Informatika, Universitas Muhammadiyah Riau. Fokus penelitian yang digelutinya meliputi bidang Kriptografi, Kecerdasan Buatan (Artificial Intelligence), serta penerapannya dalam sistem keamanan dan pengolahan data. Selain mengajar, beliau juga\nterlibat dalam berbagai kegiatan akademik seperti penelitian, penulisan artikel ilmiah, dan pengembangan teknologi berbasis open source. Yulia Fatma dapat dihubungi melalui email: yuliafatma@umri.ac.id', '2025-08-08 07:20:18', '2025-08-08 07:20:18'),
(15, 'authors/dr-santoso-ss-msi-1757296163.png', 'Dr. Santoso, S.S., M.Si', 'dr-santoso-ss-msi', 'Dr. Santoso, S.S., M.Si adalah seorang akademisi, pemikir, dan tokoh Psikologi Islam di Riau. Saat ini beliau dipercaya sebagai Dekan Fakultas Studi Islam Universitas Muhammadiyah Riau (UMRI) sekaligus Ketua Asosiasi Psikologi Islam Wilayah Riau. \nPerjalanan hidupnya merupakan cerminan dedikasi seorang ilmuwan Muslim yang menggabungkan kekuatan ilmu pengetahuan, spiritualitas, dan pengabdian sosial. Keresahan hidupnya  dimulai dari kecintaannya pada ilmu keislaman dan psikologi. Setelah menyelesaikan studi sarjana dan magister, beliau melanjutkan pendidikan doktoralnya pada Program S3 Psikologi Pendidikan Islam di Universitas Muhammadiyah Yogyakarta (UMY), dengan disertasi:  “Motivasi Agama Islam pada Kaum Mualaf Suku Akit”. Disertasi ini menjadi karya monumental yang mengungkap proses psikologis dan spiritual dalam perjalanan keislaman masyarakat adat di pedalaman Riau. Penelitian tersebut tidak hanya memberi kontribusi akademik, tetapi juga memiliki makna sosial dan dakwah yang mendalam.\nSejak bergabung dengan UMRI di tahun 2018, Dr. Santoso tampil sebagai dosen yang berdedikasi. Ia mengampu mata kuliah-mata kuliah inti Psikologi Islam, mengembangkan kurikulum berbasis OBE, serta membangun tradisi akademik yang mengintegrasikan ilmu pengetahuan modern dengan nilai-nilai Islam.\nKariernya kemudian berkembang ke ranah kepemimpinan sebagai Dekan FSI UMRI. Dr. Santoso mendorong fakultas menjadi pusat kajian keilmuan yang melahirkan generasi berkarakter Islami, berdaya saing global, dan berkomitmen pada nilai kemanusiaan. Dalam kapasitasnya sebagai Ketua Asosiasi Psikologi Islam Wilayah Riau, beliau juga menjadi motor penggerak kolaborasi akademik dan pengembangan Psikologi Islam di tingkat regional.\nDi luar kampus, Dr. Santoso aktif membina masyarakat melalui Lembaga Dakwah Komunitas Muhammadiyah Riau. Beliau terlibat dalam pendampingan mualaf, penguatan moderasi beragama, pembinaan remaja lintas etnis, hingga pelestarian seni tradisional Jawa dan budaya Melayu sebagai media dakwah kultural.\nBagi Dr. Santoso, Psikologi Islam adalah jembatan antara ilmu pengetahuan dan spiritualitas. Ia meyakini bahwa kesehatan mental sejati hanya dapat dicapai dengan keseimbangan antara akal, hati, dan iman. Dengan visi tersebut, beliau berkomitmen membangun generasi Muslim yang berilmu, berakhlak, dan berdaya saing, sekaligus menanamkan semangat kemanusiaan universal.', '2025-09-08 01:49:23', '2025-09-08 01:49:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `author_buku`
--

CREATE TABLE `author_buku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `buku_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `author_buku`
--

INSERT INTO `author_buku` (`id`, `author_id`, `buku_id`, `created_at`, `updated_at`) VALUES
(1, 9, 1, NULL, NULL),
(2, 8, 2, NULL, NULL),
(3, 9, 3, NULL, NULL),
(4, 1, 2, NULL, NULL),
(5, 2, 2, NULL, NULL),
(6, 3, 2, NULL, NULL),
(7, 4, 2, NULL, NULL),
(8, 5, 2, NULL, NULL),
(9, 6, 2, NULL, NULL),
(10, 7, 2, NULL, NULL),
(11, 13, 1, NULL, NULL),
(12, 12, 1, NULL, NULL),
(13, 10, 1, NULL, NULL),
(14, 11, 1, NULL, NULL),
(16, 15, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `sinopsis` text NOT NULL,
  `daftar_isi` text NOT NULL,
  `cover` varchar(255) NOT NULL,
  `cover_thumbnail` varchar(255) DEFAULT NULL,
  `isbn` varchar(255) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `institusi` varchar(255) DEFAULT NULL,
  `ukuran` varchar(255) NOT NULL,
  `ketersediaan` tinyint(1) NOT NULL DEFAULT 1,
  `jumlah_halaman` int(11) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `marketplace_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `kategori_id`, `judul`, `slug`, `deskripsi`, `sinopsis`, `daftar_isi`, `cover`, `cover_thumbnail`, `isbn`, `harga`, `institusi`, `ukuran`, `ketersediaan`, `jumlah_halaman`, `tanggal_terbit`, `marketplace_links`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'Long Short-Term Memory (LSTM) dengan Algoritma Pemrosesan untuk Peramalan Kedatangan Wisatawan pada Data Time Series', 'long-short-term-memory-lstm-dengan-algoritma-pemrosesan-untuk-peramalan-kedatangan-wisatawan-pada-data-time-series', '<p>Buku Long Short-Term Memory (LSTM) untuk Peramalan Kedatangan Wisatawan pada Data Time Series menyajikan informasi</p><p>umum mengenai isi dan tujuan penulisan buku. Buku ini ditujukan bagi mahasiswa, dosen, dan masyarakat umum yang berminat pada bidang peramalan data, khususnya data time series. Disusun dengan pendekatan yang mudah dipahami, buku ini dapat digunakan oleh pembaca dari berbagai tingkat pemahaman, mulai dari pemula, menengah, hingga mahir. Selain itu, pada bab ini juga dijelaskan mengenai sistematika penulisan buku yang disusun secara berurutan untuk memandu pembaca dalam memahami konsep dasar hingga implementasi algoritma LSTM dalam konteks peramalan jumlah kunjungan wisatawan.</p>', '<p>Bahwa peramalan memiliki dasar dalam Al- Qur’an, khususnya melalui kisah Nabi Yusuf AS dalam Surah Yusuf yang menunjukkan bagaimana mimpi dapat diinterpretasikan sebagai bentuk peramalan masa depan berdasarkan simbol dan data, yang diterjemahkan menjadi rencana strategis. Ayat-ayat seperti QS Yusuf: 43 dan 47–49 menggambarkan kemampuan Nabi Yusuf dalam memprediksi masa depan dan menyarankan langkah preventif, selaras dengan konsep peramalan modern dalam ilmu komputer seperti data mining, forecasting, dan decision support system. Nilai-nilai ini dijadikan dasar filosofis untuk mengembangkan metode peramalan berbasis deep learning dan hybrid intelligence. Selanjutnya, dibahas pentingnya sektor pariwisata yang berdampak pada aspek ekonomi, sosial budaya, dan lingkungan. Pengembangan pariwisata memberikan manfaat ekonomi seperti peningkatan kesejahteraan masyarakat, namun juga membawa dampak negatif seperti pengangguran, kesenjangan sosial, dan kerusakan lingkungan. Pemerintah Indonesia pun mendukung pariwisata melalui regulasi bebas visa dan strategi promosi digital. Dalam era digital, teknologi informasi seperti web, media sosial, dan big data digunakan untuk memahami perilaku wisatawan serta memprediksi permintaan pariwisata secara akurat, karena sifat produk pariwisata yang mudah rusak dan sangat</p>', '<p><br></p><p>Kata Pengantar......................................................................................v</p><p>Daftar Isi.............................................................................................vii</p><p>Daftar Tabel...........................................................................................x</p><p>Daftar Gambar.....................................................................................xii</p><p>Daftar Singkatan................................................................................xiii</p><p>Bab 1. Informasi Buku dan Sistematika Penulisan...............................1</p><p>1.1. Informasi Buku..........................................................................1</p><p>1.2. Sistematika Penulisan................................................................1</p><p>Bab 2. Pendahuluan.............................................................................12</p><p>2.1. Ayat peralaman dalam Al – Qur’an.........................................12</p><p>2.1. Pariwisata merupakan industri yang menjanjikan...................16</p><p>2.2. Permasalahan yang dibahas.....................................................22</p><p>Bab 3. Metode untuk Peramalan Kedatangan Turis............................29</p><p>3.1. Machine Learning (ML)..........................................................32</p><p>3.2. Deep Learning (DL)................................................................34</p><p>3.3. Metode Hybrid.........................................................................37</p><p>Bab 4. Masalah Peramalan Kedatangan Wisatawan dan Solusinya....45</p><p>4.1. Overfitting...............................................................................45</p><p>4.2. Noise / bias..............................................................................46</p><p>4.3. Strategi untuk Meningkatkan Akurasi.....................................50</p><p>Bab 5. Alasan Memilih LSTM sebagai Metode Peramalan Unggul...55</p><p>5.1. Kesimpulan Temuan Studi.......................................................57</p><p>5.2. Analisis Kesenjangan...............................................................58</p><p>5.3. Pentingnya mengatasi kesenjangan.........................................60</p><p>5.4. Hubungan antara kesenjangan dengan permasalahan.............61</p><p><br></p><p>vii</p><p><br></p><p>Bab 6. Long Short-Term Memory (LSTM).........................................63</p><p>Bab 7. Tren dan Arah DL untuk Peramalan Kedatangan Wisatawan..74</p><p>7.1. Big data untuk peramalan........................................................75</p><p>7.2. Data Indeks Pencarian Internet................................................79</p><p>Bab 8. Dataset.....................................................................................81</p><p>Bab 9. Evaluasi Model Peramalan......................................................85</p><p>9.1. Root Mean Squared Error (RMSE).........................................89</p><p>9.2. Mean Square Error (MSE).......................................................90</p><p>9.3. Mean Absolute Percentage Error (MAPE)..............................91</p><p>9.4. Mean Absolute Error (MAE)...................................................92</p><p>9.5. Mengukur Akurasi Peramalan dengan Confusion Matrix.......93</p><p>Bab 10. Algoritma DL dengan Teknik Pemrosesan............................95</p><p>10.1. Proses Pembentukan Dataset.................................................96</p><p>10.2. Pengurangan Noise dengan HHT........................................101</p><p>Bab 11. Hasil Percobaan...................................................................104</p><p>11.1. Dataset dan pengaturan eksperimen....................................104</p><p>11.2. Pembersihan data Hilbert - Huang Transform (HHT).........105</p><p>11.3. Pembahasan.........................................................................107</p><p>Bab 12. DL untuk Peramalan dengan Algoritma Pemrosesan..........112</p><p>Bab 13. Efektivitas DL Berbasis LSTM yang ditingkatkan..............117</p><p>13.1. Pengantar LSTM untuk peramlan........................................117</p><p>13.2. LSTM untuk peramlan dengan HHT...................................118</p><p>13.3. Evaluasi Hasil Peramalan....................................................125</p><p>Bab 14. Implementasi dengan Colab.................................................129</p><p>14.1. Idenfitikasi dan pembentukan data......................................129</p><p>14.2. Peramalan menggunakan LSTM.........................................139</p><p>Bab 15. Kesimpulan Pekerjaan Masa Depan....................................153</p><p>15.1. Kontribusi keilmuan............................................................154</p><p><br></p><p>viii</p><p><br></p><p>15.2. Detail Kontribusi.................................................................155</p><p>15.3. Pekerjaan Masa Depan........................................................157</p><p>15.4. Ringkasan kontribusi...........................................................158</p><p>Daftar Pustaka...................................................................................160</p><p>Lampiran A........................................................................................180</p><p>Lampiran B........................................................................................183</p><p>Biografi Penulis.................................................................................188</p>', 'assets/img/books/covers/ABHbRNuAFFQkKfN1RmRLsXRGcIFR8R6XUdJIEtRD.jpg', 'assets/img/books/thumbnails/A9n0E9Eb1TmnaPdWmLuVSLnhZEV8wbsdZwTE9s3S.jpg', '978-634-04-2588-8', 112000, 'UmriPress', '15.5 × 23 cm', 1, 205, '2025-08-25', '[]', 1, NULL, '2025-08-05 03:16:22', '2025-09-08 02:55:05'),
(2, 1, 'Peluang Terapi Metformin Selain Sebagai Obat Diabetes', 'peluang-terapi-metformin-selain-sebagai-obat-diabetes', '<p><br></p><p>Metformin, yang selama ini digunakan sebagai terapi lini pertama untuk pengobatan diabetes tipe 2, ternyata memiliki potensi terapeutik yang lebih luas. Dalam beberapa tahun terakhir, berbagai penelitian telah mengungkapkan manfaat metformin dalam terapi anti-kanker, anti-inflamasi, dan dalam manajemen sindrom ovarium polikistik (PCOS). Buku ini mencoba menggali peluang-peluang tersebut secara lebih mendalam, dengan harapan dapat memberikan wawasan baru bagi peneliti, praktisi medis, dan apoteker untuk mengoptimalkan penggunaan metformin dalam konteks klinis yang lebih luas.</p>', '<p><br></p><p>Metformin telah lama dikenal sebagai obat utama dalam pengobatan Diabetes Melitus (DM) tipe 2. Sebagai agen antidiabetik, metformin bekerja dengan meningkatkan sensitivitas insulin, mengurangi produksi glukosa hati, serta meningkatkan pengambilan glukosa oleh otot, sehingga efektif menurunkan kadar gula darah. Namun, seiring dengan kemajuan penelitian medis dan farmakologi, metformin menunjukkan potensi yang lebih luas di luar perannya sebagai pengontrol diabetes. Berbagai studi terbaru telah mengungkap bahwa metformin memiliki efek terapeutik pada berbagai kondisi kesehatan lainnya, memberikan peluang baru dalam bidang terapi yang sebelumnya tidak banyak diperhatikan.</p>', '<p><br></p><p>Kata Pengantar.....................................................................................Iv</p><p>Daftar Isi................................................................................................v</p><p>Bab. 1 pendahuluan...............................................................................1</p><p>1.1 Sejarah dan Perkembangan......................................................2</p><p>1.2 Mekanisme Kerja.....................................................................3</p><p>Bab. 2 Farmakokinetik dan Farmakodinamik Metformin.....................4</p><p>2.1. Absorpsi, Distribusi, Metabolisme, dan Ekskresi...................4</p><p>2.2. Mekanisme Kerja dan Efek Farmakologi...............................6</p><p>Bab. 3 Metformin dan Kesehatan Kardiovaskular..............................12</p><p>Bab. 4 Metformin Sebagai Anti Inflamasi..........................................17</p><p>4.1 Metformin sebagai anti inflamasi..........................................17</p><p>4.2 Mekanisme Aksi Metformin dalam Proses Anti-Inflamasi...17</p><p>4.3 Bukti Klinis dan Preklinis Efek Anti-Inflamasi Metformin. .18</p><p>4.4 Potensi Klinis Metformin sebagai Agen Terapi Anti-Inflamasi</p><p>.....................................................................................................19</p><p>Bab. 5 metformin sebagai anti kanker.................................................20</p><p>5.1 Metformin Sebagai Anti Kanker............................................20</p><p>5.2 Mekanisme Aksi Metformin dalam Penghambatan Sel Kanker</p><p>.....................................................................................................20</p><p>5.3 Bukti Klinis dan Preklinis Penggunaan Metformin dalam</p><p>Terapi Kanker..............................................................................21</p><p>5.4 Penggunaan Metformin sebagai Adjuvan dalam Terapi</p><p>Kanker..........................................................................................22</p><p><br></p><p>vi</p><p><br></p><p>5.5 Tantangan dan Potensi Masa Depan Metformin dalam</p><p>Onkologi......................................................................................22</p><p>Bab. 6 Metformin dan Gangguan Metabolik Non-Diabetes...............24</p><p>6.1 Metformin dalam Terapi Sindrom Polikistik Ovarium (PCOS)</p><p>.....................................................................................................24</p><p>6.2 Metformin dan Penyakit Hati Berlemak Non-Alkohol</p><p>(NAFLD).....................................................................................27</p><p>6.3. Metformin dalam Manajemen Obesitas................................31</p><p>Bab. 7 Metformin dan Anti Penuaan...................................................34</p><p>7.1 Metformin sebagai Obat Anti-Penuaan.................................34</p><p>7.2 Efek Metformin terhadap Peradangan dan Stres Oksidatif...36</p><p>7.3 Studi Klinis Metformin dan Umur Panjang...........................38</p><p>Bab. 8 efek metformin pada neuerologi..............................................41</p><p>8.1 Manfaat Metformin Terkait Penyakit Alzheimer Dan Penyakit</p><p>Neurodegeneratif.........................................................................42</p><p>8.2 Efek Metormin Terhadap Parkinson......................................43</p><p>8.3. Metormin Terhadap Kesehatan Otak....................................44</p><p>Daftar Pustaka.....................................................................................48</p>', 'assets/img/books/covers/CSUlaUCH6RF8T0ScZzRQBZuCyhTIzgjYKlUX5Zuc.jpg', 'assets/img/books/thumbnails/ngCGDnUizfW1jF9pfHVc3ZkmZ5HSsH8bwRvO3PRg.jpg', '978-634-04-2610-6 (PDF)', 60000, 'UmriPress', '165 × 250 mm', 1, 68, '2025-08-10', '[]', 1, NULL, '2025-08-05 03:27:18', '2025-09-11 03:40:56'),
(3, 2, 'Cloud Computing', 'cloud-computing', '<p>Tiga model utama layanan cloud computing, yaitu IaaS, PaaS, dan SaaS, masing-masing dengan tingkat kontrol dan fleksibilitas berbeda sesuai kebutuhan pengguna. IaaS menyediakan infrastruktur dasar seperti server dan penyimpanan; PaaS menawarkan lingkungan pengembangan aplikasi tanpa perlu mengelola infrastruktur; sementara SaaS memungkinkan pengguna langsung memakai aplikasi berbasis cloud. Berbagai contoh penyedia layanan seperti Biznet GIO, SoftLayer, Rackspace, dan Google Drive ditampilkan untuk IaaS, sedangkan untuk PaaS dibahas platform seperti Facebook, Engine Yard, dan Google App Engine. Adapun layanan SaaS dijelaskan melalui aplikasi seperti InvoiceBerry, Pipedrive, dan C-Desk.</p>', '<p>Tiga model utama layanan cloud computing, yaitu IaaS, PaaS, dan SaaS, masing-masing dengan tingkat kontrol dan fleksibilitas berbeda sesuai kebutuhan pengguna. IaaS menyediakan infrastruktur dasar seperti server dan penyimpanan; PaaS menawarkan lingkungan pengembangan aplikasi tanpa perlu mengelola infrastruktur; sementara SaaS memungkinkan pengguna langsung memakai aplikasi berbasis cloud. Berbagai contoh penyedia layanan seperti Biznet GIO, SoftLayer, Rackspace, dan Google Drive ditampilkan untuk IaaS, sedangkan untuk PaaS dibahas platform seperti Facebook, Engine Yard, dan Google App Engine. Adapun layanan SaaS dijelaskan melalui aplikasi seperti InvoiceBerry, Pipedrive, dan C-Desk.</p>', '<p>Kata Pengantar......................................................................................v</p><p>Daftar Isi...............................................................................................vi</p><p>Daftar Gambar.......................................................................................x</p><p>Daftar Tabel.........................................................................................xii</p><p>Bab1.Informasi Buku dan Sistematika Penulisan.................................1</p><p>Bab 2.Pendahuluan................................................................................9</p><p>2.1. Pengertian Cloud Computing...................................................15</p><p>2.2. Cara Kerja Cloud Computing..................................................18</p><p>2.3. Karakteristik Cloud Computing...............................................20</p><p>2.3.1. On Demoand Self Service................................................20</p><p>2.3.2. Broad Network Access.....................................................21</p><p>2.3.3. Resource Pooling.............................................................21</p><p>2.3.4. Rapid Elasticity................................................................22</p><p>2.3.5. Measured Service.............................................................23</p><p>Bab 3.Model Layanan Cloud Computing...........................................25</p><p>3.1. Infrastructure As A Service (IaaS)...........................................27</p><p>3.1.1. Biznet “Gio Cloud”..........................................................28</p><p>3.1.2. Softlayer...........................................................................29</p><p>3.1.3 Rackspace Cloud...............................................................30</p><p>3.1.4. Google Drive....................................................................31</p><p>3.2. Platform As A Service (PaaS)..................................................33</p><p>3.2.1. Facebook..........................................................................34</p><p>3.2.2. Engine Yard......................................................................35</p><p>3.2.3. Google App Engine..........................................................37</p><p>3.3. Sofware AS A Service (SaaS)..................................................37</p><p>3.3.1. Invoice Berry...................................................................38</p><p>3.3.2. Pipe Drive........................................................................40</p><p>3.3.3. Cdesk...............................................................................41</p><p><br></p><p>vii</p><p><br></p><p>3.3.4. Sleekr...............................................................................43</p><p>Bab 4.Virtualisasi................................................................................46</p><p>4.1. Virtualisasi Hardware..............................................................47</p><p>4.1.1. Virtualisasi penuh (Full virtualization)............................50</p><p>4.1.2. Virtualisasi paruh (Para virtualization)............................52</p><p>4.1.3. Virtualisasi asli (Native virtualization)............................54</p><p>4.2. Virtualisasi Sistem Operasi......................................................55</p><p>4.3. Virtualisasi Software................................................................57</p><p>Bab 5.Keamanan Cloud.......................................................................59</p><p>5.1. Keamanan Data........................................................................60</p><p>5.1.1. Ancaman dari luar............................................................62</p><p>5.1.2. Ancaman dari dalam........................................................63</p><p>5.1.3. Ancaman dari manusia.....................................................64</p><p>5.2. Kriptografy..............................................................................65</p><p>5.3. Teknik Akuisisi........................................................................66</p><p>5.3.1. Analisis Teknik Akuasisi Model I....................................67</p><p>5.3.2. Analisis Teknik Akuasisi Model II...................................70</p><p>Bab 6. Mengidentifikasi Kebutuhan....................................................73</p><p>6.1. File System dan Storage..........................................................74</p><p>6.3. Memperkirakan Resource........................................................75</p><p>6.4. Fasilitas Backup.......................................................................76</p><p>Bab 7. Hipervisor................................................................................78</p><p>7.1. Hypervisor type 1 (Bare-Metal Architecture)..........................78</p><p>7.1.1. Install Xen........................................................................79</p><p>7.1.2. Konfigurasi Jaringan........................................................82</p><p>7.1.3. Membuat Mesin Virtual dengan Xen...............................84</p><p>7.1.4. Monitoring dan Manajemen VM.....................................85</p><p>7.1.5. Memanggil Mesin Virtual di Xen dengan Browser.........86</p><p>7.1.6. Backup dan Snapshot VM...............................................88</p><p>7.2. Hypervisor type 2....................................................................89</p><p>7.2.1. Oracle VirtualBox............................................................90</p><p>7.2.2. VMware Workstation dan VMware Player......................92</p><p><br></p><p>viii</p><p><br></p><p>7.2.3. Parallels Desktop.............................................................92</p><p>7.2.4. GNOME Boxes................................................................93</p><p>Bab 8. Cloud Server............................................................................94</p><p>8.1. Pengertian................................................................................95</p><p>8.2. Fungsi Cloud Server................................................................98</p><p>Bab 9. Cloud Storage........................................................................100</p><p>Bab 10. Cloud Hosting......................................................................104</p><p>10.1. Arsitektur Cloud Hosting.....................................................106</p><p>10.2 Perbandingan Penyedia Cloud Hosting Populer...................107</p><p>10.3. Keuntungan dan Tantangan Cloud Hosting.........................109</p><p>Bab 11. Cloud Operating System......................................................111</p><p>11.1. Fungsi Cloud OS..................................................................112</p><p>11.2. Contoh Cloud OS.................................................................113</p><p>11.3. Arsitektur Cloud Operating System.....................................114</p><p>Bab 12. Perintah Dasar Linux (Pendukung Praktek)........................116</p><p>12.1. Installasi linux dan pendukungnya......................................116</p><p>12.2. Konfigurasi..........................................................................119</p><p>12.2.1. Konfigurasi Jaringan....................................................122</p><p>12.2.2. Konfigurasi Nvidia......................................................131</p><p>12.2.3. Menambahkan Sudoer.................................................134</p><p>12.2.4. Menambah Huruf Windows.........................................139</p><p>12.2.5. PrtSc (Print Screen).....................................................141</p><p>12.2.6. Install Plank.................................................................143</p><p>12.2.7. Konfigurasi Repository................................................148</p><p>12.3. Perintah dasar linux.............................................................149</p><p>12.3.1. Pindah Terminal...........................................................149</p><p>12.3.2. Melihat isi direktori.....................................................149</p><p>12.3.3. Masuk ke direktori.......................................................151</p><p>12.3.4. Membuat Direktori......................................................152</p><p>12.3.5. Menghapus Direktori...................................................152</p><p>12.3.6. Install Aplikasi.............................................................153</p><p>Bab 13. Office Cloud (Pendukung Praktek)......................................157</p><p><br></p><p>ix</p><p><br></p><p>13.1. Pengenalan...........................................................................157</p><p>13.2. Google Sheets......................................................................158</p><p>13.3. Google Docs........................................................................160</p><p>13.4. Google Slides.......................................................................161</p><p>13.5. Google Forms......................................................................162</p><p>13.6. Mendeley.............................................................................163</p><p>Bab 14. LAMP (Pendukung Praktek)................................................171</p><p>14.1. Install Apache......................................................................171</p><p>14.2. Install MariaDB Database Server........................................174</p><p>14.3. Install PHPMyadmin...........................................................186</p><p>Bab 15. Anbox (Pendukung Praktek)................................................202</p><p>15.1. Install Anbox........................................................................203</p><p>15.2. Install Google Play Store dan Mengaktifkan Dukungan ARM</p><p>......................................................................................................206</p><p>Daftar Pustaka...................................................................................213</p>', 'assets/img/books/covers/YqdWAxGwFKecnETuJbiC40lliJJuyriBGeoo5r8B.jpg', 'assets/img/books/thumbnails/bhrE10iNKKNL5QvM4QonvV7elP7mD5mzYUQrP5Hc.jpg', '978-634-04-2975-6;  ---- E-ISBN: 978-634-04-2611-3 (PDF)', 135000, 'UmriPress', '165 × 250 mm', 1, 230, '2025-07-08', '[]', 1, NULL, '2025-08-05 03:43:26', '2025-09-11 03:37:38'),
(4, 2, 'Buku Tanaman Obat Sekolah Alam', 'buku-tanaman-obat-sekolah-alam', '<p>Tanaman obat merupakan tanaman yang sangat popular yang dapat dimanfaatkan sebagai bahan baku obat tradisional dan jamu, yang bila dikonsumsi akan meningkatkan kekebalan tubuh (imun system). Kementerian Pertanian dalam hal ini Direktorat Jenderal Hortikultura sebagai institusi pemerintah yang menangani produksi tanaman obat menyatakan bahwa yang dimaksud tanaman obat adalah tanaman yang bermanfaat untuk obat-obatan, kosmetik dan kesehatan yang dikonsumsi atau digunakan dari bagian-bagian tanaman seperti daun, batang, buah, umbi (rimpang) ataupun akar</p>', '<p>Buku tanaman obat sekolah alam ini disusun sebagai kegiatan literasi tanaman obat, untuk memberitahu kepada siswa dan Masyarakat manfaat dari tanaman obat tersebut. Sasaran buku tanaman obat sekolah alam ini adalah siswa, masyarakat yang membutuhkan untuk mengetahui manfaat dari tanaman obat. Kami menyampaikan terikasih kepada semua pihak yang telah</p><p>membantu dalam penyusunan buku ini, dan kami sangat mengharapkan saran perbaikan petunjuk ini pada masa yang akan datang.</p>', '<p>Daftar Isi</p><p>KATA PENGANTAR............................................................................i</p><p>DAFTAR ISI..........................................................................................ii</p><p>PENDAHULUAN..................................................................................1</p><p>Pengertian....................................................................................2</p><p>Manfaat .......................................................................................3</p><p>JENIS TANAMAN OBAT ................................................................... 4</p><p>Cilicina ....................................................................................... 4</p><p>Daunt Mint ................................................................................. 5</p><p>Jinten .......................................................................................... 6</p><p>Basil ...........................................................................................7</p><p>Gempur Batu ............................................................................... 8</p><p>Jahe.............................................................................................8</p><p>Ciplukan ................................................................................... 10</p><p>Kumis Kucing ........................................................................... 12</p><p>Serai ..........................................................................................13</p><p>Lidah Buaya .............................................................................. 14</p><p>Kangkung .................................................................................. 16</p><p>Kunyit........................................................................................17</p><p>Seledri .......................................................................................18</p><p>Jeruk Nipis ................................................................................ 20</p><p>Lengkuas...................................................................................</p><p>Mahkota Dewa .......................................................................... 25</p><p>Daun Pandan.............................................................................26</p><p>Bawang Dayak .......................................................................... 21</p><p>Daun Kemangi .........................................................................  27</p><p>Kayu Manis.......................................................................................28</p><p>Pegangan...........................................................................................29</p><p>Sambiloto..........................................................................................30</p><p>Brotowali...........................................................................................31</p><p>Bawang Putih..................... ...............................................................32</p><p>Biji Pala.............................................................................................33</p><p>Kapulaga...........................................................................................34</p><p>Alang Alang.....................................................................................36</p><p>Akar Binasa......................................................................................38</p><p>Bakung Putih....................................................................................40</p><p>DAFTAR PUSTAKA.........................................................................43</p><p>Kencur.......................................................................................</p>', 'assets/img/books/covers/fYAvObQqXXldqYBFkcyBXqv3sxMBpvjaLzNqCr2V.jpg', 'assets/img/books/thumbnails/SDBwiWFg4h7K8grXvj7OsTMNYmSxm1YD0WTUBV8A.jpg', 'xxxxxxxxxx', 0, 'UmriPress', '15,50 × 23cm', 1, 57, '2025-12-09', '[]', 1, '2025-10-20 08:55:50', '2025-08-09 01:52:31', '2025-10-20 08:55:50'),
(5, 1, 'Metode Penelitian Psikologi Kualitatif', 'metode-penelitian-psikologi-kualitatif', '<p>Penelitian adalah aktifitas terstruktur yang dimaksudkan untuk mengungkap suatu kebenaran yang bersifat ilmiah. Secara sederhana jenis penelitian terbagi menjadi dua yaitu kuantitatif dan kualitatif. Dalam buku ini secara khusus dibahas mengenai hal penelitian kualitatif bidang Psikologi, sedangkan untuk penelitian kuantitatif hanya akan disingung sebagai pembanding saja. Secara konseptual, penelitian kualitatif adalah pendekatan penelitian yang digunakan untuk memahami fenomena sosial, perilaku, makna, atau pengalaman yang terjadi dalam konteks yang alami dan mendalam. Penelitian ini berfokus pada pemahaman tentang bagaimana individu atau kelompok memaknai dan menginterpretasikan dunia mereka, serta bagaimana mereka berinteraksi dengan dunia tersebut. Penelitian kualitatif lebih menekankan pada proses dan makna, bukan hanya pada hasil atau angka-angka statistik seperti dalam penelitian kuantitatif.</p><p><br></p>', '<p><br></p><p>Bila dicermati dari tujuannya, peneltiian kualitatif setidaknya memiliki tiga tujuan pokok, yaitu; eksplorasi, pemahaman, dan penafsiran. Eksplorasi maksudnya adalah, penelitian kualitatif bertujuan untuk menggali permasalahan baru yang belum pernah diteliti atau belum diteliti secara tuntas. Tujuan pemahaman maksudnya adalah, peneltian kualitatif dilakukan dengan tujuan memahahami suatu venomena atau persoalan secara proporsional penelitian kualitatif adalah penafsiran, maksudnya peneltian kualitatif bertujuan untuk mengungkap makna di balik venomena atau persoalan yang sedang diteliti. Hal ini perlu dilakukan agar peneliti tidak terjebak pada data observasi yang terukur dengan angka semata.</p>', '<p><br></p><p>-</p>', 'assets/img/books/covers/IYuZvtMixGREdKvMFZQ32tiWVpEZ27G8mSc36Qoa.jpg', 'assets/img/books/thumbnails/tTmWkdTUDtXqGF5e63jbYdRevWWNYENXmDQnUrIt.jpg', '-', 0, 'UmriPress', '165 × 250 mm', 1, 101, '0001-01-01', '[]', 1, NULL, '2025-09-08 01:55:39', '2025-11-06 04:34:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1757300161),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1757300161;', 1757300161),
('admin@gmail.com|125.160.205.41', 'i:3;', 1759214504),
('admin@gmail.com|125.160.205.41:timer', 'i:1759214504;', 1759214504),
('umripres@umri.ac.id|125.160.205.41', 'i:1;', 1759214486),
('umripres@umri.ac.id|125.160.205.41:timer', 'i:1759214486;', 1759214486);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buku_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Buku Ajar', 'buku-ajar', NULL, '2025-07-20 08:29:14', '2025-07-20 08:29:14'),
(2, 'Buku Referensi', 'buku-referensi', NULL, '2025-08-08 07:02:59', '2025-08-08 07:02:59'),
(3, 'Monograf', 'monograf', NULL, '2025-08-08 07:03:07', '2025-08-08 07:03:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_artikel`
--

CREATE TABLE `kategori_artikel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_12_110529_create_kategoris_table', 1),
(5, '2025_02_13_110918_create_kategori_artikels_table', 1),
(6, '2025_02_14_100529_create_authors_table', 1),
(7, '2025_02_14_110220_create_naskahs_table', 1),
(8, '2025_02_14_110529_create_bukus_table', 1),
(9, '2025_02_14_110918_create_artikels_table', 1),
(10, '2025_03_04_122504_create_tims_table', 1),
(11, '2025_03_04_135848_create_paket_penerbits_table', 1),
(12, '2025_03_04_164335_create_pengaturans_table', 1),
(13, '2025_03_05_000000_create_comments_table', 1),
(14, '2025_07_20_142429_create_author_bukus_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `naskah`
--

CREATE TABLE `naskah` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `abstrak` text NOT NULL,
  `file` text NOT NULL,
  `status` enum('diajukan','ditinjau','diterima','ditolak','diedit','diterbitkan') NOT NULL DEFAULT 'diajukan',
  `tanggal_diajukan` timestamp NULL DEFAULT NULL,
  `editor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `paket_penerbit`
--

CREATE TABLE `paket_penerbit` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `position` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'umum',
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `key`, `value`, `display_name`, `type`, `group`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'logo', 'assets/img/logo.png', 'Logo Website', 'image', 'umum', 'Logo utama website (Ukuran yang disarankan: 200x60px)', NULL, NULL),
(2, 'logo-white', 'assets/img/logo-white.png', 'Logo Website', 'image', 'umum', 'Logo untuk darkmode (Ukuran yang disarankan: 200x60px)', NULL, NULL),
(3, 'favicon', 'assets/img/favicon.png', 'Favicon', 'image', 'umum', 'Icon website (Ukuran yang disarankan: 32x32px)', NULL, NULL),
(4, 'address', 'Jl. Tuanku Tambusai, Delima, Kec. Tampan, Kota Pekanbaru, Riau', 'Alamat', 'textarea', 'kontak', 'Alamat lengkap', NULL, NULL),
(5, 'phone', '+628783715150', 'Nomor Telepon', 'text', 'kontak', 'Nomor telepon yang dapat dihubungi', NULL, NULL),
(6, 'email', 'umripres@umri.ac.id', 'Email', 'text', 'kontak', 'Alamat email untuk kontak', NULL, NULL),
(7, 'template-buku-a4', 'assets/template-buku/a4.docx', 'Template Buku A4', 'docx', 'template-buku', 'Template buku A4', NULL, NULL),
(8, 'template-buku-a5', 'assets/template-buku/a5.docx', 'Template Buku A5', 'docx', 'template-buku', 'Template buku A5', NULL, NULL),
(9, 'template-buku-b5', 'assets/template-buku/b5.docx', 'Template Buku B5', 'docx', 'template-buku', 'Template buku B5', NULL, NULL),
(10, 'template-buku-unesco', 'assets/template-buku/unesco.docx', 'Template Buku Unesco', 'docx', 'template-buku', 'Template buku Unesco', NULL, NULL),
(11, 'sertifikat', 'assets/pdf/sertifikat.pdf', 'Sertifikat', 'pdf', 'sertifikat', 'Sertifikat kerjasama', NULL, '2025-08-09 14:27:09'),
(12, 'gform', 'https://docs.google.com/forms/d/e/1FAIpQLSdsLgRLYKMQonpOCqg2TDfgu0V4bFCyZIgf-Y7FbW3VQbORUg/viewform?usp=sharing', 'Link Kirim Naskah', 'text', 'gform', 'Link gform untuk mengirim naskah', NULL, NULL),
(13, 'progress-isbn', 'https://docs.google.com/spreadsheets/d/1eB8hMFA_lPq9qHU9aHb1QTG5EZ9VAIv5/edit?usp=sharing&ouid=110970955264024363353&rtpof=true&sd=true', 'Link Progress ISBN', 'text', 'progress-isbn', 'Link progress isbn', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0KqM50aMNEGyb0vosMbX21K2tqjS32Q0dLLzFBi1', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2NmeEpGd1ZNWW1NNnh6bUNzZWJtQnkyWXFwYm42ZDdhdlYxcHZBcCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3l1bGlhLWZhdG1hLXMta29tLW0tY3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010817),
('4FvM1KdWbBi6uMPCG92hhxbHcFqqP98K3x304iV8', NULL, '34.254.203.105', 'Plesk screenshot bot https://support.plesk.com/hc/en-us/articles/10301006946066', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVk9POU0xOWFuM2dBNXl0anI1THprbHB2UHVDeWc4SjF5S3djMHBxaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763036920),
('4SFnOyoe3v3okUUkDMsLv0ythS8Ja4p3eyxk1akf', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRnZGTVVPMEt0UEtyajQ3WVp6M01kTmxtQzNzODZpQ1BHenBKNk16VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3JpZGhvLWlyYXdhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763010813),
('5wzAyFsNX5RedzpK0waMWEUtwOy9HDoMg0Cb0XaC', NULL, '185.191.171.15', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRklOSzhKVldXdEw1eXFJbXplZzFrODZZT2lXYmU3b0NWdUtrcFpsUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3dpcmF3YW4tYWRpa3VzdW1hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763026473),
('6CcukjdEkAQPuhw8sbYmEZHBcw9NFB2GI2E4cpIM', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajFoUzRhVUJrZFVYSUpobUZtOGJkYzlwV1p2bnhTNTZjY0hFUnExUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9rYXRlZ29yaT9idWt1LXJlZmVyZW5zaT0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010793),
('6HsnJcuFqS1OYckWBh3x4WfbtCb0tSzQk6rno7ru', NULL, '52.167.144.192', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRlE3TGhhQ2xwVzRrSkVQejFnWjNRMUlTV3pCQ0tDbFdVeUFySkxVZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763038270),
('7eS8cnjU55NA9hKOJbpWgbmJCKzuETbUAeG2Nktg', NULL, '85.208.96.210', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR1lEdVQ4RHN0YUR5Q0M3YTFrZTFtWGY4R1dWQ3Y4d3J5QmtTbjdQZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWxpYW4tcGFqcmlhbnRpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763017421),
('7lhQYwq17n5mUgEER58D37SJoIPCpXEDxzoIHYwN', NULL, '140.213.147.103', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjQyejZDS1RLcVByQTRmSWdGWVEwdmh2WDFKRnFXY29KVkpNMmFoUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763004392),
('87EhUahGfiUw4SYGbU9L1DFzRHi4uVjOvT3juND4', NULL, '162.120.184.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTFpN05ISWFtT2RKVXpmbXRyUVlnRmJGUXI2WXVNblNNMjZsZUZ6dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2Fzc29jLXByb2YtZHItaGFydW4tbXVraHRhci1za29tLW1rb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763006716),
('8jKVsPTYCwFEP37wUpdQkS4AKu3jYKcYu4kDwT7g', NULL, '201.254.238.130', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNjdNdjhvQWxMMFIwYnZQb1d6bEQ2YWhtWEwzT0pLSURYWlVhNkNyeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWFubmlzYS1hYmRpLWdoaWZhcmkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763039898),
('8oDtrFM1rw12eSGSXKJYmbILipGLGAfq40AIFIZ5', NULL, '14.173.19.72', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnhTTkNCQUs4QWFEaGRyWmJpaGVqaWpxd256TzlLNjNVOGMxYmhNYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWVrYS1iZWJhc2FyaS1tc2MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763039882),
('a1HP1I9gUhe3mmOxMsjrrZBiDDUr29QEhydWE216', NULL, '187.17.27.187', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXBJZVpkc0NXdHAzVUt1NjlMY0VRZjNaVlhPUWZrWG4yTHRZa2xoeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3JpZGhvLWlyYXdhbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763039911),
('a3YrLDPzsWEiLacQwAPU1hZKr8KJhM1evepGpavk', NULL, '190.175.79.195', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid0JsN2wxUVlkTmg3UjRKTEt0RzU1WWFZZ0EzdHVhdVFZM2x2eVBzUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3NhcmFoLW5hYmlsYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763039895),
('aQssRqG2IDtzkUB0oQuQO9coOCzREl3lnQzYVP81', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGxrdURUc2FuWG1TSEpySXcwMDc0ck1BMVBhOHdHNWl2bjVUaVNyaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWxpYW4tcGFqcmlhbnRpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763010807),
('bEKNZ71sEVTfrHneKilwQAeakToYIo7Ocg5zO6UO', NULL, '123.20.246.164', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmxzVldoN3d2SlRidVNIQjAyWEYyRGlvZ2RBOFp3cWNZbWhhWkFjTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWRyLW0teXVsaXMtaGFtaWR5LW1rZXMtbXBkLWtlZC1zcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763039877),
('bSbb6hFbaifdG9nw2m3FqiNTqow4W2eb2Umd21jg', NULL, '14.173.19.187', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmw5ZW5ZSWl2VUJXbjltaElscEpPemRQczdYd2J1NkE1aWcyOFh0RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWRhcm1hd2ktbWJpb21lZC1waGQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763039902),
('bwDzw4nFLYTP42Q1GN8TvDmeSnwvhURSgTfaq45j', NULL, '74.7.228.158', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36; compatible; OAI-SearchBot/1.3; +https://openai.com/searchbot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibW9oWUV3Wm5XWjkyYVV3WkZsa3lLcGQ2Z2pCMlVSTFBoSGx1MEcwQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2xhbHUtbXVoYW1tYWQtaXJoYW0tbWZhcm0tcGhkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763033976),
('co8t5I6b0ESElba7UVh30RrdpiRpbz7xyprpyFEE', NULL, '140.213.202.195', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQjJjdDhQekYzb3ptNU1aU3BYSk94OXdyRzZEQk9sZ05uWlNoUkVYbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763039510),
('CqJUM8hhkqin6Rf5ck7RzF0PdZayBuJKQjSPs8WQ', NULL, '220.181.108.157', 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTzd6ZndmN3NldzM4SElBeDI2cWVCeVg3TmFlRUFoRmNCNU91OFM5cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763016297),
('CWGlguuyTYsuHRNTt6Y88rdHnKOX81woJNpdvux1', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmk3N2dMN05NNjhGNGZYd1o1aEVEU1lyamRSazZwQ2c2NlFmdVZoZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3dpcmF3YW4tYWRpa3VzdW1hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763010816),
('DICV97tsyaUhyHN56r0YOIzvcWrhxn6cx2lGAU5J', NULL, '103.70.133.51', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiakQxYTdBZHFzNXBibnRpODlnM2F1RkU0WE14cWpKdFNGdDdrdjFobiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763005851),
('Fcbma7jQfSgpRVgIe9WH4vUzfU7hfrmkrGKqdMnq', NULL, '20.194.157.177', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTkJKOWNMcDdpQmZyRkU5T0hHTzFodHduSkZweW5sRWliMlJmZnRzTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLXNhbnRvc28tc3MtbXNpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763008577),
('fUpFb58FDgWfb2eDpzZ0z4sCRwx6qNypL9NLmxzE', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT0RkMVMxMUxSREJTeXJJNUdGUFRuQjdJZGRqV21BQXcxRDh4MWw4ZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9rYXRlZ29yaT9idWt1LWFqYXI9Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763010791),
('JgvetyT24kDqXGEz93XlKmTbugglUjpgubSFDKeD', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVEtabFcxNktDMG9ZWUVBR0hobDZ5OXFnUU9UVmZMeXgyeXBoZ3BaZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWJ1ZGktaXN0YW5hLXN0LW1lbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010801),
('jWewxj1xDLA2iOd8PzNuQBMUTQZKH03eSlkIlMBc', NULL, '85.208.96.205', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidVUyTzFDSFhjUEZkREdEdk5hRFNOUmVNb1Y0NVZxTDEzd0xRQkxUUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWVrYS1iZWJhc2FyaS1tc2MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763016943),
('jzJozO8qLwU8vpdRJ6M92glQCyAq9b59fpuWZ20K', NULL, '14.255.183.195', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzJ0ZDdWeTJRRTl4aWs1TXlhT2doVEhUWENSZTlPejdzcTNMWjdpQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9kZXRhaWwtYnVrdS9tZXRvZGUtcGVuZWxpdGlhbi1wc2lrb2xvZ2kta3VhbGl0YXRpZiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763012223),
('kGHFQbzcdxWGiV6kddzECfv7K96QAUmVtN7HZwey', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ29HajI3TGRzNUhRNXJIZzFnZVIwY0R6anJ3Unh0ek1iZTJrQ09BRiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2Fzc29jLXByb2YtZHItaGFydW4tbXVraHRhci1za29tLW1rb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010798),
('kGSfWWjTaUOfKylV9JW7D2z3zllbkrlpxCpzGUAY', NULL, '182.4.69.34', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNTg3cGtJTlY4SGFORU51NTkzY3lvWmV4QnM2c3d3eGJtd0twT08zSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763034972),
('KvaV635tbww9l5xiTOM5m8yqZXxUerj99qxGDys8', NULL, '14.191.155.234', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) EdgiOS/116.0.1938.56 Version/17.0 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFAwMVQ2MXVsVnI2YlRMaXFoaHVTZzBRN05XMXphUFduZ1hOOW9LUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3l1bGlhLWZhdG1hLXMta29tLW0tY3MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763039912),
('lZkyl9VJlDwy4iYir0cnfUjtnBLyQVI4ZuceuiR5', NULL, '103.220.23.31', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) EdgiOS/120.0.2210.86 Version/17.0 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlZtUHE4Skt3SUx6VzBpbHN3NEp1RnI2ZDBrcExNT0pUOFNONWdsTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2xhbHUtbXVoYW1tYWQtaXJoYW0tbWZhcm0tcGhkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763039885),
('neiQBwqHQwBX8ojgXkkGMAGV3ohUYF1d3EclAGNG', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHZZUjJoanpuWlNOdzducmt0QTRCSFRMNVdWVWtnSHlmeUFUQm5CMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3NhcmFoLW5hYmlsYSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763010814),
('nvwAqQacGYtCcjenClk1vxCJvt8Mfhw62MHBd8wV', NULL, '4.196.118.118', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlVWOXhaYkpSbUJvRWhkTjBYQTRzN3FRZHlwb2lQalhhRHloTDh4ViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763036580),
('Oe6CHpAWLOdW17MQBngGPmpAJ251kWS3e4XCNDSc', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1EzUVJWSGdFUDZoWmM5SjQxanVoSTdxcUh2ZjBoanp2RUdmUU13MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2xhbHUtbXVoYW1tYWQtaXJoYW0tbWZhcm0tcGhkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763010810),
('OhFDZ9UYFzKSERIBSbSznjlcToAAIKNhZj37L8Lh', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieTRxbERHdmNRS2c4NGhVZGRqb3FvR0JLRnpRMVM5MkYzQkxGcmlaQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLXNhbnRvc28tc3MtbXNpIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763010809),
('Pk16Wb2fHQUBwi8Vf3CekE07QTIq667NF3fsOnnA', NULL, '85.208.96.195', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZThFSzZoSGdWSHloWUVkelg5bHBqa3pCeUdrdGlYOU9SRU9OZmdtcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWRhcm1hd2ktbWJpb21lZC1waGQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763039492),
('pZHWFqaHPigFD2WlZ3Ir0uC5SbFqMYPvVEbEeYfS', NULL, '113.188.67.114', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) EdgiOS/119.0.2151.65 Version/17.0 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0tjcjAzcjgwem9mZHMwSjFiYzlMVFJtaVRiaXNDQmxTSGdySTFxMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2Fzc29jLXByb2YtZHItaGFydW4tbXVraHRhci1za29tLW1rb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763039923),
('QNdvfh275vH1NgQasQuiumqSAxHuzcjrAQ0138db', NULL, '14.190.96.48', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) EdgiOS/119.0.2151.96 Version/17.0 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmhERmljaGFNU2lUYTNQeWhzZGk1Vkg4QVlCemNTU1VxWWV0U3V0NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL3dpcmF3YW4tYWRpa3VzdW1hIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763039903),
('s1OjgYfBw4Hpej5qkmMr8wQj6Ir2dW5v92E0smCN', 1, '125.165.111.65', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiajBUbndxOEdtRjd2VTZIMGlqd0JwRFFnVlBZbk5ZREdZd3dJOW53TCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozNDoiaHR0cHM6Ly9wcmVzcy51bXJpLmFjLmlkL3Rva28tYnVrdSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763039885),
('tafQt0Ahf9YsZYnLkIipoEh0YvBHkZQQlengugFF', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVjEyS2p4M2cyaEtXV3NRTTVEYTN6WTVXdk1COVd3ajZYWGVoUEY2aSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWRhcm1hd2ktbWJpb21lZC1waGQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010802),
('TRedZrg8sRdvoRvkoNGfQEcTGLivyh3mdvbKnq9D', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVk2cHJiM3ljQ0dpSjZuR3ZTc0JSNHd6cXVGQU94RFFRYWNzUlFibiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWFubmlzYS1hYmRpLWdoaWZhcmkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010799),
('uj6awYqgb5JAoduQCsAlAUhNxYJkIMipUO0zzAU8', NULL, '14.240.241.147', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkhCanl0TU40Q0NjSHFDVmxhejBuZDkzZ2JnQWpQbHBVMEZKSXNHdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6OTA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9kZXRhaWwtYnVrdS9wZWx1YW5nLXRlcmFwaS1tZXRmb3JtaW4tc2VsYWluLXNlYmFnYWktb2JhdC1kaWFiZXRlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763012244),
('uMsVUvlvfjJhE1yAqdFf0gZhCzfQmC3WZ2XoBBNz', NULL, '20.194.157.183', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXVISzdGRjA5UVlDNzB0bGFlT3M1YVRaN2hsQ1E5TGpmT01ZRENJcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763008589),
('uMww0TSDoZpTCclSOYWmSXK0EnIpEuOMxw0SigP3', 1, '27.121.84.66', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnlBdkEwTVZvNGdub1J0alFOMmdwNnVJclltU0NoQnRJbnJIVHFodCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMToiaHR0cHM6Ly9wcmVzcy51bXJpLmFjLmlkL2tvbnRhayI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763016773),
('VaOhs6uQQknVo207GvDmUSXBiwgjVG3mDey5II3H', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemx6OXdiVDJJWmFsUUtZV1JUWEh1UUV2ZU9rWjU5amd2THNZYUlXNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDM6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9rYXRlZ29yaT9tb25vZ3JhZj0iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010795),
('Vf9Kr9DLl4xUv8eE3MQeF53MSJ45Lq2Iq1egiKXL', NULL, '123.20.138.148', 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 EdgiOS/121.2277.107 Mobile/15E148 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZk9oTDdCMk5YblFoOWUwUlluOHIwTU50MUREdmZlWmFjYkF1dXI1biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTUxOiJodHRwczovL3ByZXNzLnVtcmkuYWMuaWQvZGV0YWlsLWJ1a3UvbG9uZy1zaG9ydC10ZXJtLW1lbW9yeS1sc3RtLWRlbmdhbi1hbGdvcml0bWEtcGVtcm9zZXNhbi11bnR1ay1wZXJhbWFsYW4ta2VkYXRhbmdhbi13aXNhdGF3YW4tcGFkYS1kYXRhLXRpbWUtc2VyaWVzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763012248),
('vwcmDj3gpeoy67uy8ET38sWK7RFQJS4JTV5E4RU3', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGlSUU9EZEFUb2ZBaG1jU0d0S2xsNlZoZnRRb0dZV0EwcWNCZkpuVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL251cnVsLWF6aXphaC1zc2ktbWJpb21lZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763010811),
('VZJfusQJC4TBtPSiJaKachoWOCew8WGpozUl8y9h', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHdqWFRYSERYY0pvTW5tQWlpQ1RnaTZidVJHbFNtazYwVDZ4eDFYdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWVrYS1iZWJhc2FyaS1tc2MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763010805),
('wyR4B1sM8dbxHCmoCSjUe0enWC0K5ZUyiwhHEZHG', NULL, '123.20.6.73', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36 Edg/121.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUxxc0FjdHRZWkRwNExnV1RMc1FJY0JOcXZ1c3NOazRCRlNyVTNUQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9kZXRhaWwtYnVrdS9jbG91ZC1jb21wdXRpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763012214),
('xJniQKT38fpQ34i5x8Pk84uUyOexETqXxEKVW1L9', NULL, '20.204.24.245', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia3FQT0w0QVowTWh0ZkMwZ3hKZGhjdjREdms1UTQ2RmJzSjNiblpWRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763033923),
('XxzTSghJNswQhxwVkMVpfiaP16tLY93paBh1Mh5R', NULL, '182.1.45.85', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTRZUEFlYmt6MHd2Zzk2blNDdWxFT2M4dGNqZG5CZmpBMVpRd0hrUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzA6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2Fzc29jLXByb2YtZHItaGFydW4tbXVraHRhci1za29tLW1rb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1763017862),
('XYltVWewR62XiV4BRr1cBYL30xL48Je8avvsOUHL', NULL, '20.204.24.245', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko); compatible; ChatGPT-User/1.0; +https://openai.com/bot', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXdRZ0E1VTlwUGI4ald0T1dyeW1iajdvVXFCWVloVmZzRWtqeDcxaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2xhbHUtbXVoYW1tYWQtaXJoYW0tbWZhcm0tcGhkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1763033919),
('YKn3W1GIMkIAgO5xdnfvzOaCSXYSeX1GZ8K2i2fX', NULL, '85.208.96.208', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3o4V1BNRVlTZ211SGlJZXZFOXVsTkFhUFNIN0J6dVd1RDQxTXU4diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL251cnVsLWF6aXphaC1zc2ktbWJpb21lZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763034394),
('zQurowedE7EyHIjBazB1sHf5K6jEJ2aY1vWMtbdf', NULL, '65.21.113.241', 'Mozilla/5.0 (compatible; AwarioBot/1.0; +https://awario.com/bots.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGRjbk1YRk9DRUFCb3VMQm05RXZsdzFhcEtpamhjb0NLb25aZlVSVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Njk6Imh0dHBzOi8vcHJlc3MudW1yaS5hYy5pZC9wZW51bGlzL2RyLWRyLW0teXVsaXMtaGFtaWR5LW1rZXMtbXBkLWtlZC1zcCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763010804);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tim`
--

CREATE TABLE `tim` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `position` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('user','editor','admin') NOT NULL DEFAULT 'user',
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'umripres@umri.ac.id', '2025-07-20 08:29:14', 'admin', '$2y$12$nEKzxQfHZVqHhbA0n..2mOtytkSzPhkZSx2XobLcZ7L2CA9Hw7dkG', 'wwpjdD3IBlZubYwC7P4RURFW0FwowXKtRJn4NEJRAUTbvoRuq8vcd5qpyFXv', '2025-07-20 08:29:14', '2025-07-20 08:29:14');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `artikel_slug_unique` (`slug`),
  ADD KEY `artikel_user_id_foreign` (`user_id`),
  ADD KEY `artikel_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `authors_slug_unique` (`slug`);

--
-- Indeks untuk tabel `author_buku`
--
ALTER TABLE `author_buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_buku_author_id_foreign` (`author_id`),
  ADD KEY `author_buku_buku_id_foreign` (`buku_id`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `buku_slug_unique` (`slug`),
  ADD UNIQUE KEY `buku_isbn_unique` (`isbn`),
  ADD KEY `buku_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_buku_id_foreign` (`buku_id`),
  ADD KEY `comments_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_slug_unique` (`slug`);

--
-- Indeks untuk tabel `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kategori_artikel_slug_unique` (`slug`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `naskah`
--
ALTER TABLE `naskah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `naskah_user_id_foreign` (`user_id`),
  ADD KEY `naskah_editor_id_foreign` (`editor_id`);

--
-- Indeks untuk tabel `paket_penerbit`
--
ALTER TABLE `paket_penerbit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paket_penerbit_slug_unique` (`slug`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengaturan_key_unique` (`key`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tim`
--
ALTER TABLE `tim`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tim_slug_unique` (`slug`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `authors`
--
ALTER TABLE `authors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `author_buku`
--
ALTER TABLE `author_buku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kategori_artikel`
--
ALTER TABLE `kategori_artikel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `naskah`
--
ALTER TABLE `naskah`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `paket_penerbit`
--
ALTER TABLE `paket_penerbit`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tim`
--
ALTER TABLE `tim`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_artikel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `artikel_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `author_buku`
--
ALTER TABLE `author_buku`
  ADD CONSTRAINT `author_buku_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `author_buku_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `naskah`
--
ALTER TABLE `naskah`
  ADD CONSTRAINT `naskah_editor_id_foreign` FOREIGN KEY (`editor_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `naskah_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
