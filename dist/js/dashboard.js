document.addEventListener("DOMContentLoaded", function () {
    // 1. GRAFIK BATANG & GARIS (Ulasan Bulanan)
    const ctxMonthly = document.getElementById('monthlyChart');
    if (ctxMonthly) {
        new Chart(ctxMonthly, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Jumlah Ulasan Masuk',
                    data: [120, 190, 300, 500, 420, 650],
                    backgroundColor: 'rgba(122, 0, 16, 0.2)',
                    borderColor: '#7a0010', // Warna Maroon
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#888' } }
                },
                scales: {
                    y: { grid: { color: '#222' }, ticks: { color: '#888' } },
                    x: { grid: { color: '#222' }, ticks: { color: '#888' } }
                }
            }
        });
    }

    // 2. GRAFIK LINGKARAN (Distribusi Kategori/Genre Film)
    const ctxGenre = document.getElementById('genreChart');
    if (ctxGenre) {
        new Chart(ctxGenre, {
            type: 'doughnut',
            data: {
                labels: ['Action', 'Horror', 'Sci-Fi', 'Drama'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        '#7a0010', // Maroon Utama
                        '#a30015', // Maroon Terang
                        '#4a000a', // Maroon Gelap
                        '#1f1f1f'  // Abu Gelap Muted
                    ],
                    borderWidth: 1,
                    borderColor: '#0d0d0d'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#888', padding: 15 }
                    }
                }
            }
        });
    }
});