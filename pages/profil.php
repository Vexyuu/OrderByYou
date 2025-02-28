<?php
// session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.php?pages=login');
    exit;
}

echo "<h2>Profil de " . htmlspecialchars($_SESSION['user']) . "</h2>";
echo "<a href='logout.php'>Déconnexion</a>";
