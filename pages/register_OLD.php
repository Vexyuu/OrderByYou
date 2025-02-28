<?php
require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = trim($_POST['phone']);

    // Vérifier si l'email existe déjà
    $checkStmt = $dbb->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
    $checkStmt->execute();

    if ($checkStmt->fetchColumn() > 0) {
        echo "Cet email est déjà utilisé.";
    } else {
        // Insérer l'utilisateur
        $stmt = $dbb->prepare("INSERT INTO users (username, email, phone, password) VALUES (:username, :email, :phone, :password)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Compte créé avec succès. <a href='index.php?pages=login'>Se connecter</a>";
        } else {
            echo "Une erreur s'est produite lors de l'inscription.";
        }
    }
}
?>

<h2>Inscription</h2>
<form method="POST" action="index.php?pages=register">
    <input type="text" name="username" id="username" placeholder="Nom Prénom" required>
    <br>
    <input type="email" name="email" id="email" placeholder="Email" required>
    <br>
    <input type="password" name="password" id="password" placeholder="Mot de passe" required>
    <br>
    <input type="tel" name="phone" id="phone" placeholder="Téléphone (Optionnel)">
    <br>
    <button type="submit">S'inscrire</button>
</form>

<!-- Ancienne version -->
<!-- <form method="POST" action="index.php?pages=register">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <br>
    <label for="phone">Téléphone :</label>
    <input type="tel" name="phone" id="phone" placeholder="Optionnel">
    <br>
    <button type="submit">S'inscrire</button>
</form> -->
