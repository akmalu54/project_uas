<?php
session_start(); // Memulai session agar bisa dihapus
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan session yang ada

// Mengarahkan user kembali ke halaman utama (index.php) setelah logout
header("Location: index.php");
exit();
?>