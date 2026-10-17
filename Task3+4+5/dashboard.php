<?php
require 'config.php';
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$section = ($_GET['section'] ?? 'users') === 'products' ? 'products' : 'users';
$editId = (int)($_GET['edit'] ?? 0);
$msg = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    // ---------- USERS ----------
    if ($action === 'save_user') {
        $section = 'users';
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $mobile = trim($_POST['mobile'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($name === '') {
            $errors[] = 'Name is required.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email is required.';
        }
        if (!$id && strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters.';
        }
        if ($id && $password !== '' && strlen($password) < 6) {
            $errors[] = 'New password must be at least 6 characters.';
        }

        if (!$errors) {
            $dup = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id <> ?");
            $dup->execute([$email, $id]);
            if ($dup->fetch()) {
                $errors[] = 'This email is already used.';
            }
        }

        if (!$errors) {
            if ($id) {
                $pdo->prepare("UPDATE users SET name=?, email=?, mobile=? WHERE id=?")->execute([$name, $email, $mobile, $id]);
                if ($password !== '') {
                    $pdo->prepare("UPDATE users SET password=? WHERE id=?")->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
                }
                $msg = 'User updated.';
            } else {
                $pdo->prepare("INSERT INTO users (name, email, password, mobile) VALUES (?,?,?,?)")
                    ->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $mobile]);
                $msg = 'User added.';
            }
            $editId = 0;
        } else {
            $editId = $id;
        }
    }

    if ($action === 'delete_user') {
        $section = 'users';
        if ($id === (int)$_SESSION['user_id']) {
            $errors[] = 'You cannot delete the account you are logged in with.';
        } else {
            $pdo->prepare("DELETE FROM users WHERE id=?")->execute([$id]);
            $msg = 'User deleted.';
        }
    }

    // ---------- PRODUCTS ----------
    if ($action === 'save_product') {
        $section = 'products';
        $name = trim($_POST['name'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $qty = trim($_POST['quantity'] ?? '');

        if ($name === '') {
            $errors[] = 'Product name is required.';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors[] = 'Price must be a positive number.';
        }
        if (filter_var($qty, FILTER_VALIDATE_INT) === false || $qty < 0) {
            $errors[] = 'Quantity must be a whole number.';
        }

        if (!$errors) {
            if ($id) {
                $pdo->prepare("UPDATE products SET name=?, description=?, price=?, quantity=? WHERE id=?")->execute([$name, $desc, $price, $qty, $id]);
                $msg = 'Product updated.';
            } else {
                $pdo->prepare("INSERT INTO products (name, description, price, quantity) VALUES (?,?,?,?)")->execute([$name, $desc, $price, $qty]);
                $msg = 'Product added.';
            }
            $editId = 0;
        } else {
            $editId = $id;
        }
    }

    if ($action === 'delete_product') {
        $section = 'products';
        $pdo->prepare("DELETE FROM products WHERE id=?")->execute([$id]);
        $msg = 'Product deleted.';
    }
}

$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();

// Never select the password column
$users = $pdo->query("SELECT id, name, email, mobile, governorate, track, created_at FROM users ORDER BY id")->fetchAll();
$products = $pdo->query("SELECT * FROM products ORDER BY id")->fetchAll();

// Values for the add/edit form (keep submitted values if validation failed)
$form = [];
if ($editId) {
    if ($section === 'users') {
        $s = $pdo->prepare("SELECT id, name, email, mobile FROM users WHERE id=?");
    } else {
        $s = $pdo->prepare("SELECT * FROM products WHERE id=?");
    }
    $s->execute([$editId]);
    $form = $s->fetch() ?: [];
}
if ($errors) {
    $form = array_merge($form, $_POST);
}
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Dashboard</title><link rel="stylesheet" href="style.css"></head>
<body>
<nav>
    <strong style="color:#fff">Admin Dashboard</strong>
    <a href="dashboard.php?section=users">Users</a>
    <a href="dashboard.php?section=products">Products</a>
    <span class="right" style="color:#fff">Hello, <?= e($_SESSION['user_name']) ?></span>
    <a href="logout.php"><button type="button" class="btn-red">Logout</button></a>
</nav>

<div class="box wide">
    <div class="stats">
        <div class="stat"><b><?= $userCount ?></b>Total Users</div>
        <div class="stat"><b><?= $productCount ?></b>Total Products</div>
    </div>

    <?php if ($msg): ?><div class="success"><?= e($msg) ?></div><?php endif; ?>
    <?php foreach ($errors as $er): ?><div class="fail"><?= e($er) ?></div><?php endforeach; ?>

    <?php if ($section === 'users'): ?>
        <h2>Users</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Mobile</th><th>Governorate</th><th>Track</th><th>Created</th><th>Actions</th></tr>
            <?php foreach ($users as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td><td><?= e($u['name']) ?></td><td><?= e($u['email']) ?></td>
                <td><?= e($u['mobile']) ?></td><td><?= e($u['governorate']) ?></td><td><?= e($u['track']) ?></td>
                <td><?= e($u['created_at']) ?></td>
                <td>
                    <a class="btn" href="?section=users&edit=<?= $u['id'] ?>">Edit</a>
                    <form class="row" method="post" onsubmit="return confirm('Delete this user?')">
                        <input type="hidden" name="action" value="delete_user">
                        <input type="hidden" name="id" value="<?= $u['id'] ?>">
                        <button class="btn-red">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3><?= $editId ? 'Edit User' : 'Add User' ?></h3>
        <form method="post">
            <input type="hidden" name="action" value="save_user">
            <input type="hidden" name="id" value="<?= $editId ?>">
            <label>Name</label><input type="text" name="name" value="<?= e($form['name'] ?? '') ?>">
            <label>Email</label><input type="email" name="email" value="<?= e($form['email'] ?? '') ?>">
            <label>Mobile</label><input type="text" name="mobile" value="<?= e($form['mobile'] ?? '') ?>">
            <label>Password <?= $editId ? '(leave empty to keep current)' : '' ?></label><input type="password" name="password">
            <br><br>
            <button type="submit"><?= $editId ? 'Update' : 'Add' ?></button>
            <?php if ($editId): ?><a class="btn btn-gray" href="?section=users">Cancel</a><?php endif; ?>
        </form>

    <?php else: ?>
        <h2>Products</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Quantity</th><th>Created</th><th>Actions</th></tr>
            <?php foreach ($products as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td><td><?= e($p['name']) ?></td><td><?= e($p['description']) ?></td>
                <td><?= e($p['price']) ?></td><td><?= e($p['quantity']) ?></td><td><?= e($p['created_at']) ?></td>
                <td>
                    <a class="btn" href="?section=products&edit=<?= $p['id'] ?>">Edit</a>
                    <form class="row" method="post" onsubmit="return confirm('Delete this product?')">
                        <input type="hidden" name="action" value="delete_product">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <button class="btn-red">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3><?= $editId ? 'Edit Product' : 'Add Product' ?></h3>
        <form method="post">
            <input type="hidden" name="action" value="save_product">
            <input type="hidden" name="id" value="<?= $editId ?>">
            <label>Name</label><input type="text" name="name" value="<?= e($form['name'] ?? '') ?>">
            <label>Description</label><textarea name="description" rows="3"><?= e($form['description'] ?? '') ?></textarea>
            <label>Price</label><input type="number" step="0.01" name="price" value="<?= e($form['price'] ?? '') ?>">
            <label>Quantity</label><input type="number" name="quantity" value="<?= e($form['quantity'] ?? '') ?>">
            <br><br>
            <button type="submit"><?= $editId ? 'Update' : 'Add' ?></button>
            <?php if ($editId): ?><a class="btn btn-gray" href="?section=products">Cancel</a><?php endif; ?>
        </form>
    <?php endif; ?>
</div>
</body></html>
