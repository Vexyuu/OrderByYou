<?php
require_once './config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
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
        $stmt = $dbb->prepare("INSERT INTO users (username, first_name, last_name, email, phone, password) VALUES (:username, :first_name, :last_name, :email, :phone, :password)");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
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
            /* background: linear-gradient(to right, #6a11cb, #2575fc); Dégradé violet -> bleu */
        }
        .form-container {
            min-height: calc(100vh - 70px); /* Ajuste en fonction de la hauteur du header */
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15vh;
            padding: 20px;
        }
        .card {
            padding: 1.5rem;
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
        .row {
            display: flex;
            justify-content: space-between;
        }
        .col {
            flex: 1;
            margin-right: 10px;
        }
        .col:last-child {
            margin-right: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <div class="col-md-5">
            <div class="card">
                <h2 class="text-center text-primary">Création de votre compte</h2>
                <form method="POST" action="index.php?pages=register">
                    <div class="mb-2">
                        <label class="form-label" for="username">Nom d'utilisateur</label>
                        <input class="form-control" type="text" name="username" id="username" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label" for="first_name">Prénom</label>
                            <input class="form-control" type="text" name="first_name" id="first_name" placeholder="Prénom (Optionnel)">
                        </div>
                        <div class="col">
                            <label class="form-label" for="last_name">Nom</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" placeholder="Nom (Optionnel)">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="exemple@gmail.com" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="password">Mot de passe</label>
                        <input class="form-control" type="password" name="password" id="password" placeholder="Mot de passe" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label" for="phone">Téléphone</label>
                        <!-- <input class="form-control" type="tel" name="phone" id="phone" placeholder="00 00 00 00 00 (Optionnel)"> -->
                        <input class="form-control" type="text" name="phone" id="phone" maxlength="14" placeholder="00 00 00 00 00 (Optionnel)">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="check1" required>
                        <label class="form-check-label" for="check1">Accepter les conditions</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    <p class="text-center mt-3">Déjà un compte ? <a href="index.php?pages=login">Se connecter</a></p>

                    <i class="text-muted" style="font-size: 12px;">
                        *La connexion est sécurisée et vos informations ne seront jamais partagées. En cliquant sur "S'inscrire", vous acceptez nos conditions d'utilisation et notre politique de confidentialité.

                    </i>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
document.getElementById("phone").addEventListener("input", function(e) {
    let value = e.target.value.replace(/\D/g, ""); // Supprime tout sauf les chiffres
    let formattedValue = value.match(/.{1,2}/g)?.join(" ") || ""; // Regroupe par 2 chiffres avec des espaces
    e.target.value = formattedValue;
});
</script>
</html>
