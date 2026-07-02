document.addEventListener("DOMContentLoaded", function () {
    // 1. Menu Navigasi Hamburger untuk Mobile
    const menuToggle = document.getElementById("menuToggle");
    const mainMenu = document.getElementById("mainMenu");

    if (menuToggle && mainMenu) {
        menuToggle.addEventListener("click", function () {
            mainMenu.classList.toggle("open");
        });
    }

    // 2. Alert Pemicu dari SweetAlert2 untuk Pengunjung Anonim
    if (typeof Swal !== "undefined") {
        // Tampilkan popup selamat datang dengan opsi login langsung
        Swal.fire({
            title: 'Selamat Datang di Movie Review!',
            text: 'Anda sedang berada di mode pratinjau tamu. Silakan login untuk menikmati akses ulasan penuh.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-sign-in"></i> Login Sekarang',
            cancelButtonText: 'Lihat Pratinjau Terlebih Dahulu',
            background: '#131a20',
            color: '#fff',
            confirmButtonColor: '#ffaa3c',
            cancelButtonColor: '#303a42'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke file masuk.php dengan parameter halaman login milik sistem Anda
                window.location.href = "masuk.php?halaman=login";
            }
        });
    }
});