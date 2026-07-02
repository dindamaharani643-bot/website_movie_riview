-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 03:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `user_movier`
--

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `id_film` int(11) NOT NULL,
  `genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id_film`, `genre`) VALUES
(1, 'Romance'),
(2, 'Horror'),
(3, 'Action');

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'default_movie.jpg',
  `judul` varchar(255) NOT NULL,
  `rating_usia` varchar(10) NOT NULL,
  `rating_film` decimal(3,1) NOT NULL,
  `sutradara` varchar(150) NOT NULL,
  `aktor` text NOT NULL,
  `sinopsis` text NOT NULL,
  `id_film` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`id`, `image`, `judul`, `rating_usia`, `rating_film`, `sutradara`, `aktor`, `sinopsis`, `id_film`) VALUES
(3, 'movie_6a4332f676451.jpeg', 'Off Campus', 'D17', 8.3, 'Jenny Gage', 'Jacob Elordi, Austin Butler, Camilla Mendez', 'Serial Off Campus menceritakan kisah cinta antara Hannah Wells, mahasiswi pintar yang naksir seorang musisi, dan Garrett Graham, bintang atlet hoki es di Briar University. Hubungan mereka bermula dari kesepakatan pacaran pura-pura yang perlahan berubah menjadi cinta sejati.\r\nSutradara Impian: Jenny Gage (Sutradara After) atau Castille Landon (Sutradara After We Fell). Mereka dianggap berpengalaman dalam menggarap film drama romantis anak kuliahan yang diadaptasi dari novel populer.', 1),
(4, 'movie_6a43338c97440.jpeg', 'Maxton Hall', 'D17', 8.0, 'Martin Schreier', 'Damian Hardung, Harriet Herbig-Matten', 'Maxton Hall - The World Between Us adalah serial drama romantis yang menceritakan kisah cinta dua remaja dari latar belakang sosial yang sangat berbeda di sebuah sekolah swasta elit. Ceritanya berfokus pada James Beaufort, pewaris kaya yang arogan, dan Ruby Bell, seorang siswi penerima beasiswa yang pendiam.', 1),
(5, 'movie_6a4333fda34cc.jpeg', 'Bercinta dengan Maut', 'D17', 7.3, 'Monty Tiwa', 'Haico Van der Veken, Junior Roberts', 'Series \"Bercinta dengan Maut\" menceritakan tentang Raya (Haico Van der Veken), seorang penari klub malam yang hidup menderita. Kehidupannya berubah total saat ia menemukan saudara kembarnya, Anna, tewas secara misterius. Demi mengungkap kebenaran, Raya menyamar sebagai Anna dan menyusup ke dalam keluarga politik yang berkuasa.', 1),
(6, 'movie_6a4334b525ed9.jpeg', 'Us', 'R13', 7.3, 'Jordan Peele', 'Lupita Nyong\'o, Winston Duke, Elisabeth Moss, Tim Heidecker', 'Adelaide Wilson kembali ke rumah masa kecilnya di tepi pantai bersama suami dan kedua anaknya untuk liburan musim panas yang damai. Namun, Adelaide dihantui oleh trauma masa lalu yang membuatnya merasa paranoid bahwa sesuatu yang buruk akan menimpa keluarganya. Ketakutan tersebut menjadi kenyataan ketika pada suatu malam, sekelompok orang misterius yang berpegangan tangan muncul di pekarangan rumah mereka. Yang mengerikan, kelompok penyerang tersebut adalah doppelgänger atau kembaran yang berwajah persis sama dengan masing-masing anggota keluarga mereka sendiri, yang dikenal sebagai \"The Tethered\".', 2),
(7, 'movie_6a433511d86d4.jpeg', 'Evil Dead Rise', 'D17', 7.8, 'Lee Cronin', 'Lily Sullivan, Alyssa Sutherland, Morgan Davies, Gabrielle Echols, Nell Fisher', 'Film ini memindahkan aksi terornya dari hutan ke sebuah gedung apartemen di perkotaan Los Angeles. Cerita berfokus pada dua saudara perempuan yang terasing, Beth dan Ellie. Reuni mereka berubah menjadi mimpi buruk ketika anak Ellie tidak sengaja menemukan sebuah kitab kuno misterius (Naturom Demonto / Necronomicon) dan rekaman piringan hitam di ruang bawah tanah apartemen mereka. Ritual dari rekaman tersebut membangkitkan iblis pemakan jiwa (Deadites) yang merasuki Ellie. Beth pun harus berjuang mati-matian demi menyelamatkan keponakan-keponakannya dari sosok ibu mereka yang kini berubah menjadi monster mengerikan.', 2),
(8, 'movie_6a433556b6e72.jpeg', 'Bring Her Back', 'D17', 8.3, 'Danny Philippou & Michael Philippou', 'Sally Hawkins, Billy Barratt, Sora Wong, Jonah Wren Phillips', 'Setelah kematian tragis ayah mereka, remaja bernama Andy dan saudara tiri perempuannya yang tunanetra, Piper, dikirim untuk tinggal bersama ibu asuh baru bernama Laura. Laura, seorang mantan konselor eksentrik, ternyata masih dirundung duka mendalam akibat kematian putrinya sendiri, Cathy. Sikap Laura awalnya terlihat hangat namun perlahan berubah menjadi manipulatif dan sinister. Di rumah tersebut juga tinggal Oliver, seorang anak angkat lain yang misterius dan bisu. Andy segera menyadari adanya kejanggalan mengerikan: Laura ternyata terlibat dalam ritual okultisme supernatural berbahaya menggunakan rekaman VHS kuno demi membangkitkan kembali jasad putrinya, yang menempatkan nyawa Andy dan Piper dalam bahaya besar.', 2),
(9, 'movie_6a43362a96384.jpg', 'Taxi Driver', 'D17', 8.8, 'Martin Scorsese', 'Robert De Niro, Jodie Foster, Cybill Shepherd, Harvey Keitel', 'Travis Bickle (Robert De Niro) adalah seorang mantan tentara veteran Perang Vietnam yang mengalami insomnia parah dan depresi akut. Untuk mengisi malam-malamnya yang sepi di kota New York yang korup dan membusuk, ia bekerja sebagai sopir taksi malam. Seiring waktu, rasa kesepian dan rasa jijiknya terhadap kriminalitas jalanan mulai mengikis kesehatan mentalnya. Travis perlahan berubah menjadi seorang vigilante (hakim jalanan) yang terobsesi untuk \"membersihkan kota\", termasuk mencoba menyelamatkan seorang pelacur anak berusia 12 tahun bernama Iris (Jodie Foster).', 3),
(10, 'movie_6a4336bd09200.jpg', 'Fight Club', 'D17', 9.8, 'David Fincher', 'Edward Norton, Brad Pitt, Helena Bonham Carter', 'Seorang pria kantoran tanpa nama (Edward Norton) menderita insomnia akut dan terjebak dalam gaya hidup konsumerisme yang membosankan. Hidupnya berubah total setelah ia bertemu dengan Tyler Durden (Brad Pitt), seorang penjual sabun eksentrik dengan filosofi hidup anti-kemapanan. Mereka berdua kemudian mendirikan \"Fight Club\", sebuah klub bertarung rahasia bawah tanah tempat pria-pria urban meluapkan agresi dan frustrasi mereka lewat baku hantam. Namun, klub ini perlahan berevolusi menjadi organisasi teroris anarkis berskala besar bernama Project Mayhem, membawa sang Narator ke dalam pusaran kekacauan mental yang tak terkendali.', 3),
(11, 'movie_6a4337311a2cd.jpeg', 'No Country for Old Men', 'D17', 7.8, 'Joel Coen, Ethan Coen (The Coen Brothers)', 'Josh Brolin, Javier Bardem, Tommy Lee Jones', 'Berlatar di wilayah gersang Texas Barat tahun 1980, Llewelyn Moss (Josh Brolin), seorang tukang las sekaligus veteran perang, tidak sengaja menemukan lokasi transaksi narkoba yang berakhir berdarah di tengah gurun. Di sana, ia menemukan koper berisi uang tunai sebesar $2 juta dan memutuskan untuk membawanya kabur. Keputusan ini mengubah hidupnya menjadi neraka karena ia langsung diburu oleh Anton Chigurh (Javier Bardem), seorang pembunuh bayaran psikopat berdarah dingin yang menggunakan koin untuk menentukan hidup-mati korbannya. Di sisi lain, seorang sheriff tua bernama Ed Tom Bell (Tommy Lee Jones) mencoba melacak mereka sembari merenungi hilangnya moralitas di dunia modern.', 3),
(12, 'movie_6a43377f40d10.jpeg', 'Shutter Island', 'D17', 8.5, 'Martin Scorsese', 'Leonardo DiCaprio, Mark Ruffalo, Ben Kingsley, Max von Sydow', 'Pada tahun 1954, dua US Marshal, Teddy Daniels (Leonardo DiCaprio) dan mitranya Chuck Aule (Mark Ruffalo), dikirim ke Rumah Sakit Ashecliffe di Shutter Island—sebuah pulau terisolasi yang berfungsi sebagai lembaga psikiatri bagi penjahat yang sakit jiwa. Mereka bertugas menyelidiki hilangnya seorang pasien wanita bernama Rachel Solando secara misterius dari kamar terkunci. Di tengah badai besar yang memutus komunikasi dengan daratan, Teddy mulai mencurigai adanya eksperimen medis ilegal dan konspirasi rahasia yang dilakukan oleh para dokter di sana. Situasi semakin rumit karena Teddy juga dihantui oleh trauma masa lalunya di Perang Dunia II dan kematian tragis istrinya.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id_rating` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `skor` int(11) NOT NULL CHECK (`skor` >= 1 and `skor` <= 10),
  `komentar` text DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id_rating`, `id_user`, `id`, `email`, `skor`, `komentar`, `tanggal_dibuat`) VALUES
(1, 17, 8, '', 9, 'keren aktingnya', '2026-06-30 06:46:12'),
(2, 17, 5, '', 8, 'Film nya menegankan', '2026-06-30 06:53:00'),
(3, 17, 7, '', 9, 'mantap creepy bgtt', '2026-06-30 06:57:41'),
(4, 17, 10, '', 10, 'no 1 of fight club!!', '2026-06-30 06:58:17'),
(5, 17, 4, '', 9, 'good', '2026-06-30 06:58:35'),
(6, 17, 11, '', 8, 'sadis si cigur', '2026-06-30 06:58:54'),
(7, 17, 3, '', 8, 'semangat bgt gw liatnyaa', '2026-06-30 06:59:26'),
(8, 17, 12, '', 7, 'jadi siapa yang gila?', '2026-06-30 06:59:54'),
(9, 17, 9, '', 9, 'bestt movie of all time', '2026-06-30 07:00:15'),
(10, 17, 6, '', 9, 'lumayan bagus film nya', '2026-06-30 07:00:32'),
(11, 18, 5, '', 9, 'MANTAPP', '2026-06-30 07:05:26'),
(12, 18, 8, '', 8, 'KEREN', '2026-06-30 07:05:38'),
(13, 18, 7, '', 7, 'ihh sereemm', '2026-06-30 07:06:15'),
(14, 18, 10, '', 10, '2 kepribadian', '2026-06-30 07:07:00'),
(15, 18, 4, '', 9, 'bagus aktingnya', '2026-06-30 07:07:21'),
(16, 18, 11, '', 9, 'keren', '2026-06-30 07:08:13'),
(17, 18, 3, '', 9, 'cantik', '2026-06-30 07:08:29'),
(18, 18, 12, '', 8, 'thrilogy nya dapet', '2026-06-30 07:08:54'),
(19, 18, 9, '', 9, 'brutall', '2026-06-30 07:09:05'),
(20, 18, 6, '', 5, 'bosen', '2026-06-30 07:09:23'),
(21, 19, 5, '', 7, 'b aja', '2026-06-30 07:11:33'),
(22, 19, 8, '', 9, 'bagus', '2026-06-30 07:11:45'),
(23, 19, 7, '', 7, 'standar\r\n', '2026-06-30 07:11:58'),
(24, 19, 10, '', 10, 'SUKAAAA', '2026-06-30 07:12:07'),
(25, 19, 4, '', 8, 'GOOODDDD', '2026-06-30 07:12:18'),
(26, 19, 11, '', 5, 'HM', '2026-06-30 07:12:27'),
(27, 19, 3, '', 8, 'DEWASA GAISSSS', '2026-06-30 07:12:44'),
(28, 19, 12, '', 10, 'omgggggggg', '2026-06-30 07:12:57'),
(29, 19, 9, '', 10, 'keren sih', '2026-06-30 07:13:06'),
(30, 19, 6, '', 8, 'serem', '2026-06-30 07:13:16'),
(31, 20, 5, '', 5, 'not bad', '2026-06-30 07:14:31'),
(32, 20, 8, '', 7, 'cakep', '2026-06-30 07:14:43'),
(33, 20, 7, '', 8, 'serem', '2026-06-30 07:15:18'),
(34, 20, 10, '', 9, 'actionnnnnnnnnnnnnnn', '2026-06-30 07:15:29'),
(35, 20, 4, '', 6, 'hem', '2026-06-30 07:15:39'),
(36, 20, 11, '', 9, 'good good aja', '2026-06-30 07:15:53'),
(37, 20, 3, '', 8, 'hem', '2026-06-30 07:16:03'),
(38, 20, 12, '', 9, 'good', '2026-06-30 07:16:12'),
(39, 20, 9, '', 7, 'aksi', '2026-06-30 07:16:22'),
(40, 20, 6, '', 7, 'bagussss', '2026-06-30 07:16:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nama_role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `user` varchar(100) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `foto_profil` varchar(255) NOT NULL DEFAULT 'default.png',
  `sandi` varchar(200) NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `id_role` int(11) DEFAULT 2,
  `status` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `user`, `nama`, `email`, `tgl_lahir`, `bio`, `foto_profil`, `sandi`, `jenis_kelamin`, `id_role`, `status`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '2004-12-09', 'Apa saja', 'user_6a433120b8878.jpeg', '$2y$10$UhoYW9qfWKtxqpCw8sxkxu8UTW/5hlQOmhHnSJYQbFmdmkedlcZHS', 'pria', 1, 'Y'),
(17, 'joeLoveAction', 'Joseph F Kennedy', 'joe45@gmail.com', '0000-00-00', 'Joe suka film action', 'user_6a450b5585cc1.jpeg', '$2y$10$TeCUea/kjwjuXOUuzdHC/.C1LFZXGmXjPOv5um6zr1Ucv5jQbyyhS', 'pria', 2, 'N'),
(18, 'jojo', 'jojolion', 'jojo@gmail.com', NULL, NULL, 'default.png', '$2y$10$jNI/BP/7RY0wY/h5eoP1jehkxMoZxCKecrdccYHg0rg2y1Tv0OJtS', 'pria', 2, 'N'),
(19, 'putri', 'putri', 'putri@gmail.com', NULL, NULL, 'default.png', '$2y$10$mUKTWYr0.kdD.cqTHljkfukSX3S.4.YPW.hpqzZELLoJu3NGE1dhO', 'pria', 2, 'N'),
(20, 'oktafiani', 'fian', 'oktafiani@gmail.com', NULL, NULL, 'default.png', '$2y$10$AYX972V/k6B/yrUJHSslWuzgZ0lsilCin.DaZXDFR/HWRaM8LmYpW', 'pria', 2, 'N');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_film`);

--
-- Indexes for table `movie`
--
ALTER TABLE `movie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_movie_genre` (`id_film`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `id` (`id`),
  ADD KEY `fk_rating_user` (`id_user`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`),
  ADD UNIQUE KEY `nama_role` (`nama_role`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id_film` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `movie`
--
ALTER TABLE `movie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id_rating` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movie`
--
ALTER TABLE `movie`
  ADD CONSTRAINT `fk_movie_genre` FOREIGN KEY (`id_film`) REFERENCES `genre` (`id_film`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `fk_rating_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`id`) REFERENCES `movie` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
