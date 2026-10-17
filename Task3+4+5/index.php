<?php
require 'config.php';

class Registration
{
    public $name;
    public $email;
    public $mobile;
    public $governorate;
    public $track;
    public $skills;
    public $message;
}

// Cookie pre-fill (name, email, track) when the form has not been submitted yet
$v = [
    'name' => $_COOKIE['name'] ?? '', 'email' => $_COOKIE['email'] ?? '', 'mobile' => '',
    'governorate' => '', 'track' => $_COOKIE['track'] ?? '', 'skills' => [], 'message' => '',
];
$errors = [];
$user = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v['name'] = trim($_POST['name'] ?? '');
    $v['email'] = trim($_POST['email'] ?? '');
    $v['mobile'] = trim($_POST['mobile'] ?? '');
    $v['governorate'] = trim($_POST['governorate'] ?? '');
    $v['track'] = trim($_POST['track'] ?? '');
    $v['skills'] = $_POST['skills'] ?? [];
    $v['message'] = trim($_POST['message'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($v['name'] === '') {
        $errors['name'] = 'Full name is required.';
    }
    if ($v['email'] === '') {
        $errors['email'] = 'Email is required.';
    } elseif (!filter_var($v['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format.';
    }
    if ($v['mobile'] === '') {
        $errors['mobile'] = 'Mobile is required.';
    } elseif (!preg_match('/^07[789]\d{7}$/', $v['mobile'])) {
        $errors['mobile'] = 'Use a Jordanian mobile like 0791234567.';
    }
    if (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters.';
    }
    if (!in_array($v['governorate'], $governorates)) {
        $errors['governorate'] = 'Please select a governorate.';
    }
    if (!in_array($v['track'], $tracks)) {
        $errors['track'] = 'Please select a track.';
    }
    if (!is_array($v['skills']) || count(array_intersect($v['skills'], $skillList)) === 0) {
        $v['skills'] = [];
        $errors['skills'] = 'Select at least one skill.';
    }
    if (empty($_POST['terms'])) {
        $errors['terms'] = 'You must accept the terms.';
    }

    if (!$errors) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$v['email']]);
        if ($check->fetch()) {
            $errors['email'] = 'This email is already registered.';
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, mobile, governorate, track, skills, message) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$v['name'], $v['email'], password_hash($password, PASSWORD_DEFAULT), $v['mobile'],
            $v['governorate'], $v['track'], implode(', ', $v['skills']), $v['message']]);

        $user = new Registration();
        foreach (['name', 'email', 'mobile', 'governorate', 'track', 'skills', 'message'] as $f) {
            $user->$f = $v[$f];
        }

        $_SESSION['registered'] = $user;
        setcookie('name', $user->name, time() + 86400 * 30);
        setcookie('email', $user->email, time() + 86400 * 30);
        setcookie('track', $user->track, time() + 86400 * 30);
    }
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Register</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'nav.php'; ?>
<div class="box">
<?php if ($user): ?>
    <div class="success">Registration successful! You can now <a href="login.php">log in</a>.</div>
    <h2>Submitted Information</h2>
    <p><b>Name:</b> <?= e($user->name) ?></p>
    <p><b>Email:</b> <?= e($user->email) ?></p>
    <p><b>Mobile:</b> <?= e($user->mobile) ?></p>
    <p><b>Governorate:</b> <?= e($user->governorate) ?></p>
    <p><b>Track:</b> <?= e($user->track) ?></p>
    <p><b>Skills:</b> <?= e(implode(', ', $user->skills)) ?></p>
    <p><b>Message:</b> <?= e($user->message) ?></p>
    <a class="btn" href="profile.php">View my profile (session)</a>
<?php else: ?>
    <h2>Registration</h2>
    <form method="post" novalidate>
        <label>Full Name</label>
        <input type="text" name="name" value="<?= e($v['name']) ?>">
        <span class="error"><?= $errors['name'] ?? '' ?></span>

        <label>Email</label>
        <input type="email" name="email" value="<?= e($v['email']) ?>">
        <span class="error"><?= $errors['email'] ?? '' ?></span>

        <label>Password</label>
        <input type="password" name="password">
        <span class="error"><?= $errors['password'] ?? '' ?></span>

        <label>Mobile</label>
        <input type="text" name="mobile" value="<?= e($v['mobile']) ?>">
        <span class="error"><?= $errors['mobile'] ?? '' ?></span>

        <label>Governorate</label>
        <select name="governorate">
            <option value="">-- Select --</option>
            <?php foreach ($governorates as $g): ?>
                <option <?= $v['governorate'] === $g ? 'selected' : '' ?>><?= e($g) ?></option>
            <?php endforeach; ?>
        </select>
        <span class="error"><?= $errors['governorate'] ?? '' ?></span>

        <label>Track</label>
        <?php foreach ($tracks as $t): ?>
            <label class="inline"><input type="radio" name="track" value="<?= e($t) ?>" <?= $v['track'] === $t ? 'checked' : '' ?>> <?= e($t) ?></label>
        <?php endforeach; ?>
        <span class="error"><?= $errors['track'] ?? '' ?></span>

        <label>Skills</label>
        <?php foreach ($skillList as $s): ?>
            <label class="inline"><input type="checkbox" name="skills[]" value="<?= e($s) ?>" <?= in_array($s, $v['skills']) ? 'checked' : '' ?>> <?= e($s) ?></label>
        <?php endforeach; ?>
        <span class="error"><?= $errors['skills'] ?? '' ?></span>

        <label>Message</label>
        <textarea name="message" rows="3"><?= e($v['message']) ?></textarea>

        <label class="inline"><input type="checkbox" name="terms" <?= !empty($_POST['terms']) ? 'checked' : '' ?>> I accept the Terms &amp; Conditions</label>
        <span class="error"><?= $errors['terms'] ?? '' ?></span>

        <br><br><button type="submit">Register</button>
    </form>
<?php endif; ?>
</div>
</body></html>
