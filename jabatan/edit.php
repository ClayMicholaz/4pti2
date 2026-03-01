<?php
require_once "../core/Auth.php";
require_once "../core/Jabatan.php";

Auth::cekLogin();
$jabatan = new Jabatan();
$data = $jabatan->find($_GET['id']);
if(isset($_POST['update'])){
    $jabatan->update($_GET['id'], $_POST['nama']);
    header("Location: index.php");
}
include "../layout/header.php";
include "../layout/sidebar.php";
?>
<main class="content">
    <h3> Edit Data Jabatan </h3>
<form method="post">
    <input type="text" name="nama" 
    value="<?= $data['namajab'] ?>" required>
    <button class="btn btn-tambah" 
    name="update">Simpan Perubahan</button>
</form>
</main>
</div>
<?php include "../layout/footer.php"; ?>