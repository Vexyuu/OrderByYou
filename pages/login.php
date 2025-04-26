<?php
// session_start(); // Si ce n'est pas déjà fait dans un fichier commun
require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $dbb->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_firstname'] = $user['first_name'];
        $_SESSION['user_lastname'] = $user['last_name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_phone'] = $user['phone'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_creation'] = $user['created_at'];

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
        header('Location: index.php?pages=home');
        exit;
    } else {
        ?>
        <script>alert("Nom d'utilisateur ou mot de passe incorrect.");</script>
        <?php
    }
}
?>
<style>
        .form-container {
            min-height: calc(100vh - 70px);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
            background-color: white;
        }
        .form-control:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        }

        #displayErrorLog {
            display: block;
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<div class="container form-container">
    <div class="col-md-5">
        <div class="card">
            <h2 class="text-center text-primary">Connexion à votre compte</h2>
            <form method="POST" action="index.php?pages=login">
                <div class="mb-3">
                    <label class="form-label" for="username">Nom d'utilisateur ou email</label>
                    <input class="form-control" type="text" name="username" id="username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Mot de passe</label>
                    <input class="form-control" type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" onclick="LoginTry()">Se connecter</button>
                <p class="text-center mt-3">Pas encore de compte ? <a href="index.php?pages=register">S'inscrire</a></p>
                <p id="displayErrorLog"></p>
            </form>
        </div>
    </div>
</div>