<?php
try {
    global $dbb;

    if (!isset($dbb)) {
        echo "Erreur : connexion à la base de données non initialisée.";
        return [];
    }

    // Initialisation des variables de filtrage
    $marque = isset($_GET['brand']) ? $_GET['brand'] : '';
    $prix_min = isset($_GET['prix_min']) ? (float)$_GET['prix_min'] : 0;
    $prix_max = isset($_GET['prix_max']) ? (float)$_GET['prix_max'] : 999999;

    // Construction de la requête SQL
    $sql = "SELECT * FROM products WHERE 1=1";
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
