<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "db_7summits_sembalun";

$koneksi = new mysqli($host, $username, $password, $db);

if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}
?>