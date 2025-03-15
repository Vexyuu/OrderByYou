<?php
if (!isset($_SESSION['username'])) {
    header('Location: index.php?pages=login');
    exit;
}
?>
<div style="height: 80px;"></div>
<div class="profile-wrapper">
    <div class="container-profile">
        <div class="info card p-4 shadow-lg">
            <div class="row align-items-center">
                <div class="col-md-4 text-center profil-img-container">
                    <img src="./assets/img/profil1.png" alt="Image de profil" class="profil-img">
                    <p><strong>Ancien mot de passe</strong></p>
                    <input type="password" class="form-control mt-3" id="profil-password" value="XXXXXXXXXX" disabled>
                    <p><strong>Nouveau mot de passe</strong></p>
                    <input type="password" class="form-control mt-3" id="profil-password-new">
                    <button class="btn btn-primary mt-3" id="profil-password-btn">Changer le mot de passe</button>
                </div>
                <div class="col-md-8 profil-details">
                    <p><strong>Nom d'utilisateur</strong>
                    <input type="text" class="form-control mt-3" id="profil-name" value="<?= htmlspecialchars($_SESSION['username']) ?>"></p>
                    <p><strong>Email</strong> 
                    <input type="email" class="form-control mt-3" id="profil-email" value="<?= htmlspecialchars($_SESSION['user_email']) ?>"></p>
                    <p><strong>Téléphone</strong> 
                    <input type="tel" class="form-control mt-3" id="profil-phone" value="<?= htmlspecialchars($_SESSION['user_phone']) ?>"></p>
                    <p><strong>Date de création</strong>
                    <input type="text" class="form-control mt-3" id="profil-creation" value="<?= htmlspecialchars($_SESSION['user_creation']) ?>" disabled></p>
                    <p><strong>Rôle</strong>
                    <input type="text" class="form-control mt-3" id="profil-role" value="<?= htmlspecialchars($_SESSION['user_role']) ?>" disabled></p>
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
        $req = $dbb->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $req->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $req->execute();
        $orders = $req->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h3 class="text-center mt-3">Historique des commandes</h3>
        <ul class="list-group">
            <?php
            if (!empty($orders)) {
                foreach ($orders as $index => $order) {
                    echo '<li class="list-group-item">Commande n°' . ($index + 1) . ' - ' . htmlspecialchars($order['status']) . ' - Total : ' . htmlspecialchars($order['total_price']) . ' €</li>';
                }
            } else {
                echo '<li class="list-group-item">Aucune commande trouvée</li>';
            }
            ?>
        </ul>
    </div>
</div>
