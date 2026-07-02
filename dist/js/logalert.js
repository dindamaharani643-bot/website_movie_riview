window.onload = function () {
            const alert = document.getElementById('loginAlert');
            if (alert) {
                setTimeout(function () {
                    alert.style.transition = "opacity 0.6s ease";
                    alert.style.opacity = "0";
                    setTimeout(function () {
                        alert.remove();
                    }, 600);
                }, 5000);
            }
        };