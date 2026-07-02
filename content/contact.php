<link rel="stylesheet" href="dist/css/user_movies.css?v=<?= time(); ?>">
<link rel="stylesheet" href="dist/css/profil.css">

<!-- Wrapper Utama Tema Profil (Midnight Maroon Dekopal) -->
<div class="mv-profile-scope">
    <div class="mv-profile-container">
        <!-- Breadcrumbs -->
        <div style="margin-bottom: 25px; font-size: 0.9rem; color: #9e9e9e;">
            <a href="index.php?halaman=index" style="color: #7a0010; text-decoration: none; font-weight: 600;">Home</a>
            <span style="margin: 0 8px; color: #444;">/</span>
            <span style="color: #ffffff;">Contact</span>
        </div>
        <div class="mv-profile-card">

            <!-- Konten Utama Form Kontak -->
            <div class="mv-profile-form">
                <h2 class="mv-profile-title"
                    style="text-align: center; color: #ffffff; border-bottom: none; margin-bottom: 30px;">
                    <i class="fa fa-envelope" style="color: #7a0010; margin-right: 8px;"></i> Contact Us
                </h2>

                <div class="mv-form-row">
                    <!-- Kolom Kiri: Informasi Kontak -->
                    <div class="mv-form-group"
                        style="flex: 0 0 40%; max-width: 40%; display: flex; flex-direction: column; gap: 20px; border-right: 1px solid #222; padding-right: 25px;">

                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div
                                style="background: #0a0a0a; border: 1px solid #2a2a2a; padding: 12px; border-radius: 8px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <img src="dist/img/icon-contact-map.png" alt="Map"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <address style="font-style: normal; font-size: 0.9rem; color: #cccccc; line-height: 1.4;">
                                <strong style="color: #ffffff; display: block; margin-bottom: 2px;">Kuningan</strong>
                                Jawa Barat, Indonesia
                            </address>
                        </div>

                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div
                                style="background: #0a0a0a; border: 1px solid #2a2a2a; padding: 12px; border-radius: 8px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <img src="dist/img/icon-contact-phone.png" alt="Phone"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div style="font-size: 0.9rem;">
                                <span
                                    style="color: #9e9e9e; display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Phone</span>
                                <a href="tel:+631590912831"
                                    style="color: #ffffff; text-decoration: none; transition: 0.2s;"
                                    onmouseover="this.style.color='#7a0010'" onmouseout="this.style.color='#ffffff'">+63
                                    1590 912 831</a>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div
                                style="background: #0a0a0a; border: 1px solid #2a2a2a; padding: 12px; border-radius: 8px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <img src="dist/img/icon-contact-message.png" alt="Email"
                                    style="max-width: 100%; height: auto;">
                            </div>
                            <div style="font-size: 0.9rem;">
                                <span
                                    style="color: #9e9e9e; display: block; font-size: 0.75rem; font-weight: 600; text-transform: uppercase;">Email</span>
                                <a href="mailto:contact@kelompok5.com"
                                    style="color: #ffffff; text-decoration: none; transition: 0.2s;"
                                    onmouseover="this.style.color='#7a0010'"
                                    onmouseout="this.style.color='#ffffff'">contact@kelompok5.com</a>
                            </div>
                        </div>

                    </div>

                    <!-- Kolom Kanan: Form Kirim Pesan -->
                    <div class="mv-form-group" style="flex: 0 0 60%; max-width: 60%; padding-left: 25px;">

                        <div class="mv-form-group-full">
                            <label class="mv-form-label">Name</label>
                            <input type="text" class="mv-profile-input" placeholder="Your name...">
                        </div>

                        <div class="mv-form-group-full">
                            <label class="mv-form-label">Email Address</label>
                            <input type="email" class="mv-profile-input" placeholder="Your email...">
                        </div>

                        <div class="mv-form-group-full">
                            <label class="mv-form-label">Website</label>
                            <input type="text" class="mv-profile-input" placeholder="Your website (optional)...">
                        </div>

                        <div class="mv-form-group-full">
                            <label class="mv-form-label">Message</label>
                            <textarea class="mv-profile-input" style="min-height: 120px; resize: vertical;"
                                placeholder="Write your message here..."></textarea>
                        </div>

                        <div class="mv-form-actions" style="padding-top: 10px;">
                            <button type="submit" class="mv-btn-submit">
                                <i class="fa fa-paper-plane"></i> Send Message
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>