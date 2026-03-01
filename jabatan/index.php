<?php
require_once "../core/Auth.php";
require_once "../core/Jabatan.php";

Auth::cekLogin();
$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page-1)*$limit;
$jabatan = new Jabatan();
$data = $jabatan->getAll($limit,$offset);
$total = $jabatan->count();
$totalPage = ceil($total/$limit);

include "../layout/header.php";
include "../layout/sidebar.php";
?>
<main class="content">
    <h3> Data Jabatan </h3>
<form method="post">
    <input type="text" name="nama" placeholder="Nama Jabatan" required>
    <button class="btn btn-tambah" 
    name="simpan">Tambah Jabatan</button>
</form>
<br>
    <table>
        <tr>
            <th class="nomor"> No</th>
            <th> Jabatan</th>
            <th class="aksi"> Aksi</th>
</tr>
<?php
$no=$offset+1;
while($j=$data->fetch_assoc()): ?>
<tbody>
    <tr>
        <td class="nomor"><?= $no++ ?></td>
        <td><?= $j['namajab'] ?></td>
        <td class="aksi">
            <a href="edit.php?id=<?= $j['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="?hapus=<?= $j['id'] ?>" class="btn btn-hapus"
            onclick="return confirm('Yakin Menghapus Data ini?')">Hapus</a>
</td>
</tr>
</tbody>
<?php endwhile; ?>
</table>
<br>
<?php
    for($i=1; $i<=$totalPage; $i++): ?>
        <a href="?page=<?= $i ?>">[<?= $i ?>]</a>
<?php endfor; ?>

</main>
</div>
<?php
if(isset($_POST['simpan'])){
    $jabatan->insert($_POST['nama']);
    header("Location: index.php");
}
if(isset($_GET['hapus'])){
    $jabatan->delete($_GET['hapus']);
    header("Location: index.php");
}
include "../layout/footer.php"; ?>