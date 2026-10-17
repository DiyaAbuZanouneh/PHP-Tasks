<?php require 'config.php';
$q = trim($_GET['q'] ?? ''); ?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Search</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'nav.php'; ?>
<div class="box">
    <h2>Search</h2>
    <form method="get">
        <input type="text" name="q" placeholder="Search..." value="<?= e($q) ?>">
        <br><br><button type="submit">Search</button>
    </form>
    <?php if ($q !== ''): ?>
        <h3>Search result for: <?= e($q) ?></h3>
    <?php endif; ?>
</div>
</body></html>
