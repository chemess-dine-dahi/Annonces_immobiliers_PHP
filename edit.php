<?php
session_start();
require_once 'bdd.php';

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
if ($_SESSION['user']['role'] !== 'admin' && !($_SESSION['user']['role'] === 'agent' && $_SESSION['user']['id'] === $annonce['user_id'])) {
    echo "Vous n'avez pas le droit de modifier cette annonce.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $city = $_POST['city'];
    $description = $_POST['description'];
    $currentImage = $annonce['image_url'];
    // Si une nouvelle image est uploadée
    if (!empty($_FILES['image_url']['name'])) {
        $uploadDir = 'upload/'; 
        $fileName = basename($_FILES['image_url']['name']);
        $dest = $uploadDir . time() . '_' . $fileName;
        
        if (move_uploaded_file($_FILES['image_url']['tmp_name'], $des)){
            if (!empty($currentImage) && file_exists($currentImage)) {
                unlink($currentImage);
            }
            $currentImage = $targetFilePath;
        }
    }

    $stmt = $pdo->prepare("UPDATE listing SET title = ?, price = ?, city = ?, description = ?, image_url = ? WHERE id = ?");
    $stmt->execute([$title, $price, $city, $description, $currentImage, $id]);

    header('Location: index.php');
    exit;
}
?>

<!-- Formulaire HTML -->
<h2>Modifier l’annonce</h2>
<form method="post">
    <label>Titre :</label>
    <input type="text" name="title" value="<?= $annonce['title'] ?>" required><br>


    <img src="<?= $annonce['image_url']?>" alt="Image actuelle" style="width:150px;"><br>

    <label>Changer l’image :</label>
    <input type="file" name="image_url"><br>

    <label>Prix :</label>
    <input type="number" name="price" value="<?= $annonce['price'] ?>" required><br>

    <label>Ville :</label>
    <input type="text" name="city" value="<?= htmlspecialchars($annonce['city']) ?>" required><br>

    <label>Description :</label><br>
    <textarea name="description" rows="5"><?= htmlspecialchars($annonce['description']) ?></textarea><br>

    <button type="submit">Enregistrer</button>
</form>
