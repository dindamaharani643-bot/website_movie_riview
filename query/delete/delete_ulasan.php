<?php
session_start();
include __DIR__ . '/../../config/db.php';

// Pengecekan keamanan: Pastikan pengguna sudah login sebelum mengeksekusi script
if (empty($_SESSION['username'])) {
    echo "<script>alert('Harap login terlebih dahulu!'); window.location='../../masuk.php?halaman=login';</script>";
    exit;
}

// Validasi parameter id_rating dari URL agar aman dari celah SQL Injection
if (!isset($_GET['id_rating']) || empty($_GET['id_rating'])) {
    echo "<script>alert('ID Ulasan tidak valid!'); window.history.back();</script>";
    exit;
}

$id_rating = intval($_GET['id_rating']);

// 1. Ambil id film terlebih dahulu sebelum data ulasan dihapus dari database
$query_cari_film = mysqli_query($con, "SELECT id FROM rating WHERE id_rating = '$id_rating'");
$data_film = mysqli_fetch_assoc($query_cari_film);

if ($data_film) {
    $id_film = $data_film['id'];

    // 2. Jalankan perintah hapus data ulasan berdasarkan id_rating
    $query_delete = mysqli_query($con, "DELETE FROM rating WHERE id_rating = '$id_rating'");

    if ($query_delete) {
        // 3. Hitung ulang rata-rata skor film setelah ulasan berhasil terhapus
        $query_rata_rata = mysqli_query($con, "SELECT AVG(skor) AS skor_baru FROM rating WHERE id = '$id_film'");
        $data_rata_rata = mysqli_fetch_assoc($query_rata_rata);
        
        // Jika tidak ada ulasan tersisa sama sekali untuk film tersebut, set nilainya menjadi 0
        $skor_baru = ($data_rata_rata['skor_baru'] !== null) ? $data_rata_rata['skor_baru'] : 0;

        // 4. Update kolom rating_film di tabel movie agar tampilan slider/grid di beranda tetap sinkron
        mysqli_query($con, "UPDATE movie SET rating_film = '$skor_baru' WHERE id = '$id_film'");

        // 5. Tampilkan alert sukses dan redirect kembali ke halaman manage_reviews
        header("Location: ../../index.php?halaman=manage_reviews&pesan=sukses_hapus");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus ulasan dari database.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Data ulasan tidak ditemukan atau sudah dihapus sebelumnya!'); window.history.back();</script>";
    exit;
}
?>