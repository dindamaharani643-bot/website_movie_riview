document.addEventListener('DOMContentLoaded', function() {
    // 1. Logika Tombol Konfirmasi Hapus Kustom
    const tombolHapus = document.querySelectorAll('.btn-hapus-kustom');

    tombolHapus.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah link langsung mengeksekusi ke proses.php
            
            const urlTujuan = this.getAttribute('href'); // Mengambil isi link asli

            // Jalankan SweetAlert2 dengan gaya Midnight Maroon
            Swal.fire({
                title: 'APAKAH ANDA YAKIN?',
                text: "Data yang dihapus tidak dapat dikembalikan lagi!",
                icon: 'warning',
                iconColor: '#7a0010',          /* Warna icon warning jadi merah gelap */
                showCancelButton: true,
                confirmButtonColor: '#7a0010', /* Warna tombol konfirmasi merah gelap */
                cancelButtonColor: '#6c757d',  /* Warna tombol batal abu-abu */
                confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#141414',         /* Background gelap ala Netflix */
                color: '#ffffff',              /* Warna teks putih */
                customClass: {
                    popup: 'border-merah-kustom'
                }
            }).then((result) => {
                // Jika Admin menekan tombol "Ya, Hapus!"
                if (result.isConfirmed) {
                    window.location.href = urlTujuan; // Teruskan ke jalur proses.php
                }
            });
        });
    });
});