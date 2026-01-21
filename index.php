<?php
// Memulai session di bagian paling atas
session_start();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>7 Summits Sembalun - Gerbang Petualangan Rinjani</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .header {
            height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('img/pemandangan.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }

        .header-content h1 {
            font-size: 3.5rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .text-justify {
            text-align: justify;
        }

        .navbar {
            background-color: rgba(33, 37, 41, 0.9) !important;
        }

        /* Styling tambahan untuk dropdown user */
        .nav-link.user-name {
            color: #ffc107 !important; /* Warna kuning agar menonjol */
            font-weight: bold;
        }

        /* Hover effect pada nav-link */
        .nav-link:hover {
            color: #27ae60 !important;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="img/logo.jpg" alt="Logo" class="me-3" style="width: 40px;" />
                <span class="fs-4 fw-bold">7 Summits Sembalun</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vsummits.php">Daftar Puncak</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vkomentar.php">
                            <i class="fas fa-comments"></i> Komentar
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="vbooking.php">
                            <i class="fas fa-ticket-alt"></i> Booking Tiket
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-name" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle"></i> Halo, <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="vbooking.php"><i class="fas fa-history me-2"></i>Riwayat Booking</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link border border-warning rounded px-3 ms-lg-2" href="login.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <header id="home" class="header">
        <div class="container">
            <div class="header-content">
                <h1 class="fw-bold mb-3 text-uppercase">Selamat Datang di 7 Summits Sembalun</h1>
                <p class="lead fs-4">Taklukkan Puncak Tertinggi dan Nikmati Keindahan Alam Rinjani</p>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="vsummits.php" class="btn btn-success btn-lg px-5 py-3 shadow">Mulai Petualangan</a>
                    <a href="tbooking.php" class="btn btn-warning btn-lg px-5 py-3 shadow fw-bold">Pesan Tiket</a>
                </div>
            </div>
        </div>
    </header>

    <section id="about" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h2 class="display-5 fw-bold mb-4 border-bottom pb-2">Tentang Kami</h2>
                    <div class="text-justify fs-5 text-muted">
                        <p>
                            <strong>7 Summits Sembalun</strong> merupakan tantangan pendakian tujuh puncak bukit dan gunung yang mengelilingi Lembah Sembalun, Lombok Timur. Terinspirasi dari semangat petualangan, tempat ini menjadi wadah bagi para pendaki untuk mengeksplorasi keindahan geografis Sembalun yang unik.
                        </p>
                        <p>
                            Ketujuh puncak tersebut meliputi <b>Gunung Rinjani</b> sebagai ikon utama, disusul oleh deretan bukit eksotis seperti Bukit Sempana, Bukit Nanggi, Bukit Lembah Gedong, Bukit Kondok, Bukit Anak Dara, dan Bukit Pergasingan.
                        </p>
                        <div class="mt-4">
                            <a href="vkomentar.php" class="btn btn-outline-dark me-2">
                                <i class="fas fa-comment-dots"></i> Lihat Apa Kata Pendaki
                            </a>
                            <a href="tbooking.php" class="btn btn-outline-success">
                                <i class="fas fa-calendar-check"></i> Booking Pendakian
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 text-center mt-4 mt-md-0">
                    <img src="img/pemandangan.jpg" alt="Pemandangan Puncak" 
                        class="img-fluid rounded shadow-lg" style="width: 100%; max-height: 450px; object-fit: cover;" />
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-5">
        <div class="container">
            <img src="img/logo.jpg" alt="Logo" class="mb-3 rounded-circle" style="width: 60px;" />
            <h5 class="mb-3">7 Summits Sembalun</h5>
            <p class="mb-4">Ikuti perjalanan kami melalui media sosial:</p>
            <div class="mb-4">
                <a href="#" class="text-white mx-3"><i class="fab fa-instagram fa-2x"></i></a>
                <a href="#" class="text-white mx-3"><i class="fab fa-facebook fa-2x"></i></a>
                <a href="#" class="text-white mx-3"><i class="fab fa-youtube fa-2x"></i></a>
            </div>
            <hr class="bg-secondary">
            <p class="mb-0 opacity-75">
                © 2026 7 Summits Sembalun. Adventure Starts Here.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>