<?php
session_start();

// 1. PINDAHKAN KE ATAS: Load koneksi database terlebih dahulu
include __DIR__ . '/config/db.php';

// 2. PERBAIKAN AMAN: Validasi Cookie ke Database (Bukan langsung dipercaya)
if (empty($_SESSION['username']) && !empty($_COOKIE['username'])) {
	$cookie_email = $_COOKIE['username'];

	// Cek apakah email di cookie benar-benar terdaftar di database
	$stmt_cookie = mysqli_prepare($con, "SELECT email, nama, id_role, user FROM user WHERE email = ?");
	mysqli_stmt_bind_param($stmt_cookie, "s", $cookie_email);
	mysqli_stmt_execute($stmt_cookie);
	$res_cookie = mysqli_stmt_get_result($stmt_cookie);

	if ($data_c = mysqli_fetch_assoc($res_cookie)) {
		// Jika VALID, daftarkan session resmi beserta rolenya
		$_SESSION['username'] = $data_c['email'];
		$_SESSION['username_id'] = $data_c['user'];
		$_SESSION['nama'] = $data_c['nama'];
		$_SESSION['id_role'] = $data_c['id_role'];
	} else {
		// Jika PALSU/TIDAK ADA, hapus cookie yang menempel di browser
		setcookie('username', '', time() - 3600, "/");
	}
}

$halaman = $_GET['halaman'] ?? 'index';
$semua_review = ['movies', 'manage_movies'];

// Mengambil ID Role untuk pembatasan hak akses halaman
$role = $_SESSION['id_role'] ?? null;

// Menentukan status login user
$belum_login = empty($_SESSION['username']);
$email_aktif = $_SESSION['username'] ?? '';

// 3. PERBAIKAN AMAN: Ambil data profil menggunakan Prepared Statement (Bebas SQL Injection)
$data_profil = null;
if (!empty($email_aktif)) {
	$stmt_profil = mysqli_prepare($con, "SELECT * FROM user WHERE email = ?");
	mysqli_stmt_bind_param($stmt_profil, "s", $email_aktif);
	mysqli_stmt_execute($stmt_profil);
	$result_profil = mysqli_stmt_get_result($stmt_profil);
	$data_profil = mysqli_fetch_assoc($result_profil);
}

// Fungsi mengecek keaslian file foto profil fisik di server
function getFotoProfil($nama_file)
{
	$path = __DIR__ . '/file/' . $nama_file;
	if (!empty($nama_file) && file_exists($path)) {
		return $nama_file;
	} else {
		return 'default.png';
	}
}

$foto_sekarang = getFotoProfil($data_profil['foto_profil'] ?? '');
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">

	<title>Movie Review</title>

	<!-- Loading third party fonts -->
	<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
	<link href="dist/fonts/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


	<!-- Loading main css file -->
	<link rel="stylesheet" href="dist/css/style.css">
	<link rel="stylesheet" href="dist/css/popup.css">
	<link rel="stylesheet" href="dist/css/dashboard.css">
	<link rel="stylesheet" href="dist/css/navbar.css">
	< <!--[if lt IE 9]>
		<script src="TugasWEBPHP/dist/js/ie-support/html5.js"></script>
		<script src="TugasWEBPHP/dist/js/ie-support/respond.js"></script>
		<![endif]-->

</head>


<body>
<?php
$halaman_admin = ['dashboard', 'tabel', 'manage_reviews', 'manage_movies', 'profil_admin'];

if (in_array($halaman, $halaman_admin) && $role != 1) {
	?>
					<div class="netflix-overlay">
						<div class="netflix-box">
							<div class="netflix-icon">
								<i class="fa fa-ban"></i>
							</div>
							<h2>Akses Ditolak</h2>
							<p>Halaman ini hanya dapat diakses oleh Administrator.</p>
							<button onclick="window.location.href='index.php?halaman=index';" class="netflix-btn">Kembali</button>
						</div>
					</div>
					<?php
					exit();
}
?>

	<?php
	if (@$_GET['notif'] == 'sukses') {
		echo "
    <script>
        alert('Data berhasil diproses!'); window.location = 'index.php?halaman=tabel';
    </script>";
	}
	?>
	<?php if ($belum_login): ?>
									<div class="netflix-overlay">
										<div class="netflix-box">
											<div class="netflix-icon">
												<i class="fa fa-exclamation-triangle"></i>
											</div>
											<h2>Akses Terbatas</h2>
											<p>Ulasan film eksklusif Kelompok 5 hanya dapat diakses oleh anggota terdaftar. Silakan masuk ke akun Anda
												terlebih dahulu.</p>

											<button onclick="window.location.href='masuk.php?halaman=login';" class="netflix-btn">Login
												Sekarang</button>
										</div>
									</div>
									<?php
									// Sisa kode HTML index.php ke bawah tidak akan pernah dibaca/dimuat jika user belum login
									exit();
	endif;
	?>

	<div id="site-content">
		<header class="site-header">
			<div class="container">
				<a href="index.php" id="branding">
					<img src="dist/img/logo.png" alt="" class="logo">
					<div class="logo-copy">
						<h1 class="site-title">Movie Review</h1>
						<small class="site-description">Kelompok 5</small>
					</div>
				</a> <!-- #branding -->

				<?php
				// Memisahkan tampilan menu navbar hanya untuk user yang SUDAH LOGIN
				switch ($role) {
					case 1: // ==================== MENU NAVBAR ADMIN ====================
						?>
						<div class="navigasi-movie">
							<button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
							<ul class="menu" style="text-align: center;">
								<li class="menu-item <?= ($halaman == 'dashboard') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=dashboard">Dashboard</a>
								</li>

								<li class="menu-item <?= ($halaman == 'profil_admin') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=profil_admin">Profil</a>
								</li>

								<li class="menu-item <?= in_array($halaman, $semua_review) ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=manage_movies">Movies</a>
								</li>

								<li class="menu-item <?= ($halaman == 'tabel') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=tabel">Users</a>
								</li>

								<li class="menu-item <?= ($halaman == 'manage_reviews') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=manage_reviews">Reviews</a>
								</li>

								<li class="menu-item">
									<a href="query/proses.php?aksi=logout" class="nav-logout-btn">Logout</a>
								</li>
							</ul>

							<form action="query/search.php" method="GET" class="search-form">
								<input type="text" name="keyword" placeholder="Search movie...">
								<button type="submit"><i class="fa fa-search"></i></button>
							</form>
						</div>
						<?php
						break;

					case 2: // ==================== MENU NAVBAR USER BIASA ====================
						?>
						<div class="navigasi-movie">
							<button type="button" class="menu-toggle"><i class="fa fa-bars"></i></button>
							<ul class="menu" style="text-align: center;">
								<li class="menu-item <?= ($halaman == 'index') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=index">Home</a>
								</li>

								<li class="menu-item <?= ($halaman == 'about') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=about">About</a>
								</li>

								<li class="menu-item <?= in_array($halaman, $semua_review) ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=movies">Movies</a>
								</li>

								<li class="menu-item <?= ($halaman == 'profil_user') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=profil_user">Profil</a>
								</li>

								<li class="menu-item <?= ($halaman == 'rating') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=rating">Rating</a>
								</li>

								<li class="menu-item <?= ($halaman == 'contact') ? 'current-menu-item' : '' ?>">
									<a href="index.php?halaman=contact">Contact</a>
								</li>

								<li class="menu-item">
									<a href="query/proses.php?aksi=logout" class="nav-logout-btn">Logout</a>
								</li>
							</ul>

							<form action="query/search.php" method="GET" class="search-form">
								<input type="text" name="keyword" placeholder="Search movie...">
								<button type="submit"><i class="fa fa-search"></i></button>
							</form>
						</div>
						<?php
						break;

					default:
						echo "<div class='alert alert-danger'>Role tidak valid.</div>";
						break;
				}
				?>

				<div class="mobile-navigation"></div>
			</div>
		</header>
		<main class="main-content">
			<?php
			switch ($halaman) {
				case 'index':
					?>
																		<?php include __DIR__ . '/content/home.php'; ?>	
																			<?php
																			break;

				case 'about':
					?>
																			<?php include __DIR__ . '/content/about.php'; ?>	

																			<?php
																			break;

				case 'movies':
					?>
																			<?php include __DIR__ . '/content/movies.php'; ?>
																			<?php
																			break;

				case 'profil_user':
					?>
																			<?php include __DIR__ . '/content/profil_user.php'; ?>
																			<?php
																			break;

				case 'rating':
					?>
																			<?php include __DIR__ . '/content/rating.php'; ?>
																			<?php
																			break;

				case 'contact':
					?>
																			<?php include __DIR__ . '/content/contact.php'; ?>
																				<?php
																				break;

				case 'dashboard':
					?>
																				<?php include __DIR__ . '/content/dashboard_admin.php'; ?>
																				<?php
																				break;

				case 'profil_admin':
					?>
																				<?php include __DIR__ . '/content/profil_admin.php'; ?>
																				<?php
																				break;

				case 'manage_movies':
					?>
																				<?php include __DIR__ . '/content/manage_movies.php'; ?>
																				<?php
																				break;

				case 'tabel':
					?>
																				<?php include __DIR__ . '/content/tabel.php'; ?>

																				<?php
																				break;

				case 'manage_reviews':
					?>
																				<?php include __DIR__ . '/content/manage_reviews.php'; ?>
																				<?php
																				break;

				default:
					echo "<div class='container'><h2>Halaman Tidak Ditemukan</h2></div>";
					break;
			}
			?>
		</main>

		<footer class="site-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-2">
						<div class="widget">
							<h3 class="widget-title">About Us</h3>
							<p style="text-align: justify;">MovieRate Kelompok 5 adalah platform terpercaya untuk
								meninjau dan mengeksplorasi
								film-film terbaru.</p>
						</div>
					</div>
					<div class="col-md-2">
						<div class="widget">
							<h3 class="widget-title">Recent Review</h3>
							<ul class="no-bullet">
								<li><a href="index.php?halaman=web5">Avengers (2012)</a></li>
								<li><a href="index.php?halaman=web7">Ready Or Not</a></li>
								<li><a href="index.php?halaman=web3">World War Z</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="widget">
							<h3 class="widget-title">Help Center</h3>
							<ul class="no-bullet">
								<li><a href="#">Butuh bantuan?</a></li>
								<li><a href="#">Hubungin tim</a></li>
								<li><a href="#">Serta dukung kami</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="widget">
							<h3 class="widget-title">Join Us</h3>
							<ul class="no-bullet">
								<li><a href="#">Daftar sekarang</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="widget">
							<h3 class="widget-title">Social Media</h3>
							<ul class="no-bullet">
								<li><a href="#">Facebook</a></li>
								<li><a href="#">Twitter</a></li>
								<li><a href="#">Google+</a></li>
								<li><a href="#">Pinterest</a></li>
							</ul>
						</div>
					</div>
					<div class="col-md-2">
						<div class="widget">
							<h3 class="widget-title">Newsletter</h3>
							<form action="#" class="subscribe-form">
								<input type="text" placeholder="Email Address">
							</form>
						</div>
					</div>
				</div> <!-- .row -->

				<div class="colophon">Copyright 2026 MovieRate Kelompok 5, Designed by Kelompok 5. All rights reserved
				</div>
			</div> <!-- .container -->

		</footer>
	</div>
	<!-- Default snippet for navigation -->


	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="dist/js/sweetalert.js?v=<?php echo time(); ?>"></script>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="dist/js/dashboard.js"></script>

	<script src="dist/js/jquery-1.11.1.min.js"></script>
	<script src="dist/js/plugins.js"></script>
	<script src="dist/js/app.js"></script>
</body>

</html>