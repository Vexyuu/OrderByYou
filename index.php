<?php
session_start();

require_once './config/database.php';
include './templates/header.php';

// Récupère le paramètre "pages" dans l'URL ou utilise "home" par défaut
$page = isset($_GET['pages']) ? $_GET['pages'] : 'home';
// Définit le chemin du fichier à inclure
$pagePath = './pages/' . $page . '.php';

if (file_exists($pagePath)) {
    include $pagePath;
} else {
    // include './pages/404.php';
}

include './templates/footer.php';
?>
