<?php
if (!isset($_SESSION['username']) || $_SESSION['user_role'] !== 'admin') {
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
    $req = $dbb->prepare("SELECT * FROM users INNER JOIN orders where users.id = orders.user_id");
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
    }
    .dashboard-links {
        display: flex;
        justify-content: center;
        margin: 5vh 0;
    }

    .dashboard-links a {
        margin: 0 10px;
    }

    table {
        width: 100%;
        min-height: 40vh;
        border-collapse: collapse;
        margin: 10vh 0;
        background: white;
        color: black;
    }

    th, td {
        border: 1px solid black;
        padding: 10px;
    }

    th {
        background: #f39c12;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    tr:hover {
        background: #f3f3f3;
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
