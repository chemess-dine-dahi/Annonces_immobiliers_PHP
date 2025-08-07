<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bdd.php';
?>

<header style="background: #eee; padding: 10px;">
    <nav style="display: flex;">
        <div class="logo">Find My Dream Home</div>
        <div>
            <a href="index.php">Accueil</a> |
            <a href="category.php?type=house">Maisons</a> |
            <a href="category.php?type=apartment">Appartements</a>
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