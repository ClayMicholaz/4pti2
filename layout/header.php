<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once __DIR__ . "/../config/database.php";

$headerPhoto = "/4pti2/assets/default_profile.jpg";
if (!empty($_SESSION['username'])) {
    try {
        $db = new Database();
        $stmt = $db->conn->prepare("SELECT foto_profil FROM tbl_pegawai WHERE username = ? LIMIT 1");
        if ($stmt) {
            $stmt->bind_param("s", $_SESSION['username']);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if (!empty($row['foto_profil'])) {
                $fotoProfil = trim($row['foto_profil']);
                if (strpos($fotoProfil, "http") === 0 || strpos($fotoProfil, "/") === 0) {
                    $headerPhoto = $fotoProfil;
                } else {
                    $headerPhoto = "/4pti2/" . ltrim($fotoProfil, "/");
                }
            }
        }
    } catch (Exception $e) {
        $headerPhoto = "/4pti2/assets/default_profile.jpg";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Information System</title>
    <link rel="Stylesheet" href="/4pti2/assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <header class="header">
        <div>Human Resource Information System</div>
        <div class="header-profile">
            <a href="/4pti2/jabatan/profile.php"><img src="<?= htmlspecialchars($headerPhoto, ENT_QUOTES, 'UTF-8'); ?>"
                    alt="Profile" class="profile-image"></a>
        </div>
    </header>
    <div class="wrapper">