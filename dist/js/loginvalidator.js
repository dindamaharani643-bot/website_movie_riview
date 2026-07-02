document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password'); // Sesuai ID di HTML login
    const btnMasuk = document.getElementById('btnMasuk');

    if (emailInput && passwordInput && btnMasuk) {
        function checkLoginValidity() {
            const emailVal = emailInput.value.trim();
            const passwordVal = passwordInput.value.trim();

            // Tombol AKTIF hanya jika Email dan Password tidak kosong
            if (emailVal !== '' && passwordVal !== '') {
                btnMasuk.removeAttribute('disabled');
            } else {
                btnMasuk.setAttribute('disabled', 'true');
            }
        }

        // Jalankan pengecekan setiap kali user mengetik
        emailInput.addEventListener('input', checkLoginValidity);
        passwordInput.addEventListener('input', checkLoginValidity);
    }
});