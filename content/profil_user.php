<link rel="stylesheet" href="dist/css/profil.css?v=<?= time(); ?>">

<div class="mv-profile-scope">
    <div class="mv-profile-container">
        <div style="margin-bottom: 25px; font-size: 0.9rem; color: #9e9e9e;">
            <a href="index.php?halaman=index" style="color: #7a0010; text-decoration: none; font-weight: 600;">Home</a>
            <span style="margin: 0 8px; color: #444;">/</span>
            <span style="color: #ffffff;">Profil</span>
        </div>
        <div class="mv-profile-row">


            <div class="mv-profile-col-left">
                <div class="mv-profile-card text-center">
                    <div class="mv-avatar-container">
                        <img src="file/<?= $foto_sekarang; ?>" alt="Foto Profil" class="mv-profile-avatar">
                    </div>

                    <h4 class="mv-profile-name"><?= htmlspecialchars($data_profil['nama'] ?? 'Movie Lovers'); ?></h4>
                    <p class="mv-profile-username">@<?= htmlspecialchars($data_profil['user'] ?? 'username'); ?></p>

                    <div class="mv-badge-wrapper">
                        <?php if (isset($data_profil['id_role']) && $data_profil['id_role'] == 1): ?>
                            <span class="mv-badge-role mv-badge-admin"><i class="fa fa-shield"></i> Administrator</span>
                        <?php else: ?>
                            <span class="mv-badge-role mv-badge-user"><i class="fa fa-user"></i> Movie Lovers</span>
                        <?php endif; ?>
                    </div>

                    <div class="mv-bio-box">
                        <span class="mv-bio-label">Bio Singkat</span>
                        <p class="mv-bio-text">
                            "<?= !empty($data_profil['bio']) ? htmlspecialchars($data_profil['bio']) : 'Belum menulis kutipan film favorit.'; ?>"
                        </p>
                    </div>
                </div>
            </div>

            <div class="mv-profile-col-right">
                <div class="mv-profile-card">
                    <h4 class="mv-profile-title">
                        <i class="fa fa-user-edit me-2"></i> Perbarui Pengaturan Profil
                    </h4>

                    <form action="query/edit/edit.php" method="POST" enctype="multipart/form-data"
                        class="mv-profile-form">

                        <div class="mv-form-row">
                            <div class="mv-form-group">
                                <label class="mv-form-label">Username</label>
                                <input type="text" name="user" class="mv-profile-input"
                                    value="<?= htmlspecialchars($data_profil['user'] ?? ''); ?>" required
                                    placeholder="Masukkan username">
                            </div>
                            <div class="mv-form-group">
                                <label class="mv-form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="mv-profile-input"
                                    value="<?= htmlspecialchars($data_profil['nama'] ?? ''); ?>" required
                                    placeholder="Masukkan nama lengkap">
                            </div>
                        </div>

                        <div class="mv-form-row">
                            <div class="mv-form-group">
                                <label class="mv-form-label">Alamat Email (Kunci Akun)</label>
                                <input type="email" class="mv-profile-input-disabled"
                                    value="<?= htmlspecialchars($data_profil['email'] ?? ''); ?>" disabled>
                            </div>
                            <div class="mv-form-group">
                                <label class="mv-form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="mv-profile-input"
                                    value="<?= htmlspecialchars($data_profil['tgl_lahir'] ?? ''); ?>">
                            </div>
                        </div>

                        <div class="mv-form-row">
                            <div class="mv-form-group">
                                <label class="mv-form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="mv-profile-input">
                                    <option value="" disabled <?= empty($data_profil['jenis_kelamin']) ? 'selected' : ''; ?>>-- Pilih Jenis Kelamin --</option>
                                    <option value="pria" <?= (isset($data_profil['jenis_kelamin']) && $data_profil['jenis_kelamin'] == 'pria') ? 'selected' : ''; ?>>Pria</option>
                                    <option value="wanita" <?= (isset($data_profil['jenis_kelamin']) && $data_profil['jenis_kelamin'] == 'wanita') ? 'selected' : ''; ?>>Wanita</option>
                                </select>
                            </div>
                            <div class="mv-form-group">
                                <label class="mv-form-label">Kata Sandi Baru (Kosongkan jika tidak diganti)</label>
                                <div class="mv-password-wrapper">
                                    <input type="password" id="passwordInput" name="sandi" class="mv-profile-input"
                                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{12,}"
                                        title="Password harus mengandung minimal 12 karakter, huruf besar, huruf kecil, angka, dan simbol."
                                        placeholder="••••••••">
                                    <?php if (isset($_SESSION['error_password'])): ?>
                                        <div style="color: red; font-size: 0.8em; margin-top: 5px;">
                                            <?= $_SESSION['error_password']; ?>
                                        </div>
                                        <?php unset($_SESSION['error_password']); // Hapus pesan setelah ditampilkan ?>
                                    <?php endif; ?>
                                    <span id="togglePassword" class="mv-password-eye">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mv-form-group-full">
                            <label class="mv-form-label">Bio Singkat Pengguna</label>
                            <textarea name="bio" rows="3" class="mv-profile-input"
                                placeholder="Tulis kutipan film favorit dirimu..."><?= htmlspecialchars($data_profil['bio'] ?? ''); ?></textarea>
                        </div>

                        <div class="mv-form-group-full">
                            <label class="mv-form-label">Ubah Foto Profil</label>
                            <input type="file" name="foto" class="mv-profile-input">
                            <div class="mv-form-help">Format berkas: JPG, JPEG, PNG. Ukuran maksimal: 2MB.</div>
                        </div>

                        <div class="mv-form-actions">
                            <button type="submit" class="mv-btn-submit">
                                <i class="fa fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Penyamaran password secara interaktif
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#passwordInput');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
<script>
    const passwordInput = document.getElementById('passwordInput');
    const reqList = document.querySelectorAll('#password-requirements p i');
    let hasError = false; // Status untuk mengunci warna merah

    passwordInput.addEventListener('keyup', function () {
        // Jika user mulai mengetik lagi, hapus status error
        hasError = false;
        validatePassword();
    });

    // Fungsi validasi yang dipanggil saat mengetik
    function validatePassword() {
        const val = passwordInput.value;

        // Fungsi untuk memperbarui UI
        const updateUI = (id, condition) => {
            const icon = document.querySelector(`#${id} i`);
            const text = document.getElementById(id);
            if (condition) {
                icon.className = 'fa fa-check';
                icon.style.color = 'green';
                text.style.color = 'green';
            } else {
                // Jika ada error dan belum diset hasError, tetap merah
                icon.className = 'fa fa-times';
                icon.style.color = 'red';
                text.style.color = 'red';
            }
        };

        updateUI('length', val.length >= 12);
        updateUI('upper', /[A-Z]/.test(val));
        updateUI('number', /[0-9]/.test(val));
        updateUI('symbol', /[\W_]/.test(val));
    }

    // Tambahkan event listener saat klik "Simpan"
    document.querySelector('form').addEventListener('submit', function (e) {
        const val = passwordInput.value;
        // Cek jika password tidak kosong tapi tidak memenuhi syarat
        if (val.length > 0 && !/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/.test(val)) {
            e.preventDefault(); // Mencegah submit
            hasError = true;    // Kunci status error
            validatePassword(); // Paksa tampilan jadi merah
            passwordInput.style.borderColor = 'red'; // Outline merah
        }
    });
</script>