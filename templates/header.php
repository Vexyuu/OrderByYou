<?php
require_once './config/database.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrderByYou - Votre Boutique en Ligne</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<header class="glass-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a href="index.php?pages=home" class="navbar-brand">
                <img src="./assets/img/OrderByYou.png" alt="Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?pages=home">Accueil</a></li>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?pages=dashboard&users" style="color:rgb(212, 44, 44)">Dashboard</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?pages=cart">Panier</a></li>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link btn-register" href="index.php?pages=register">Inscription</a></li>
                        <li class="nav-item"><a class="nav-link btn-login" href="index.php?pages=login">Connexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?pages=profil">Profil</a></li>
                        <li class="nav-item"><a class="nav-link btn-logout" href="index.php?pages=logout">Déconnexion</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="profil-name">
        <img src="./assets/img/profil.png" width="60px" alt="logo profil"><br>
        <strong><?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Invité'; ?></strong>
       
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    // Changer la navigation de style lors du scroll (y > 200)
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            document.querySelector('.glass-header').classList.add('scrolled');
            } else {
                document.querySelector('.glass-header').classList.remove('scrolled');
            }
    });
</script>
</html>

