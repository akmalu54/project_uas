<?php
include 'koneksi.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi Password
    if ($password !== $confirm_password) {
        $message = "<div class='alert error'>Konfirmasi password tidak cocok!</div>";
    } else {
        // Cek apakah email sudah terdaftar
        $cek_email = $koneksi->query("SELECT email FROM pengguna WHERE email='$email'");
        if ($cek_email->num_rows > 0) {
            $message = "<div class='alert error'>Email sudah digunakan!</div>";
        } else {
            // Simpan ke database (menggunakan kolom username, pass, email sesuai db_7summits_sembalun)
            $sql = "INSERT INTO pengguna (username, pass, email) VALUES ('$nama', '$password', '$email')";
            if ($koneksi->query($sql)) {
                $message = "<div class='alert success'>Pendaftaran berhasil! <a href='login.php'>Login di sini</a></div>";
            } else {
                $message = "<div class='alert error'>Gagal mendaftar: " . $koneksi->error . "</div>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <style>
        :root { --hijau-muda: #e8f5e9; --hijau-utama: #4caf50; --hijau-gelap: #2e7d32; --biru-aksen: #2196f3; --putih: #ffffff; }
        body { font-family: 'Segoe UI', sans-serif; background-color: var(--hijau-muda); display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .register-card { background-color: var(--putih); width: 100%; max-width: 450px; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-top: 5px solid var(--biru-aksen); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { color: var(--hijau-gelap); margin: 0; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 8px; color: var(--hijau-gelap); font-weight: 600; font-size: 14px; }
        .form-group input { width: 100%; padding: 12px; border: 2px solid #ddd; border-radius: 8px; box-sizing: border-box; outline: none; }
        .form-group input:focus { border-color: var(--biru-aksen); }
        .btn-register { width: 100%; padding: 13px; background-color: var(--hijau-utama); color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; text-align: center; }
        .error { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .success { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .footer-text { text-align: center; margin-top: 20px; font-size: 14px; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="header">
        <h2>Buat Akun</h2>
    </div>

    <?php echo $message; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Nama Lengkap / Username</label>
            <input type="text" name="nama" placeholder="Masukkan nama" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="contoh@email.com" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input type="password" name="confirm_password" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn-register">DAFTAR SEKARANG</button>
    </form>

    <div class="footer-text">
        Sudah punya akun? <a href="login.php" style="color:var(--biru-aksen); text-decoration:none; font-weight:bold;">Login di sini</a>
    </div>
</div>

</body>
</html>