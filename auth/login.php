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
        <h2> Login System</h2>
        <form action="proses_login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <div class="password-field">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="button" class="toggle-password" data-target="password" aria-label="Show password">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <button type="submit" name="login">Sign In</button>
            <p><a href="change_password.php">Forget password?</a></p>
            <button type="button" id="register" name="register"
                onclick="window.location.href='register.php'">Register</button>
        </form>
        <div class="login-footer">
            &copy <?= date('Y'); ?> Human Resource Information System
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