<?php
session_start();
require_once "../config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['register'])) {
    header("Location: /4pti2/auth/register.php");
    exit;
}

$errors = [];
$name = trim($_POST['nama'] ?? "");
$email = trim($_POST['email'] ?? "");
$tanggalLahir = trim($_POST['tanggallahir'] ?? "");
$idJabatan = trim($_POST['idjabatan'] ?? "");
$username = trim($_POST['username'] ?? "");
$password = $_POST['password'] ?? "";
$confirmPassword = $_POST['confirm_password'] ?? "";

if ($name === "") {
    $errors[] = "Nama wajib diisi.";
}
if ($email === "") {
    $errors[] = "Email wajib diisi.";
}
if ($tanggalLahir === "") {
    $errors[] = "Tanggal lahir wajib diisi.";
}
if ($idJabatan === "" || !in_array($idJabatan, ["1", "2"], true)) {
    $errors[] = "Jabatan wajib dipilih.";
}
if ($username === "") {
    $errors[] = "Username wajib diisi.";
}
if ($password === "") {
    $errors[] = "Password wajib diisi.";
}
if ($password !== $confirmPassword) {
    $errors[] = "Konfirmasi password tidak cocok.";
}

if (count($errors) === 0) {
    try {
        $db = new Database();

        $stmt = $db->conn->prepare("SELECT username FROM tbl_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $exists = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($exists) {
            $errors[] = "Username sudah digunakan.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $db->conn->prepare(
                "INSERT INTO tbl_pegawai (nama, email, username, password, role, idjabatan, tanggallahir) VALUES (?, ?, ?, ?, 'user', ?, ?)"
            );
            $idJabatanInt = (int) $idJabatan;
            $stmt->bind_param("ssssis", $name, $email, $username, $hashedPassword, $idJabatanInt, $tanggalLahir);

            if ($stmt->execute()) {
                header("Location: /4pti2/auth/login.php");
                exit;
            } else {
                $errors[] = "Registrasi gagal. Coba lagi.";
            }

            $stmt->close();
        }
    } catch (Exception $e) {
        $errors[] = "Koneksi database gagal.";
    }
}

if (count($errors) > 0) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_name'] = $name;
    $_SESSION['register_email'] = $email;
    $_SESSION['register_tanggallahir'] = $tanggalLahir;
    $_SESSION['register_jabatan'] = $idJabatan;
    $_SESSION['register_username'] = $username;
}

header("Location: /4pti2/auth/register.php");
exit;
?>