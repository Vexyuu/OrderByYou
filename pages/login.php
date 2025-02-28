<?php
// session_start(); // Si ce n'est pas déjà fait dans un fichier commun
require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $dbb->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        // Vérifier si l'utilisateur a un panier en base de données
        $userId = $user['id'];
        $stmt = $dbb->prepare("SELECT product_id, quantity FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        // Initialiser $_SESSION['cart'] avec les produits du panier de la base de données
        $_SESSION['cart'] = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['cart'][$row['product_id']] = $row['quantity'];
        }

        // Rediriger l'utilisateur vers la page d'accueil ou ailleurs
        header('Location: index.php?pages=home');
        exit;
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<h2>Connexion</h2>
<form method="POST" action="index.php?pages=login">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" name="username" id="username" required>
    <br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit">Se connecter</button>
</form>
