<?php
if (!isset($_SESSION['username']) && $_SESSION['user_role'] === 'admin') {
    header('Location: index.php?pages=login');
    exit;
}

