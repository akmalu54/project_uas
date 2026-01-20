<?php
$host = "localhost"; $username = "root"; $password = ""; $db = "db_7summits_sembalun";
$koneksi = new mysqli($host, $username, $password, $db);

if (isset($_POST['submit'])) {
    $nama = $_POST['nama_puncak'];
    $tinggi = $_POST['ketinggian'];
    $jalur = $_POST['kd_jalur'];

    $sql = "INSERT INTO summits (nama_puncak, ketinggian, kd_jalur) VALUES ('$nama', '$tinggi', '$jalur')";
    
    if ($koneksi->query($sql)) {
        echo "<script>alert('Data Berhasil Ditambah!'); window.location='vsummits.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Puncak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white"><h5>Form Tambah Puncak</h5></div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label>Nama Puncak/Bukit</label>
                                <input type="text" name="nama_puncak" class="form-control" required placeholder="Contoh: Bukit Savana">
                            </div>
                            <div class="mb-3">
                                <label>Ketinggian (MDPL)</label>
                                <input type="text" name="ketinggian" class="form-control" required placeholder="Contoh: 1500 MDPL">
                            </div>
                            <div class="mb-3">
                                <label>Tingkat Kesulitan</label>
                                <select name="kd_jalur" class="form-select" required>
                                    <option value="EASY">Mudah / Pemula</option>
                                    <option value="MOD">Moderate / Menengah</option>
                                    <option value="HARD">Sulit / Ahli</option>
                                    <option value="EXT">Extreme / Profesional</option>
                                </select>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success">Simpan Data</button>
                            <a href="vsummits.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>