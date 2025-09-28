<?php
session_start();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'All fields are required!';
    } elseif ($username === 'admin' && $password === '1234') {
        $_SESSION['logged_in'] = true;
        header('Location: resume.php');
        exit;
    } else {
        $error = 'Invalid Username or Password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-bg">
        <div class="login-center">
            <form method="POST" class="login-form">
                <h2 class="login-title">Welcome Back</h2>
                <p class="login-subtitle">Sign in to view resume</p>
                <?php if ($error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <button type="submit" class="login-btn">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>