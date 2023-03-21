
 <head>
        <link rel="stylesheet" href="styles.css">
        <script src="script.js" defer></script>
</head>

    <nav class="navbar">
        <div class="brand-title">Professor In Space</div>
        <div class="navbar-links">
            <ul>
                <li><a href="game.php">Game</a></li>
                <li><a href="leaderboard.php">Leaderboard</a></li>
                <li><a href="profile.php">Profile</a></li>

                <li>
                    <?php
                    if(session_status() === PHP_SESSION_ACTIVE){ ?>
                        <a href="register.php"> Register </a>
                    <?php }
                    else { ?>
                        <a href="logout.php?logout=true">Logout </a>
                    <?php } ?>
                </li>
    
            </ul>
        </div>
    </nav>
