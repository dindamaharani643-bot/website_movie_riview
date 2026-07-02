<?php
session_start();
include __DIR__ . '/../../config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Cari tahu nama file gambar terlebih dahulu sebelum baris datanya dihapus
    $query_gambar = mysqli_query($con, "SELECT image FROM movie WHERE id = $id");
    $data_gambar  = mysqli_fetch_assoc($query_gambar);

    if ($data_gambar) {
        $nama_file = $data_gambar['image'];
        // Hapus file fisik jika bukan gambar bawaan sistem
        if (!empty($nama_file) && $nama_file != 'default_movie.jpg') {
            $path_file = "../../file/" . $nama_file;
            if (file_exists($path_file)) {
                unlink($path_file);
            }
        }

        // Jalankan kueri penghapusan baris data film
        $delete = mysqli_query($con, "DELETE FROM movie WHERE id = $id");
        if ($delete) {
            header("Location: ../../index.php?halaman=manage_movies");
            exit();
        }
    }
}

echo "<script>alert('Gagal menghapus data.'); window.location='../../index.php?halaman=manage_movies';</script>";
?>