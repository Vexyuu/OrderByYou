<?php
// index.php
session_start();

require_once './config/database.php';
include './templates/header.php';

// Récupère le paramètre "page" dans l'URL ou utilise "home" par défaut
$page = isset($_GET['pages']) ? $_GET['pages'] : 'home';
// Définit le chemin du fichier à inclure
$pagePath = './pages/' . $page . '.php';

// Vérifie si le fichier existe et l'inclut
if (file_exists($pagePath)) {
    include $pagePath;
} else {
    // Page non trouvée, charge une page d'erreur personnalisée
    include './pages/404.php';
}

// Inclut le footer
include './templates/footer.php';
?>
