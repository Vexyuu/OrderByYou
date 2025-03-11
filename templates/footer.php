<!-- footer.php -->
<footer>
    <div class="container-footer">
        <div></div>

        <div class="footer-links">
            <a href="index.php">Accueil</a>
            <a href="about.php">À propos</a>
            <a href="contact.php">Contact</a>
            <a href="privacy.php">Confidentialité</a>
        </div>
        
        <div class="footer-social">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>

        <p>&copy; <?php echo date('Y'); ?> OrderByYou. Tous droits réservés.</p>
    </div>
</footer>

<!-- Icônes FontAwesome -->
<!-- <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js" crossorigin="anonymous"></script> -->

<style>
    footer {
        background: #222;
        color: white;
        text-align: center;
        padding: 20px 0;
        margin-top: 20px;
    }
    .container {
        width: 80%;
        margin: auto;
    }
    .footer-links a, .footer-social a {
        color: white;
        text-decoration: none;
        margin: 0 10px;
        font-size: 16px;
    }
    .footer-social a {
        font-size: 20px;
    }
    .footer-links a:hover, .footer-social a:hover {
        color: #f39c12;
    }
</style>
