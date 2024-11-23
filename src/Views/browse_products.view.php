<!DOCTYPE html>
<html>
<head>
    <title>Prehliadať produkty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-buttons {
            position: absolute;
            top: 15px;
            left: 15px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="top-buttons">
        <a href="index.php?page=dashboard" class="btn btn-primary">Späť na Dashboard</a>
        <?php if ($current_level != 'main'): ?>
            <a href="<?php
                if ($current_level == 'category') {
                    echo 'index.php?page=browse_products';
                } elseif ($current_level == 'subcategory' && isset($current_category['id'])) {
                    echo 'index.php?page=browse_products&category_id=' . $current_category['id'];
                }
            ?>" class="btn btn-secondary">Späť</a>
        <?php endif; ?>
    </div>
    <br><br>
    <div style="clear: both;"></div>
    
    <div class="container mt-5">

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" id="message">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" id="message">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <script>
            setTimeout(function() {
                var message = document.getElementById('message');
                if (message) {
                    message.style.display = 'none';
                }
            }, 1500); 
        </script>
    </div>

    <?php
    if (isset($current_category)) {
        if ($current_category['id'] == 2) { 
            $others_subcategory_id = 998;
        } elseif ($current_category['id'] == 1) { 
            $others_subcategory_id = 999;
        } else {
            $others_subcategory_id = null;
        }
    }
    ?>

    <?php if ($current_level == 'main'): ?>
        <h1>Prehliadať produkty</h1>
        <br><br>
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
            
        </ul>

    <?php elseif ($current_level == 'subcategory'): ?>
        <?php
        $is_others = ($current_subcategory['id'] == 998 || $current_subcategory['id'] == 999);
        ?>
        <h2>
            <?php if ($is_others): ?>
                <?= htmlspecialchars($current_category['name']) ?> - Others
            <?php else: ?>
                <?= htmlspecialchars($current_subcategory['name']) ?>
            <?php endif; ?>
        </h2>
        
    <?php endif; ?>
    <br><br>
    <h3>Produkty:</h3>
        <?php if (empty($products)): ?>
            <p>Žiadne produkty k zobrazeniu.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Názov</th>
                        <th>Cena/Kg (€)</th>
                        <th>Dostupné množstvo ( Kg )</th>
                        <th>Farmár</th>
                        <th>Hodnotenie (počet)</th>
                        <th>Pridať do košíka</th>
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
                            <td><?= htmlspecialchars($product['average_rating']) ?> (<?= htmlspecialchars($product['number_of_reviews']) ?>)</td>
                            <td>
                                <form method="post" action="index.php?page=add_to_cart" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" name="quantity" value="0.1" class="btn btn-sm btn-primary">+100g</button>
                                    <button type="submit" name="quantity" value="0.5" class="btn btn-sm btn-primary">+500g</button>
                                    <button type="submit" name="quantity" value="1.0" class="btn btn-sm btn-primary">+1000g</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
</div>
</body>
</html>
