<?php include 'locations.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Example</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="logo">Find My Dream Home</div>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="#">House</a></li>
            <li><a href="#">Appartement</a></li>
        </ul>
    </nav>
    <!-- Main content -->
     <div class="container">
        <h2>Nos annonces de maison</h2>
        <div class="annoncesMaison">
             <?php foreach ($maisons as $maison): ?>
                <div classe="annonce">
                    <img src="<?= $maison['image'] ?>" alt="Maison">
                    <h3> <?= $maison['titre'] ?> </h3>
                    <p><strong> Prix :</strong> <?= $maison['prix'] ?></p>
                    <p><strong> Ville :</strong> <?= $maison['ville'] ?></p>
                    <p><strong> Type :</strong> <?= $maison['type'] ?></p>
                    <a href="#" class="btn">Contact</a>
                </div>
            <?php endforeach ?>
        </div>

        <h2>Nos annonces d’appartements</h2>
        <div class="annoncesAppar">
             <?php foreach ($appartements as $appartement): ?>
                <div classe="annonce">
                    <img src="<?= $appartement['image'] ?>" alt="Appartement">
                    <h3> <?= $appartement['titre'] ?> </h3>
                    <p><strong> Prix :</strong> <?= $appartement['prix'] ?></p>
                    <p><strong> Ville :</strong> <?= $appartement['ville'] ?></p>
                    <p><strong> Type :</strong> <?= $appartement['type'] ?></p>
                    <a href="#" class="btn">Contact</a>
                </div>
            <?php endforeach ?> 
        </div>


<!-- Footer -->
<footer>
    © 2025 Find My Dream Home – Tous droits réservés.
</footer>
</body>
</html>