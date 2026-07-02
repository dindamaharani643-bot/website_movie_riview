<?php
session_start();

// Hubungkan ke file koneksi database Anda
include __DIR__ . '/../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastikan user sudah login
    if (empty($_SESSION['username'])) {
        header("Location: ../../index.php");
        exit();
    }

    $email_aktif = $_SESSION['username'];

    // Ambil data kiriman form dan amankan dari SQL Injection
    $user = mysqli_real_escape_string($con, trim($_POST['user']));
    $nama = mysqli_real_escape_string($con, trim($_POST['nama']));
    $tgl_lahir = mysqli_real_escape_string($con, trim($_POST['tgl_lahir']));
    $jenis_kelamin = mysqli_real_escape_string($con, trim($_POST['jenis_kelamin'] ?? ''));
    $bio = mysqli_real_escape_string($con, trim($_POST['bio']));
    $sandi = $_POST['sandi']; // Membaca name="sandi" dari form

    // 1. Ambil informasi profile lama
    $query_lama = mysqli_query($con, "SELECT foto_profil, sandi FROM user WHERE email = '$email_aktif'");
    $data_lama = mysqli_fetch_assoc($query_lama);

    // Pastikan inisialisasi di awal
$sql_sandi = ""; 

if (!empty($_POST['sandi'])) {
    $sandi = $_POST['sandi'];
    // Validasi Regex
    if (preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/', $sandi)) {
        $sandi_hash = password_hash($sandi, PASSWORD_DEFAULT);
        // Penting: Awali dengan koma karena akan diletakkan di tengah query
        $sql_sandi = ", sandi = '$sandi_hash'"; 
    } else {
        echo "<script>alert('Password tidak memenuhi syarat!'); window.history.back();</script>";
        exit();
    }
}
    // 3. Proses Validasi & Unggah Foto Profil Baru ke folder file/
    $nama_foto_final = $data_lama['foto_profil'];

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $file_name = $_FILES['foto']['name'];
        $file_size = $_FILES['foto']['size'];
        $file_tmp = $_FILES['foto']['tmp_name'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed_ext) && $file_size <= 2097152) {
            $nama_foto_baru = 'user_' . uniqid() . '.' . $ext;
            $folder_tujuan = "../../file/" . $nama_foto_baru;

            if (move_uploaded_file($file_tmp, $folder_tujuan)) {
                if (!empty($data_lama['foto_profil']) && $data_lama['foto_profil'] != 'default.jpg') {
                    $path_foto_lama = "../../file/" . $data_lama['foto_profil'];
                    if (file_exists($path_foto_lama)) {
                        unlink($path_foto_lama);
                    }
                }
                $nama_foto_final = $nama_foto_baru;
            }
        } else {
            echo "<script>alert('Format foto harus JPG/JPEG/PNG dan ukuran kurang dari 2MB!'); window.history.back();</script>";
            exit();
        }
    }

    // 4. Eksekusi Query Pembaruan ke tabel user (Termasuk jenis_kelamin)
    // 4. Eksekusi Query Pembaruan
// Pastikan $sql_sandi ditambahkan dengan benar
    $update_query = "UPDATE user SET 
                    user = '$user', 
                    nama = '$nama', 
                    tgl_lahir = '$tgl_lahir', 
                    jenis_kelamin = '$jenis_kelamin',
                    bio = '$bio', 
                    foto_profil = '$nama_foto_final' 
                    $sql_sandi 
                WHERE email = '$email_aktif'";

    // Tambahkan ini untuk melihat apakah query berhasil atau tidak
    $query_eksekusi = mysqli_query($con, $update_query);

    if ($query_eksekusi) {
        // Berhasil
        $role_aktif = $_SESSION['id_role'];
        $halaman_tujuan = ($role_aktif == 1) ? "profil_admin" : "profil_user";
        header("Location: ../../index.php?halaman=$halaman_tujuan");
        exit();
    } else {
        // Tampilkan error jika SQL gagal
        echo "Error Database: " . mysqli_error($con);
        exit();
    }
}
?>