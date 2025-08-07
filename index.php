<?php include 'locations.php'; 
require_once 'bdd.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Example</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation -->
    <?php include 'header.php'; ?>
    <!-- Main content -->
     <div class="container">
        <h2>Nos annonces de maison</h2>
        <div class="annoncesMaison">
            <?php $sqlMaisons = "SELECT l.*, pt.name AS property_type, tt.name AS transaction_type
                    FROM listing l
                    JOIN propertyType pt ON l.property_type_id = pt.id
                    JOIN transactionType tt ON l.transaction_type_id = tt.id
                    WHERE pt.name = :type
                    ";
                $stmt = $pdo->prepare($sqlMaisons);
                $stmt->bindValue(':type', 'house', PDO::PARAM_STR);
                $stmt->execute();
             ?>

             <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="annonce">
                    <img src="<?= $row['image_url'] ?>" alt="Maison">
                    <h3> <?= $row['title'] ?> </h3>
                    <p><strong> Prix :</strong> <?= number_format($row['price'], 0, ',', ' ') ?> €</p>
                    <p><strong> Ville :</strong> <?= $row['city'] ?></p>
                    <p><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</p>
                    <p><strong> Type :</strong> <?= $row['transaction_type'] ?></p>
                    <a href="#" class="btn">Contact</a>
                </div>
            <?php endwhile ?>
        </div>

        <h2>Nos annonces d’appartements</h2>
        <div class="annoncesAppar">
             <?php $sqlAppart = "SELECT l.*, pt.name AS property_type, tt.name AS transaction_type
                    FROM listing l
                    JOIN propertyType pt ON l.property_type_id = pt.id
                    JOIN transactionType tt ON l.transaction_type_id = tt.id
                    WHERE pt.name = :type
                    ";
                $stmt = $pdo->prepare($sqlAppart);
                $stmt->bindValue(':type', 'appartment', PDO::PARAM_STR);
                $stmt->execute();
             ?>

             <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="annonce">
                    <img src="<?= $row['image_url'] ?>" alt="Appartment">
                    <h3> <?= $row['title'] ?> </h3>
                    <p><strong> Prix :</strong> <?= number_format($row['price'], 0, ',', ' ') ?> €</p>
                    <p><strong> Ville :</strong> <?= $row['city'] ?></p>
                    <p><?= htmlspecialchars(substr($row['description'], 0, 100)) ?>...</p>
                    <p><strong> Type :</strong> <?= $row['transaction_type'] ?></p>
                    <a href="#" class="btn">Contact</a>
                </div>
            <?php endwhile ?> 
        </div>


<!-- Footer -->
<footer>
    © 2025 Find My Dream Home – Tous droits réservés.
</footer>
</body>
</html>