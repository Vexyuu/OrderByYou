<?php
// session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php?pages=login');
    exit;
}

// Pour des raisons de sécurité, on ne doit pas afficher l'ID réel de l'utilisateur
// $displayUserId = $_SESSION['user_id'] + rand(1, 1000);
?>

<div class="profil-wrapper">
    <div class="container-profile">
        <h1 class="text-primary text-center">Profil</h1>
        <div class="info card p-4 shadow-lg">
            <div class="row align-items-center">
                <!-- Partie gauche : Image + Nom -->
                <div class="col-md-4 text-center">
                    <img src="./assets/img/profil1.png" alt="Image de profil" class="profil-img">
                    <h2 class="mt-2"><?= htmlspecialchars($_SESSION['user']) ?></h2>
                </div>

                <!-- Partie droite : Infos utilisateur -->
                <div class="col-md-8 profil-details">
                    <p><strong>Email :</strong> <?= htmlspecialchars($_SESSION['user_email']) ?></p>
                    <p><strong>Date de création :</strong> <i><?= htmlspecialchars($_SESSION['user_creation']) ?></i></p>
                    <!-- <p><strong>ID utilisateur :</strong> <?php // htmlspecialchars($displayUserId) ?></p> -->
                    <p><strong>Article(s) au panier :</strong> 
                        <span class="badge bg-primary">
                            <?= isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0 ?>
                        </span>
                    </p>
                    <a href="index.php?pages=logout" class="btn btn-danger mt-3">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>
</div>
