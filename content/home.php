<?php
// Query Slider: Mengambil 3 film terpopuler berdasarkan rating tertinggi
$query_slider = mysqli_query($con, "SELECT * FROM movie ORDER BY rating_film DESC LIMIT 3");

// Query Grid: Mengambil 8 daftar film terbaru untuk katalog bawah
$query_grid = mysqli_query($con, "SELECT * FROM movie ORDER BY id DESC LIMIT 8");
?>

<link rel="stylesheet" href="dist/css/home.css?v=<?= time(); ?>">

<div class="hm-home-scope">
    <div class="hm-home-container">
        
        <!-- BAGIAN ATAS: SLIDER BANNER -->

        <!-- BAGIAN BAWAH: KATALOG GRID FILM -->
        <h2 class="hm-home-section-title">
            <i class="fa fa-star"></i> Rekomendasi Film Terpopuler
        </h2>

        <div class="hm-movie-grid">
            <?php while ($m = mysqli_fetch_assoc($query_grid)): ?>
            <div class="hm-movie-item-card">
                <div class="hm-movie-poster-box">
                    <a href="index.php?halaman=detail&id=<?= $m['id'] ?>">
                        <img src="file/<?= htmlspecialchars($m['image']) ?>" alt="<?= htmlspecialchars($m['judul']) ?>">
                    </a>
                </div>
                <div class="hm-movie-detail-box">
                    <a href="index.php?halaman=detail&id=<?= $m['id'] ?>" class="hm-movie-title-link">
                        <?= htmlspecialchars($m['judul']) ?>
                    </a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

    </div>
</div>