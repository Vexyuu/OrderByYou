<?php
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION)) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    echo "<p class='container no-connect-cart-text'>Vous devez être connecté pour ajouter un produit au panier.</p>";
    exit;
}

// Vérifier si un panier est déjà associé à l'utilisateur dans la base de données
if (!isset($_SESSION['cart'])) {
    $userId = $_SESSION['user_id'];

    // Récupérer le panier de l'utilisateur depuis la base de données
    $stmt = $dbb->prepare("SELECT product_id, quantity FROM cart WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    // Initialiser $_SESSION['cart'] avec les produits du panier de la base de données
    $_SESSION['cart'] = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $_SESSION['cart'][$row['product_id']] = $row['quantity'];
    }
}

// Ajouter un produit au panier
if (isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Vérifier si le produit est déjà dans le panier (session)
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    // Si l'utilisateur est connecté, enregistrer l'ajout dans la base de données
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Vérifier si le produit est déjà dans la base de données
        $stmt = $dbb->prepare("SELECT product_id FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Si le produit existe déjà dans la base de données, mettre à jour la quantité
            $stmt = $dbb->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            // Sinon, insérer le produit dans la base de données
            $stmt = $dbb->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $stmt->execute();
        }
    }
    echo "Produit ajouté au panier !";
    exit;
}

// Supprimer un produit du panier ou réduire la quantité
if (isset($_POST['remove_product_id'])) {
    $productId = $_POST['remove_product_id'];

    // Vérifier si le produit existe dans la session
    if (isset($_SESSION['cart'][$productId])) {
        // Réduire la quantité de 1 ou supprimer le produit si la quantité atteint 0
        if ($_SESSION['cart'][$productId] > 1) {
            $_SESSION['cart'][$productId] -= 1;
        } else {
            unset($_SESSION['cart'][$productId]);
        }

        // Supprimer également de la base de données
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Vérifier si le produit est dans le panier en base de données
            $stmt = $dbb->prepare("SELECT * FROM cart WHERE user_id = :user_id AND product_id = :product_id");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Mettre à jour la quantité ou supprimer
                $stmt = $dbb->prepare("UPDATE cart SET quantity = quantity - 1 WHERE user_id = :user_id AND product_id = :product_id");
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->execute();

                // Si la quantité devient 0, supprimer l'élément de la base de données
                $stmt = $dbb->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id AND quantity = 0");
                $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
                $stmt->execute();
            }
        }
    }
    // echo "Produit retiré du panier !";
}
?>
<!-- Afficher le panier -->
<div class="container mt-5">
<h1 class="cart-title-h1 text-center mb-5">Mon Panier</h1>
    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p class='text-center text-muted'>Votre panier est vide.</p>";
    } else {
        // Initialisation du total du panier
        $totalPanier = 0;
        
        echo "<div class='row'>";
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // Récupérer les informations du produit
            $stmt = $dbb->prepare("SELECT name, image_path, price FROM products WHERE id = :product_id");
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                // Sécuriser et afficher les données
                $productName = htmlspecialchars($product['name']);
                $productImage = htmlspecialchars($product['image_path']);
                $productPrice = $product['price'];
                $totalProductPrice = $productPrice * $quantity; // Calcul du prix total pour ce produit
                
                // Ajouter le prix total de ce produit au total global
                $totalPanier += $totalProductPrice;

                echo "<div class='col-md-6 col-lg-3 mb-4'>";
                echo "  <div class='card h-100'>";
                echo "    <img src='./$productImage' alt='$productName' class='card-img-top' style='max-height: 300px; object-fit: cover;'>";
                echo "    <div class='card-body d-flex flex-column'>";
                echo "      <h5 class='card-title'>$productName</h5>";
                echo "      <p class='card-text'>Quantité: $quantity</p>";
                echo "      <p class='card-text text-primary fw-bold'>Prix unitaire: " . number_format($productPrice, 2, ',', ' ') . "€</p>";
                echo "      <p class='card-text text-success fw-bold'>Total: " . number_format($totalProductPrice, 2, ',', ' ') . "€</p>";
                echo "      <form method='POST' action='index.php?pages=cart' class='mt-auto'>";
                echo "          <input type='hidden' name='remove_product_id' value='$productId'>";
                echo "          <button type='submit' class='btn btn-danger'>Retirer 1</button>";
                echo "      </form>";
                echo "    </div>";
                echo "  </div>";
                echo "</div>";
            }
        }
        echo "</div>";

        // Afficher le total du panier
        echo "<h3 class='text-end'>Total du Panier : <span class='text-success'>" . number_format($totalPanier, 2, ',', ' ') . "€</span></h3>";
    }
    ?>
</div>
