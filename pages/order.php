<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour passer une commande.";
    exit;
}

$userId = $_SESSION['user_id'];
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "Votre panier est vide.";
    exit;
}

// Calcul du total de la commande
$totalPrice = $_POST['total_price'] ?? 0;

// Insérer la commande dans la table orders
$stmt = $dbb->prepare("INSERT INTO orders (user_id, total_price) VALUES (:user_id, :total_price)");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->bindParam(':total_price', $totalPrice, PDO::PARAM_STR);
$stmt->execute();

// Récupérer l'ID de la commande créée
$orderId = $dbb->lastInsertId();

// Insérer les produits dans order_items
foreach ($cart as $productId => $quantity) {
    // Récupérer le prix du produit
    $stmt = $dbb->prepare("SELECT price FROM products WHERE id = :product_id");
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($product) {
        $price = $product['price'];
        $stmt = $dbb->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price) 
            VALUES (:order_id, :product_id, :quantity, :price)"
        );
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->execute();
    }
}

// Vider le panier après la commande
unset($_SESSION['cart']);
$stmt = $dbb->prepare("DELETE FROM cart WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();

echo "Commande validée avec succès !";
header("Location: index.php?pages=home");
exit;
?>
