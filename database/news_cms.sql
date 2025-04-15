-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 07 Apr 2025 pada 06.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `news_cms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(8, 'Gaming', 'gaming', '2025-03-29 18:20:07', '2025-03-30 18:27:33'),
(13, 'Dashboard Creation', 'dashboard-creation', '2025-03-29 18:40:23', '2025-03-29 18:40:23'),
(15, 'Skill Improvement', 'skill-improvement', '2025-03-29 18:40:51', '2025-03-29 18:40:51'),
(18, 'Exploit', 'exploit', '2025-03-29 18:41:24', '2025-03-29 18:41:24'),
(19, 'Technology', 'technology', '2025-04-01 08:44:05', '2025-04-01 08:44:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`id`, `news_id`, `user_id`, `comment`, `status`, `created_at`, `updated_at`) VALUES
(1, 35, 122, 'halo', 'approved', '2025-04-01 21:24:41', '2025-04-02 11:06:16'),
(2, 35, 122, 'Sangat bermanfaat sekali konten ini, saya jadi tahu perbedaan antara penggunaan mouse gaming atau tidak', 'approved', '2025-04-02 06:09:28', '2025-04-02 11:15:35'),
(3, 34, 122, 'Info yang sangat menarik, dari sini saya tahu bahwa CPU mengalami proses binning agar tersortir dengan sesuai antara high-end, mid-end, dan low-end', 'approved', '2025-04-02 06:42:29', '2025-04-02 11:43:07'),
(4, 34, 126, 'Sangat bagus, mengupas tuntas tentang CPU binning yang tidak biasa didengar oleh user awam', 'approved', '2025-04-02 08:37:39', '2025-04-02 13:37:49'),
(5, 34, 126, 'Sangat jelas, sangat disayangkan website seperti ini sepi\r\n', 'approved', '2025-04-02 08:38:50', '2025-04-02 13:39:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `published` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `category_id`, `author_id`, `published`, `created_at`, `updated_at`) VALUES
(34, 'Mengupas Proses Binning CPU High-End: Rahasia di Balik Performa dan Harga Premium', 'mengupas-proses-binning-cpu-high-end-rahasia-di-balik-performa-dan-harga-premium', '<p>Dalam industri semikonduktor yang kompetitif, proses binning menjadi salah satu kunci yang menentukan nasib sebuah prosesor. Terutama untuk CPU high-end , teknik ini tidak hanya memengaruhi performa, tetapi juga harga dan ketersediaan produk di pasaran. Artikel ini mengulas secara mendalam mekanisme binning , dampaknya pada pasar CPU kelas atas, serta inovasi terkini yang mengubah paradigma industri.</p><p><br></p><p><img src=\"https://asset.kompas.com/crops/wi8nYo2QFuB0ZTc24cYqFnPe58M=/140x49:724x437/1200x800/data/photo/2022/09/28/63338ea978dba.jpg\"></p><p><br></p><h3><strong style=\"color: inherit;\">Apa Itu Binning CPU?</strong></h3><p>Binning adalah proses seleksi dan klasifikasi <em>chip </em>berdasarkan hasil pengujian kualitas, kestabilan, dan kemampuan performa. Setiap <em>wafer </em>silikon yang diproduksi mengandung ratusan hingga ribuan <em>die </em>CPU. Namun, tidak semua <em>die </em>memiliki karakteristik yang sama. Faktor seperti cacat manufaktur, variasi suhu, atau ketidaksempurnaan material menyebabkan perbedaan kualitas.</p><p>Proses <em>binning </em>memilah <em>die </em>ini ke dalam \"kelompok\" (<em>bin </em>) berdasarkan parameter kritis. Pertama, kecepatan clock maksimal: <em>die </em>yang mampu berjalan pada frekuensi tinggi tanpa <em>overheating </em>dikategorikan sebagai <em>high-end </em>. Kedua, konsumsi daya: <em>chip </em>dengan efisiensi daya optimal diprioritaskan untuk segmen premium. Ketiga, fitur tambahan seperti dukungan <em>cache </em>ekstra atau teknologi <em>overclocking </em>(misalnya Intel® Turbo Boost atau AMD Precision Boost).</p><p><em>Die </em>yang tidak memenuhi standar <em>high-end </em>seringkali \"diturunkan\" menjadi model kelas menengah atau dijual dengan fitur terbatas. Contohnya, GPU terintegrasi pada CPU dinonaktifkan untuk dijual sebagai prosesor biasa.</p><p><br></p><h3><strong style=\"color: inherit;\">Dampak pada Pasar CPU High-End</strong></h3><p>Salah satu dampak utama binning adalah penetapan harga premium. CPU <em>high-end </em>seperti Intel Core i9-13900K atau AMD Ryzen 9 7950X dibanderol lebih mahal karena lolos uji ketat. Menurut laporan <em>International Business Strategies (IBS) </em>, hanya 10-20% <em>die </em>dari setiap <em>wafer </em>yang memenuhi kriteria <em>high-end </em>. Kelangkaan ini mendorong harga tinggi, bahkan untuk produk yang secara teknis mirip dengan versi lebih murah.</p><p>Fenomena \"silicon lottery\" juga erat kaitannya dengan binning. Pengguna seringkali bersaing mendapatkan \"CPU pemenang lotre silikon\" — <em>chip </em>yang mampu melebihi spesifikasi pabrik melalui <em>overclocking </em>. Hal ini menjadi daya tarik bagi komunitas <em>enthusiast </em>yang ingin memaksimalkan performa sistem.</p><p>Di sisi strategi pemasaran, perusahaan seperti Intel dan AMD memanfaatkan <em>binning </em>untuk menciptakan hierarki produk. Contohnya, AMD Ryzen 7 7800X3D dengan <em>3D V-Cache </em>dirancang khusus untuk gaming berkat seleksi <em>die </em>berkualitas super.</p><p><br></p><h3><strong style=\"color: inherit;\">Proses Binning dalam Industri Semikonduktor</strong></h3><p>Tahap pengujian dimulai setelah <em>wafer </em>selesai diproduksi. Setiap <em>die </em>menjalani uji <em>burn-in </em>(pembebanan ekstrem) untuk menilai ketahanan dan kestabilan. Parameter seperti <em>voltage-frequency curve </em>(hubungan antara tegangan dan kecepatan clock) dan <em>Thermal Design Power (TDP) </em>menjadi penentu klasifikasi.</p><p>Teknologi pendukung seperti <em>process node </em>generasi terbaru (misalnya TSMC 5nm/3nm) meningkatkan akurasi <em>binning </em>. Algoritma AI kini digunakan untuk memprediksi kualitas <em>die </em>sejak fase desain, mengurangi limbah material.</p><p><br></p><h3><strong style=\"color: inherit;\">Tantangan dan Inovasi</strong></h3><p>Salah satu tantangan terbesar adalah kompleksitas node yang lebih kecil. Pada node 3nm, risiko cacat meningkat, sehingga <em>yield rate </em>(persentase <em>die </em>layak jual) turun hingga 50%. Produsen dipaksa meningkatkan efisiensi <em>binning </em>untuk menekan biaya.</p><p>Inovasi seperti arsitektur <em>chiplet </em>(misalnya pada CPU AMD Ryzen dan Intel Core generasi terbaru) memungkinkan <em>binning </em>per modul. Alih-alih memproduksi CPU monolitik, <em>chiplet </em>membagi komponen menjadi modul kecil yang diuji dan dikelompokkan secara independen. Hal ini mengurangi pemborosan dan biaya produksi.</p><p>Isu lingkungan juga menjadi sorotan. Limbah <em>die </em>yang tidak lolos <em>binning </em>kini didaur ulang untuk meminimalkan jejak karbon, seperti komitmen Intel dalam program keberlanjutan mereka.</p><p><br></p><h3><strong style=\"color: inherit;\">Kutipan Ahli</strong></h3><p><em>\"Binning adalah seni dan sains yang menyeimbangkan performa, biaya, dan keberlanjutan. Di era node 3nm, kesalahan seleksi bisa berarti kerugian jutaan dolar,\" </em>kata Dr. Helena Weiss, pakar semikonduktor dari Institut Teknologi Massachusetts (MIT).</p><p><br></p><h3><strong style=\"color: inherit;\">Kesimpulan</strong></h3><p>Proses <em>binning </em>CPU <em>high-end </em>merupakan tulang punggung industri semikonduktor modern. Meski sering dianggap sebagai rahasia dapur produsen, mekanisme ini secara langsung memengaruhi pengalaman pengguna, dinamika pasar, dan inovasi teknologi. Seiring dengan perkembangan <em>process node </em>dan AI, <em>binning </em>akan terus berevolusi — menjadi lebih presisi, efisien, dan ramah lingkungan.</p><p>Bagi konsumen, pemahaman tentang <em>binning </em>dapat membantu membuat keputusan pembelian yang lebih cerdas, terutama ketika berinvestasi pada CPU <em>high-end </em>yang menjanjikan performa terdepan.</p><p><br></p>', 19, 124, 1, '2025-04-01 08:43:51', '2025-04-02 08:36:43'),
(35, 'Penggunaan Mouse Gaming: Apakah Benar-Benar Mempengaruhi Performa?', 'penggunaan-mouse-gaming-apakah-benar-benar-mempengaruhi-performa', '<p>Dalam dunia gaming yang semakin kompetitif, setiap detail kecil dapat membuat perbedaan besar. Salah satu aspek yang sering menjadi perdebatan di kalangan gamer adalah penggunaan mouse gaming. Apakah mouse gaming benar-benar memberikan dampak signifikan terhadap performa pemain, atau hanya sekadar tren yang berlebihan?</p><p><br></p><p><img src=\"https://cdn.mos.cms.futurecdn.net/4NBgfY8Q8ssNZ8LViYVEQh-1200-80.png\"></p><p><br></p><p><strong style=\"color: var(--tw-prose-bold);\">Desain Ergonomis dan Kenyamanan</strong></p><p>Salah satu alasan utama mengapa banyak gamer memilih mouse gaming adalah desainnya yang ergonomis. Berbeda dengan mouse standar, mouse gaming dirancang khusus untuk mendukung postur tangan yang nyaman selama sesi bermain yang panjang. Dengan bentuk yang lebih presisi dan bahan yang nyaman dipegang, mouse gaming dapat mengurangi risiko kelelahan otot dan cedera repetitif seperti <em>carpal tunnel syndrome </em>. Karena kenyamanan ini, gamer dapat fokus lebih lama tanpa gangguan fisik.</p><p>Namun, apakah faktor kenyamanan ini langsung berdampak pada performa? Jawabannya adalah iya, namun secara tidak langsung. Ketika seorang pemain merasa nyaman, mereka dapat bermain lebih lama tanpa kehilangan konsentrasi. Ini sangat penting dalam game-game kompetitif seperti <em>esports </em>, di mana sedetik pun bisa menentukan hasil pertandingan.</p><p><br></p><p><strong style=\"color: var(--tw-prose-bold);\">Kecepatan dan Presisi yang Lebih Tinggi</strong></p><p>Mouse gaming biasanya dilengkapi dengan sensor DPI (dots per inch) yang jauh lebih tinggi dibandingkan mouse konvensional. DPI yang tinggi memungkinkan gerakan kursor yang lebih responsif dan akurat, yang sangat penting dalam game <em>first-person shooter </em>(FPS) seperti <em>Counter-Strike: Global Offensive </em>atau <em>Call of Duty </em>. Dengan sensitivitas yang lebih baik, gamer dapat melakukan gerakan cepat dan tepat, seperti menembak musuh dengan cepat atau menghindari serangan.</p><p>Selain itu, beberapa mouse gaming juga menawarkan fitur penyesuaian DPI secara real-time melalui tombol khusus. Fitur ini memungkinkan pemain untuk menyesuaikan sensitivitas mouse sesuai dengan situasi dalam game, misalnya, menggunakan DPI rendah untuk tembakan jarak jauh yang lebih stabil atau DPI tinggi untuk pergerakan cepat.</p><p><br></p><p><strong style=\"color: var(--tw-prose-bold);\">Tombol Makro dan Kustomisasi</strong></p><p>Mouse gaming sering kali dilengkapi dengan tombol tambahan yang dapat diprogram untuk menjalankan fungsi tertentu dalam game. Misalnya, seorang pemain dapat mengatur tombol makro untuk melakukan serangkaian aksi kompleks hanya dengan satu klik. Fitur ini sangat berguna dalam game RPG atau MOBA, di mana kombinasi skill atau item harus dilakukan dengan cepat dan efisien.</p><p>Namun, penggunaan tombol makro juga menuai kontroversi di beberapa komunitas gaming. Beberapa turnamen profesional bahkan melarang penggunaan fitur ini karena dianggap memberikan keuntungan yang tidak adil. Meski demikian, bagi gamer kasual, tombol makro dapat meningkatkan efisiensi dan mengurangi beban kerja manual.</p><p><br></p><p><strong style=\"color: var(--tw-prose-bold);\">Daya Tahan dan Kualitas Material</strong></p><p>Kualitas material yang digunakan dalam mouse gaming umumnya lebih unggul dibandingkan mouse biasa. Banyak mouse gaming menggunakan switch mekanis berkualitas tinggi yang dirancang untuk bertahan hingga jutaan klik. Hal ini tentunya penting bagi para gamer profesional yang membutuhkan perangkat yang dapat diandalkan dalam jangka waktu lama.</p><p><br></p><p><strong style=\"color: var(--tw-prose-bold);\">Apakah Mouse Gaming Harus Dimiliki?</strong></p><p>Meskipun mouse gaming menawarkan berbagai keunggulan, bukan berarti perangkat ini wajib dimiliki oleh semua gamer. Bagi pemain kasual atau mereka yang baru memulai, mouse standar mungkin sudah cukup memadai. Namun, bagi gamer yang serius atau berencana berkompetisi di level profesional, investasi pada mouse gaming bisa menjadi langkah strategis.</p><p>Sebuah studi yang dilakukan oleh <em>Esports Research Network </em>menunjukkan bahwa 78% gamer profesional menganggap mouse gaming sebagai salah satu faktor penting dalam meningkatkan performa mereka. Namun, perlu dicatat bahwa performa gaming tidak hanya bergantung pada perangkat keras, tetapi juga pada keterampilan, strategi, dan latihan yang konsisten.</p><p><br></p><p><strong style=\"color: var(--tw-prose-bold);\">Kesimpulan</strong></p><p>Penggunaan mouse gaming memang dapat memberikan dampak positif terhadap performa, terutama dalam hal kenyamanan, presisi, dan kustomisasi. Namun, perangkat ini bukanlah solusi instan untuk menjadi gamer yang lebih baik. Pada akhirnya, kombinasi antara perangkat keras yang tepat, latihan yang konsisten, dan mentalitas kompetitiflah yang akan menentukan kesuksesan seorang gamer.</p><p>Bagi Anda yang ingin meningkatkan pengalaman gaming, mempertimbangkan mouse gaming sebagai investasi mungkin layak dipertimbangkan. Namun, pastikan untuk memilih produk yang sesuai dengan kebutuhan dan gaya bermain Anda. Setelah semua, performa terbaik datang dari sinergi antara teknologi dan kemampuan manusia.</p>', 8, 122, 1, '2025-04-01 18:49:50', '2025-04-02 15:54:46'),
(37, 'Microsoft dan Partikel Majorana: Ambisi Menguasai Komputasi Kuantum Masa Depan', 'microsoft-dan-partikel-majorana-ambisi-menguasai-komputasi-kuantum-masa-depan', '<p>Microsoft tengah menjadi sorotan dalam perlombaan komputasi kuantum global. Perusahaan ini mengambil jalur berbeda dengan mengandalkan partikel Majorana, fenomena fisika kuantum yang dianggap sebagai \"batu loncatan\" untuk membangun komputer kuantum yang stabil dan kuat. Ambisi ini bukan tanpa risiko, tetapi jika berhasil, Microsoft bisa mengubah cara manusia memecahkan masalah kompleks di bidang kesehatan, keamanan siber, atau kecerdasan buatan.</p><p><br></p><p><img src=\"https://www.hpcwire.com/wp-content/uploads/2025/02/Majorana-1-004-4000px-scaled.jpg\"></p><p><br></p><p><strong style=\"color: inherit;\">Partikel Majorana: Kunci Komputasi Kuantum yang Stabil</strong></p><p>Partikel Majorana adalah partikel unik yang menjadi partikel dan antipartikelnya sendiri. Pertama kali diprediksi oleh fisikawan Italia Ettore Majorana pada 1937, keberadaannya baru terbukti secara eksperimental pada 2012. Dalam komputasi kuantum, partikel ini digunakan untuk menciptakan <span style=\"color: var(--tw-prose-bold);\">qubit topologis </span>— unit dasar komputer kuantum yang jauh lebih tahan terhadap gangguan eksternal seperti panas atau medan magnet.</p><p>Qubit konvensional, seperti yang digunakan IBM atau Google, sangat rentan terhadap <em>decoherence </em>(kehilangan informasi kuantum). Sementara qubit topologis menyimpan data dalam pola anyon, partikel yang eksistensinya bergantung pada struktur material. Inilah yang membuatnya lebih stabil dan cocok untuk aplikasi praktis.</p><p><br></p><p><strong style=\"color: inherit;\">Mengapa Microsoft Memilih Jalur Ini?</strong></p><p>Microsoft memfokuskan risetnya pada komputasi kuantum topologis karena tiga alasan utama:</p><p>Pertama, qubit topologis mengurangi kebutuhan akan sistem koreksi kesalahan yang rumit, sehingga lebih efisien. Kedua, desainnya memungkinkan skalabilitas lebih mudah dibanding qubit superkonduktor. Ketiga, Microsoft ingin membedakan diri dari kompetitor yang sudah lebih dulu membangun komputer kuantum berbasis teknologi lain.</p><p>Proyek ini didukung oleh kolaborasi antara Microsoft Quantum Lab dan universitas terkemuka seperti TU Delft dan University of Sydney. Tim peneliti menggunakan material hibrida (superkonduktor dan semikonduktor) untuk menciptakan kondisi yang memungkinkan partikel Majorana terbentuk.</p><p><br></p><p><strong style=\"color: inherit;\">Kemajuan dan Hambatan</strong></p><p>Pada 2018, Microsoft mengklaim berhasil mendeteksi jejak partikel Majorana melalui eksperimen \"zero-bias peaks\" dalam nano-wire semikonduktor. Namun, hasil ini masih diperdebatkan karena replikasi yang sulit. Baru pada 2022, Microsoft mengumumkan prototipe qubit topologis pertama yang mampu menjalankan operasi logika dasar.</p><p>Meski demikian, tantangan besar tetap ada. Deteksi partikel Majorana membutuhkan kondisi ekstrem (suhu mendekati nol mutlak) dan isolasi sempurna. Selain itu, kompetitor seperti IBM dan Google telah mengoperasikan komputer kuantum dengan ratusan qubit, sementara Microsoft masih dalam tahap awal.</p><p><br></p><p><strong style=\"color: inherit;\">Kontroversi dan Kritik</strong></p><p>Sebagian ilmuwan menilai pendekatan Microsoft terlalu spekulatif. Partikel Majorana belum sepenuhnya dipahami, dan eksperimen seringkali gagal menghasilkan data konsisten. Bahkan, beberapa peneliti internal Microsoft dilaporkan frustrasi dengan lambatnya kemajuan. Namun, perusahaan tetap yakin bahwa investasi jangka panjang ini akan membuahkan hasil.</p><p><br></p><p><strong style=\"color: inherit;\">Pernyataan Kunci dari Microsoft</strong></p><p><em>\"Kami sedang membangun fondasi komputasi kuantum yang akan bertahan puluhan tahun. Ini bukan tentang kecepatan, tapi tentang ketepatan,\" </em>ujar <span style=\"color: var(--tw-prose-bold);\">Dr. Krysta Svore </span>, kepala penelitian komputasi kuantum Microsoft.</p><p><span style=\"color: inherit;\">Implikasi bagi Masa Depan</span></p><p>Jika Microsoft berhasil, komputer kuantum berbasis Majorana bisa merevolusi berbagai bidang:</p><ul><li><span style=\"color: var(--tw-prose-bold);\">Kesehatan </span>: Simulasi molekul untuk penemuan obat baru.</li><li><span style=\"color: var(--tw-prose-bold);\">Keamanan </span>: Pemecahan algoritma enkripsi klasik dan pengembangan kriptografi kuantum.</li><li><span style=\"color: var(--tw-prose-bold);\">AI </span>: Pelatihan model machine learning dengan kecepatan eksponensial.</li></ul><p>Namun, para ahli memperingatkan bahwa teknologi ini mungkin baru siap digunakan secara komersial dalam 10–20 tahun.</p><p><br></p><p><strong style=\"color: inherit;\">Kesimpulan</strong></p><p>Microsoft mungkin sedang berjudi dengan partikel Majorana, tetapi taruhannya bisa mengubah dunia. Meski penuh risiko, pendekatan ini menunjukkan visi Microsoft untuk memimpin era komputasi pasca-silikon. Bagi industri teknologi, ini adalah pengingat bahwa inovasi terbesar seringkali lahir dari eksperimen yang berani — bahkan jika hasilnya masih jauh dari pasti.</p>', 19, 126, 1, '2025-04-03 05:37:22', '2025-04-03 06:38:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `news_media`
--

CREATE TABLE `news_media` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `media_type` varchar(50) DEFAULT 'image',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `news_votes`
--

CREATE TABLE `news_votes` (
  `id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote` enum('up','down') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `news_votes`
--

INSERT INTO `news_votes` (`id`, `news_id`, `user_id`, `vote`, `created_at`) VALUES
(1, 35, 122, 'up', '2025-04-01 21:08:25'),
(2, 34, 122, 'up', '2025-04-02 06:22:58'),
(3, 34, 126, 'up', '2025-04-02 08:37:18'),
(4, 35, 124, 'up', '2025-04-02 19:33:28'),
(5, 37, 122, 'up', '2025-04-03 05:47:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','editor','writer','user') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `profile_image`, `password`, `role`, `created_at`, `updated_at`) VALUES
(96, 'nauvalbest123', 'Nauval D. Sidiq', 'nauval@gmail.com', NULL, '$2y$10$Zysh2hu92vzqrcuoScMLn.dyR7bP4Qy9b8kFQjuP/abr8LMjdC3dO', 'editor', '2025-03-25 19:58:48', '2025-03-25 22:37:48'),
(99, 'nauvality', 'Nauval D. Sidiq', 'john@gmail.com', NULL, '$2y$10$0Xlefji6CwKs78ednVRDg.fEb4T7RU8Lb4msWUWWmsEMTOpTNhbKK', 'writer', '2025-03-26 02:05:56', '2025-03-26 02:07:22'),
(100, 'randomuser123', 'Randomly Created User', 'randomuser@gmail.com', NULL, '$2y$10$ZNk0BObthRTZ9XiukQIryurTve5gN5R3eiyiL/JIJ0gZ2dzK/n6/W', 'user', '2025-03-26 04:05:25', '2025-03-26 04:05:25'),
(103, 'user3', 'User 3', 'user3@example.com', NULL, '$2y$10$IElOAYupATFj8hydBjuice88W3Cq0alAMb22QBWd9r9HjnEKHjoWK', 'admin', '2025-03-25 22:08:13', '2025-03-26 04:08:13'),
(104, 'user4', 'User 4', 'user4@example.com', NULL, '$2y$10$Y72OnZUpBxIL.dY52/c1nOcGEUjxwNzLE3kEFIQ5cPF8ckcHrK1yi', 'writer', '2025-03-25 22:08:13', '2025-03-26 04:08:13'),
(105, 'user5', 'User 5', 'user5@example.com', NULL, '$2y$10$svKoroA2/JPYq8jRwEMTp.E0/1zyA0kla9GEb3Ch/xfgF6IJDJLAe', 'user', '2025-03-25 22:08:13', '2025-03-26 04:08:13'),
(106, 'user6', 'User 6', 'user6@example.com', NULL, '$2y$10$m3ZxYMYZ9wvGgKdLnRbrHOK2X3foP7G7Qeu5RKfwvRHz3./Je1/Gu', 'user', '2025-03-25 22:08:13', '2025-03-26 04:08:13'),
(107, 'user7', 'User 7', 'user7@example.com', NULL, '$2y$10$mRLMCSjQk6yaEEmmYU7gxO.25sfBB7P/NytraBaFCSNxURVoMNBOO', 'admin', '2025-03-25 22:08:13', '2025-03-26 04:08:13'),
(108, 'user8', 'User 8', 'user8@example.com', NULL, '$2y$10$3fMmtPFDdmgFn0qBmQWp8ujpEtNMtyFmn7KucUdyLJ4PbZTkiksy.', 'admin', '2025-03-25 22:08:13', '2025-03-26 04:08:13'),
(109, 'user9', 'User 9', 'user9@example.com', NULL, '$2y$10$32Q5kjgKR.vN/5a3j0GjmuvujzfeUdnQ7xIY6RCkOt4TJ8UymlZs2', 'admin', '2025-03-25 22:08:14', '2025-03-26 04:08:14'),
(110, 'user10', 'User 10', 'user10@example.com', NULL, '$2y$10$Ti7KrN6dvBhDjypODbXEJunm1ecM23r4gjxEyXYvLhlpfm9VyV.du', 'editor', '2025-03-25 22:08:14', '2025-03-26 04:08:14'),
(111, 'user11', 'User 11', 'user11@example.com', NULL, '$2y$10$S1zRlJ6h.JIFNKPxahLy.eMuuB6WbgXOA.N2q39H8DVFIpXq182nq', 'editor', '2025-03-25 22:08:14', '2025-03-26 04:08:14'),
(112, 'user12', 'User 12', 'user12@example.com', NULL, '$2y$10$nY6iBhR6MGoohhpJ2Poe1ODG./R43omEGYIWT1kgdQTfQrdoEK0Q.', 'writer', '2025-03-25 22:08:14', '2025-03-26 04:08:14'),
(113, 'user13', 'User 13', 'user13@example.com', NULL, '$2y$10$91lfkI5qqBrI/nJSLRTiF.Zz7F8WeIQWe/So9S2M.nSzngBwXfWxC', 'user', '2025-03-25 22:08:14', '2025-03-26 04:08:14'),
(114, 'user14', 'User 14', 'user14@example.com', NULL, '$2y$10$AaPyDEfepXxMp7alG8S7tOTsIINb7jRoWWjMiUMAVtU/mfD//QMcS', 'user', '2025-03-25 22:08:14', '2025-03-26 04:08:14'),
(115, 'user15', 'User 15', 'user15@example.com', NULL, '$2y$10$lJcVnzsRJzRuxQcwugQ36uwCW9zmG9/tBwlE3c1n4eSK75ltvS51.', 'user', '2025-03-25 22:08:15', '2025-03-26 04:08:15'),
(116, 'user16', 'User 16', 'user16@example.com', NULL, '$2y$10$WsEG/aGtH5ya8yoUNeB4eOcgjuYtY0la5b0dDHePUi8O7HT2kwM0q', 'admin', '2025-03-25 22:08:15', '2025-03-26 04:08:15'),
(117, 'user17', 'User 17', 'user17@example.com', NULL, '$2y$10$PwfzQqqpKW5d2I8GBYieG.UFeOQwc2zVuyIjbXghBY9u/9jzuPzzu', 'user', '2025-03-25 22:08:15', '2025-03-26 04:08:15'),
(118, 'user18', 'User 18', 'user18@example.com', NULL, '$2y$10$t1NbSieIkQE6SueFISfP7.BOZ2sPsuxBnkHuAUWlQnd3v3.K/4Eue', 'editor', '2025-03-25 22:08:15', '2025-03-26 04:08:15'),
(119, 'user19', 'User 19', 'user19@example.com', NULL, '$2y$10$wbe7/LbMUdVlk1wmo1X.NevxeaTa9Yl.aG9//UcXYfusJpoZWnzwu', 'writer', '2025-03-25 22:08:15', '2025-03-26 04:08:15'),
(120, 'user20', 'User 20', 'user20@example.com', NULL, '$2y$10$DG6NkeNVvfGs47n3/vrJreTMri5iViSIX4TKRXWnzw6WtrFy23nhK', 'writer', '2025-03-25 22:08:15', '2025-03-26 04:08:15'),
(122, 'adminada3', 'Admin Ada Banget', 'adminada@example.com', '', '$2y$10$e0bm3wfQtRwZ5VxltHqCIOAd6cq6V8QD3.YtA2sy/Xl6pz5e1ex1K', 'admin', '2025-03-29 23:42:53', '2025-04-03 11:37:56'),
(123, 'admin1234', 'Admin Ganteng Idaman', 'admin@example2.com', NULL, '$2y$10$CGVFVUK8FO.WZqZB2OPdruL6y9d160lemJ.aqXLcx5v//PzmOXVtW', 'user', '2025-03-30 22:59:28', '2025-03-30 22:59:28'),
(124, 'nauvaldsidiq123', 'Nauval Dhonand Sidiq', 'nauvalsidiq@example.com', NULL, '$2y$10$JeLlBcTtkbA5G6bNOodcOOikj729CEjXPnDMucsztmX.rdo9t79i2', 'writer', '2025-04-01 10:32:01', '2025-04-03 00:16:22'),
(125, 'user123', 'User Pencoba', 'user1234@gmail.com', NULL, '$2y$10$6xhGjDNlR/JBWrZiOeQkpOfxNaty9slJeKPYyc73bvoMwJDQ0ajKe', 'user', '2025-04-01 10:34:30', '2025-04-01 10:34:30'),
(126, 'saed123', 'Said Ikmal F', 'saed13@example.com', NULL, '$2y$10$aTvmvD7WAqBbEO26TZeRkOOhS/VGK0NDpckJt6AYJ/NRUhlNO4pA.', 'writer', '2025-04-02 13:28:20', '2025-04-02 13:28:44');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indeks untuk tabel `news_media`
--
ALTER TABLE `news_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `news_id` (`news_id`);

--
-- Indeks untuk tabel `news_votes`
--
ALTER TABLE `news_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`news_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `news_media`
--
ALTER TABLE `news_media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `news_votes`
--
ALTER TABLE `news_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news_media`
--
ALTER TABLE `news_media`
  ADD CONSTRAINT `news_media_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `news_votes`
--
ALTER TABLE `news_votes`
  ADD CONSTRAINT `news_votes_ibfk_1` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `news_votes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
