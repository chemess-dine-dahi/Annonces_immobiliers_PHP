<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bdd.php';
?>
<?php
$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("
    SELECT l.*, pt.name AS property_type, tt.name AS transaction_type
    FROM listing l
    JOIN favorite f ON l.id = f.listing_id
    JOIN propertyType pt ON l.property_type_id = pt.id
    JOIN transactionType tt ON l.transaction_type_id = tt.id
    WHERE f.user_id = :user_id
");
$stmt->bindValue(':user_id', $user_id);
$stmt->execute();
$favorites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes favoris</title>
</head>
<body>
    <h1>Mes annonces favorites</h1>
    <?php if (empty($favorites)): ?>
        <p>Vous n'avez aucune annonce en favoris.</p>
    <?php else: ?>
        <?php foreach ($favorites as $fav): ?>
            <div class="annonce">
                <img src="<?= htmlspecialchars($fav['image_url']) ?>" alt="Annonce">
                <h3><?= htmlspecialchars($fav['title']) ?></h3>
                <p><strong>Prix :</strong> <?= number_format($fav['price'], 0, ',', ' ') ?> €</p>
                <p><strong>Ville :</strong> <?= htmlspecialchars($fav['city']) ?></p>
                <p><?= htmlspecialchars(substr($fav['description'], 0, 100)) ?>...</p>
                <p><strong>Type :</strong> <?= htmlspecialchars($fav['transaction_type']) ?></p>
                <form method="post" action="remove_favorite.php" style="display:inline;">
                    <input type="hidden" name="listing_id" value="<?= $fav['id'] ?>">
                    <button type="submit">Retirer des favoris</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>