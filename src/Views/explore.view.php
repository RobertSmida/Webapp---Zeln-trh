<!DOCTYPE html>
<html>
<head>
    <title>Prehliadka ponúk</title>
</head>
<body>
    <h1>Ponuka produktov</h1>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <?= htmlspecialchars($product['name']) ?> - <?= htmlspecialchars($product['price_per_unit']) ?> €/kg
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?page=home">Späť na hlavnú stránku</a>
</body>
</html>