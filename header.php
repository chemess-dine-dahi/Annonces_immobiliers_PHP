<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bdd.php';
?>
<link rel="stylesheet" href="styles.css">
<header >
    <nav >
        <div class="logo">Find My Dream Home</div>
        <div>
            <a href="index.php">Accueil</a> |
            <a href="house.php?page=1">Maisons</a> |
            <a href="appartment.php?page=2">Appartements</a>|
            <a href="search.php">Recherche</a></li>
        </div>
        <div>
            <?php if (isset($_SESSION['user']['email'])): ?>
                <span>Bienvenue, <?= htmlspecialchars($_SESSION['user']['email']) ?></span> |
                <a href="add.php">Ajouter une annonce</a> |
                <a href="favorites.php">Mes favoris</a> |
                <a href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </nav>
</header>