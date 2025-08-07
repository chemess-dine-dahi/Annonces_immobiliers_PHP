<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'bdd.php';
$errors = [];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $email = trim($_POST['email']);
    $password =trim($_POST['password']);

    if(empty($email)){
    $errors[]= "L'email est obligatoire";
    }

    if(empty($password)){
        $errors[]= "Le mot de passe est obligatoire";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email AND password = :password");
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR); // pas de hash ici

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Connexion réussie
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        header('Location: index.php'); // Redirige vers l’accueil
        exit;
    } else {
        $errors[] = "Email ou mot de passe incorrect";
    }
    }
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion à Find My Dream Home</title>
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
    <?php if (!empty($errors)): ?>
        <?php foreach ($errors as $err): ?>
            <div class="error"><?= htmlspecialchars($err) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    <form method="post" action="">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Se connecter">
    </form>
    <p>
        Pas encore de compte ? <a href="register.php">Inscrivez-vous</a>
    </p>
</div>
</body>
</html>



