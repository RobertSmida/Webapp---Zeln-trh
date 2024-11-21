<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Vitajte, <?= htmlspecialchars($user['name']) ?>!</h1>
    <p>Vaša rola: <?= htmlspecialchars($user['role']) ?></p>

    <h2>Možnosti:</h2>
    <ul>
        <?php if ($user['role'] === 'farmer'): ?>
            <li><a href="manage_products.php">Spravovať ponuky</a></li>
            <li><a href="manage_harvest_events.php">Spravovať udalosti samosběru</a></li>
        <?php elseif ($user['role'] === 'customer'): ?>
            <li><a href="browse_products.php">Prehliadať ponuky</a></li>
            <li><a href="view_orders.php">Moje objednávky</a></li>
        <?php elseif ($user['role'] === 'moderator'): ?>
            <li><a href="approve_categories.php">Schváliť návrhy kategórií</a></li>
        <?php elseif ($user['role'] === 'admin'): ?>
            <li><a href="manage_users.php">Spravovať užívateľov</a></li>
        <?php endif; ?>
        <li><a href="index.php?page=profile">Upraviť profil</a></li>
        <li><a href="index.php?page=logout">Odhlásiť sa</a></li>
    </ul>
</body>
</html>