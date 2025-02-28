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

    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc); /* Dégradé violet -> bleu */
        }
        .form-container {
            min-height: calc(100vh - 70px); /* Ajuste en fonction de la hauteur du header */
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
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .logo-container img {
            max-width: 100%;
            /* height: auto; */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container form-container">
    <div class="row justify-content-center align-items-center">
        <!-- Colonne pour le logo -->
        <div class="col-md-4 text-center logo-container">
            <img src="./assets/img/OrderByYou.png" alt="Logo officiel" style="width: 50%;">
        </div>
        <!-- Colonne pour le formulaire -->
        <div class="col-md-6">
            <div class="card">
                <h2 class="text-center text-primary">Inscription</h2>
                <form method="POST" action="index.php?pages=register">
                    <div class="mb-3">
                        <label class="form-label" for="username">Nom d'utilisateur</label>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Nom" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="exemple@gmail.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Mot de passe</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Téléphone</label>
                        <input class="form-control" type="tel" name="phone" id="phone" placeholder="00 00 00 00 00 (Optionnel)">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="check1" required>
                        <label class="form-check-label" for="check1">Accepter les conditions</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
