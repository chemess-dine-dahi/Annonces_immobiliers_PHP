<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin', 'agent'])) {
    $_SESSION['error'] = "Accès refusé. Seuls les agents ou les admins peuvent publier.";
    header('Location: index.php');
    exit;
}

require_once 'bdd.php';
function validateForm($data) {
    $required = ['image', 'titre', 'prix', 'ville', 'description', 'type'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}

function sqlInsert($pdo){
    $property_type_id=1;
    $transaction_type_id = 1;
    if($_POST['property_type_id']==="Appartment"){
        $property_type_id = 2;
    }
    if($_POST['transaction_type_id']==="Sale"){
        $transaction_type_id = 2;
    }

    $stmt = $pdo->prepare("
        INSERT INTO listing (title, description, price, city, image_url, property_type_id, transaction_type_id, user_id, created_at, updated_at)
        VALUES (:title, :description, :price, :city, :image_url, :property_type_id, :transaction_type_id, :user_id, NOW(), NOW())
    ");
    $stmt->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
    $stmt->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
    $stmt->bindValue(':price', $_POST['price'], PDO::PARAM_INT);
    $stmt->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
    $stmt->bindValue(':image_url', $_POST['image_url'], PDO::PARAM_STR);
    $stmt->bindValue(':property_type_id', $property_type_id, PDO::PARAM_INT);
    $stmt->bindValue(':transaction_type_id', $transaction_type_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', 1, PDO::PARAM_INT); // à remplacer par l'utilisateur connecté plus tard

    $stmt->execute();
}
        

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une annonce</title>
    <link rel="stylesheet" href="/styles/stylAdd.css">
</head>
<body>
    <div class="add-form-container">
        <h1>Ajouter une annonce</h1>
        <?php
        $success = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                sqlInsert($pdo);
                $success = "Annonce ajoutée avec succès !";
            } catch (PDOException $e) {
                $error = "Erreur lors de l'ajout : " . $e->getMessage();
            }
        }
        $propertyTypes = $pdo->query("SELECT id, name FROM propertyType")->fetchAll(PDO::FETCH_ASSOC);
        $transactionTypes = $pdo->query("SELECT id, name FROM transactionType")->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (isset($success)) echo "<p style='color: green;'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form name="addForm" action="add.php" method="post" onsubmit="return validateForm();">
            <label for="titre">Titre :</label>
            <input type="text" id="title" name="title" required>

            <label for="type">Property type :</label>
            <select id="type" name="property_type_id" required>
                <option value="">--Choisir--</option>
                <option value="House">House</option>
                <option value="Appartment">Appartment</option>
            </select>

            <label for="image">Image (url) :</label>
            <input type="text" id="image_url" name="image_url" required>

            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="price" required>

            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="city" required>

            <label for="description">Description courte :</label>
            <textarea id="description" name="description" rows="3" required></textarea>

            <label for="type">Type :</label>
            <select id="type" name="transaction_type_id" required>
                <option value="">--Choisir--</option>
                <option value="Rent">Rent</option>
                <option value="Sale">Sale</option>
            </select>

            <button type="submit">Enregistrer</button>
        </form>
        <a class="back-link" href="index.php">&larr; Retour à l’accueil</a>
    </div>
</body>
</html>
