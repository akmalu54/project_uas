<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$user_login = $_SESSION['username'];

// Ambil ID Pengguna dari database berdasarkan session username
$res_user = $koneksi->query("SELECT id FROM pengguna WHERE username = '$user_login'");
$u = $res_user->fetch_assoc();
$id_user_login = $u['id'];

// LOGIKA EDIT: Ambil data lama jika ada parameter 'edit' di URL
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_e = $_GET['edit'];
    // Keamanan: Pastikan booking ini milik user yang login
    $cek_milik = $koneksi->query("SELECT * FROM booking WHERE id_booking = '$id_e' AND id_pengguna = '$id_user_login'");
    if ($cek_milik->num_rows > 0) {
        $edit_data = $cek_milik->fetch_assoc();
    } else {
        echo "<script>alert('Akses Ditolak!'); window.location='vbooking.php';</script>";
        exit;
    }
}

// PROSES SIMPAN (Baru atau Update)
if (isset($_POST['proses'])) {
    $id_peak = $_POST['id_peak'];
    $tgl = $_POST['tanggal_mendaki'];
    $jumlah = $_POST['jumlah_personel'];

    if (isset($_POST['id_booking_lama'])) {
        // UPDATE
        $id_b = $_POST['id_booking_lama'];
        $sql = "UPDATE booking SET id_peak='$id_peak', tanggal_mendaki='$tgl', jumlah_personel='$jumlah' 
                WHERE id_booking='$id_b' AND id_pengguna='$id_user_login'";
        $msg = "Booking berhasil diperbarui!";
    } else {
        // INSERT
        $sql = "INSERT INTO booking (id_peak, id_pengguna, tanggal_mendaki, jumlah_personel) 
                VALUES ('$id_peak', '$id_user_login', '$tgl', '$jumlah')";
        $msg = "Booking berhasil dipesan!";
    }

    if ($koneksi->query($sql)) {
        echo "<script>alert('$msg'); window.location='vbooking.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Booking Tiket - 7 Summits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow border-0 mx-auto" style="max-width: 500px; border-radius: 15px;">
            <div class="card-header bg-dark text-white text-center py-3">
                <h5 class="mb-0">🎟️ <?= $edit_data ? 'Edit Booking' : 'Booking Tiket Baru'; ?></h5>
            </div>
            <div class="card-body p-4">
                <p class="text-muted small text-center">Pemesanan atas nama: <strong><?= $user_login; ?></strong></p>
                <form method="POST">
                    <?php if($edit_data): ?>
                        <input type="hidden" name="id_booking_lama" value="<?= $edit_data['id_booking']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih Puncak</label>
                        <select name="id_peak" class="form-select" required>
                            <?php 
                            $peaks = $koneksi->query("SELECT * FROM summits");
                            while($p = $peaks->fetch_assoc()) {
                                $sel = ($edit_data && $edit_data['id_peak'] == $p['id_peak']) ? 'selected' : '';
                                echo "<option value='".$p['id_peak']."' $sel>".$p['nama_puncak']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tanggal Mendaki</label>
                        <input type="date" name="tanggal_mendaki" class="form-control" 
                            value="<?= $edit_data ? $edit_data['tanggal_mendaki'] : ''; ?>" 
                            required min="<?= date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Personel</label>
                        <input type="number" name="jumlah_personel" class="form-control" 
                            value="<?= $edit_data ? $edit_data['jumlah_personel'] : '1'; ?>" 
                            min="1" required>
                    </div>
                    <button type="submit" name="proses" class="btn btn-success w-100 fw-bold">
                        <?= $edit_data ? 'Simpan Perubahan' : 'Pesan Sekarang'; ?>
                    </button>
                    <a href="vbooking.php" class="btn btn-light border w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>