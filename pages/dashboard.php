<?php
if (!isset($_SESSION['username']) || $_SESSION['user_role'] !== 'ADMINISTRATEUR') {
    header('Location: index.php?pages=login');
    exit;
}

$users = $orders = $products = [];

if (isset($_GET['users'])) {
    $req = $dbb->prepare("SELECT * FROM users");
    $req->execute();
    $users = $req->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['orders'])) {
    $req = $dbb->prepare("SELECT users.id, users.username, orders.status, orders.total_price, orders.created_at
    FROM users INNER JOIN orders where users.id = orders.user_id");
    $req->execute();
    $orders = $req->fetchAll(PDO::FETCH_ASSOC);
}

if (isset($_GET['products'])) {
    $req = $dbb->prepare("SELECT * FROM products");
    $req->execute();
    $products = $req->fetchAll(PDO::FETCH_ASSOC);
}
?>
<style>
    .container {
        margin-top: 20vh;
        padding: 20px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        color: black;
    }
    .dashboard-links {
        display: flex;
        justify-content: center;
        margin: 5vh 0;
    }

    .dashboard-links a {
        margin: 0 10px;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .dashboard-links a:hover {
        background-color: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10vh 0;
        background: white;
        color: black;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);e
    }

    th, td {
        border: 1px solid #dee2e6;
        padding: 15px;
        text-align: left;
    }

    th {
        background: #343a40;
        color: white;
    }

    tr:nth-child(even) {
        background: #f2f2f2;
    }

    tr:hover {
        background: #e9ecef;
        cursor: default;
    }
</style>

<div class="container">
    <h1 class="text-center mt-5">Dashboard</h1>
    <div class="dashboard-links">
        <a href="index.php?pages=dashboard&users" class="btn btn-primary">Utilisateurs</a>
        <a href="index.php?pages=dashboard&orders" class="btn btn-primary">Commandes</a>
        <a href="index.php?pages=dashboard&products" class="btn btn-primary">Produits</a>
    </div>
</div>

<?php if (isset($_GET['users'])): ?>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Utilisateur</th>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Création</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['first_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['last_name'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone'] ?? '') ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (isset($_GET['orders'])): ?>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Utilisateur</th>
                <th>Statut</th>
                <th>Prix Total</th>
                <th>Création</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><?= htmlspecialchars($order['total_price']) ?></td>
                    <td><?= htmlspecialchars($order['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if (isset($_GET['products'])): ?>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nom</th>
                <th>Marque</th>
                <th>Prix</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['brand']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
