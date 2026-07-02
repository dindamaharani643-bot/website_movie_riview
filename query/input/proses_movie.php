<?php
session_start();
include __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data form dan amankan dari serangan SQL Injection
    $judul        = mysqli_real_escape_string($con, trim($_POST['judul']));
    $id_film      = intval($_POST['id_film']); // Foreign Key ID Genre
    $rating_usia  = mysqli_real_escape_string($con, trim($_POST['rating_usia']));
    $rating_film  = floatval($_POST['rating_film']);
    $sutradara    = mysqli_real_escape_string($con, trim($_POST['sutradara']));
    $aktor        = mysqli_real_escape_string($con, trim($_POST['aktor']));
    $sinopsis     = mysqli_real_escape_string($con, trim($_POST['sinopsis']));

    // Nama file cover default jika proses unggah tidak dilakukan
    $nama_gambar_final = 'default_movie.jpg';

    // Proses Pengecekan & Unggah File Cover Gambar Film
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp  = $_FILES['image']['tmp_name'];
        
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];

        // Validasi ekstensi dan batas berkas maksimal 2MB
        if (in_array($ext, $allowed_ext) && $file_size <= 2097152) {
            $nama_gambar_final = 'movie_' . uniqid() . '.' . $ext;
            $folder_tujuan     = "../../file/" . $nama_gambar_final;

            if (!move_uploaded_file($file_tmp, $folder_tujuan)) {
                $nama_gambar_final = 'default_movie.jpg'; // Reset ke default jika gagal pindah folder
            }
        } else {
            echo "<script>alert('Format Cover harus JPG/JPEG/PNG dan ukuran dibawah 2MB!'); window.history.back();</script>";
            exit();
        }
    }

    // Eksekusi kueri penambahan ke tabel movie
    $insert_query = "INSERT INTO movie (image, judul, rating_usia, rating_film, sutradara, aktor, sinopsis, id_film) 
                     VALUES ('$nama_gambar_final', '$judul', '$rating_usia', '$rating_film', '$sutradara', '$aktor', '$sinopsis', '$id_film')";

    if (mysqli_query($con, $insert_query)) {
        header("Location: ../../index.php?halaman=manage_movies");
        exit();
    } else {
        echo "<script>
                alert('Gagal menyimpan data film.'); 
                window.history.back();
              </script>";
    }
} else {
    header("Location: ../../index.php");
    exit();
}
?>