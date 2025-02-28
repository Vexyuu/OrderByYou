# OrderByYou

OrderByYou est un site E-commerce permettant aux utilisateurs de consulter et d’acheter des produits en ligne. Conçu pour offrir une expérience utilisateur fluide et intuitive, OrderByYou met en avant les fonctionnalités essentielles d'un site de commerce en ligne moderne.

## Fonctionnalités principales

- **Affichage des marques :**
  Les utilisateurs peuvent parcourir une liste de marques disponibles et afficher les produits associés à chaque marque.

- **Gestion des produits :**
  Les produits sont affichés dynamiquement à partir d'une base de données MySQL, permettant une mise à jour rapide et évolutive des informations.

- **Navigation intuitive :**
  Un menu de navigation dynamique, construit en JavaScript, facilite l'exploration des différentes catégories et marques.

## Technologies utilisées

- **Frontend :**

  - HTML, CSS, JavaScript pour une interface utilisateur moderne et réactive.

- **Backend :**

  - PHP pour gérer la logique serveur et communiquer avec la base de données.

- **Base de données :**

  - MySQL (géré via WampServer64) pour stocker les informations sur les marques et les produits.

- **Serveur local :**

  - WampServer pour le développement et les tests locaux.

## Configuration

1. **Installation des dépendances :**

   - Assurez-vous que WampServer est installé sur votre machine.
   - Configurez une base de données MySQL et importez les tables suivantes :
     - `marques`
     - `produit`

2. **Configuration du projet :**

   - Placez les fichiers du projet dans le répertoire `www` de WampServer.
   - Configurez les accès à la base de données dans les fichiers PHP (par exemple, `config.php`).

3. **Lancement du projet :**

   - Démarrez WampServer.
   - Accédez à l'application via `http://localhost/OrderByYou/`.

## Structure du projet

- **index.html :**
  Fichier principal affichant la page d'accueil du site.

- **CSS/** :
  Contient les styles CSS pour la mise en page et le design.

- **JS/** :
  Contient les scripts JavaScript pour la navigation et les interactions dynamiques.

- **PHP/** :
  Contient les fichiers backend pour la gestion des données et des requêtes.

## Auteur

- **Prénom :** Killian
- **Statut :** Étudiant en BTS SIO
- **Projet E-commerce OrderByYou** : Conçu dans le cadre d’un projet personnel pour explorer les technologies du web et de la base de données.

## Objectifs futurs

- Ajouter un système d'authentification pour les utilisateurs.
- Intégrer un panier d'achat fonctionnel.
- Mettre en place un système de paiement sécurisé.
- Améliorer l'interface utilisateur avec des animations et un design adapté aux mobiles.

---

Pour toute question ou suggestion, n'hésitez pas à me contacter !

