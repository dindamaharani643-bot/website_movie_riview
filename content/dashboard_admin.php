<?php
// Pastikan file koneksi database sudah ter-load, jika belum jalankan include
if (!isset($con)) {
    include __DIR__ . '/config/db.php';
}

// ==========================================================================
// 1. QUERY UNTUK KARTU RINGKASAN DATA (STATISTIK COUNTER)
// ==========================================================================

// Total Pengguna (id_role = 2 / User Biasa)
$q_user = mysqli_query($con, "SELECT COUNT(*) AS total FROM user WHERE id_role = 2");
$d_user = mysqli_fetch_assoc($q_user);
$total_user = $d_user['total'] ?? 0;

// Total Koleksi Movie
$q_movie = mysqli_query($con, "SELECT COUNT(*) AS total FROM movie");
$d_movie = mysqli_fetch_assoc($q_movie);
$total_movie = $d_movie['total'] ?? 0;

// Total Ulasan Masuk
$q_rating = mysqli_query($con, "SELECT COUNT(*) AS total FROM rating");
$d_rating = mysqli_fetch_assoc($q_rating);
$total_ulasan = $d_rating['total'] ?? 0;

// Rata-rata Rating Komunitas
$q_avg = mysqli_query($con, "SELECT AVG(skor) AS rata_rata FROM rating");
$d_avg = mysqli_fetch_assoc($q_avg);
$avg_rating = number_format(($d_avg['rata_rata'] ?? 0), 1);


// ==========================================================================
// 2. QUERY UNTUK GRAFIK STATISTIK SIMPEL (CHART.JS)
// ==========================================================================

// A. Grafik Batang: Sebaran Distribusi Skor Ulasan (Bintang 1 sampai 10)
$chart_review_data = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
$q_chart_review = mysqli_query($con, "SELECT skor, COUNT(*) AS jumlah FROM rating GROUP BY skor ORDER BY skor ASC");
while ($row = mysqli_fetch_assoc($q_chart_review)) {
    $s = intval($row['skor']);
    if ($s >= 1 && $s <= 10) {
        $chart_review_data[$s - 1] = intval($row['jumlah']);
    }
}

// B. Grafik Lingkaran: Jumlah Film Berdasarkan ID Genre (id_film)
$genre_labels = [];
$genre_counts = [];
$q_chart_genre = mysqli_query($con, "SELECT id_film, COUNT(*) AS jumlah FROM movie GROUP BY id_film");

// Array bantuan nama genre (Silakan sesuaikan teks nama genre ini jika diperlukan)
$nama_genre_lookup = [
    1 => 'Action',
    2 => 'Horror',
    3 => 'Romance',
    4 => 'Drama',
    5 => 'Romance',
    6 => 'Sci-Fi'
];

while ($row = mysqli_fetch_assoc($q_chart_genre)) {
    $g_id = intval($row['id_film']);
    // Ambil nama genre berdasarkan ID, jika tidak ada tampilkan ID aslinya
    $genre_labels[] = $nama_genre_lookup[$g_id] ?? "Genre ID " . $g_id;
    $genre_counts[] = intval($row['jumlah']);
}


// ==========================================================================
// 3. QUERY UNTUK TABEL PREVIEW 5 ULASAN TERBARU
// ==========================================================================
$q_table = mysqli_query($con, "SELECT r.*, u.nama AS nama_pemberi, m.judul AS judul_film 
                               FROM rating r
                               INNER JOIN user u ON r.id_user = u.id_user
                               INNER JOIN movie m ON r.id = m.id
                               ORDER BY r.id_rating DESC LIMIT 5");
?>

<link rel="stylesheet" href="dist/css/manage_review.css?v=<?= time(); ?>">

<style>
    /* Grid Box Statistik */
    .tb-dashboard-grid-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
        margin-top: 20px;
    }
    .tb-stat-box {
        background-color: #0d0d0d;
        border: 1px solid #262626;
        border-left: 4px solid #7a0010;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease, border-color 0.3s ease;
    }
    .tb-stat-box:hover {
        transform: translateY(-3px);
        border-color: #7a0010;
    }
    .tb-stat-icon-box {
        font-size: 2.2rem;
        color: #7a0010;
        opacity: 0.9;
    }
    .tb-stat-text-box h3 {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 700;
        color: #ffffff;
    }
    .tb-stat-text-box p {
        margin: 4px 0 0 0;
        font-size: 0.78rem;
        color: #888888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* Grid Area Bagan Grafik */
    .tb-dashboard-grid-charts {
        display: grid;
        grid-template-columns: 1.6fr 1fr;
        gap: 25px;
        margin-bottom: 35px;
    }
    @media (max-width: 992px) {
        .tb-dashboard-grid-charts {
            grid-template-columns: 1fr;
        }
    }
    .tb-chart-panel {
        background-color: #0d0d0d;
        border: 1px solid #262626;
        border-radius: 8px;
        padding: 22px;
    }
    .tb-chart-panel-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #ffffff;
        margin-top: 0;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #1f1f1f;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tb-chart-panel-title i {
        color: #7a0010;
        margin-right: 6px;
    }
    .tb-canvas-holder {
        position: relative;
        height: 240px;
        width: 100%;
    }

    /* Elemen Penyelaras Tabel */
    .tb-header-inline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }
    .tb-btn-more {
        background-color: #7a0010;
        color: #ffffff !important;
        text-decoration: none;
        border-radius: 4px;
        padding: 6px 14px;
        font-size: 0.78rem;
        font-weight: 600;
        transition: background-color 0.2s;
    }
    .tb-btn-more:hover {
        background-color: #a00015;
    }
</style>

<div class="tb-table-scope">
    <div class="tb-table-container">

        <h2 class="tb-table-title">
            <i class="fa fa-dashboard"></i> Panel Ringkasan & Performa Aplikasi
        </h2>

        <div class="tb-dashboard-grid-stats">
            <div class="tb-stat-box">
                <div class="tb-stat-icon-box"><i class="fa fa-users"></i></div>
                <div class="tb-stat-text-box">
                    <h3><?= number_format($total_user); ?></h3>
                    <p>Total User</p>
                </div>
            </div>
            <div class="tb-stat-box">
                <div class="tb-stat-icon-box"><i class="fa fa-film"></i></div>
                <div class="tb-stat-text-box">
                    <h3><?= number_format($total_movie); ?></h3>
                    <p>Jumlah Movie</p>
                </div>
            </div>
            <div class="tb-stat-box">
                <div class="tb-stat-icon-box"><i class="fa fa-comments"></i></div>
                <div class="tb-stat-text-box">
                    <h3><?= number_format($total_ulasan); ?></h3>
                    <p>Total Ulasan</p>
                </div>
            </div>
            <div class="tb-stat-box">
                <div class="tb-stat-icon-box"><i class="fa fa-star"></i></div>
                <div class="tb-stat-text-box">
                    <h3><?= $avg_rating; ?></h3>
                    <p>Avg Rating</p>
                </div>
            </div>
        </div>

        <div class="tb-dashboard-grid-charts">
            <div class="tb-chart-panel">
                <h4 class="tb-chart-panel-title"><i class="fa fa-bar-chart"></i> Grafik Sebaran Bintang Ulasan</h4>
                <div class="tb-canvas-holder">
                    <canvas id="barUlasanChart"></canvas>
                </div>
            </div>
            <div class="tb-chart-panel">
                <h4 class="tb-chart-panel-title"><i class="fa fa-pie-chart"></i> Rasio Movie per Genre</h4>
                <div class="tb-canvas-holder">
                    <canvas id="pieGenreChart"></canvas>
                </div>
            </div>
        </div>

        <div class="tb-header-inline">
            <h3 class="tb-table-title" style="margin-bottom: 0; font-size: 1.1rem; border-bottom: none; padding-bottom: 0;">
                <i class="fa fa-clock-o"></i> Preview Singkat Ulasan Terbaru
            </h3>
            <a href="index.php?halaman=manage_reviews" class="tb-btn-more">Kelola Seluruh Data</a>
        </div>

        <div class="tb-table-responsive-wrapper">
            <table class="tb-custom-table">
                <thead>
                    <tr style="text-align: center;">
                        <th class="col-no" style="width: 60px;">No.</th>
                        <th class="col-nama">Nama Pengguna</th>
                        <th class="col-film">Judul Film</th>
                        <th class="col-skor" style="width: 100px;">Skor</th>
                        <th class="col-ulasan">Isi Ulasan & Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($q_table) > 0): 
                        while ($row = mysqli_fetch_assoc($q_table)): 
                    ?>
                        <tr style="text-align: center;">
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="fw-semibold text-white"><?= htmlspecialchars($row['nama_pemberi']); ?></td>
                            <td style="color: #ccccxx;"><?= htmlspecialchars($row['judul_film']); ?></td>
                            <td class="text-center text-warning"><i class="fa fa-star"></i> <?= htmlspecialchars($row['skor']); ?>/10</td>
                            <td class="text-muted text-truncate" style="max-width: 350px;">
                                <?= htmlspecialchars($row['komentar']); ?>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else: 
                    ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada aktivitas ulasan film terbaru saat ini.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi warna teks global Chart agar senada dengan warna abu teks web
    Chart.defaults.color = '#888888';
    Chart.defaults.font.family = 'sans-serif';

    // 1. Inisialisasi Grafik Batang (Jumlah Ulasan)
    const ctxBar = document.getElementById('barUlasanChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['1★', '2★', '3★', '4★', '5★', '6★', '7★', '8★', '9★', '10★'],
            datasets: [{
                label: 'Jumlah Kontribusi Ulasan',
                data: <?= json_encode($chart_review_data); ?>,
                backgroundColor: '#7a0010', // Midnight Maroon utama
                borderColor: '#a00015',
                borderWidth: 1,
                borderRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#1f1f1f' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // 2. Inisialisasi Grafik Lingkaran (Jumlah Movie per Genre)
    const ctxPie = document.getElementById('pieGenreChart').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?= json_encode($genre_labels); ?>,
            datasets: [{
                data: <?= json_encode($genre_counts); ?>,
                backgroundColor: ['#7a0010', '#3a0006', '#1c1c1c', '#a00015', '#444444', '#5c000b'],
                borderColor: '#0d0d0d',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 12,
                        boxWidth: 12,
                        font: { size: 11 }
                    }
                }
            }
        }
    });
</script>