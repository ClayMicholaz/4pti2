<?php
    $role = $_SESSION['role'] ?? '';
?>
<aside class="sidebar">
    <ul>
        <li><a href="/4pti2/dashboard.php">Dashboard</a></li>
        <?php if($role === 'admin'): ?>
        <li><a href="/4pti2/pegawai/index.php">Data Pegawai</a></li>
        <li><a href="/4pti2/jabatan/index.php">Data Jabatan</a></li>
        <?php endif; ?>

        <?php if($role === 'user'): ?>
        <li><a href="/4pti2/jabatan/profile.php">Profil</a></li>
        <?php endif; ?>
        <li class="logout">
            <a href="/4pti2/auth/logout.php">Logout</a></li>
</ul>
</aside>