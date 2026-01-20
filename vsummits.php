<?php
// Menggunakan include koneksi agar lebih rapi
include 'koneksi.php'; 

// Jika file koneksi.php belum dibuat, gunakan fallback ini (hapus jika sudah ada koneksi.php)
if (!isset($koneksi)) {
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "db_7summits_sembalun";
    $koneksi = new mysqli($host, $username, $password, $db);
}

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
    <title>Explore 7 Summits Sembalun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #1a1a1a !important; }
        
        /* Card Styling */
        .summit-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
            height: 100%;
        }
        .summit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
            background-color: #e9ecef;
        }
        .difficulty-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.8rem;
            text-transform: uppercase;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .btn-action {
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🏔️ 7 SUMMITS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Home</a>
                <a class="nav-link active" href="vsummits.php">Daftar Puncak</a>
                <a class="nav-link" href="vkomentar.php">Komentar</a>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h2 class="fw-bold mb-0">Destinasi Puncak</h2>
            <p class="text-muted">Jelajahi keindahan 7 puncak legendaris di Sembalun</p>
        </div>
    </div>

    <div class="row g-4">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card summit-card shadow-sm">
                    <?php
                        $color = "secondary";
                        if($row['kd_jalur'] == 'EXT') $color = "danger";
                        elseif($row['kd_jalur'] == 'HARD') $color = "warning text-dark";
                        elseif($row['kd_jalur'] == 'MOD') $color = "info text-dark";
                        elseif($row['kd_jalur'] == 'EASY') $color = "success";
                    ?>
                    <span class="difficulty-badge bg-<?= $color; ?>">
                        <?= $row['tingkat_kesulitan']; ?>
                    </span>

                    <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=500&q=60" class="card-img-top" alt="<?= $row['nama_puncak']; ?>">
                    
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title fw-bold text-dark"><?= $row['nama_puncak']; ?></h4>
                        <div class="d-flex align-items-center mb-3 text-muted">
                            <i class="fas fa-mountain me-2 text-success"></i>
                            <span>Ketinggian: <strong><?= $row['ketinggian']; ?></strong></span>
                        </div>
                        
                        <div class="mt-auto d-grid gap-2">
                            <a href="vkomentar.php?id=<?= $row['id_peak']; ?>" class="btn btn-outline-primary btn-action">
                                <i class="far fa-comments me-2"></i>Lihat Diskusi
                            </a>
                            <a href="detail_puncak.php?id=<?= $row['id_peak']; ?>" class="btn btn-dark btn-action">
                                <i class="fas fa-info-circle me-2"></i>Detail Destinasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>