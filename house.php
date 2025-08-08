<?php
require_once 'bdd.php';

// ---- CONFIG ----
$itemsPerPage = 12;
$propertyTypeName = "House"; // on filtre uniquement sur "Maison"

// ---- PAGE COURANTE ----
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
if ($page < 1) $page = 1;

// ---- RÉCUPÉRATION ID DU TYPE ----
$stmtType = $pdo->prepare("SELECT id FROM propertyType WHERE name = :name");
$stmtType->execute([':name' => $propertyTypeName]);
$typeId = $stmtType->fetchColumn();

if (!$typeId) {
    die("Type de bien introuvable.");
}

// ---- NOMBRE TOTAL D’ANNONCES ----
$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM listing WHERE property_type_id = :typeId");
$stmtCount->execute([':typeId' => $typeId]);
$totalItems = $stmtCount->fetchColumn();

$totalPages = ceil($totalItems / $itemsPerPage);
if ($page > $totalPages && $totalPages > 0) {
    header("Location: ?page=1");
    exit;
}

// ---- CALCUL OFFSET ----
$offset = ($page - 1) * $itemsPerPage;

// ---- RÉCUPÉRATION DES ANNONCES ----
$stmt = $pdo->prepare("
    SELECT * 
    FROM listing 
    WHERE property_type_id = :typeId
    ORDER BY created_at DESC
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':typeId', $typeId, PDO::PARAM_INT);
$stmt->bindValue(':limit', $itemsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Maisons à vendre / louer</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Liste des maisons</h1>

    <div class="listing-container">
        <?php if (empty($listings)): ?>
            <p>Aucune annonce trouvée.</p>
        <?php else: ?>
            <?php foreach ($listings as $listing): ?>
                <div class="listing-card">
                    <img src="<?= $listing['image_url'] ?>" alt="Image">
                    <h3><?= $listing['title'] ?></h3>
                    <p><?= $listing['city'] ?> - <?= number_format($listing['price'], 0, ',', ' ') ?> €</p>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php
                            // Vérifier si cette annonce est déjà en favoris pour l'utilisateur
                            $stmtFav = $pdo->prepare("SELECT COUNT(*) FROM favorite WHERE user_id = :user_id AND listing_id = :listing_id");
                            $stmtFav->execute(['user_id' => $_SESSION['user']['id'], 'listing_id' => $listing['id']]);
                            $isFavorite = $stmtFav->fetchColumn() > 0;
                        ?>

                        <?php if (!$isFavorite): ?>
                            <form method="post" action="add_favorite.php" style="display:inline;">
                                <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                <button type="submit">Ajouter aux favoris</button>
                            </form>
                        <?php else: ?>
                            <form method="post" action="remove_favorite.php" style="display:inline;">
                                <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                <button type="submit">Retirer des favoris</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>
                    <br>       
                    <?php if (isset($_SESSION['user']) && 
                    ($_SESSION['user']['id'] === $listing['user_id'] || $_SESSION['user']['role'] === 'admin')): ?>
                        <a href="edit.php?id=<?= $listing['id'] ?>">Modifier </a>
                        <br> 
                        <a href="delete.php?id=<?= $listing['id'] ?>"> Supprimer</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- PAGINATION -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>">&laquo; Précédent</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="active"><?= $i ?></span>
            <?php else: ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>">Suivant &raquo;</a>
        <?php endif; ?>
    </div>
    

</body>
</html>

