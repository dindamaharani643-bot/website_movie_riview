<?php
// Pastikan koneksi database tersedia (asumsi sudah di-include di index.php)
if (!isset($con)) {
    die("Koneksi database tidak ditemukan.");
}

// Ambil daftar semua film untuk dropdown
$query_semua_film = mysqli_query($con, "SELECT id, judul FROM movie ORDER BY judul ASC");
$id_terpilih = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<link rel="stylesheet" href="dist/css/profil.css">

<div class="mv-profile-scope">
    <div class="mv-profile-container">
        <div style="margin-bottom: 25px; font-size: 0.9rem; color: #9e9e9e;">
			<a href="index.php?halaman=index" style="color: #7a0010; text-decoration: none; font-weight: 600;">Home</a>
			<span style="margin: 0 8px; color: #444;">/</span>
			<span style="color: #ffffff;">Ulasan</span>
		</div>
        <div class="mv-profile-scope" style="background: #0a0a0a; border: 1px solid #1f1f1f; padding: 30px; border-radius: 12px; color: #fff;">
            <h2 style="margin-bottom: 25px; border-bottom: 1px solid #333; padding-bottom: 10px;">Beri Ulasan Film</h2>
            
            <form action="query/proses_rating.php" method="POST">
                <div style="margin-bottom: 20px;">
                    <label for="id_film" style="color: #ccc; display: block; margin-bottom: 8px;">Pilih Film:</label>
                    <select name="id_film" id="id_film" class="mv-input-disabled" style="background: #111 !important; color: #fff !important; width: 100%; padding: 10px; border-radius: 8px;" required>
                        <option value="">-- Pilih Film --</option>
                        <?php while ($f = mysqli_fetch_assoc($query_semua_film)): ?>
                            <option value="<?= $f['id'] ?>" <?= ($f['id'] == $id_terpilih) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($f['judul']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="skor" style="color: #ccc; display: block; margin-bottom: 8px;">Skor (1-10):</label>
                    <input type="number" name="skor" id="skor" min="1" max="10" required class="mv-input-disabled" style="background: #111 !important; color: #fff !important; width: 100%; padding: 10px; border-radius: 8px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label for="komentar" style="color: #ccc; display: block; margin-bottom: 8px;">Ulasan Anda:</label>
                    <textarea name="komentar" id="komentar" required class="mv-input-disabled" style="height: 120px; background: #111 !important; color: #fff !important; width: 100%; padding: 10px; border-radius: 8px;"></textarea>
                </div>
                
                <button type="submit" class="mv-btn-submit" style="background: #e50914; color: #fff; border: none; padding: 12px 30px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: background 0.3s;">
                    Kirim Ulasan
                </button>
            </form>
        </div>
    </div>
</div>