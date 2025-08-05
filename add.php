<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une annonce</title>
    <link rel="stylesheet" href="/styles/stylAdd.css">
<?php
function validateForm($data) {
    $required = ['image', 'titre', 'prix', 'ville', 'description', 'type'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}
?>

</head>
<body>
    <div class="add-form-container">
        <h1>Ajouter une annonce</h1>
        <?php
        $confirmation = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (validateForm($_POST)) {
                $confirmation = 'Annonce enregistrée avec succès !';
            } else {
                echo '<div class="confirmation" style="color:red;">Veuillez remplir tous les champs.</div>';
            }
        }
        if ($confirmation) {
            echo '<div class="confirmation">' . $confirmation . '</div>';
        }
        ?>
        <form name="addForm" action="add.php" method="post" onsubmit="return validateForm();">
            <label for="image">Image (URL) :</label>
            <input type="text" id="image" name="image" required>

            <label for="titre">Titre :</label>
            <input type="text" id="titre" name="titre" required>

            <label for="prix">Prix :</label>
            <input type="number" id="prix" name="prix" min="0" required>

            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" required>

            <label for="description">Description courte :</label>
            <textarea id="description" name="description" rows="3" required></textarea>

            <label for="type">Type :</label>
            <select id="type" name="type" required>
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
