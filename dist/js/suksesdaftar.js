document.addEventListener("DOMContentLoaded", function() {
    // Ambil parameter dari URL browser
    const urlParams = new URLSearchParams(window.location.search);
    const pesan = urlParams.get('pesan');

    // Jika di URL terdapat parameter pesan=suksesdaftar
    if (pesan === 'suksesdaftar') {
        var modalElement = document.getElementById('modalSuksesDaftar');
        if (modalElement) {
            // Panggil modal Bootstrap secara aman
            var bootstrapModal = window.bootstrap || bootstrap;
            var myModal = new bootstrapModal.Modal(modalElement);
            myModal.show();
            
            // Opsional: Bersihkan parameter di URL agar saat di-refresh pop-up tidak muncul lagi
            if (window.history.replaceState) {
                window.history.replaceState(null, null, 'masuk.php?halaman=daftar');
            }
        }
    }
});