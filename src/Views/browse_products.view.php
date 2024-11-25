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
<div class="container">
    <div class="top-buttons ms-5">
        
        <?php if ($_SESSION['user_role'] !== 'nonreg'): ?>
        <a href="index.php?page=dashboard" class="btn btn-outline-primary">Späť na Dashboard</a>
        <?php else: ?>
        <a href="index.php?page=home" class="btn btn-outline-primary">Späť na prihlásenie</a>
        <?php endif; ?>

    </div>
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

    <style>
        .category-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .category-buttons a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .category-buttons a:hover {
            background-color: #0056b3;
        }
    </style>

    <?php if ($current_level === 'main'): ?>
        <h1>Všetky produkty</h1>
        <br></br>
        <h4>Kategórie:</h4>
        <div class="category-buttons">
            <?php foreach ($categories as $category): ?>
                <a href="index.php?page=browse_products&category_id=<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php elseif ($current_level === 'category'): ?>
        <h1><?= htmlspecialchars($current_category['name']) ?></h1>
        <br></br>
        <h4>Podkategórie:</h4>
        <div class="category-buttons">
            <?php foreach ($subcategories as $subcategory): ?>
                <a href="index.php?page=browse_products&subcategory_id=<?= $subcategory['id'] ?>">
                    <?= htmlspecialchars($subcategory['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($current_level == 'subcategory'): ?>
        <?php
        $is_others = ($current_subcategory['id'] == 998 || $current_subcategory['id'] == 999);
        ?>
        <h1>
            <?php if ($is_others): ?>
                <?= htmlspecialchars($current_category['name']) ?> - Others
            <?php else: ?>
                <?= htmlspecialchars($current_subcategory['name']) ?>
            <?php endif; ?>
        </h1>
    <?php endif; ?>

    <?php if ($current_level != 'main'): ?>
        <a href="<?php
            if ($current_level == 'category') {
                echo 'index.php?page=browse_products';
            } elseif ($current_level == 'subcategory' && isset($current_category['id'])) {
                echo 'index.php?page=browse_products&category_id=' . $current_category['id'];
            }
        ?>" class="btn btn-outline-secondary mt-3">Späť</a>
    <?php endif; ?>

    <br><br>
    <h3>Produkty:</h3>
        <div class="container">
            <div class="float-child"><h5>filter:</h5></div>
            <div class="float-child">
            <form method="get" action="index.php">
                <input type="hidden" name="page" value="browse_products">
                <?php if (isset($category_id)): ?>
                    <input type="hidden" name="category_id" value="<?= htmlspecialchars($category_id) ?>">
                <?php endif; ?>
                <?php if (isset($subcategory_id)): ?>
                    <input type="hidden" name="subcategory_id" value="<?= htmlspecialchars($subcategory_id) ?>">
                <?php endif; ?>
                <select name="sort_by" onchange="this.form.submit()">
                    <option> -- Vyber filter -- </option>
                    <option value="price_asc" <?= isset($_GET['sort_by']) && $_GET['sort_by'] === 'price_asc' ? 'selected' : '' ?>>Cena vzostupne</option>
                    <option value="product_reviews" <?= isset($_GET['sort_by']) && $_GET['sort_by'] === 'product_reviews' ? 'selected' : '' ?>>Hodnotenie produktu</option>
                    <option value="farmer_reviews" <?= isset($_GET['sort_by']) && $_GET['sort_by'] === 'farmer_reviews' ? 'selected' : '' ?>>Hodnotenie farmára</option>
                </select>
            </form>
            </div>
            </div>

            <style>
            .container {
                width: 100%;
            }
            .float-child {
                width: 25%;
                float: left;
            }
            </style>

        <br><br>
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
                        <th>Hodnotenie Farmára</th>
                        <th>Hodnotenie (počet)</th>

                        <?php if ($_SESSION['user_role'] !== 'nonreg'): ?>
                        <th>Pridať do košíka</th>
                        <?php endif; ?>
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
                            <td><?= htmlspecialchars($product['farmer_aggregate_reviews'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($product['average_rating']) ?> (<?= htmlspecialchars($product['number_of_reviews']) ?>)</td>
                            
                            <?php if ($_SESSION['user_role'] !== 'nonreg'): ?>
                            <td>
                                <form method="post" action="index.php?page=add_to_cart" style="display: flex; gap: 5px;">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" name="quantity" value="0.1" class="btn btn-sm btn-primary">+100g</button>
                                    <button type="submit" name="quantity" value="0.5" class="btn btn-sm btn-primary">+500g</button>
                                    <button type="submit" name="quantity" value="1.0" class="btn btn-sm btn-primary">+1000g</button>
                                </form>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
</div>
</body>
</html>
