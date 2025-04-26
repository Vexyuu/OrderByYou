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

// Vérification des stocks avant d'appeler la procédure
foreach ($cart as $productId => $quantity) {
    $stmt = $dbb->prepare("SELECT stock FROM products WHERE id = :product_id");
    $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product || $product['stock'] < $quantity) {
        echo "Stock insuffisant pour le produit ID: $productId.";
        exit;
    }
}

// Appel de la procédure stockée
$orderId = 0; // Variable pour récupérer l'ID de la commande
$stmt = $dbb->prepare("CALL CreateOrder(:userId, :totalPrice, @orderId)");
$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
$stmt->bindParam(':totalPrice', $totalPrice, PDO::PARAM_STR);
$stmt->execute();

// Récupérer l'ID de la commande créée
$orderId = $dbb->query("SELECT @orderId")->fetchColumn();

if ($orderId) {
    echo "Commande validée avec succès !";
    header("Location: index.php?pages=home");
    exit;
} else {
    echo "Une erreur s'est produite lors de la validation de la commande.";
}
?>