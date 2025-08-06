<?php 
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email= trim($_POST['email']);
    $password = $_POST['password'];
    $ConfirmedPassword= $_POST['Confirmedpassword'];
    if(empty($email)){
        $errors[]= "L'email est obligatoire";
    }

    if(empty($password)){
        $errors[]= "Le mot de passe est obligatoire";
    }

    if($ConfirmedPassword !== $password){
        $errors[] = 'Les deux mots de passe ne sont pas similaires';
    }
    if (empty($errors)){
        header("Location: login.php");
        exit();
    }
    
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
    <?php if (isset($errors) && !empty($errors)): ?>
        <?php foreach($errors as $error) : ?>
        
        <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
    <?php endif; ?>
    <form id="registerForm" method="post" action="">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <span class="error" id="emailError"></span>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
        <span class="error" id="passwordError"></span>
        <label for="password">Confirmer mot de passe</label>
        <input type="password" id="confirmPassword" name="Confirmedpassword" required>
        <div class="error" id="confirmPasswordError"></div>
        <input type="submit" id="submit" value="S'inscrire">
    </form>
    <p>
        Déjà inscrit ? <a href="login.php">Connectez-vous</a>
    </p>
</div>
</body>
</html>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');
    let isSubmitted = false;
    form.addEventListener('submit', function (e) {
        
        let isValid = true;
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const button = document.querySelector('button');

        document.querySelectorAll('.error').forEach(el => el.textContent = '');
        document.querySelectorAll('input').forEach(el => el.classList.remove('invalid'));

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            isValid = false;
            email.classList.add('invalid');
            document.getElementById('emailError').textContent = 'Veuillez entrer une adresse email valide.';
        }

        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (!passwordRegex.test(password.value)) {
            isValid = false;
            password.classList.add('invalid');
            document.getElementById('passwordError').textContent = 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.';
        }

        if (password.value !== confirmPassword.value || confirmPassword.value === '') {
            isValid = false;
            confirmPassword.classList.add('invalid');
            document.getElementById('confirmPasswordError').textContent = 'Les mots de passe ne correspondent pas.';
        }

        if (isValid && !isSubmitted) {
            alert('Formulaire validé avec succès !');
            button.disabled = true;
            isSubmitted = true;
            form.submit();
        }
        else{
            e.preventDefault();
        }
    });
});
</script>
