<?php
require_once "core/Auth.php";
Auth::cekLogin();
include "layout/header.php";
include "layout/sidebar.php";
?>
<main>
    <h2>Dashboard User</h2>
    <p>Selamat datang, <?= $_SESSION['username']; ?></p>
</main>
</div>
<?php include "layout/footer.php"; ?>