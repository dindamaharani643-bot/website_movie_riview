document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password_daftar');
    const confirmInput = document.getElementById('konfirmasi_sandi');
    const btnSubmit = document.getElementById('btnSubmit');
    const passwordBox = document.getElementById('passwordBox');

    if (passwordInput && confirmInput) {
        const reqLength = document.getElementById('req-length');
        const reqCapital = document.getElementById('req-capital');
        const reqNumber = document.getElementById('req-number');
        const reqSymbol = document.getElementById('req-symbol');
        const noteCocok = document.getElementById('note-cocok');

        function validatePassword() {
            const val = passwordInput.value;

            // Jika kosong, sembunyikan box kriteria
            if (val.length === 0) {
                passwordBox.style.display = 'none';
                btnSubmit.setAttribute('disabled', 'true');
                return;
            } else {
                passwordBox.style.display = 'block';
            }

            // Pengujian Kriteria
            const isLengthValid = val.length >= 12;
            const isCapitalValid = /[A-Z]/.test(val);
            const isNumberValid = /[0-9]/.test(val);
            const isSymbolValid = /[\W_]/.test(val);

            // Manipulasi Teks & Icon Realtime
            reqLength.className = isLengthValid ? 'text-valid' : 'text-invalid';
            reqLength.innerHTML = isLengthValid ? '✔ Minimal 12 Karakter' : '❌ Minimal 12 Karakter';

            reqCapital.className = isCapitalValid ? 'text-valid' : 'text-invalid';
            reqCapital.innerHTML = isCapitalValid ? '✔ Mengandung Huruf Kapital (A-Z)' : '❌ Mengandung Huruf Kapital (A-Z)';

            reqNumber.className = isNumberValid ? 'text-valid' : 'text-invalid';
            reqNumber.innerHTML = isNumberValid ? '✔ Mengandung Angka (0-9)' : '❌ Mengandung Angka (0-9)';

            reqSymbol.className = isSymbolValid ? 'text-valid' : 'text-invalid';
            reqSymbol.innerHTML = isSymbolValid ? '✔ Mengandung Simbol / Karakter Spesial' : '❌ Mengandung Simbol / Karakter Spesial';

            // Cek Konfirmasi Password
            let matches = val === confirmInput.value && confirmInput.value !== '';
            if (confirmInput.value !== '') {
                noteCocok.style.display = 'block';
                if (matches) {
                    noteCocok.style.color = '#2ecc71';
                    noteCocok.innerHTML = '✔ Password sudah cocok.';

                    // Sembunyikan box kriteria utama hanya jika konfirmasi juga sudah sukses dicocokkan
                    if (isLengthValid && isCapitalValid && isNumberValid && isSymbolValid) {
                        passwordBox.style.display = 'none';
                    }
                } else {
                    noteCocok.style.color = '#ff6b6b';
                    noteCocok.innerHTML = '❌ Password belum cocok.';
                }
            } else {
                noteCocok.style.display = 'none';
            }

            // Aktivasi Tombol (Style otomatis berubah jadi merah tegas)
            if (isLengthValid && isCapitalValid && isNumberValid && isSymbolValid && matches) {
                btnSubmit.removeAttribute('disabled');
            } else {
                btnSubmit.setAttribute('disabled', 'true');
            }
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmInput.addEventListener('input', validatePassword);
    }

    // --- Bagian Paling Bawah dari fungsi validatePassword() ---

    // Ambil data input email dan nama untuk dicek kelengkapannya
    const emailInput = document.getElementById('email').value.trim();
    const namaInput = document.getElementById('nama').value.trim();

    // Tombol AKTIF & BISA DI-HOVER hanya jika:
    // 1. Semua kriteria password terpenuhi (TRUE)
    // 2. Password dan konfirmasi cocok
    // 3. Email dan Nama tidak kosong
    if (isLengthValid && isCapitalValid && isNumberValid && isSymbolValid && matches && emailInput !== '' && namaInput !== '') {
        btnSubmit.removeAttribute('disabled');
    } else {
        btnSubmit.setAttribute('disabled', 'true');
    }
});