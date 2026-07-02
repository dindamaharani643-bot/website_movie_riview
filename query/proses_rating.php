<?php
session_start();
include __DIR__ . '/../config/db.php';

// 1. Sesuaikan pengecekan login dengan index.php
if (empty($_SESSION['username'])) {
    // Arahkan ke masuk.php sesuai dengan struktur aplikasi kamu
    echo "<script>alert('Harap login terlebih dahulu!'); window.location='../masuk.php?halaman=login';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_film = intval($_POST['id_film']);
    $skor = intval($_POST['skor']);
    $komentar = mysqli_real_escape_string($con, $_POST['komentar']);
    
    // 2. Ambil email aktif dari session (karena session 'username' isinya email)
    $email_aktif = $_SESSION['username']; 
    
    // 3. Cari id_user di database berdasarkan email tersebut
    $query_user = mysqli_query($con, "SELECT id_user FROM user WHERE email = '$email_aktif'");
    $data_user = mysqli_fetch_assoc($query_user);
    
    // Pastikan data user ditemukan
    if ($data_user) {
        $id_user = $data_user['id_user'];

        // Cek apakah user sudah pernah beri rating pada film ini
        $cek = mysqli_query($con, "SELECT id_rating FROM rating WHERE id = '$id_film' AND id_user = '$id_user'");
        
        if (mysqli_num_rows($cek) > 0) {
            $sql = "UPDATE rating SET skor='$skor', komentar='$komentar' WHERE id='$id_film' AND id_user='$id_user'";
        } else {
            $sql = "INSERT INTO rating (id, id_user, skor, komentar) VALUES ('$id_film', '$id_user', '$skor', '$komentar')";
        }

        if (mysqli_query($con, $sql)) {
            // Update rata-rata rating di tabel movie
            mysqli_query($con, "UPDATE movie SET rating_film = (SELECT AVG(skor) FROM rating WHERE id = '$id_film') WHERE id = '$id_film'");
            
            // Redirect kembali ke index.php halaman rating atau detail film
            header("Location: ../index.php?halaman=rating");
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan ulasan.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Data pengguna tidak ditemukan!'); window.location='../masuk.php?halaman=login';</script>";
    }
}
?>