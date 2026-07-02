<?php
// 1. Sertakan file koneksi database kelompokmu
include '../config/db.php'; 

// 2. Tangkap kata kunci dari URL jika ada
$keyword = "";
if (isset($_GET['keyword'])) {
    /* CATATAN: Pastikan nama variabel koneksi di dalam db.php kalian adalah $koneksi. 
       Jika di file db.php kalian menggunakan nama lain (misal: $conn), 
       silakan ganti variabel $koneksi di bawah ini menjadi $conn.
    */
    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
}

// 3. Query SQL untuk mencari data ke tabel movies
$query = "SELECT * FROM movies WHERE judul_film LIKE '%$keyword%' OR genre LIKE '%$keyword%'";
$saring = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian Film</title>
    <link rel="stylesheet" href="../dist/css/navbar.css">
</head>
<body class="bg-dark text-white">

    <div class="container mt-5">
        <h2>Hasil Pencarian untuk: "<?php echo htmlspecialchars($keyword); ?>"</h2>
        <hr class="border-secondary">

        <div class="row">
            <?php 
            // 4. Tampilkan data hasil pencarian
            if (mysqli_num_rows($saring) > 0) {
                while ($movie = mysqli_fetch_assoc($saring)) {
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card bg-secondary text-white h-100">
                            <img src="img/<?php echo $movie['foto']; ?>" class="card-img-top" alt="..."> 
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $movie['judul_film']; ?></h5>
                                <p class="card-text">Genre: <?php echo $movie['genre']; ?></p>
                                <a href="detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-danger btn-sm">Lihat Review</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-12'><p class='alert alert-warning'>Film tidak ditemukan.</p></div>";
            }
            ?>
        </div>
    </div>

</body>