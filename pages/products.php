<h2 class="text-center my-4">Résultats :</h2>
<div class="container">
    <div class="row" id="product-container">
        <?php if (isset($result) && !empty($result)): ?>
            <?php foreach ($result as $product): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100">
                        <img class="card-img-top" src="./<?= htmlspecialchars($product['image_path'] ?? 'default.png') ?>" 
                             alt="Image de <?= htmlspecialchars($product['name']) ?>" style="max-height: 400px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($product['brand']) ?></h6>
                            <p class="card-text text-primary fw-bold"><?= htmlspecialchars($product['price']) ?> €</p>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <button class="btn btn-primary mt-auto" data-id="<?= htmlspecialchars($product['id']) ?>"
                                onclick="addToCart(<?= htmlspecialchars($product['id']) ?>, this)">Acheter</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <i class="noProduct text-center">Aucun produit trouvé</i>
        <?php endif; ?>
    </div>
</div>

<script>
var isLoggedIn = <?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>;

function addToCart(productId, buttonElement) {
    if (isLoggedIn) {
        fetch('./pages/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `product_id=${productId}`
        }).then(response => response.text())
          .then(data => {
              alert("Produit ajouté au panier avec succès !");
              console.log(data);
          });
    } else {
        alert("Vous devez être connecté pour ajouter un produit au panier.");
    }
}
</script>
