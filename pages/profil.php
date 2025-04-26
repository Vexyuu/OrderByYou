<?php
if (!isset($_SESSION['username'])) {
    header('Location: index.php?pages=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])) {
    $newPassword = $_POST['new_password'];

    if (strlen($newPassword) < 8) {
        $error = "Le mot de passe doit contenir au moins 8 caractères.";
    } else {
        // Hashage du mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Mettre à jour le mot de passe dans la base de données
        $sql = "UPDATE users SET password = :password WHERE id = :user_id";
        $stmt = $dbb->prepare($sql);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $success = "Mot de passe changé avec succès.";
        } else {
            $error = "Erreur lors du changement de mot de passe.";
        }
    }
}
?>
<div style="height: 80px;"></div>
<div class="profile-wrapper">
    <div class="container-profile">
        <div class="info card p-4 shadow-lg">
            <div class="row align-items-center">
                <div class="col-md-4 text-center profil-img-container">
                    <img src="./assets/img/profil1.png" alt="Image de profil" class="profil-img">
                    <form method="POST" action="">
                        <p><strong>Nouveau mot de passe</strong></p>
                        <input type="password" class="form-control mt-3" name="new_password" placeholder="Changer le mot de passe" required>
                        <button type="submit" class="btn btn-primary mt-3">Changer le mot de passe</button>
                    </form>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mt-3"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success mt-3"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-8 profil-details">
                    <p><strong>Nom d'utilisateur</strong>
                    <input type="text" class="form-control mt-3" id="profil-name" value="<?= htmlspecialchars($_SESSION['username']) ?>" disabled></p>
                    <div class="row mb-2">
                        <div class="col">
                        <p><strong>Prénom</strong>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($_SESSION['user_firstname'] ?? '') ?>" disabled></p>
                        </div>
                        <div class="col">
                        <p><strong>Nom</strong>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($_SESSION['user_lastname'] ?? '') ?>" disabled></p>
                        </div>
                    </div>
                    <p><strong>Email</strong> 
                    <input type="email" class="form-control mt-3" id="profil-email" value="<?= htmlspecialchars($_SESSION['user_email']) ?>" disabled></p>
                    <p><strong>Téléphone</strong> 
                    <input type="tel" class="form-control mt-3" id="profil-phone" value="<?= htmlspecialchars($_SESSION['user_phone']) ?>" disabled></p>
                    <p><strong>Date de création</strong>
                    <input type="text" class="form-control mt-3" id="profil-creation" value="<?= htmlspecialchars($_SESSION['user_creation']) ?>" disabled></p>
                    <p><strong>Rôle</strong>
                    <input type="text" class="form-control mt-3" id="profil-role" value="<?= htmlspecialchars($_SESSION['user_role']) ?>" disabled></p>
                    <p><strong>Article(s) au panier :</strong> 
                        <span class="badge bg-primary mt-3">
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
