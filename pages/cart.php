<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION)) {
    session_start();
}

$message = "";

if (!isset($_SESSION['user_id'])) {
    $message = "<p class='no-cart-text center-text' style='margin: 0 auto'>Vous devez être connecté pour accéder au panier.</p>";
} else {
    $userId = $_SESSION['user_id'];
    $cart = $_SESSION['cart'] ?? [];

    // ----------------------------------------------------------------
    // Récupérer le panier de l'user depuis la DB si non initialisé
    // ----------------------------------------------------------------
    if (empty($cart)) {
        $stmt = $dbb->prepare("SELECT product_id, quantity FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cart[$row['product_id']] = $row['quantity'];
        }
        $_SESSION['cart'] = $cart;
    }

    // ----------------------------------------------------------------
    // Ajouter un produit au panier
    // ----------------------------------------------------------------
    if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        
        $stmt = $dbb->prepare(
            "INSERT INTO cart (user_id, product_id, quantity) 
            VALUES (:user_id, :product_id, :quantity) 
            ON DUPLICATE KEY UPDATE quantity = quantity + :quantity"
        );
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
        
        $_SESSION['cart'] = $cart;
        echo "Produit ajouté au panier !";
        exit;
    }
    // ----------------------------------------------------------------
    // Supprimer un produit par quantité
    // ----------------------------------------------------------------
    if (isset($_POST['remove_product_id'])) {
        $productId = $_POST['remove_product_id'];
        if (isset($cart[$productId])) {
            if ($cart[$productId] > 1) {
                $cart[$productId]--;
                $stmt = $dbb->prepare("UPDATE cart SET quantity = quantity - 1 WHERE user_id = :user_id AND product_id = :product_id");
            } else {
                unset($cart[$productId]);
                $stmt = $dbb->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
            }
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $_SESSION['cart'] = $cart;
        }
    }
    // ----------------------------------------------------------------
    // Supprimer un produit totalement
    // ----------------------------------------------------------------
    if (isset($_POST['remove_product_all_id'])) {
        $productId = $_POST['remove_product_all_id'];
        if (isset($cart[$productId])) {
            $stmt = $dbb->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            unset($cart[$productId]);
            $_SESSION['cart'] = $cart;
        }
    }
}

?>

<div style="height: 90px;"></div>
<!-- Affichage du panier -->
<div class="cart-container container mt-5">
    <?php if (!empty($message)): ?>
        <?= $message ?>
    <?php else: ?>
        <h1 class="cart-title-h1 text-center mb-5">Mon Panier</h1>
        <?php if (empty($cart)): ?>
            <p class="no-cart-text">Votre panier est vide.</p>
        <?php else: ?>
            <?php
            $ids = implode(',', array_keys($cart));
            $stmt = $dbb->prepare("SELECT id, name, image_path, price FROM products WHERE id IN ($ids)");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $totalPanier = 0;
            ?>
            <div class="row">
                <?php foreach ($products as $product):
                    $productId = $product['id'];
                    $quantity = $cart[$productId];
                    $totalProductPrice = $product['price'] * $quantity;
                    $totalPanier += $totalProductPrice;
                ?>
                <div class='col-md-6 col-lg-4 mb-4'>
                    <div class='card h-100'>
                        <img src='./<?= htmlspecialchars($product['image_path']) ?>' alt='<?= htmlspecialchars($product['name']) ?>' class='card-img-top' style='max-height: 300px; object-fit: cover;'>
                        <div class='card-body d-flex flex-column'>
                            <h5 class='card-title'><?= htmlspecialchars($product['name']) ?></h5>
                            <p class='card-text'>Quantité: <?= $quantity ?></p>
                            <p class='card-text text-primary fw-bold'>Prix unitaire: <?= number_format($product['price'], 2, ',', ' ') ?>€</p>
                            <p class='card-text text-success fw-bold'>Total: <?= number_format($totalProductPrice, 2, ',', ' ') ?>€</p>
                            <form method='POST' action='index.php?pages=cart' class='mt-auto'>
                                <input type='hidden' name='remove_product_id' value='<?= $productId ?>'>
                                <button type='submit' class='btn btn-danger'>Retirer 1</button>
                            </form>
                            <form method='POST' action='index.php?pages=cart' class='mt-auto'>
                                <input type='hidden' name='remove_product_all_id' value='<?= $productId ?>'>
                                <button type="submit" class="btn btn-danger-tout">Retirer tout</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <form action="index.php?pages=order" method="POST">
                <input type="hidden" name="total_price" value="<?= $totalPanier ?>">
                <button type="submit" class="btn btn-primary" onclick="OrderValidate()">Commander</button>
            </form>
            <h3 class='text-end'>Total du Panier : <span class='text-success'><?= htmlspecialchars(number_format($totalPanier, 2, ',', ' ')) ?>€</span></h3>
        <?php endif; ?>  
    <?php endif; ?>
</div>

<script>
function OrderValidate() {
    if (confirm("Êtes-vous sûr de vouloir commander ?")) {
        alert("Commande validée !");
    }
}
</script>