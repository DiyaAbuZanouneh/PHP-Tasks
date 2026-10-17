<?php require 'config.php';
$u = $_SESSION['registered'] ?? null; ?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>My Profile</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'nav.php'; ?>
<div class="box">
    <h2>My Registration Info (from Session)</h2>
    <?php if ($u): ?>
        <p><b>Name:</b> <?= e($u->name) ?></p>
        <p><b>Email:</b> <?= e($u->email) ?></p>
        <p><b>Mobile:</b> <?= e($u->mobile) ?></p>
        <p><b>Governorate:</b> <?= e($u->governorate) ?></p>
        <p><b>Track:</b> <?= e($u->track) ?></p>
        <p><b>Skills:</b> <?= e(implode(', ', $u->skills)) ?></p>
        <p><b>Message:</b> <?= e($u->message) ?></p>
    <?php else: ?>
        <p>No registration data in this session. <a href="index.php">Register first</a>.</p>
    <?php endif; ?>
</div>
</body></html>
