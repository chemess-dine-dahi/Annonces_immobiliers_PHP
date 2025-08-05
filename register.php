<?php 
session_start();
$errors = [];
if(empty($_POST['email'])){
    $errors[]= "L'email est obligatoire";
}

if(empty($_POST['password'])){
    $errors[]= "Le mot de passe est obligatoire";
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un compte sur Find My Dream Home</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; }
        .login-container {
            width: 300px; margin: 100px auto; padding: 20px;
            background: #fff; border-radius: 8px; box-shadow: 0 0 10px #ccc;
        }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;
        }
        h2 {
            display : flex;
            justify-content: center;}
        input[type="submit"] {
            width: 100%; padding: 10px; background: #007bff; color: #fff; border: none; border-radius: 4px;
            cursor: pointer;
        }
        .error { color: red; }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
        <label for="password">Confirmer mot de passe</label>
        <input type="password" id="password" name="password" required>
        <input type="submit" value="S'inscrire">
    </form>
    <p>
        Déjà inscrit ? <a href="login.php">Connectez-vous</a>
    </p>
</div>
</body>
</html>
