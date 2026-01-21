<?php
session_start();
include 'koneksi.php';

$sql = "SELECT s.*, k.tingkat_kesulitan 
        FROM summits s 
        JOIN kategori_jalur k ON s.kd_jalur = k.kd_jalur 
        ORDER BY s.id_peak ASC";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Puncak - 7 Summits Sembalun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #1a1a1a !important; }
        .summit-card {
            border: none; border-radius: 15px; overflow: hidden;
            transition: transform 0.3s ease; background: #fff; height: 100%;
        }
        .summit-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .card-img-top { height: 200px; object-fit: cover; }
        .difficulty-badge {
            position: absolute; top: 15px; right: 15px;
            padding: 5px 12px; border-radius: 20px; font-weight: bold; font-size: 0.75rem;
            color: white; z-index: 2;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🏔️ 7 SUMMITS</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Home</a>
            <a class="nav-link active" href="vsummits.php">Daftar Puncak</a>
            <a class="nav-link" href="vkomentar.php">Komentar</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-6"><h2>Destinasi Puncak</h2></div>
        <?php if(isset($_SESSION['username'])): ?>
        <div class="col-md-6 text-md-end">
            <a href="tbooking.php" class="btn btn-success">+ Booking Ticket</a>
        </div>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4">
                <div class="card summit-card shadow-sm">
                    <?php
                        $color = "secondary";
                        if($row['kd_jalur'] == 'EXT') $color = "danger";
                        elseif($row['kd_jalur'] == 'HARD') $color = "warning text-dark";
                        elseif($row['kd_jalur'] == 'MOD') $color = "info text-dark";
                        elseif($row['kd_jalur'] == 'EASY') $color = "success";

                        // Logika Gambar Otomatis
                        $nama = strtolower($row['nama_puncak']);
                        $img = "pemandangan.jpg"; // default
                        if (strpos($nama, 'rinjani') !== false) $img = 'rinjani.jpg';
                        elseif (strpos($nama, 'pergasingan') !== false) $img = 'pergasingan.jpg';
                        elseif (strpos($nama, 'dara') !== false) $img = 'anak dara.jpg';
                        elseif (strpos($nama, 'nanggi') !== false) $img = 'nanggi.jpg';
                        elseif (strpos($nama, 'gedong') !== false) $img = 'gedong.jpg';
                        elseif (strpos($nama, 'kondo') !== false) $img = 'kondo.jpg';
                        elseif (strpos($nama, 'sempana') !== false) $img = 'sempana.jpg';
                    ?>
                    <span class="difficulty-badge bg-<?= $color; ?>"><?= $row['tingkat_kesulitan']; ?></span>
                    <img src="img/<?= $img; ?>" class="card-img-top">
                    
                    <div class="card-body">
                        <h4 class="fw-bold"><?= $row['nama_puncak']; ?></h4>
                        <p class="text-muted"><i class="fas fa-mountain"></i> <?= $row['ketinggian']; ?></p>
                        
                        <div class="d-grid gap-2">
                            <?php if(isset($_SESSION['username'])): ?>
                                <a href="vkomentar.php?id=<?= $row['id_peak']; ?>" class="btn btn-primary">Buka Komentar</a>
                            <?php else: ?>
                                <a href="login.php" class="btn btn-outline-secondary">Login untuk Komentar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>