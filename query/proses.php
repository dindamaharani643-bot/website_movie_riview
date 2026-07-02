<?php
session_start();
require_once(__DIR__ . '/../config/db.php');

$aksi = $_GET['aksi'] ?? '';

switch ($aksi) {
    // 1. PROSES LOGIN //
    case 'login':
        $email = $_POST['email'] ?? ''; // Ambil email
        $sandi = $_POST['sandi'] ?? '';
        $ingatsaya = $_POST['ingatsaya'] ?? '';

        // Query mencari data berdasarkan email
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($data = mysqli_fetch_assoc($result)) {
            if (password_verify($sandi, $data['sandi'])) {

                // Update status online menggunakan email
                mysqli_query($con, "UPDATE user SET status = 'Y' WHERE email = '$email'");

                session_regenerate_id(true);

                // Set session identitas akun
                $_SESSION['username'] = $data['email']; // Session utama menyimpan email
                $_SESSION['username_id'] = $data['user'];  // Menyimpan potongan username otomatis
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['id_role'] = $data['id_role'];

                if ($ingatsaya == "Y") {
                    setcookie('username', $email, time() + 86400, "/");
                }

                if ($_SESSION['id_role'] == 1) {
                    // Jika Admin (1), arahkan ke dashboard admin
                    header('Location: ../index.php?halaman=dashboard');
                } else {
                    // Jika User biasa (2), arahkan ke beranda index
                    header('Location: ../index.php?halaman=index');
                }
                exit();
            }
        }
        header('Location: ../masuk.php?halaman=login&pesan=gagal');
        exit();
        break;

    // 2. PROSES LOGOUT //
    case 'logout':
        $user_login = $_SESSION['username'] ?? ''; // berisi email

        if (!empty($user_login)) {
            $query_logout = "UPDATE user SET status = 'N' WHERE email = ?";
            $stmt = mysqli_prepare($con, $query_logout);
            mysqli_stmt_bind_param($stmt, "s", $user_login);
            mysqli_stmt_execute($stmt);
        }

        // 🛡️ TAMBAHKAN INI: Hapus cookie 'username' (Remember Me) dari browser
        if (isset($_COOKIE['username'])) {
            setcookie('username', '', time() - 3600, "/");
        }

        // 3. Bersihkan semua data session dari memori server
        $_SESSION = array(); //
        if (ini_get("session.use_cookies")) { //
            $params = session_get_cookie_params(); //
            setcookie( //
                session_name(), //
                '', //
                time() - 42000, //
                $params["path"], //
                $params["domain"], //
                $params["secure"], //
                $params["httponly"] //
            ); //
        } //
        session_destroy(); //

        // 4. Lempar kembali pengguna ke halaman utama/login
        header("location:../landing_page.php"); //
        exit(); //
        break; //

    // 3. PROSES DAFTAR (REGISTER) //
    case 'daftar':
        $email = $_POST['email'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $sandi = $_POST['sandi'] ?? '';
        $konfirmasi_sandi = $_POST['konfirmasi_sandi'] ?? '';
        $id_role = $_POST['id_role'] ?? 2;

        // Validasi Format Email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Gagal! Format email tidak valid.'); window.history.back();</script>";
            exit();
        }

        // Cek Duplikasi Email
        $cek_email = mysqli_query($con, "SELECT email FROM user WHERE email = '$email'");
        if (mysqli_num_rows($cek_email) > 0) {
            echo "<script>alert('Gagal! Alamat email sudah terdaftar.'); window.history.back();</script>";
            exit();
        }

        // --- LOGIKA PEMOTONGAN EMAIL MENJADI USERNAME OTOMATIS ---
        $potong_email = explode('@', $email);
        $username_otomatis = $potong_email[0];

        // Mencegah duplikasi data pada kolom user lama
        $cek_user = mysqli_query($con, "SELECT user FROM user WHERE user = '$username_otomatis'");
        if (mysqli_num_rows($cek_user) > 0) {
            $username_otomatis = $username_otomatis . rand(10, 99);
        }
        // --------------------------------------------------------

        $sandi_hash = password_hash($sandi, PASSWORD_DEFAULT);

        // Menyimpan data ke database (kolom 'user' terisi otomatis, kolom 'email' aman terisi)
        $query = "INSERT INTO user (user, email, nama, sandi, status, id_role) VALUES (?, ?, ?, ?, 'N', ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "ssssi", $username_otomatis, $email, $nama, $sandi_hash, $id_role);
        $eksekusi = mysqli_stmt_execute($stmt);

        if ($eksekusi) {
            // Diubah dari alert() menjadi lempar parameter lewat URL
            header("Location: ../masuk.php?halaman=daftar&pesan=suksesdaftar");
            exit();
        } else {
            echo "Gagal mendaftar: " . mysqli_error($con);
        }
        break;

    // 4. PROSES EDIT // 
    case 'edit':
        // Tangkap data dari form input HTML
        $id_user = $_POST['id_user'] ?? '';
        $user = $_POST['user'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $sandi = $_POST['sandi'] ?? '';
        $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';

        // JIKA ID USER KOSONG, KEMBALIKAN KE TABEL (Mencegah error update kosong)
        if (empty($id_user)) {
            header("location:../index.php?halaman=tabel&pesan=id_tidak_ditemukan");
            exit();
        }

        // 🛡️ PROTEKSI BACKEND: Cek apakah target yang akan diedit adalah Admin (ID Role == 1)
        $cek_admin = mysqli_query($con, "SELECT id_role FROM user WHERE id_user = '$id_user'");
        $data_user = mysqli_fetch_assoc($cek_admin);

        if ($data_user && $data_user['id_role'] == 1) {
            // Jika yang mau diedit ternyata admin, batalkan demi keamanan
            header("location:../index.php?halaman=tabel&pesan=gagal_edit_admin");
            exit();
        }

        // 📝 PROSES UPDATE DATABASE (Untuk User Biasa)
        // Jika password ($sandi) diisi baru oleh admin, lakukan hash ulang
        if (!empty($sandi)) {
            $sandi_hash = password_hash($sandi, PASSWORD_DEFAULT);
            $query_update = "UPDATE user SET user = ?, nama = ?, sandi = ?, jenis_kelamin = ? WHERE id_user = ?";
            $stmt = mysqli_prepare($con, $query_update);
            mysqli_stmt_bind_param($stmt, "ssssi", $user, $nama, $sandi_hash, $jenis_kelamin, $id_user);
        } else {
            // Jika password dikosongkan (artinya password lama tidak ingin diubah)
            $query_update = "UPDATE user SET user = ?, nama = ?, jenis_kelamin = ? WHERE id_user = ?";
            $stmt = mysqli_prepare($con, $query_update);
            mysqli_stmt_bind_param($stmt, "sssi", $user, $nama, $jenis_kelamin, $id_user);
        }

        // Eksekusi statement SQL
        $eksekusi = mysqli_stmt_execute($stmt);

        if ($eksekusi) {
            // Jika berhasil, lempar kembali ke halaman tabel dengan penanda sukses
            header("location:../index.php?halaman=tabel&pesan=sukses_edit");
            exit();
        } else {
            echo "Gagal memperbarui data: " . mysqli_error($con);
        }
        break;

    // Jalankan perintah query UPDATE lama Anda di bawah ini jika target adalah user biasa...

    // 5. PROSES DELETE //
    case 'delete':
        $id_user = $_GET['id_user'] ?? '';

        if ($id_user != '') {
            // PROTEKSI BACKEND: Cek terlebih dahulu apakah user yang mau dihapus adalah Admin
            $cek_admin = mysqli_query($con, "SELECT id_role FROM user WHERE id_user = '$id_user'");
            $data_user = mysqli_fetch_assoc($cek_admin);

            if ($data_user && $data_user['id_role'] == 1) {
                // Jika terdeteksi id_role == 1 (Admin), gagalkan proses penghapusan
                echo "<script>
                        alert('Gagal! Akun Administrator tidak boleh dihapus demi keamanan.');
                        window.location.href='../index.php?halaman=tabel';
                      </script>";
                exit();
            }

            // Jika lolos pengecekan (berarti user biasa), jalankan perintah hapus lama Anda
            $query = mysqli_query($con, "DELETE FROM user WHERE id_user = '$id_user' LIMIT 1");

            if ($query) {
                $cek_sisa_data = mysqli_query($con, "SELECT id_user FROM user");
                $jumlah_sisa = mysqli_num_rows($cek_sisa_data);

                if ($jumlah_sisa == 0) {
                    header("location:../masuk.php?halaman=daftar");
                    exit();
                } else {
                    header("location:../index.php?halaman=tabel");
                    exit();
                }
            } else {
                echo "Gagal menghapus data: " . mysqli_error($con);
            }
        } else {
            header("location:../index.php?halaman=tabel");
            exit();
        }
        break;
}
?>