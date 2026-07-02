<?php
// Ambil data genre untuk pilihan dropdown di Form Input
$query_genre = mysqli_query($con, "SELECT * FROM genre ORDER BY genre ASC");
$list_genre = [];
while ($row = mysqli_fetch_assoc($query_genre)) {
    $list_genre[] = $row;
}

// Ambil semua data film gabungan dari tabel `movie` dan `genre`
$query_movie = mysqli_query($con, "SELECT m.*, g.genre FROM movie m JOIN genre g ON m.id_film = g.id_film ORDER BY m.id DESC");
?>

<link rel="stylesheet" href="dist/css/manage_movies.css?v=<?= time(); ?>">

<div class="mv-manage-scope">
    <div class="mv-manage-container">
        <div style="margin-bottom: 25px; font-size: 0.9rem; color: #9e9e9e;">
            <a href="index.php?halaman=dashboard" style="color: #7a0010; text-decoration: none; font-weight: 600;">Home</a>
            <span style="margin: 0 8px; color: #444;">/</span>
            <span style="color: #ffffff;">Kelola Data Film</span>
        </div>

        <div class="mv-manage-header">
            <h2 class="mv-manage-title"><i class="fa fa-film me-2"></i> Kelola Data Film</h2>
            <button class="mv-btn-add" id="openAddModalBtn">
                <i class="fa fa-plus-circle me-2"></i> Tambah Film Baru
            </button>
        </div>

        <div class="mv-table-responsive">
            <table class="mv-table">
                <thead>
                    <tr style="text-align: center;">
                        <th width="4%">No</th>
                        <th width="8%">Cover</th>
                        <th width="10%">Judul Film</th>
                        <th width="10%">Genre</th>
                        <th width="10%">Rating Usia</th>
                        <th width="10%">Rating Film</th>
                        <th width="13%">Sutradara</th>
                        <th width="25%">Aktor</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_rows_displayed = 0; // Inisialisasi penghitung baris
                    
                    if (mysqli_num_rows($query_movie) > 0):
                        while ($movie = mysqli_fetch_assoc($query_movie)):
                            $total_rows_displayed++;
                            ?>
                            <tr style="text-align: center;">
                                <td><span class="text-muted"><?= $no++; ?></span></td>
                                <td>
                                    <img src="file/<?= htmlspecialchars($movie['image']); ?>" alt="Cover" class="mv-table-img">
                                </td>
                                <td><strong class="text-white"><?= htmlspecialchars($movie['judul']); ?></strong></td>
                                <td><span class="mv-table-badge-genre"><?= htmlspecialchars($movie['genre']); ?></span></td>
                                <td><span class="mv-table-badge-usia"><?= htmlspecialchars($movie['rating_usia']); ?></span>
                                </td>
                                <td>
                                    <span class="text-warning"><i
                                            class="fa fa-star me-1"></i><?= htmlspecialchars($movie['rating_film']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($movie['sutradara']); ?></td>
                                <td><span class="mv-text-truncate-aktor"
                                        title="<?= htmlspecialchars($movie['aktor']); ?>"><?= htmlspecialchars($movie['aktor']); ?></span>
                                </td>
                                <td>
                                    <div class="mv-action-buttons">
                                        <button class="btn-custom-edit" data-id="<?= $movie['id']; ?>"
                                            data-judul="<?= htmlspecialchars($movie['judul']); ?>"
                                            data-idfilm="<?= $movie['id_film']; ?>"
                                            data-usia="<?= htmlspecialchars($movie['rating_usia']); ?>"
                                            data-skor="<?= htmlspecialchars($movie['rating_film']); ?>"
                                            data-sutradara="<?= htmlspecialchars($movie['sutradara']); ?>"
                                            data-aktor="<?= htmlspecialchars($movie['aktor']); ?>"
                                            data-sinopsis="<?= htmlspecialchars($movie['sinopsis']); ?>"
                                            onclick="bukaModalEdit(this)">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <a href="query/delete/hapus_movie.php?id=<?= $movie['id']; ?>"
                                            class="btn-custom-delete btn-hapus-kustom">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        endwhile;
                    endif;

                    // Menambahkan baris kosong pelengkap jika data kurang dari 15 baris
                    while ($total_rows_displayed < 15) {
                        $total_rows_displayed++;
                        ?>
                        <tr class="mv-empty-row">
                            <td><span class="text-muted"><?php echo $no++; ?></span></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="mv-modal-overlay" id="addMovieModal">
            <div class="mv-modal-card">
                <div class="mv-modal-header">
                    <h3><i class="fa fa-plus-circle me-2"></i> Form Input Data Film</h3>
                    <span class="mv-modal-close" id="closeAddModalBtn">&times;</span>
                </div>

                <form action="query/input/proses_movie.php" method="POST" enctype="multipart/form-data"
                    class="mv-modal-form">

                    <div class="mv-form-row">
                        <div class="mv-form-group">
                            <label class="mv-form-label">Judul Film</label>
                            <input type="text" name="judul" class="mv-form-input" required
                                placeholder="Contoh: The Batman">
                        </div>
                        <div class="mv-form-group">
                            <label class="mv-form-label">Genre Hubungan</label>
                            <select name="id_film" class="mv-form-input" required>
                                <option value="" disabled selected>-- Pilih Kategori Genre --</option>
                                <?php foreach ($list_genre as $g): ?>
                                    <option value="<?= $g['id_film']; ?>"><?= htmlspecialchars($g['genre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mv-form-row">
                        <div class="mv-form-group">
                            <label class="mv-form-label">Rating Usia</label>
                            <select name="rating_usia" class="mv-form-input" required>
                                <option value="" disabled selected>-- Pilih Batas Usia --</option>
                                <option value="SU">SU (Semua Umur)</option>
                                <option value="R13">R13 (Remaja 13+)</option>
                                <option value="D17">D17 (Dewasa 17+)</option>
                            </select>
                        </div>
                        <div class="mv-form-group">
                            <label class="mv-form-label">Rating Skor Angka (0.0 - 10.0)</label>
                            <input type="number" name="rating_film" class="mv-form-input" min="0" max="10" step="0.1"
                                required placeholder="Contoh: 8.5">
                        </div>
                    </div>

                    <div class="mv-form-row">
                        <div class="mv-form-group">
                            <label class="mv-form-label">Nama Sutradara</label>
                            <input type="text" name="sutradara" class="mv-form-input" required
                                placeholder="Contoh: Christopher Nolan">
                        </div>
                        <div class="mv-form-group">
                            <label class="mv-form-label">Unggah Cover Gambar</label>
                            <input type="file" name="image" class="mv-form-input" required>
                        </div>
                    </div>

                    <div class="mv-form-group-full">
                        <label class="mv-form-label">Daftar Pemeran / Aktor</label>
                        <input type="text" name="aktor" class="mv-form-input" required
                            placeholder="Contoh: Robert Pattinson, Zoe Kravitz (pisahkan dengan koma)">
                    </div>

                    <div class="mv-form-group-full">
                        <label class="mv-form-label">Sinopsis Cerita Film</label>
                        <textarea name="sinopsis" rows="4" class="mv-form-input" required
                            placeholder="Tuliskan jalan cerita film secara singkat dan menarik di sini..."></textarea>
                    </div>

                    <div class="mv-form-actions">
                        <button type="button" class="mv-btn-cancel" id="cancelAddModalBtn">Batal</button>
                        <button type="submit" class="mv-btn-submit">Simpan ke Katalog</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mv-modal-overlay" id="editMovieModal">
            <div class="mv-modal-card">
                <div class="mv-modal-header">
                    <h3><i class="fa fa-edit me-2"></i> Form Edit Data Film</h3>
                    <span class="mv-modal-close" onclick="tutupModalEdit()">&times;</span>
                </div>

                <form action="query/edit/edit_movie.php" method="POST" enctype="multipart/form-data"
                    class="mv-modal-form">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="mv-form-row">
                        <div class="mv-form-group">
                            <label class="mv-form-label">Judul Film</label>
                            <input type="text" name="judul" id="edit_judul" class="mv-form-input" required>
                        </div>
                        <div class="mv-form-group">
                            <label class="mv-form-label">Genre Hubungan</label>
                            <select name="id_film" id="edit_idfilm" class="mv-form-input" required>
                                <?php foreach ($list_genre as $g): ?>
                                    <option value="<?= $g['id_film']; ?>"><?= htmlspecialchars($g['genre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mv-form-row">
                        <div class="mv-form-group">
                            <label class="mv-form-label">Rating Usia</label>
                            <select name="rating_usia" id="edit_usia" class="mv-form-input" required>
                                <option value="SU">SU (Semua Umur)</option>
                                <option value="R13">R13 (Remaja 13+)</option>
                                <option value="D17">D17 (Dewasa 17+)</option>
                            </select>
                        </div>
                        <div class="mv-form-group">
                            <label class="mv-form-label">Rating Skor Angka (0.0 - 10.0)</label>
                            <input type="number" name="rating_film" id="edit_skor" class="mv-form-input" min="0"
                                max="10" step="0.1" required>
                        </div>
                    </div>

                    <div class="mv-form-row">
                        <div class="mv-form-group">
                            <label class="mv-form-label">Nama Sutradara</label>
                            <input type="text" name="sutradara" id="edit_sutradara" class="mv-form-input" required>
                        </div>
                        <div class="mv-form-group">
                            <label class="mv-form-label">Ubah Cover Gambar (Kosongkan jika tidak diganti)</label>
                            <input type="file" name="image" class="mv-form-input">
                        </div>
                    </div>

                    <div class="mv-form-group-full">
                        <label class="mv-form-label">Daftar Pemeran / Aktor</label>
                        <input type="text" name="aktor" id="edit_aktor" class="mv-form-input" required>
                    </div>

                    <div class="mv-form-group-full">
                        <label class="mv-form-label">Sinopsis Cerita Film</label>
                        <textarea name="sinopsis" id="edit_sinopsis" rows="4" class="mv-form-input" required></textarea>
                    </div>

                    <div class="mv-form-actions">
                        <button type="button" class="mv-btn-cancel" onclick="tutupModalEdit()">Batal</button>
                        <button type="submit" class="mv-btn-submit">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi JavaScript untuk membuka Modal Edit dan memetakan datanya secara otomatis
    const modalEdit = document.getElementById('editMovieModal');

    function bukaModalEdit(btn) {
        document.getElementById('edit_id').value = btn.getAttribute('data-id');
        document.getElementById('edit_judul').value = btn.getAttribute('data-judul');
        document.getElementById('edit_idfilm').value = btn.getAttribute('data-idfilm');
        document.getElementById('edit_usia').value = btn.getAttribute('data-usia');
        document.getElementById('edit_skor').value = btn.getAttribute('data-skor');
        document.getElementById('edit_sutradara').value = btn.getAttribute('data-sutradara');
        document.getElementById('edit_aktor').value = btn.getAttribute('data-aktor');
        document.getElementById('edit_sinopsis').value = btn.getAttribute('data-sinopsis');

        modalEdit.classList.add('mv-show');
    }

    function tutupModalEdit() {
        modalEdit.classList.remove('mv-show');
    }

    // Menutup modal jika mengklik area hitam di luar modal card
    window.addEventListener('click', (e) => {
        if (e.target === modalEdit) {
            tutupModalEdit();
        }
    });
</script>

<script>
    // Penanganan Tampilan Modal Popup via Javascript murni
    const modal = document.getElementById('addMovieModal');
    const openBtn = document.getElementById('openAddModalBtn');
    const closeBtn = document.getElementById('closeAddModalBtn');
    const cancelBtn = document.getElementById('cancelAddModalBtn');

    openBtn.addEventListener('click', () => modal.classList.add('mv-show'));
    closeBtn.addEventListener('click', () => modal.classList.remove('mv-show'));
    cancelBtn.addEventListener('click', () => modal.classList.remove('mv-show'));

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('mv-show');
        }
    });
</script>