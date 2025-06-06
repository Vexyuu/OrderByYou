<?php
try {
    global $dbb;

    if (!isset($dbb)) {
        echo "Erreur : connexion à la base de données non initialisée.";
        return [];
    }

    // Initialisation des variables de filtrage
    $searchValue = isset($_GET['search']) ? trim($_GET['search']) : '';
    $marque = isset($_GET['brand']) ? $_GET['brand'] : '';
    $prix_min = isset($_GET['prix_min']) ? (float)$_GET['prix_min'] : 0;
    $prix_max = isset($_GET['prix_max']) ? (float)$_GET['prix_max'] : 999999;

    // Construction de la requête SQLs
    $sql = "SELECT products.*, categories.name AS category_name FROM products JOIN categories ON categories.id = products.category_id WHERE 1=1";
    
    if ($searchValue) {
        $sql .= " AND products.name LIKE :search";
    }
    if ($marque) {
        $sql .= " AND brand = :marque";
    }
    if ($prix_min > 0) {
        $sql .= " AND price >= :prix_min";
    }
    if ($prix_max > 0) {
        $sql .= " AND price <= :prix_max";
    }

    $stmt = $dbb->prepare($sql);

    if ($searchValue) {
        $stmt->bindValue(':search', "%$searchValue%", PDO::PARAM_STR);
    }
    if ($marque) {
        $stmt->bindParam(':marque', $marque, PDO::PARAM_STR);
    }
    if ($prix_min > 0) {
        $stmt->bindParam(':prix_min', $prix_min, PDO::PARAM_INT);
    }
    if ($prix_max > 0) {
        $stmt->bindParam(':prix_max', $prix_max, PDO::PARAM_INT);
    }

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    return [];
}
?>
