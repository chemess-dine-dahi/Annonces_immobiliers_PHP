<?php
require_once 'bdd.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID manquant.";
    exit;
}

$id = (int) $_GET['id'];

// Récupère l'annonce
$stmt = $pdo->prepare("SELECT * FROM listing WHERE id = ?");
$stmt->execute([$id]);
$annonce = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$annonce) {
    echo "Annonce non trouvée.";
    exit;
}

// Vérifie les droits
if ($_SESSION['user']['role'] !== 'admin' && $_SESSION['user']['id'] !== $annonce['user_id']) {
    echo "Vous n'avez pas le droit de modifier cette annonce.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $description = $_POST['description'];

    $stmt = $pdo->prepare("UPDATE listing SET title = ?, price = ?, city = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $price, $city, $description, $id]);

    header('Location: index.php');
    exit;
}
?>

<!-- Formulaire HTML -->
<h2>Modifier l’annonce</h2>
<form method="post">
    <label>Titre :</label>
    <input type="text" name="title" value="<?= htmlspecialchars($annonce['title']) ?>" required><br>

    <label>Prix :</label>
    <input type="number" name="price" value="<?= $annonce['price'] ?>" required><br>

    <label>Ville :</label>
    <input type="text" name="city" value="<?= htmlspecialchars($annonce['city']) ?>" required><br>

    <label>Description :</label><br>
    <textarea name="description" rows="5"><?= htmlspecialchars($annonce['description']) ?></textarea><br>

    <button type="submit">Enregistrer</button>
</form>
