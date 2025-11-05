<?php
// login.php (Updated to use PostgreSQL and PDO)
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: resume.php');
    exit;
}

require_once 'db_config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'All fields are required!';
    } else {
        try {
            $database = new Database();
            $db = $database->connect();
            
            if ($db) {
                // ELOQUENT spirit: Use prepared statement to safely fetch user data
                $sql = "SELECT id, password_hash, resume_id FROM users WHERE username = :username";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
    
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Auth::attempt() spirit: Verify password hash
                if ($user && password_verify($password, $user['password_hash'])) {
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['resume_id'] = $user['resume_id'];
                    
                    // Redirect to their dashboard
                    header('Location: resume.php'); 
                    exit;
                } else {
                    $error = 'Invalid Username or Password';
                }
            } else {
                $error = 'Could not connect to database for authentication.';
            }

        } catch (Exception $e) {
            $error = 'A system error occurred during login.';
        }
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
                <p class="login-subtitle">Sign in to view and edit your portfolio.</p>
                <?php if ($error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                <button type="submit" class="login-btn">Sign In</button>
                <p class="login-hint">Hint: Use your credentials from the SQL script.</p>
            </form>
        </div>
    </div>
</body>
</html>