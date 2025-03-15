<!-- footer.php -->
<footer>
    <div class="container-footer">

        <div class="footer-links">
            <a href="index.php?pages=home">Accueil</a>
            <a href="index.php?pages=about">À propos</a>
            <a href="index.php?pages=contact">Contact</a>
            <a href="index.php?pages=privacy">Confidentialité</a>
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


<style>
    footer {
        background: #222;
        color: white;
        text-align: center;
        padding: 20px;
        margin-top: 20px;
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
