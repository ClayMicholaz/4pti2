<?php
require_once "core/Auth.php";
Auth::cekLogin();
include "layout/header.php";
include "layout/sidebar.php";
?>
<main>
    <h2>Dashboard Admin</h2>
    <p>Kelola Data Pegawai dan Jabatan</p>
</main>
</div>
<?php include "layout/footer.php"; ?>