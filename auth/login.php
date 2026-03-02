<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Information System</title>
    <link rel="stylesheet" href="../assets/style_login.css">
</head>

<body>
    <div class="login-card">
        <div>
            <img src="../assets/logo.png" alt="Logo">
        </div>
        <h2> Login System</h2>
        <form action="proses_login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Sign In</button>
            <button type="button" id="register" name="register" onclick="window.location.href='register.php'">Register</button>
        </form>
        <div class="login-footer">
            &copy <?= date('Y'); ?> Human Resource Information System
        </div>
    </div>
</body>

</html>