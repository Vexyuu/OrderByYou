# OrderByYou

OrderByYou est un site E-commerce permettant aux utilisateurs de consulter et d’acheter des produits en ligne. Ce projet vise à offrir une expérience utilisateur fluide et intuitive, tout en mettant en avant les fonctionnalités essentielles d'un site de commerce moderne.

## Fonctionnalités principales

- **Affichage des marques et catégories :**
  Les utilisateurs peuvent parcourir une liste de marques et de catégories disponibles, et afficher les produits associés.

- **Gestion des produits :**
  Les produits sont affichés dynamiquement à partir d'une base de données MySQL, avec des informations mises à jour en temps réel.

- **Système de panier :**
  Les utilisateurs peuvent ajouter des produits à leur panier et consulter un récapitulatif avant de passer commande.

- **Authentification utilisateur :**
  Un système de connexion et d'inscription permet aux utilisateurs de créer un compte et de gérer leurs commandes.

- **Compte administrateur :**
  Un compte administrateur est disponible avec les identifiants suivants :
  - **Nom d'utilisateur :** admin
  - **Mot de passe :** admin

## Technologies utilisées

- **Frontend :**
  - HTML, CSS, JavaScript pour une interface utilisateur moderne et réactive.

- **Backend :**
  - PHP pour la gestion des requêtes serveur et la logique métier.

- **Base de données :**
  - MySQL pour stocker les informations sur les utilisateurs, produits, marques, et commandes.

- **Serveur local :**
  - WampServer pour le développement et les tests locaux.

## Configuration

1. **Installation des dépendances :**
   - Installez WampServer sur votre machine.
   - Importez le fichier `ppe_orderbyyou.sql` fourni dans votre base de données MySQL. Ce fichier contient la structure et les données nécessaires.

2. **Configuration du projet :**
   - Placez les fichiers du projet dans le répertoire `www` de WampServer.

3. **Lancement du projet :**
   - Démarrez WampServer.
   - Accédez à l'application via `http://localhost/OrderByYou/`.

## Structure du projet

- **index.php :**
  Sert de routeur principal et assure une protection de navigation en vérifiant que les pages demandées sont incluses dans un tableau des pages autorisées (allowed pages). Si une page non autorisée est demandée, une redirection ou un message d'erreur est affiché.

- **pages/** :
  Contient toutes les pages nécessaires au fonctionnement du site, telles que les pages de connexion, d'inscription, de panier, etc.

- **CSS/** :
  Contient les fichiers de styles pour la mise en page et le design.

- **JS/** :
  Contient les scripts JavaScript pour les interactions dynamiques.

- **PHP/** :
  Contient les fichiers backend pour la gestion des données et des fonctionnalités (connexion, panier, etc.).

- **config.php :**
  Fichier de configuration pour la connexion à la base de données.

- **assets/** :
  Contient les images et autres ressources statiques.

- **database.sql :**
  Fichier contenant la structure et les données de la base de données.

## Auteur

- **Prénom :** Killian
- **Statut :** Étudiant en BTS SIO
- **Projet E-commerce OrderByYou :** Conçu dans le cadre d’un projet en classe pour explorer les technologies web et bases de données.

## Objectifs futurs

- Intégrer un système de paiement sécurisé.
- Ajouter des notifications pour les commandes.
- Optimiser le site pour les appareils mobiles.
- Ajouter des fonctionnalités avancées comme les avis clients et les recommandations de produits.

---

Pour toute question ou suggestion, n'hésitez pas à me contacter !
