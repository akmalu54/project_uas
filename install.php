<?php
// Pengaturan koneksi awal ke MySQL
$host = "localhost";
$username = "root";
$password = "";

$koneksi = new mysqli($host, $username, $password);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

echo "<h2>Proses Instalasi Database 7 Summits Sembalun</h2>";

// 1. Membuat Database db_7summits_sembalun
$sql_db = "CREATE DATABASE IF NOT EXISTS db_7summits_sembalun";
if ($koneksi->query($sql_db) === TRUE) {
    echo "✔️ Database 'db_7summits_sembalun' berhasil disiapkan.<br>";
} else {
    die("❌ Gagal membuat database: " . $koneksi->error);
}

// Memilih database
$koneksi->select_db("db_7summits_sembalun");

// 2. Membuat Tabel Kategori Jalur
$sql_kategori = "CREATE TABLE IF NOT EXISTS `kategori_jalur` (
    `kd_jalur` varchar(5) NOT NULL,
    `tingkat_kesulitan` varchar(30) NOT NULL,
    PRIMARY KEY (`kd_jalur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($koneksi->query($sql_kategori) === TRUE) {
    echo "✔️ Tabel 'kategori_jalur' berhasil disiapkan.<br>";
}

// 3. Membuat Tabel Pengguna (Hiker/Admin)
$sql_pengguna = "CREATE TABLE IF NOT EXISTS `pengguna` (
    `id` int(3) NOT NULL AUTO_INCREMENT,
    `username` varchar(30) NOT NULL,
    `pass` varchar(255) NOT NULL,
    `email` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($koneksi->query($sql_pengguna) === TRUE) {
    echo "✔️ Tabel 'pengguna' berhasil disiapkan.<br>";
}

// 4. Membuat Tabel Puncak/Gunung
$sql_summits = "CREATE TABLE IF NOT EXISTS `summits` (
    `id_peak` int(2) NOT NULL AUTO_INCREMENT,
    `nama_puncak` varchar(50) NOT NULL,
    `ketinggian` varchar(15) NOT NULL,
    `kd_jalur` varchar(5) NOT NULL,
    PRIMARY KEY (`id_peak`),
    KEY `kd_jalur` (`kd_jalur`),
    CONSTRAINT `fk_summit_jalur` FOREIGN KEY (`kd_jalur`) REFERENCES `kategori_jalur` (`kd_jalur`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($koneksi->query($sql_summits) === TRUE) {
    echo "✔️ Tabel 'summits' berhasil disiapkan.<br>";
}

// --- BAGIAN BARU: TABEL KOMENTAR ---
// 7. Membuat Tabel Komentar
$sql_komentar = "CREATE TABLE IF NOT EXISTS `komentar` (
    `id_komentar` int(5) NOT NULL AUTO_INCREMENT,
    `id_peak` int(2) NOT NULL,
    `nama_pengirim` varchar(50) NOT NULL,
    `isi_komentar` text NOT NULL,
    `tanggal` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_komentar`),
    CONSTRAINT `fk_komentar_peak` FOREIGN KEY (`id_peak`) REFERENCES `summits` (`id_peak`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if ($koneksi->query($sql_komentar) === TRUE) {
    echo "✔️ Tabel 'komentar' berhasil disiapkan.<br>";
}
// ----------------------------------

// 5. Mengisi Data Kategori Kesulitan Jalur
$sql_isi_jalur = "INSERT IGNORE INTO `kategori_jalur` (`kd_jalur`, `tingkat_kesulitan`) VALUES
('EASY', 'Mudah / Pemula'),
('MOD', 'Moderate / Menengah'),
('HARD', 'Sulit / Ahli'),
('EXT', 'Extreme / Profesional')";

if ($koneksi->query($sql_isi_jalur) === TRUE) {
    echo "✔️ Data referensi tingkat jalur berhasil diinput.<br>";
}

// 6. Mengisi Data 7 Summits Sembalun
$sql_isi_peaks = "INSERT IGNORE INTO `summits` (`id_peak`, `nama_puncak`, `ketinggian`, `kd_jalur`) VALUES 
(1, 'Gunung Rinjani', '3726 MDPL', 'EXT'), 
(2, 'Bukit Pergasingan', '1707 MDPL', 'EASY'), 
(3, 'Bukit Anak Dara', '1923 MDPL', 'MOD'),
(4, 'Bukit Nanggi', '2300 MDPL', 'MOD'),
(5, 'Bukit Lembah Gedong', '2200 MDPL', 'MOD'),
(6, 'Bukit Kondo', '1930 MDPL', 'EASY'),
(7, 'Bukit Sempana', '2329 MDPL', 'HARD')";

if ($koneksi->query($sql_isi_peaks) === TRUE) {
    echo "✔️ Data 7 Puncak Sembalun berhasil diinput.<br>";
}

echo "<br><strong>Instalasi 7 Summits Selesai!</strong><br>";
echo "Akses sistem: <a href='login.php'>Login</a> | <a href='vsummits.php'>Lihat Daftar Puncak</a>";

$koneksi->close();
?>