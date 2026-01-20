<?php
session_start();
include 'koneksi.php';

// Proteksi halaman: Jika belum login, tendang kembali ke login.php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - 7 Summits Sembalun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar { height: 100vh; background: #212529; color: white; padding-top: 20px; }
        .sidebar a { color: #adb5bd; text-decoration: none; display: block; padding: 10px 20px; }
        .sidebar a:hover { background: #343a40; color: white; }
        .main-content { padding: 20px; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 sidebar d-none d-md-block">
                <h5 class="text-center mb-4">Admin Panel</h5>
                <a href="index.php"><i class="fas fa-home me-2"></i> Lihat Web</a>
                <a href="summits.php"><i class="fas fa-mountain me-2"></i> Kelola Puncak</a>
                <a href="logout.php" class="text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
            </nav>

            <main class="col-md-10 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h1>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-success mb-3 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Total Puncak</h5>
                                <p class="card-text fs-2">7</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-primary mb-3 shadow">
                            <div class="card-body">
                                <h5 class="card-title">Kategori Jalur</h5>
                                <p class="card-text fs-2">3</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>