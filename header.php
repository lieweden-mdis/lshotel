<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div>
        <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
    </div>
    <div class="user-links">
        <?php if (isset($_SESSION['user_full_name'])): ?>
            <a href="profile.php" class="username-link"><?php echo htmlspecialchars($_SESSION['user_full_name']); ?></a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</header>
<nav>
    <a href="index.php">HOME</a>
    <a href="room.php">ROOM</a>
    <a href="facilities.php">FACILITIES</a>
    <a href="dining.php">DINING</a>
    <a href="about.php">ABOUT</a>
</nav>
