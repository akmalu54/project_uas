<?php
session_start();
// 1. Koneksi ke Database
$host = "localhost";
$username = "root";
$password = "";
$db = "db_7summits_sembalun";
$koneksi = new mysqli($host, $username, $password, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// 2. PROSES SIMPAN KOMENTAR (CREATE)
if (isset($_POST['simpan'])) {
    $id_peak = $_POST['id_peak'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_pengirim']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi_komentar']);

    $query_tambah = "INSERT INTO komentar (id_peak, nama_pengirim, isi_komentar) VALUES ('$id_peak', '$nama', '$isi')";
    $koneksi->query($query_tambah);
    header("Location: vkomentar.php"); // Refresh halaman
}

// 3. PROSES HAPUS KOMENTAR (DELETE)
if (isset($_GET['hapus'])) {
    $id_h = $_GET['hapus'];
    $koneksi->query("DELETE FROM komentar WHERE id_komentar = '$id_h'");
    header("Location: vkomentar.php");
}

// 4. AMBIL DATA UNTUK FORM EDIT (Jika tombol edit ditekan)
$edit_data = null;
if (isset($_GET['edit'])) {
    $id_e = $_GET['edit'];
    $res_edit = $koneksi->query("SELECT * FROM komentar WHERE id_komentar = '$id_e'");
    $edit_data = $res_edit->fetch_assoc();
}

// 5. PROSES UPDATE KOMENTAR (UPDATE)
if (isset($_POST['update'])) {
    $id_k = $_POST['id_komentar'];
    $isi_u = mysqli_real_escape_string($koneksi, $_POST['isi_komentar']);
    $koneksi->query("UPDATE komentar SET isi_komentar = '$isi_u' WHERE id_komentar = '$id_k'");
    header("Location: vkomentar.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Diskusi Pendaki - 7 Summits Sembalun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-arrow-left"></i> Kembali ke Home</a>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><?php echo $edit_data ? 'Edit Komentar' : 'Tulis Komentar'; ?></h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <?php if($edit_data): ?>
                            <input type="hidden" name="id_komentar" value="<?php echo $edit_data['id_komentar']; ?>">
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label">Pilih Puncak</label>
                            <select name="id_peak" class="form-select" required <?php echo $edit_data ? 'disabled' : ''; ?>>
                                <?php
                                $peaks = $koneksi->query("SELECT id_peak, nama_puncak FROM summits");
                                while($p = $peaks->fetch_assoc()){
                                    $sel = ($edit_data && $edit_data['id_peak'] == $p['id_peak']) ? 'selected' : '';
                                    echo "<option value='".$p['id_peak']."' $sel>".$p['nama_puncak']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Anda</label>
                            <input type="text" name="nama_pengirim" class="form-control" 
                                value="<?php echo $edit_data ? $edit_data['nama_pengirim'] : ''; ?>" 
                                required <?php echo $edit_data ? 'readonly' : ''; ?>>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi Komentar</label>
                            <textarea name="isi_komentar" class="form-control" rows="4" required><?php echo $edit_data ? $edit_data['isi_komentar'] : ''; ?></textarea>
                        </div>
                        
                        <?php if($edit_data): ?>
                            <button type="submit" name="update" class="btn btn-primary w-100">Update Komentar</button>
                            <a href="vkomentar.php" class="btn btn-secondary w-100 mt-2">Batal</a>
                        <?php else: ?>
                            <button type="submit" name="simpan" class="btn btn-success w-100">Kirim Komentar</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h3 class="mb-4">Diskusi Terbaru</h3>
            <?php
            $sql_tampil = "SELECT k.*, s.nama_puncak FROM komentar k 
                        JOIN summits s ON k.id_peak = s.id_peak 
                        ORDER BY k.tanggal DESC";
            $res = $koneksi->query($sql_tampil);
            
            if ($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    ?>
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="text-success mb-1 fw-bold"><?php echo $row['nama_pengirim']; ?></h6>
                                <small class="text-muted"><?php echo date('d M Y, H:i', strtotime($row['tanggal'])); ?></small>
                            </div>
                            <p class="badge bg-light text-dark mb-2">Gunung: <?php echo $row['nama_puncak']; ?></p>
                            <p class="card-text text-secondary"><?php echo nl2br($row['isi_komentar']); ?></p>
                            <div class="text-end">
                                <a href="?edit=<?php echo $row['id_komentar']; ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i> Edit</a>
                                <a href="?hapus=<?php echo $row['id_komentar']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus komentar ini?')"><i class="fas fa-trash"></i> Hapus</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='alert alert-info'>Belum ada komentar. Jadi yang pertama berkomentar!</div>";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>