<?php
require_once 'bdd.php';

// ---- RÉCUPÉRATION DES TYPES DE BIEN ----
$stmtTypes = $pdo->query("SELECT id, name FROM propertyType ORDER BY name");
$propertyTypes = $stmtTypes->fetchAll(PDO::FETCH_ASSOC);

// ---- RÉCUPÉRATION DES TYPES DE TRANSACTION ----
$stmtTransactions = $pdo->query("SELECT id, name FROM transactionType ORDER BY name");
$transactionTypes = $stmtTransactions->fetchAll(PDO::FETCH_ASSOC);

// ---- FILTRES REÇUS EN GET ----
$ville = $_GET['ville'] ?? '';
$prixMax = $_GET['prix_max'] ?? '';
$typeBien = $_GET['type_bien'] ?? '';
$typeTransaction = $_GET['type_transaction'] ?? '';

// ---- REQUÊTE DE BASE ----
$sql = "SELECT * FROM listing WHERE 1=1";
$params = [];

// ---- AJOUT DES FILTRES SI RENSEIGNÉS ----
if (!empty($ville)) {
    $sql .= " AND city LIKE :ville";
    $params[':ville'] = "%" . $ville . "%";
}

if (!empty($prixMax)) {
    $sql .= " AND price <= :prixMax";
    $params[':prixMax'] = $prixMax;
}

if (!empty($typeBien)) {
    $sql .= " AND property_type_id = :typeBien";
    $params[':typeBien'] = $typeBien;
}

if (!empty($typeTransaction)) {
    $sql .= " AND transaction_type_id = :typeTransaction";
    $params[':typeTransaction'] = $typeTransaction;
}

$sql .= " ORDER BY created_at DESC";

// ---- EXÉCUTION ----
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>






<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche d'annonces</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <h1>Recherche d'annonces</h1>

    <!-- FORMULAIRE DE RECHERCHE -->
    <form method="GET" action="search.php" class="search-form">
        <label for="ville">Ville :</label>
        <input type="text" name="ville" id="ville" value="<?= $ville ?>">

        <label for="prix_max">Prix maximum (€) :</label>
        <input type="number" name="prix_max" id="prix_max" value="<?= $prixMax ?>">

        <label for="type_bien">Type de bien :</label>
        <select name="type_bien" id="type_bien">
            <option value="">-- Tous --</option>
            <?php foreach ($propertyTypes as $type): ?>
                <option value="<?= $type['id'] ?>" <?= ($typeBien == $type['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="type_transaction">Type de transaction :</label>
        <select name="type_transaction" id="type_transaction">
            <option value="">-- Tous --</option>
            <?php foreach ($transactionTypes as $trans): ?>
                <option value="<?= $trans['id'] ?>" <?= ($typeTransaction == $trans['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($trans['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Rechercher</button>
    </form>

    <!-- AFFICHAGE DES ANNONCES -->
    <div class="listing-container">
        <?php if (empty($listings)): ?>
            <p>Aucune annonce trouvée.</p>
        <?php else: ?>
            <?php foreach ($listings as $listing): ?>
                <div class="listing-card">
                    <img src="<?= $listing['image_url'] ?>" alt="Image">
                    <h3><?= $listing['title'] ?></h3>
                    <p><?= $listing['city'] ?> - <?= number_format($listing['price'], 0, ',', ' ') ?> €</p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</body>
</html>
