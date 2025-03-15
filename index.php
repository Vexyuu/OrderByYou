<?php
session_start();

require_once './config/database.php';
include './templates/header.php';

// Liste des pages autorisées pour plus de sécurité (whitelist)
$allowedPages = ['home', 'products', 'cart', 'login', 'register', 'profil', 'logout', 'dashboard'];

// Récupère le paramètre "pages" dans l'URL ou utilise "home" par défaut
$page = isset($_GET['pages']) ? $_GET['pages'] : 'home';

// Valide la page demandée par l'utilisateur
if (in_array($page, $allowedPages)) {
    $pagePath = './pages/' . $page . '.php';
} else {
    $pagePath = './pages/404.php';
}

// Inclut le fichier de la page
include $pagePath;

include './templates/footer.php';
?>