<?php
require_once "../core/Auth.php";
require_once "../config/database.php";

Auth::cekLogin();

$page = (int) ($_GET['page'] ?? 1);
if ($page < 1) {
    $page = 1;
}
$limit = 10;
$offset = ($page - 1) * $limit;

$rows = [];
$total = 0;

try {
    $db = new Database();

    $countStmt = $db->conn->prepare("SELECT COUNT(*) AS total FROM tbl_pegawai");
    if ($countStmt) {
        $countStmt->execute();
        $countRow = $countStmt->get_result()->fetch_assoc();
        $total = (int) ($countRow['total'] ?? 0);
        $countStmt->close();
    }

    $stmt = $db->conn->prepare(
        "SELECT p.id, p.nama, p.email, p.username, p.role, p.tanggallahir, j.namajab
		FROM tbl_pegawai p
		LEFT JOIN tbl_jabatan j ON p.idjabatan = j.id
		ORDER BY p.id DESC
		LIMIT ? OFFSET ?"
    );
    if ($stmt) {
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
    }
} catch (Exception $e) {
    $rows = [];
}

$totalPage = $limit > 0 ? (int) ceil($total / $limit) : 1;

include "../layout/header.php";
include "../layout/sidebar.php";
?>

<main class="content">
    <h3>Data Pegawai</h3>

    <table>
        <tr>
            <th class="nomor">No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Username</th>
            <th>Jabatan</th>
            <th>Role</th>
            <th>Tanggal Lahir</th>
        </tr>
        <tbody>
            <?php if (count($rows) === 0): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Belum ada data pegawai.</td>
                </tr>
            <?php else: ?>
                <?php $no = $offset + 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td class="nomor">
                            <?= $no++ ?>
                        </td>
                        <td>
                            <a href="/4pti2/jabatan/profile.php?username=<?= urlencode($row['username'] ?? '') ?>">
                                <?= htmlspecialchars($row['nama'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['namajab'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['role'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($row['tanggallahir'] ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($totalPage > 1): ?>
        <div style="margin-top: 12px;">
            <?php for ($i = 1; $i <= $totalPage; $i++): ?>
                <a href="?page=<?= $i ?>">[
                    <?= $i ?>]
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</main>

<?php include "../layout/footer.php"; ?>