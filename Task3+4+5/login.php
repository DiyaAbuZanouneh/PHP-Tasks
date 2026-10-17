<?php
require 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $u = $stmt->fetch();
    if ($u && password_verify($_POST['password'] ?? '', $u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['user_name'] = $u['name'];
        header("Location: dashboard.php");
        exit;
    }
    $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'nav.php'; ?>
<div class="box">
    <h2>Login</h2>
    <?php if ($error): ?><div class="fail"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
        <label>Email</label>
        <input type="email" name="email" required value="<?= e($_POST['email'] ?? '') ?>">
        <label>Password</label>
        <input type="password" name="password" required>
        <br><br><button type="submit">Login</button>
    </form>
    <p>No account? <a href="index.php">Register</a></p>
</div>
</body></html>
