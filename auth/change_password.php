<?php
require_once "../core/Auth.php";
$auth = new Auth();
$message = '';
$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $new_password = $_POST['new_password'];
    
    if(empty($username) || empty($new_password)){
        $error = "Username dan password tidak boleh kosong.";
    } elseif(strlen($new_password) < 6){
        $error = "Password minimal 6 karakter.";
    } else {
        if($auth->changePassword($username, $new_password)){
            $message = "Password berhasil diubah. <a href=\"login.php\">Back to login page</a>";
        } else {
            $error = "Username tidak ditemukan atau gagal mengubah password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="../assets/style_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="login-card">
        <h2>Change Password</h2>
        
        <?php if($message): ?>
            <p style="color: green;"><?= $message ?></p>
        <?php endif; ?>
        
        <?php if($error): ?>
            <p style="color: red;"><?= htmlentities($error) ?></p>
        <?php endif; ?>
        
        <?php if(!$message): ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <div class="password-field">
                <input type="password" id="password" name="new_password" placeholder="New Password" required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Show password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <button type="submit" name="submit">Change Password</button>
            <p><a href="login.php">Back to login page</a></p>
        </form>
        <?php endif; ?>
        
        <div class="login-footer">
            &copy; <?= date('Y'); ?> HR Information System
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (button) {
            button.addEventListener('click', function () {
                let targetId = button.getAttribute('data-target');
                let input = document.getElementById(targetId);
                let icon = button.querySelector('i');
                if (!input || !icon) {
                    return;
                }
                let isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
                button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
            });
        });
    </script>
</body>
</html>