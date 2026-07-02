<?php
// Menggabungkan tabel rating, user, dan movie agar admin bisa melihat detail ulasan lengkap
$query = "SELECT rating.*, user.nama AS nama_pemberi, movie.judul AS judul_film 
          FROM rating 
          INNER JOIN user ON rating.id_user = user.id_user
          INNER JOIN movie ON rating.id = movie.id
          ORDER BY rating.id_rating DESC";

$tampil = mysqli_query($con, $query);
?>

<link rel="stylesheet" href="dist/css/manage_review.css?v=<?= time(); ?>">

<div class="tb-table-scope">
    <div class="tb-table-container">

        <div class="tb-breadcrumbs">
            <a href="index.php?halaman=index">Home</a>
            <i class="fa fa-angle-right"></i>
            <span>Kelola Ulasan Pengguna</span>
        </div>

        <h2 class="tb-table-title">
            <i class="fa fa-comments"></i> Daftar Ulasan & Rating Film
        </h2>

        <div class="tb-table-responsive-wrapper">
            <table class="tb-custom-table">
                <thead>
                    <tr style="text-align: center;">
                        <th class="col-no">No.</th>
                        <th class="col-nama">Nama Pengguna</th>
                        <th class="col-film">Judul Film</th>
                        <th class="col-skor">Skor</th>
                        <th class="col-ulasan">Ulasan / Komentar</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_rows_displayed = 0;

                    // Menampilkan data ulasan dari database jika ada
                    if ($tampil && mysqli_num_rows($tampil) > 0) {
                        while ($data = mysqli_fetch_array($tampil)) {
                            $total_rows_displayed++;
                            ?>
                            <tr style="text-align: center;">
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td><span
                                        class="tb-text-highlight"><?php echo htmlspecialchars($data['nama_pemberi']); ?></span>
                                </td>
                                <td><span class="tb-text-film"><?php echo htmlspecialchars($data['judul_film']); ?></span></td>
                                <td class="text-center">
                                    <span class="tb-skor-badge">
                                        <i class="fa fa-star text-maroon"></i> <?php echo htmlspecialchars($data['skor']); ?>/10
                                    </span>
                                </td>
                                <td class="tb-comment-cell"><?php echo htmlspecialchars($data['komentar']); ?></td>
                                <td class="text-center">
                                    <div class="tb-action-buttons">
                                        <a href="query/delete/delete_ulasan.php?id_rating=<?php echo $data['id_rating']; ?>"
                                            class="tb-btn-action btn-delete btn-hapus-kustom">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }

                    // Loop tambahan untuk mencetak baris kosong penyeimbang template agar visual tetap konsisten (minimal 10 baris)
                    while ($total_rows_displayed < 10) {
                        $total_rows_displayed++;
                        ?>
                        <tr class="tr-blank-placeholder">
                            <td class="text-center"><?php echo $no++; ?></td>
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

    </div>
</div>