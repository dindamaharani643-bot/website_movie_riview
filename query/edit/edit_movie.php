<?php
session_start();
include __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil ID utama film dan data form, amankan dari SQL Injection
    $id = intval($_POST['id']);
    $judul = mysqli_real_escape_string($con, trim($_POST['judul']));
    $id_film = intval($_POST['id_film']); // Foreign Key ID Genre
    $rating_usia = mysqli_real_escape_string($con, trim($_POST['rating_usia']));
    $rating_film = floatval($_POST['rating_film']);
    $sutradara = mysqli_real_escape_string($con, trim($_POST['sutradara']));
    $aktor = mysqli_real_escape_string($con, trim($_POST['aktor']));
    $sinopsis = mysqli_real_escape_string($con, trim($_POST['sinopsis']));

    // 1. Ambil data nama file gambar cover lama untuk pengecekan berkas fisik
    $query_lama = mysqli_query($con, "SELECT image FROM movie WHERE id = $id");
    $data_lama = mysqli_fetch_assoc($query_lama);
    $nama_gambar_final = $data_lama['image'] ?? 'default_movie.jpg';

    // 2. Cek apakah admin mengunggah file cover gambar baru
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];

        // Batas berkas gambar maksimal 2MB
        if (in_array($ext, $allowed_ext) && $file_size <= 2097152) {
            $nama_gambar_baru = 'movie_' . uniqid() . '.' . $ext;
            $folder_tujuan = "../../file/" . $nama_gambar_baru;

            if (move_uploaded_file($file_tmp, $folder_tujuan)) {
                // Hapus berkas gambar lama dari folder lokal jika bukan berkas default bawaan sistem
                if (!empty($data_lama['image']) && $data_lama['image'] != 'default_movie.jpg') {
                    $path_gambar_lama = "../../file/" . $data_lama['image'];
                    if (file_exists($path_gambar_lama)) {
                        unlink($path_gambar_lama);
                    }
                }
                $nama_gambar_final = $nama_gambar_baru;
            }
        } else {
            echo "<script>alert('Format Cover harus JPG/JPEG/PNG dan ukuran dibawah 2MB!'); window.history.back();</script>";
            exit();
        }
    }

    // 3. Eksekusi Kueri UPDATE data ke tabel movie
    $update_query = "UPDATE movie SET 
                        judul = '$judul',
                        id_film = '$id_film',
                        rating_usia = '$rating_usia',
                        rating_film = '$rating_film',
                        sutradara = '$sutradara',
                        aktor = '$aktor',
                        sinopsis = '$sinopsis',
                        image = '$nama_gambar_final'
                    WHERE id = $id";

    if (mysqli_query($con, $update_query)) {
        echo "<script>
                window.location='../../index.php?halaman=manage_movies';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data film.'); 
                window.history.back();
              </script>";
    }
} else {
    header("Location: ../../index.php");
    exit();
}
?>