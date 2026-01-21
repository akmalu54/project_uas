<?php
session_start();

// Proteksi Halaman: User harus login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
$user_login = $_SESSION['username'];

// 1. PROSES SIMPAN (CREATE)
if (isset($_POST['kirim'])) {
    $id_peak = $_POST['id_peak'];
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    
    $koneksi->query("INSERT INTO komentar (id_peak, nama_pengirim, isi_komentar) VALUES ('$id_peak', '$user_login', '$isi')");
    header("Location: vkomentar.php");
}

// 2. PROSES HAPUS (DELETE) + Keamanan Ownership
if (isset($_GET['hapus'])) {
    $id_h = $_GET['hapus'];
    
    // Validasi: Cek apakah ID tersebut milik user yang sedang login
    $cek_milik = $koneksi->query("SELECT * FROM komentar WHERE id_komentar = '$id_h' AND nama_pengirim = '$user_login'");
    
    if ($cek_milik->num_rows > 0) {
        $koneksi->query("DELETE FROM komentar WHERE id_komentar = '$id_h'");
        header("Location: vkomentar.php");
    } else {
        echo "<script>alert('Akses Ditolak! Anda tidak bisa menghapus komentar orang lain.'); window.location='vkomentar.php';</script>";
    }
}

// 3. AMBIL DATA UNTUK EDIT (Menampilkan di Form)
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_e = $_GET['edit'];
    
    // Validasi: Cek apakah ID tersebut milik user yang sedang login
    $query_edit = $koneksi->query("SELECT * FROM komentar WHERE id_komentar = '$id_e' AND nama_pengirim = '$user_login'");
    
    if ($query_edit->num_rows > 0) {
        $edit_data = $query_edit->fetch_assoc();
    } else {
        echo "<script>alert('Akses Ditolak! Anda tidak bisa mengedit komentar orang lain.'); window.location='vkomentar.php';</script>";
    }
}

// 4. PROSES UPDATE (UPDATE)
if (isset($_POST['update'])) {
    $id_k = $_POST['id_komentar'];
    $isi_u = mysqli_real_escape_string($koneksi, $_POST['isi']);
    
    // Update hanya jika ID dan Nama Pengirim cocok (Double Security)
    $koneksi->query("UPDATE komentar SET isi_komentar = '$isi_u' WHERE id_komentar = '$id_k' AND nama_pengirim = '$user_login'");
    header("Location: vkomentar.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi - 7 Summits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .navbar { background-color: #1a1a1a !important; }
        .card-form { border-radius: 15px; border: none; }
        .comment-card { border-radius: 12px; border: none; transition: 0.3s; }
        .comment-card:hover { background-color: #ffffff; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .user-avatar { width: 40px; height: 40px; background: #198754; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="vsummits.php"><i class="fas fa-arrow-left me-2"></i> KEMBALI KE DAFTAR PUNCAK</a>
        <span class="navbar-text text-white small">Login sebagai: <strong><?= $user_login; ?></strong></span>
    </div>
</nav>

<div class="container mb-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card card-form p-4 shadow-sm">
                <h5 class="fw-bold mb-3"><?= $edit_data ? '<i class="fas fa-edit text-primary"></i> Edit Komentar' : '<i class="fas fa-pen text-success"></i> Tulis Komentar'; ?></h5>
                <form method="POST">
                    <?php if ($edit_data): ?>
                        <input type="hidden" name="id_komentar" value="<?= $edit_data['id_komentar']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pilih Destinasi</label>
                        <select name="id_peak" class="form-select bg-light" <?= $edit_data ? 'disabled' : ''; ?>>
                            <?php 
                            $res = $koneksi->query("SELECT * FROM summits");
                            while($p = $res->fetch_assoc()){
                                $selected = ($edit_data && $edit_data['id_peak'] == $p['id_peak']) ? 'selected' : '';
                                echo "<option value='".$p['id_peak']."' $selected>".$p['nama_puncak']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Pesan Anda</label>
                        <textarea name="isi" class="form-control bg-light" rows="5" placeholder="Bagikan pengalamanmu..." required><?= $edit_data ? $edit_data['isi_komentar'] : ''; ?></textarea>
                    </div>

                    <?php if ($edit_data): ?>
                        <button name="update" class="btn btn-primary w-100 fw-bold shadow-sm">Simpan Perubahan</button>
                        <a href="vkomentar.php" class="btn btn-light w-100 mt-2 border">Batal</a>
                    <?php else: ?>
                        <button name="kirim" class="btn btn-success w-100 fw-bold shadow-sm">Kirim Komentar</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">Diskusi Pendaki</h5>
                <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill"><?= $user_login; ?> Online</span>
            </div>

            <?php
            $sql_tampil = "SELECT k.*, s.nama_puncak FROM komentar k 
                           JOIN summits s ON k.id_peak = s.id_peak 
                           ORDER BY k.tanggal DESC";
            $data = $koneksi->query($sql_tampil);

            if ($data->num_rows > 0) {
                while($row = $data->fetch_assoc()): ?>
                    <div class="card comment-card p-3 mb-3 shadow-sm">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3"><?= strtoupper(substr($row['nama_pengirim'], 0, 1)); ?></div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark"><?= $row['nama_pengirim']; ?></h6>
                                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> <?= $row['nama_puncak']; ?></small>
                                </div>
                            </div>
                            <small class="text-muted small"><?= date('H:i, d M Y', strtotime($row['tanggal'])); ?></small>
                        </div>
                        
                        <div class="mt-3 text-secondary">
                            <?= nl2br(htmlspecialchars($row['isi_komentar'])); ?>
                        </div>

                        <?php if ($row['nama_pengirim'] == $user_login): ?>
                        <div class="text-end mt-2 pt-2 border-top">
                            <a href="?edit=<?= $row['id_komentar']; ?>" class="btn btn-sm text-primary text-decoration-none">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="?hapus=<?= $row['id_komentar']; ?>" class="btn btn-sm text-danger text-decoration-none" onclick="return confirm('Hapus komentar Anda?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; 
            } else {
                echo "<div class='text-center p-5'><img src='https://cdn-icons-png.flaticon.com/512/742/742751.png' width='100' class='mb-3 opacity-25'><p class='text-muted'>Belum ada komentar di sini.</p></div>";
            } ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>