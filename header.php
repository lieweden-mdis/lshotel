<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L's HOTEL</title>
    <link rel="icon" href="img/icon.jpg">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <style>
        .user-links {
            display: flex;
            align-items: center;
            position: relative;
        }

        .user-links a,
        .user-links .username-link {
            color: white;
            margin: 0 1em;
            text-decoration: none;
            font-size: 1.5em;
            font-weight: bold;
        }

        .user-links .username-link {
            padding: 0.5em 1em;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <img src="img/logo.png" alt="Logo">
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
</body>
</html>
