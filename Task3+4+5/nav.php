<nav>
    <a href="index.php">Register</a>
    <a href="search.php">Search</a>
    <a href="profile.php">My Profile</a>
    <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a class="right" href="logout.php">Logout</a>
    <?php else: ?>
        <a class="right" href="login.php">Login</a>
    <?php endif; ?>
</nav>
