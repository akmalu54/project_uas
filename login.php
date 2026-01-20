<?php
include 'koneksi.php';
session_start();

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitasi input untuk keamanan
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Query mencari user di tabel pengguna
    $query = "SELECT * FROM pengguna WHERE username='$username' AND pass='$password'";
    $result = $koneksi->query($query);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $data['username'];

        // Redirect ke halaman utama
        header("Location: index.php");
        exit;
    } else {
        $error_message = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - 7 Summits Sembalun</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #e8f5e9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #ffffff; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); width: 100%; max-width: 380px; }
        .login-header { text-align: center; margin-bottom: 30px; }
        .login-header h2 { color: #2e7d32; margin: 0; font-size: 1.8rem; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; color: #2e7d32; font-weight: 600; }
        .input-group input { width: 100%; padding: 12px; border: 2px solid #c8e6c9; border-radius: 8px; box-sizing: border-box; outline: none; }
        .input-group input:focus { border-color: #4caf50; }
        .btn-login { width: 100%; padding: 12px; background-color: #4caf50; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: bold; }
        .alert { padding: 10px; border-radius: 6px; margin-bottom: 20px; text-align: center; font-size: 0.9rem; }
        .error { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .footer { margin-top: 20px; text-align: center; }
        .footer a { color: #4caf50; text-decoration: none; font-size: 0.85rem; }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-header">
            <h2>Form Login</h2>
            <p>Silakan Masuk menuju dashboard</p>
        </div>

        <?php if ($error_message): ?>
            <div class="alert error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn-login">LOGIN</button>
        </form>

        <div class="footer">
            <a href="register.php">Belum punya akun? Daftar sekarang</a>
        </div>
    </div>

</body>
</html>