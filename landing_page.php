<?php
session_start();
// Menyertakan koneksi database jika Anda ingin mengambil data film asli dari DB
// include __DIR__ . '/config/db.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Movie Review - Kelompok 5</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="dist/css/landing.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="dist/css/style.css">
</head>

<body>

    <div id="site-content">
        <header class="ld-site-header">
            <div class="ld-container ld-header-wrapper">
                <a href="landing_page.php" class="ld-branding">
                    <img src="dist/img/logo.png" alt="Logo" class="ld-logo">
                    <div class="ld-logo-copy">
                        <h1 class="ld-site-title">Movie Review</h1>
                        <small class="ld-site-description">Kelompok 5</small>
                    </div>
                </a>

                <nav class="ld-main-navigation">
                    <button type="button" class="ld-menu-toggle" id="menuToggle">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="ld-menu" id="mainMenu">
                        <li class="ld-menu-item"><a href="#home">Home</a></li>
                        <li class="ld-menu-item"><a href="#preview-content">Pratinjau Film</a></li>
                        <li class="ld-menu-item"><a href="#about">Tentang Proyek</a></li>
                        <li class="ld-menu-item"><a class="ld-btn-login-nav" href="masuk.php?halaman=login">Login</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="ld-hero-section" id="home">
            <div class="ld-container">
                <div class="ld-hero-text">
                    <h2>Cari Ulasan Film Terfavorit Anda di Sini!</h2>
                    <p>Temukan sinopsis mendalam, rating akurat, dan ruang diskusi seru dari film-film populer.</p>
                    <a href="masuk.php?halaman=login" class="ld-btn-primary">Mulai Review Sekarang</a>
                </div>
            </div>
        </section>

        <main class="ld-main-content" id="preview-content" style="padding-bottom: 40px;">
            <div class="ld-container">
                <div class="ld-page-card">
                    
                    <div class="ld-section-header">
                        <h2 class="ld-section-title"><i class="fa fa-eye" style="color: #7a0010; margin-right: 6px;"></i> Sedang Tayang & Populer (Pratinjau)</h2>
                        <p class="ld-section-subtitle">Silakan log in untuk melihat detail ulasan, skor penuh, dan memberikan komentar.</p>
                    </div>

                    <div class="ld-row">
                        <div class="ld-col-3 ld-col-6">
                            <div class="ld-movie-card">
                                <div class="ld-poster-area">
                                    <img src="dist/img/movie4.jpg" alt="Mulan">
                                    <div class="ld-poster-overlay">
                                        <a href="masuk.php?halaman=login" class="ld-btn-lock"><i class="fa fa-lock"></i> Login untuk Detail</a>
                                    </div>
                                </div>
                                <div class="ld-movie-info">
                                    <h3>Mulan</h3>
                                </div>
                            </div>
                        </div>

                        <div class="ld-col-3 ld-col-6">
                            <div class="ld-movie-card">
                                <div class="ld-poster-area">
                                    <img src="dist/img/movie5.jpg" alt="The Avengers">
                                    <div class="ld-poster-overlay">
                                        <a href="masuk.php?halaman=login" class="ld-btn-lock"><i class="fa fa-lock"></i> Login untuk Detail</a>
                                    </div>
                                </div>
                                <div class="ld-movie-info">
                                    <h3>The Avengers</h3>
                                </div>
                            </div>
                        </div>

                        <div class="ld-col-3 ld-col-6">
                            <div class="ld-movie-card">
                                <div class="ld-poster-area">
                                    <img src="dist/img/movie6.jpg" alt="Rec (2007)">
                                    <div class="ld-poster-overlay">
                                        <a href="masuk.php?halaman=login" class="ld-btn-lock"><i class="fa fa-lock"></i> Login untuk Detail</a>
                                    </div>
                                </div>
                                <div class="ld-movie-info">
                                    <h3>Rec (2007)</h3>
                                </div>
                            </div>
                        </div>

                        <div class="ld-col-3 ld-col-6">
                            <div class="ld-movie-card">
                                <div class="ld-poster-area">
                                    <img src="dist/img/movie7.jpg" alt="Ready or Not">
                                    <div class="ld-poster-overlay">
                                        <a href="masuk.php?halaman=login" class="ld-btn-lock"><i class="fa fa-lock"></i> Login untuk Detail</a>
                                    </div>
                                </div>
                                <div class="ld-movie-info">
                                    <h3>Ready or Not</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ld-row" id="about" style="margin-top: 50px; padding-top: 40px; border-top: 1px solid #262626;">
                        <div class="ld-col-4">
                            <figure style="margin: 0;">
                                <img src="dist/img/kel5.jpeg" alt="Kelompok 5" style="width: 100%; border-radius: 8px; border: 1px solid #2a2a2a; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
                            </figure>
                        </div>
                        <div class="ld-col-8">
                            <h2 style="color: #ffffff; margin-top: 0; font-weight: 700; font-size: 24px;">Tentang Web Movie Review</h2>
                            <p style="text-align: justify; line-height: 1.6; color: #cccccc; font-size: 14px;">Web Movie Review Kelompok 5 merupakan platform interaktif yang dikembangkan khusus untuk mengelola katalog, sinopsis, dan nilai ulasan sinematografi secara terstruktur.</p>
                            <p style="text-align: justify; line-height: 1.6; color: #cccccc; font-size: 14px;">Untuk berpartisipasi memberikan rating bintang, menulis opini kritis Anda, atau melihat statistik penilaian grafik interaktif kelompok kami, silakan daftarkan akun baru atau masuk menggunakan kredensial Anda.</p>
                            <a href="masuk.php?halaman=daftar" class="ld-btn-secondary">Buat Akun Baru</a>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <footer class="ld-site-footer">
            <div class="ld-container">
                <div class="ld-row">
                    <div class="ld-col-4 ld-col-6" style="flex: 0 0 16.666%; max-width: 16.666%;">
                        <div class="ld-widget">
                            <h3 class="ld-widget-title">About Us</h3>
                            <p style="text-align: justify;">MovieRate Kelompok 5 adalah platform terpercaya untuk meninjau dan mengeksplorasi film-film terbaru.</p>
                        </div>
                    </div>
                    <div class="ld-col-4 ld-col-6" style="flex: 0 0 16.666%; max-width: 16.666%;">
                        <div class="ld-widget">
                            <h3 class="ld-widget-title">Review</h3>
                            <p style="text-align: justify;">Kami menghadirkan penilaian rating bintang yang jujur, ulasan mendalam, serta statistik visual yang mempermudah Anda memilih tontonan terbaik minggu ini.</p>
                        </div>
                    </div>
                    <div class="ld-col-4 ld-col-6" style="flex: 0 0 16.666%; max-width: 16.666%;">
                        <div class="ld-widget">
                            <h3 class="ld-widget-title">Help Center</h3>
                            <ul class="ld-no-bullet">
                                <li><a href="#">Butuh bantuan?</a></li>
                                <li><a href="#">Hubungi tim</a></li>
                                <li><a href="#">Serta dukung kami</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ld-col-4 ld-col-6" style="flex: 0 0 16.666%; max-width: 16.666%;">
                        <div class="ld-widget">
                            <h3 class="ld-widget-title">Join Us</h3>
                            <ul class="ld-no-bullet">
                                <li><a href="masuk.php?halaman=daftar">Daftar sekarang</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ld-col-4 ld-col-6" style="flex: 0 0 16.666%; max-width: 16.666%;">
                        <div class="ld-widget">
                            <h3 class="ld-widget-title">Social Media</h3>
                            <ul class="ld-no-bullet">
                                <li><a href="#">Facebook</a></li>
                                <li><a href="#">Twitter</a></li>
                                <li><a href="#">Google+</a></li>
                                <li><a href="#">Pinterest</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="ld-col-4 ld-col-6" style="flex: 0 0 16.666%; max-width: 16.666%;">
                        <div class="ld-widget">
                            <h3 class="ld-widget-title">Newsletter</h3>
                            <form action="#" class="ld-subscribe-form">
                                <input type="text" placeholder="Email Address">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="ld-colophon">Copyright 2026 MovieRate Kelompok 5, Designed by Kelompok 5. All rights reserved.</div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Skrip Aktivasi Hamburger Menu Responsif Mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('mainMenu').classList.toggle('ld-open');
        });
    </nav>
</body>

</html>