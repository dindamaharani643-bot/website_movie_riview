<?php
// ==========================================================================
// LOGIKIK PEMROSESAN DATA (BACK-END)
// ==========================================================================

// 1. Ambil list genre untuk mengisi komponen filter dropdown
$query_dropdown_genre = mysqli_query($con, "SELECT * FROM genre ORDER BY genre ASC");

// 2. Deteksi filter genre yang dipilih user
$genre_terpilih = isset($_GET['filter_genre']) ? intval($_GET['filter_genre']) : 0;

// 3. Query SQL: Jika memilih genre tertentu, filter berdasarkan foreign key. Jika 0, tampilkan semua.
if ($genre_terpilih > 0) {
	$sql_movie = "SELECT m.*, g.genre 
                  FROM movie m 
                  JOIN genre g ON m.id_film = g.id_film 
                  WHERE m.id_film = $genre_terpilih 
                  ORDER BY m.id DESC";
} else {
	// Diurutkan berdasarkan ID terbaru agar film baru masuk di baris atas seperti layout referensi
	$sql_movie = "SELECT m.*, g.genre 
                  FROM movie m 
                  JOIN genre g ON m.id_film = g.id_film 
                  ORDER BY m.id DESC";
}

$query_movie = mysqli_query($con, $sql_movie);
?>

<!-- Link Stylesheet -->
<link rel="stylesheet" href="dist/css/user_movies.css?v=<?= time(); ?>">
<link rel="stylesheet" href="dist/css/profil.css">

<!-- Wrapper Utama Tema Profil (Midnight Maroon Dekopal) -->
<div class="mv-profile-scope">
	<div class="mv-profile-container">
		<div style="margin-bottom: 25px; font-size: 0.9rem; color: #9e9e9e;">
			<a href="index.php?halaman=index" style="color: #7a0010; text-decoration: none; font-weight: 600;">Home</a>
			<span style="margin: 0 8px; color: #444;">/</span>
			<span style="color: #ffffff;">Movie List</span>
		</div>
		<div class="mv-profile-card">

			<!-- Baris Filter & Judul Konten -->
			<div class="filters-row">
				<div class="filter-left">
					<h2 class="section-title">
						<i class="fa fa-th-large"></i> Katalog Film Kelompok 5
					</h2>
				</div>
				<div class="filter-right">
					<form action="" method="GET" class="themezy-filter-form">
						<input type="hidden" name="halaman"
							value="<?= htmlspecialchars($_GET['halaman'] ?? 'movies'); ?>">

						<i class="fa fa-filter filter-icon"></i>
						<select name="filter_genre" class="themezy-select" onchange="this.form.submit()">
							<option value="0">Semua Kategori (All Genres)</option>
							<?php
							// Reset pointer select genre
							mysqli_data_seek($query_dropdown_genre, 0);
							while ($g = mysqli_fetch_assoc($query_dropdown_genre)):
								?>
								<option value="<?= $g['id_film']; ?>" <?= ($genre_terpilih == $g['id_film']) ? 'selected' : ''; ?>>
									<?= htmlspecialchars($g['genre']); ?>
								</option>
							<?php endwhile; ?>
						</select>
					</form>
				</div>
			</div>

			<!-- Menampilkan Grid Poster Film -->
			<?php if (mysqli_num_rows($query_movie) > 0): ?>
				<div class="movie-poster-container">
					<?php while ($movie = mysqli_fetch_assoc($query_movie)): ?>
						<div class="movie-item">
							<div class="movie-poster">
								<img src="file/<?= htmlspecialchars($movie['image']); ?>"
									alt="<?= htmlspecialchars($movie['judul']); ?>">

								<!-- Overlay Premium (Akan Berwarna Maroon saat Hover) -->
								<div class="movie-poster-overlay">
									<div class="overlay-details">
										<div class="ol-rating">
											<i class="fa fa-star"></i> <?= htmlspecialchars($movie['rating_film']); ?>/10
										</div>
										<div class="ol-info">
											<strong>Sutradara:</strong> <?= htmlspecialchars($movie['sutradara']); ?>
										</div>
										<div class="ol-info text-truncate">
											<strong>Aktor:</strong> <?= htmlspecialchars($movie['aktor']); ?>
										</div>
									</div>
								</div>
							</div>

							<!-- Judul Film -->
							<div class="movie-title">
								<a href="#"><?= htmlspecialchars($movie['judul']); ?></a>
							</div>
						</div>
					<?php endwhile; ?>
				</div>

				<!-- Komponen Navigasi Halaman (Pagination) -->
				<div class="page-navigation">
					<a href="#" class="page-number prev"><i class="fa fa-angle-left"></i></a>
					<span class="page-number current">1</span>
					<a href="#" class="page-number">2</a>
					<a href="#" class="page-number">3</a>
					<a href="#" class="page-number next"><i class="fa fa-angle-right"></i></a>
				</div>

			<?php else: ?>
				<!-- Tampilan Alert Jika Data Kosong -->
				<div class="themezy-empty-alert">
					<i class="fa fa-film"></i>
					<h3>Katalog Belum Tersedia</h3>
					<p>Belum ada film yang diinput oleh admin untuk kategori genre ini.</p>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>