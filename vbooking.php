<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$user_login = $_SESSION['username'];

// PROSES HAPUS
if (isset($_GET['hapus'])) {
    $id_h = $_GET['hapus'];
    // Keamanan: Pastikan hanya bisa menghapus milik sendiri
    $cek = $koneksi->query("SELECT b.* FROM booking b 
                            JOIN pengguna p ON b.id_pengguna = p.id 
                            WHERE b.id_booking = '$id_h' AND p.username = '$user_login'");
    
    if ($cek->num_rows > 0) {
        $koneksi->query("DELETE FROM booking WHERE id_booking = '$id_h'");
        header("Location: vbooking.php");
    } else {
        echo "<script>alert('Akses Ditolak!'); window.location='vbooking.php';</script>";
    }
}

// AMBIL DATA: Hanya data milik user yang sedang login
$sql = "SELECT b.*, s.nama_puncak, p.username 
        FROM booking b 
        JOIN summits s ON b.id_peak = s.id_peak 
        JOIN pengguna p ON b.id_pengguna = p.id
        WHERE p.username = '$user_login'
        ORDER BY b.id_booking DESC";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Booking - 7 Summits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4 text-white">
        <div class="container">
            <span class="navbar-brand">Riwayat Tiket: <strong><?= $user_login; ?></strong></span>
            <a href="vsummits.php" class="btn btn-outline-light btn-sm">Kembali ke Home</a>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">📋 Daftar Pesanan Tiket</h3>
            <a href="tbooking.php" class="btn btn-primary">+ Booking Baru</a>
        </div>

        <div class="card border-0 shadow-sm p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID Tiket</th>
                            <th>Nama Pemesan</th>
                            <th>Destinasi Puncak</th>
                            <th>Tanggal Mendaki</th>
                            <th>Personel</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold text-muted">#BTK-<?= $row['id_booking']; ?></td>
                                <td><?= $row['username']; ?></td>
                                <td><?= $row['nama_puncak']; ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal_mendaki'])); ?></td>
                                <td><?= $row['jumlah_personel']; ?> Orang</td>
                                <td>
                                    <span class="badge bg-<?= $row['status_bayar'] == 'Lunas' ? 'success' : 'warning'; ?>">
                                        <?= $row['status_bayar']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="tbooking.php?edit=<?= $row['id_booking']; ?>" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="?hapus=<?= $row['id_booking']; ?>" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Batalkan pesanan ini?')">
                                        <i class="fas fa-trash"></i> Batal
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Anda belum memiliki pesanan tiket.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>