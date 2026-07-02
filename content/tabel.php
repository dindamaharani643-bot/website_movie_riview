<?php
// Menggabungkan tabel user dan roles berdasarkan id_role
$query = "SELECT user.*, roles.nama_role 
          FROM user 
          INNER JOIN roles ON user.id_role = roles.id_role";

$tampil = mysqli_query($con, $query);
?>

<link rel="stylesheet" href="dist/css/tabel.css?v=<?= time(); ?>">

<div class="tb-table-scope">
    <div class="tb-table-container">
         <div style="margin-bottom: 25px; font-size: 0.9rem; color: #9e9e9e;">
            <a href="index.php?halaman=dashboard" style="color: #7a0010; text-decoration: none; font-weight: 600;">Home</a>
            <span style="margin: 0 8px; color: #444;">/</span>
            <span style="color: #ffffff;">Manage User</span>
        </div>

        <h2 class="tb-table-title">
            <i class="fa fa-users"></i> List User Aktif
        </h2>

        <div class="tb-table-responsive-wrapper">
            <table class="tb-custom-table">
                <thead>
                    <tr style="text-align: center;">
                        <th class="col-no">No.</th>
                        <th class="col-username">Username</th>
                        <th class="col-nama">Nama Lengkap</th>
                        <th class="col-jk">Jenis Kelamin</th>
                        <th class="col-role">Role</th>
                        <th class="col-status">Status</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $total_rows_displayed = 0;

                    // Menampilkan data aktif dari database jika ada
                    while ($data = mysqli_fetch_array($tampil)) {
                        $total_rows_displayed++;
                        ?>
                        <tr style="text-align: center;">
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><span class="tb-text-highlight"><?php echo htmlspecialchars($data['user']); ?></span></td>
                            <td><?php echo htmlspecialchars($data['nama']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($data['jenis_kelamin']); ?></td>
                            <td class="text-center">
                                <?php if ($data['id_role'] == 1): ?>
                                    <span class="tb-role-badge badge-admin"><?php echo htmlspecialchars($data['nama_role']); ?></span>
                                <?php else: ?>
                                    <span class="tb-role-badge badge-user"><?php echo htmlspecialchars($data['nama_role']); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php
                                if ($data['status'] == 'Y') {
                                    echo '<span class="tb-status-indicator status-online"><span class="dot"></span>Online</span>';
                                } else {
                                    echo '<span class="tb-status-indicator status-offline"><span class="dot"></span>Offline</span>';
                                }
                                ?>
                            </td>
                            <td class="text-center">
                                <div class="tb-action-buttons">
                                    <?php if ($data['id_role'] == 1): ?>
                                        <span class="tb-btn-protected">
                                            <i class="fa fa-lock"></i> Protected
                                        </span>
                                    <?php else: ?>
                                        <a href="masuk.php?halaman=edit&id=<?php echo $data['id_user']; ?>" class="tb-btn-action btn-edit">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="query/proses.php?aksi=delete&id_user=<?php echo $data['id_user']; ?>" class="tb-btn-action btn-delete btn-hapus-kustom">
                                            <i class="fa fa-trash"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }

                    // Loop tambahan untuk memaksa tabel mencetak baris kosong hingga pas 15 baris penyeimbang template
                    while ($total_rows_displayed < 15) {
                        $total_rows_displayed++;
                        ?>
                        <tr class="tr-blank-placeholder">
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>