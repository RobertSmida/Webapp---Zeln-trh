<!DOCTYPE html>
<html>
<head>
    <?php if ($current_level == 'others'): ?>
        <a href="index.php?page=browse_products&category_id=<?= $current_category['id'] ?>" class="btn btn-secondary mb-3">Späť</a>
    <?php endif; ?>
    <?php if ($current_level == 'subcategory'): ?>
        <a href="index.php?page=browse_products&category_id=<?= $current_category['id'] ?>" class="btn btn-secondary mb-3">Späť</a>
    <?php endif; ?>
    <?php if ($current_level == 'category'): ?>
        <a href="index.php?page=browse_products" class="btn btn-secondary mb-3">Späť</a>
    <?php endif; ?>
    <title>Prehliadať produkty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-left {
            position: absolute;
            top: 15px;
            right: 15px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    
    <a href="index.php?page=dashboard" class="btn btn-primary top-right">Späť na Dashboard</a>

    <?php if ($current_level == 'main'): ?>
        <h1>Prehliadať produkty</h1>
        <h2>Kategórie:</h2>
        <ul class="list-group">
            <?php foreach ($categories as $category): ?>
                <li class="list-group-item">
                    <a href="index.php?page=browse_products&category_id=<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php elseif ($current_level == 'category'): ?>
        <h2><?= htmlspecialchars($current_category['name']) ?></h2>

        <h3>Podkategórie:</h3>
        <ul class="list-group">
            <?php foreach ($subcategories as $subcategory): ?>
                <li class="list-group-item">
                    <a href="index.php?page=browse_products&subcategory_id=<?= $subcategory['id'] ?>">
                        <?= htmlspecialchars($subcategory['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
            <li class="list-group-item">
                <a href="index.php?page=browse_products&category_id=<?= $current_category['id'] ?>&others=1">Others</a>
            </li>
        </ul>

    <?php elseif ($current_level == 'subcategory'): ?>
        <h2><?= htmlspecialchars($current_subcategory['name']) ?></h2>
    <?php endif; ?>

    <h3>Produkty:</h3>
    <?php if (empty($products)): ?>
        <p>Žiadne produkty k zobrazeniu.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Cena/Kg (€)</th>
                    <th>Dostupné množstvo</th>
                    <th>Farmár</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['price_per_unit']) ?></td>
                        <td><?= htmlspecialchars($product['available_quantity']) ?></td>
                        <td>
                            <?php
                            $stmt = $db->prepare("SELECT name FROM users WHERE id = ?");
                            $stmt->execute([$product['farmer_id']]);
                            $farmer = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo htmlspecialchars($farmer['name']);
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <?php if ($current_level == 'others'): ?>
        <h2><?= htmlspecialchars($current_category['name']) ?> - Others</h2>
    <?php endif; ?>

</div>
</body>
</html>
