<?php

define('host' , 'localhost');
define('user' , 'root');
define('pass' , '');
define('dbase','user_movier');

$con = mysqli_connect(host, user, pass) or die("Koneksi Gagal");
mysqli_select_db($con, dbase) or die("Tidak Bisa Terhubung Ke Database");

?>