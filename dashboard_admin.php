<?php
require_once "core/Auth.php";
Auth::cekLogin();
include "layout/header.php";
include "layout/sidebar.php";

// helper fungsi untuk membuat timestamp acak
function randomTimestamp() {
    $now = time();
    $pastWeek = $now - 7 * 24 * 3600;
    return date("Y-m-d H:i:s", rand($pastWeek, $now));
}

// Ambil data pegawai dari database untuk notifikasi
$db = new Database();
$pegawaiQuery = "SELECT p.nama, j.namajab FROM tbl_pegawai p JOIN tbl_jabatan j ON p.idjabatan = j.id LIMIT 10";
$stmt = $db->conn->prepare($pegawaiQuery);
$stmt->execute();
$result = $stmt->get_result();
$pegawaiList = [];
while ($row = $result->fetch_assoc()) {
    $pegawaiList[] = $row;
}
$stmt->close();

// Jika notifikasi belum dibuat di session, generate satu kali dan simpan
if (!isset($_SESSION['notifications'])) {
    // Data awal yang pasti ada
    $notifications = [];
    $id = 1;

    // tambahkan notifikasi untuk Jona sesuai permintaan
    $notifications[] = [
        "id" => $id++,
        "type" => "updated",
        "message" => "Data pegawai diperbarui: Jona",
        "detail" => "Jona telah diperbarui dalam sistem pada tanggal " . date("Y-m-d") . ".",
        "timestamp" => randomTimestamp()
    ];
    $notifications[] = [
        "id" => $id++,
        "type" => "added",
        "message" => "Pegawai baru ditambahkan: Jona",
        "detail" => "Jona berhasil ditambahkan ke sistem pada tanggal " . date("Y-m-d") . ".",
        "timestamp" => randomTimestamp()
    ];
    // notifikasi tambahan untuk pegawai baru khusus
    $additionalNew = ['Lamine Yamal'];
    foreach ($additionalNew as $name) {
        $notifications[] = [
            "id" => $id++,
            "type" => "added",
            "message" => "Pegawai baru ditambahkan: $name",
            "detail" => "$name berhasil ditambahkan ke sistem pada tanggal " . date("Y-m-d") . ".",
            "timestamp" => randomTimestamp()
        ];
    }
    // sisipkan notif penghapusan Julian di posisi ke-5
    $julianNotif = [
        "id" => $id++,
        "type" => "removed",
        "message" => "Pegawai dihapus: Julian",
        "detail" => "Julian dihapus karena pekerjaan tidak baik pada tanggal " . date("Y-m-d") . ".",
        "timestamp" => randomTimestamp()
    ];
    // taruh di index 4 (pos kelima)
    array_splice($notifications, 4, 0, [$julianNotif]);

    // Baik notifikasi lain dibuat dari pegawai yang ada (kecuali Jona jika muncul)
    $types = ['added', 'updated', 'removed'];
    $actions = [
        'added' => 'Pegawai baru ditambahkan',
        'updated' => 'Data pegawai diperbarui',
        'removed' => 'Pegawai dihapus'
    ];
    $details = [
        'added' => 'telah berhasil ditambahkan ke sistem pada tanggal ' . date("Y-m-d") . '. Jabatan: ',
        'updated' => 'telah diperbarui. Perubahan: Jabatan atau data lainnya. Tanggal update: ' . date("Y-m-d") . '. Jabatan: ',
        'removed' => 'telah dihapus dari sistem pada tanggal ' . date("Y-m-d") . '. Alasan: Resign. Jabatan: '
    ];

    foreach ($pegawaiList as $pegawai) {
        if (strtolower($pegawai['nama']) === 'jona') {
            // lewati karena sudah kita tambahkan manual
            continue;
        }
        $type = $types[array_rand($types)];
        $message = $actions[$type] . ': ' . $pegawai['nama'];
        $detail = $pegawai['nama'] . ' ' . $details[$type] . $pegawai['namajab'] . '.';
        $notifications[] = [
            "id" => $id++,
            "type" => $type,
            "message" => $message,
            "detail" => $detail,
            "timestamp" => randomTimestamp()
        ];
    }

    // sebelum menyimpan, pastikan semua notifikasi bertipe 'added' kecuali
    // pertama (Jona update) yang memang harus "telah diperbarui" dan
    // juga kecuali notifikasi penghapusan Julian yang harus tetap removed
    foreach ($notifications as &$n) {
        if ($n['message'] === "Data pegawai diperbarui: Jona" ||
            $n['message'] === "Pegawai dihapus: Julian") {
            // biarkan seperti semula
            continue;
        }
        $n['type'] = 'added';
        // ubah pesan menjadi selalu "Pegawai baru ditambahkan: ..." jika belum
        if (strpos($n['message'], 'Pegawai baru ditambahkan') === false) {
            $parts = explode(':', $n['message']);
            $name = trim(end($parts));
            $n['message'] = "Pegawai baru ditambahkan: $name";
        }
    }
    unset($n);
    $_SESSION['notifications'] = $notifications;
} else {
    $notifications = $_SESSION['notifications'];
    // hapus notifikasi Hansi Flick, Buntol, dan Lamine Yamal yang tidak perlu
    $notifications = array_filter($notifications, function($n) {
        return strpos($n['message'], 'Hansi Flick') === false && 
               strpos($n['message'], 'Buntol') === false &&
               strpos($n['message'], 'Lamine Yamal') === false;
    });
    $notifications = array_values($notifications); // reset array keys
    
    // pastikan setiap notifikasi tetap bertipe added saat ditampilkan,
    // tapi jangan ubah notifikasi "Data pegawai diperbarui: Jona" atau Julian removal
    foreach ($notifications as &$n) {
        // jika belum ada timestamp (dari sesi lama), tambahkan
        if (!isset($n['timestamp'])) {
            $n['timestamp'] = randomTimestamp();
        }
        if ($n['message'] === "Data pegawai diperbarui: Jona" ||
            $n['message'] === "Pegawai dihapus: Julian") {
            continue;
        }
        $n['type'] = 'added';
        if (strpos($n['message'], 'Pegawai baru ditambahkan') === false) {
            $parts = explode(':', $n['message']);
            $name = trim(end($parts));
            $n['message'] = "Pegawai baru ditambahkan: $name";
        }
    }
    unset($n);
    // simpan kembali ke session agar timestamp tetap konsisten
    $_SESSION['notifications'] = $notifications;
}
?>
<main>
    <h2>Dashboard HRD</h2>
    <p></p>

    <!-- Bagian Notifikasi -->
    <section class="notifications mt-4">
        <h3>Notifikasi</h3>
        <div class="card">
            <div class="card-body p-2" style="max-height: 300px; overflow-y: auto;">
                <?php foreach ($notifications as $notif): ?>
                    <div class="notification-item d-flex align-items-center p-2 border-bottom" onclick="showNotificationDetail(<?php echo $notif['id']; ?>)">
                        <?php
                        $iconClass = '';
                        $iconColor = '';
                        if ($notif['type'] == 'added') {
                            $iconClass = 'fa-plus-circle';
                            $iconColor = 'text-success';
                        } elseif ($notif['type'] == 'updated') {
                            $iconClass = 'fa-edit';
                            $iconColor = 'text-warning';
                        } elseif ($notif['type'] == 'removed') {
                            $iconClass = 'fa-minus-circle';
                            $iconColor = 'text-danger';
                        }
                        ?>
                        <i class="fas <?php echo $iconClass; ?> <?php echo $iconColor; ?> me-2"></i>
                        <div class="flex-grow-1">
                            <small class="fw-bold"><?php echo htmlspecialchars($notif['message']); ?></small><br>
                            <small class="text-muted"><?php echo date("Y-m-d H:i", strtotime($notif['timestamp'])); ?> - Klik untuk detail</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<!-- Modal untuk Detail Notifikasi -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Detail Notifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificationDetail">
                <!-- Detail akan diisi oleh JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Data notifikasi untuk JavaScript
    const notifications = <?php echo json_encode($notifications); ?>;

    function showNotificationDetail(id) {
        const notif = notifications.find(n => n.id === id);
        if (notif) {
            document.getElementById('notificationModalLabel').textContent = notif.message;
            document.getElementById('notificationDetail').textContent = notif.detail;
            const modal = new bootstrap.Modal(document.getElementById('notificationModal'));
            modal.show();
        }
    }
</script>

</div>
<?php include "layout/footer.php"; ?>