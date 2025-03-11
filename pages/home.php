
<div class="container mt-5">
<h1 class="title-h1 text-center">Filtrer les Produits</h1>
<?php // var_dump($_SESSION); ?>

    <form method="GET" action="index.php" class="row g-3 mb-4">
        <div class="col-md-12">
            <label for="search" class="form-label">Rechercher un produit :</label>
            <input type="text" name="search" id="search" class="form-control" 
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
                placeholder="Entrez le nom du produit...">
        </div>
        <div class="col-md-4">
            <label for="brand" class="form-label">Marque :</label>
            <select name="brand" id="brand" class="form-select">
                <option value="">Toutes</option>
                <option value="samsung" <?= isset($_GET['brand']) && $_GET['brand'] == 'samsung' ? 'selected' : '' ?>>Samsung</option>
                <option value="apple" <?= isset($_GET['brand']) && $_GET['brand'] == 'apple' ? 'selected' : '' ?>>Apple</option>
                <option value="xiaomi" <?= isset($_GET['brand']) && $_GET['brand'] == 'xiaomi' ? 'selected' : '' ?>>Xiaomi</option>
                <option value="huawei" <?= isset($_GET['brand']) && $_GET['brand'] == 'huawei' ? 'selected' : '' ?>>Huawei</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="prix_min" class="form-label">Prix Min :</label>
            <input type="number" name="prix_min" id="prix_min" class="form-control" 
                value="<?= isset($_GET['prix_min']) ? htmlspecialchars($_GET['prix_min']) : '' ?>" min="0">
        </div>

        <div class="col-md-4">
            <label for="prix_max" class="form-label">Prix Max :</label>
            <input type="number" name="prix_max" id="prix_max" class="form-control" 
                value="<?= isset($_GET['prix_max']) ? htmlspecialchars($_GET['prix_max']) : '' ?>" min="0">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Filtrer</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php?pages=home'">Réinitialiser</button>
        </div>
    </form>
</div>

<?php
// Inclure le fichier de filtrage et d'affichage des produits
include './pages/filter.php';
include './pages/products.php';
?>