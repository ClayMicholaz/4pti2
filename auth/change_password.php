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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <div class="password-wrapper">
                <input type="password" id="password" name="new_password" placeholder="New Password" required>
                <span id="togglePassword" class="toggle-password" title="Password hidden"><i class="fa-solid fa-eye-slash"></i></span>
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
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        toggle.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            if(type === 'password'){
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.title = 'Password hidden';
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.title = 'Password visible';
            }
        });
    </script>
</body>
</html>