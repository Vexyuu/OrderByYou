<?php
// session_start();

if (!isset($_SESSION['username'])) {
    header('Location: index.php?pages=login');
    exit;
}

?>
<div style="height: 80px;"></div> <!-- Ajuste la hauteur si nécessaire -->
<div class="profile-wrapper">
    <button class="btn btn-primary">M</button>
    <div class="container-profile">
        <h1 class="text-center">Profil</h1>
        <div class="info card p-4 shadow-lg">
            <div class="row align-items-center">
                <!-- Partie gauche : Image + Nom -->
                <div class="col-md-4 text-center">
                    <img src="./assets/img/profil1.png" alt="Image de profil" class="profil-img">
                    <h2 class="mt-2"><?= htmlspecialchars($_SESSION['username']) ?></h2>
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
    <div class="display-orders">
            <?php
            // Récupération des commandes
            $req = $dbb->prepare("SELECT * FROM orders WHERE user_id = :user_id");
            $req->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $req->execute();
            $orders = $req->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <h3 class="text-center mt-3">Historique des commandes</h3>
            <ul class="list-group">
                <?php
                    $i = 0;
                    if (isset($orders) && !empty($orders)) {
                        foreach ($orders as $order) {
                        ?>
                        <li class="list-group-item">
                            Commande n°<?= ++$i ?> - <?= htmlspecialchars($order['status']) ?> - Total : <?= htmlspecialchars($order['total_price']) ?> €
                        </li>
                    <?php }
                    } else {
                        echo '<li class="list-group-item">Aucune commande trouvée</li>';
                    };
                ?>
            </ul>
        </div>
</div>
