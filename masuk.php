<?php
include __DIR__ . "/config/db.php";
// Ambil ID dari URL yang dikirim oleh tabel.php
$id = $_GET['id'] ?? '';
$query = mysqli_query($con, "SELECT * FROM user WHERE id_user = '$id'");
$data = mysqli_fetch_array($query);

$halaman = $_GET['halaman'] ?? 'login';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/masuk.css">
    <link rel="stylesheet" href="dist/css/validator.css">
</head>

<body>
    <?php
    switch ($halaman) {
        case 'daftar':
            ?>
            <div class="card login-card">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Daftar</h3>
                    <p class="text-muted small">Silakan Buat Akun Baru</p>
                </div>

                <form action="query/proses.php?aksi=daftar" method="POST" id="formDaftar">
                    <input type="hidden" name="id_role" value="2">

                    <div class="mb-3">
                        <label for="email" class="form-label small">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" required
                            style="background-color: #1f1f1f; color: #fff; border: 1px solid #333;">
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label small">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Lengkap Anda" required
                            style="background-color: #1f1f1f; color: #fff; border: 1px solid #333;">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label small">Password</label>
                        <input type="password" name="sandi" class="form-control" id="password_daftar" placeholder="••••••••"
                            required style="background-color: #1f1f1f; color: #fff; border: 1px solid #333;">

                        <div class="password-requirements" id="passwordBox"
                            style="display: none; background-color: #0b0b0b; border: 1px solid #7a0010; padding: 12px; margin-top: 8px; border-radius: 4px;">
                            <p style="color: #ccc; font-size: 13px; margin-bottom: 6px; font-weight: bold;">Kriteria Password:
                            </p>
                            <ul style="padding-left: 0; margin-bottom: 0; font-size: 12px;">
                                <li id="req-length" class="text-invalid">❌ Minimal 12 Karakter</li>
                                <li id="req-capital" class="text-invalid">❌ Mengandung Huruf Kapital (A-Z)</li>
                                <li id="req-number" class="text-invalid">❌ Mengandung Angka (0-9)</li>
                                <li id="req-symbol" class="text-invalid">❌ Mengandung Simbol (@, #, $, dll)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="konfirmasi_sandi" class="form-label small">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_sandi" class="form-control" id="konfirmasi_sandi"
                            placeholder="••••••••" required
                            style="background-color: #1f1f1f; color: #fff; border: 1px solid #333;">
                        <small id="note-cocok" style="display:none; font-size: 11px; margin-top: 4px;"></small>
                    </div>

                    <button type="submit" id="btnSubmit" class="btn btn-maroon-aktif w-100 fw-semibold" disabled>Daftar
                        Akun</button>
                    <p class="text-center mt-3 small text-white">Sudah punya akun? <a href="masuk.php?halaman=login">Masuk
                            di sini</a></p>
                </form>
            </div>

            <div class="modal fade" id="modalSuksesDaftar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background-color: #151515; border: 2px solid #7a0010; color: #ffffff; border-radius: 8px;">
                        <div class="modal-header" style="border-bottom: 1px solid #222;">
                            <h5 class="modal-title fw-bold" style="color: #2ecc71;">✔ Pendaftaran Berhasil</h5>
                        </div>
                        <div class="modal-body text-center py-4">
                            <p class="mb-2 fs-5 fw-semibold">Akun Anda Telah Terdaftar!</p>
                            <p class="text-muted small mb-0">Silakan klik tombol di bawah untuk beralih ke halaman login.</p>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #222; justify-content: center;">
                            <a href="masuk.php?halaman=login" class="btn btn-maroon-aktif px-5 py-2 w-100 text-decoration-none text-center">Masuk Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            break;

        case 'login':
            ?>
            <div class="card login-card">
                <?php if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal"): ?>
                    <div id="loginAlert" class="alert-floating">
                        <strong>Login Gagal!</strong> Username atau sandi salah.
                    </div>
                <?php endif; ?>
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Login</h3>
                    <p class="text-muted small">Silakan masuk ke akun Anda</p>
                </div>

                <form action="query/proses.php?aksi=login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label small">Alamat Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" required>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label small">Password</label>
                        </div>
                        <input type="password" name="sandi" class="form-control" id="password" placeholder="••••••••" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="ingatsaya" value="Y">
                        <label class="form-check-label small text-white" for="remember">Ingat saya</label>
                    </div>


                    <button type="submit" id="btnMasuk" class="btn btn-maroon-aktif w-100 fw-semibold text-white"
                        disabled>Masuk</button>
                    <p class="text-center mt-3 small text-white">Belum punya akun? <a href="masuk.php?halaman=daftar">Daftar
                            di sini</a></p>

                </form>
            </div>
            <?php
            break;

        case 'edit':
            ?>
            <div class="card login-card">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Update</h3>
                    <p class="text-muted small">Silahkan Edit Profil Anda</p>
                </div>

                <form action="query/proses.php?aksi=edit" method="POST">
                    <input type="hidden" name="id_user" value="<?php echo $data['id_user']; ?>">
                    <div class="mb-3">
                        <label for="nama" class="form-label small">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="user" class="form-label small">Nama Pengguna</label>
                        <input type="text" name="user" class="form-control" id="user" placeholder="nama pengguna" required>
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label small">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control text white bg-dark" id="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="pria">Pria</option>
                            <option value="wanita">Wanita</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label small">Password</label>
                        </div>
                        <input type="password" name="sandi" class="form-control" id="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-semibold text-white">Submit</button>

                </form>
            </div>
            <?php
            break;

        default:
            echo "<div class='container'><h2>Halaman Tidak Ditemukan</h2></div>";
            break;
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/logalert.js"></script>
    <script src="dist/js/validator.js"></script>
    <script src="dist/js/loginvalidator.js"></script>
    <script src="dist/js/suksesdaftar.js"></script>

</body>

</html>