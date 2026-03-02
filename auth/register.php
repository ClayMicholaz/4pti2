<?php
session_start();

$errors = $_SESSION['register_errors'] ?? [];
$success = $_SESSION['register_success'] ?? "";
$name = $_SESSION['register_name'] ?? "";
$email = $_SESSION['register_email'] ?? "";
$tanggalLahir = $_SESSION['register_tanggallahir'] ?? "";
$jabatan = $_SESSION['register_jabatan'] ?? "";
$username = $_SESSION['register_username'] ?? "";

unset(
    $_SESSION['register_errors'],
    $_SESSION['register_success'],
    $_SESSION['register_name'],
    $_SESSION['register_email'],
    $_SESSION['register_tanggallahir'],
    $_SESSION['register_jabatan'],
    $_SESSION['register_username']
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Information System</title>
    <link rel="stylesheet" href="../assets/style_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="login-card">
        <div>
            <img src="../assets/logo.png" alt="Logo">
        </div>
        <h2> Register System</h2>

        <?php if (count($errors) > 0): ?>
            <div>
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success !== ""): ?>
            <div>
                <p><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?></p>
            </div>
        <?php endif; ?>

        <form action="proses_register.php" method="post">
            <input type="text" name="nama" placeholder="Nama" required
                value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="email" name="email" placeholder="Email" required
                value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="date" name="tanggallahir" required
                value="<?= htmlspecialchars($tanggalLahir, ENT_QUOTES, 'UTF-8'); ?>">
            <select name="idjabatan" required>
                <option value="" disabled <?= $jabatan === "" ? "selected" : ""; ?>>Pilih Jabatan</option>
                <option value="1" <?= $jabatan === "1" ? "selected" : ""; ?>>IT Manager</option>
                <option value="2" <?= $jabatan === "2" ? "selected" : ""; ?>>Data Analis</option>
            </select>
            <input type="text" name="username" placeholder="Username" required
                value="<?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="password-field">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Show password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <div class="password-field">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password"
                    required>
                <button type="button" class="toggle-password" data-target="confirm_password"
                    aria-label="Show password confirmation">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <button type="submit" name="register">Sign Up</button>
        </form>
        <div class="login-footer">
            &copy <?= date('Y'); ?> Human Resource Information System
        </div>
    </div>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                var targetId = button.getAttribute('data-target');
                var input = document.getElementById(targetId);
                var icon = button.querySelector('i');
                if (!input || !icon) {
                    return;
                }
                var isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
                button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
            });
        });
    </script>
</body>

</html>