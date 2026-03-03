<?php
session_start();
require_once "../core/Auth.php";
require_once "../config/database.php";

Auth::cekLogin();

$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$targetUsername = $_SESSION['username'] ?? '';
if ($isAdmin && isset($_POST['target_username'])) {
    $candidate = trim((string) $_POST['target_username']);
    if ($candidate !== '' && preg_match('/^[a-zA-Z0-9_.-]+$/', $candidate)) {
        $targetUsername = $candidate;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /4pti2/jabatan/profile.php");
    exit;
}

$allowedFields = [
    'nama',
    'tempat_lahir',
    'tanggallahir',
    'jenis_kelamin',
    'status_pernikahan',
    'kewarganegaraan',
    'foto_profil',
    'nomor_hp',
    'email',
    'alamat_domisili',
    'nik',
    'npwp',
    'bpjs_kesehatan',
    'bpjs_ketenagakerjaan',
    'nip',
    'jabatan',
    'departemen',
    'status_karyawan',
    'tanggal_bergabung',
    'atasan_nama',
    'atasan_jabatan',
    'bank_rekening',
    'bank_nama',
    'gaji_pokok',
    'pendidikan_terakhir',
    'jurusan',
    'tahun_lulus',
    'mutasi_jabatan',
    'promosi',
    'perubahan_status',
    'kontak_darurat_nama',
    'kontak_darurat_hubungan',
    'kontak_darurat_nomor'
];

$updates = [];
$values = [];
$types = "";
$errors = [];

foreach ($allowedFields as $field) {
    if (array_key_exists($field, $_POST)) {
        $value = trim((string) $_POST[$field]);
        if ($field === 'gaji_pokok' && $value !== '') {
            $value = preg_replace('/[^0-9.,]/', '', $value);
            $value = str_replace(',', '.', $value);
        }
        $updates[] = "$field = ?";
        $values[] = $value === '' ? null : $value;
        $types .= "s";
    }
}

if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['foto_profil']['error'] === UPLOAD_ERR_OK) {
        $maxSize = 2 * 1024 * 1024;
        if ($_FILES['foto_profil']['size'] > $maxSize) {
            $errors[] = "Ukuran foto maksimal 2MB.";
        } else {
            $originalName = $_FILES['foto_profil']['name'];
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($extension, $allowedExtensions, true)) {
                $errors[] = "Format foto harus jpg, jpeg, png, atau webp.";
            } else {
                $uploadDir = __DIR__ . '/../uploads/profile/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                $fileName = uniqid('profile_', true) . '.' . $extension;
                $destination = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $destination)) {
                    $relativePath = 'uploads/profile/' . $fileName;
                    $updates[] = "foto_profil = ?";
                    $values[] = $relativePath;
                    $types .= "s";
                } else {
                    $errors[] = "Upload foto gagal.";
                }
            }
        }
    } else {
        $errors[] = "Upload foto gagal.";
    }
}

if (count($errors) === 0 && count($updates) > 0) {
    try {
        $db = new Database();
        $sql = "UPDATE tbl_pegawai SET " . implode(', ', $updates) . " WHERE username = ?";
        $stmt = $db->conn->prepare($sql);
        if ($stmt) {
            $values[] = $targetUsername;
            $types .= "s";
            $stmt->bind_param($types, ...$values);
            if ($stmt->execute()) {
                $_SESSION['profile_success'] = "Data profil berhasil diperbarui.";
            } else {
                $_SESSION['profile_errors'] = ["Update profil gagal."];
            }
            $stmt->close();
        } else {
            $_SESSION['profile_errors'] = ["Query update gagal."];
        }
    } catch (Exception $e) {
        $_SESSION['profile_errors'] = ["Koneksi database gagal."];
    }
} elseif (count($errors) > 0) {
    $_SESSION['profile_errors'] = $errors;
} else {
    $_SESSION['profile_errors'] = ["Tidak ada perubahan yang disimpan."];
}

if ($isAdmin && $targetUsername !== ($_SESSION['username'] ?? '')) {
    header("Location: /4pti2/jabatan/profile.php?username=" . urlencode($targetUsername));
    exit;
}
header("Location: /4pti2/jabatan/profile.php");
exit;
?>