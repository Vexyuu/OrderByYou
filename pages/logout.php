<?php
session_destroy();
header('Location: index.php?pages=home');
exit();
?>
