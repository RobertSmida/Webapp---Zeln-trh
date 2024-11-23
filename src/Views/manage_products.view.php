<!DOCTYPE html>
<html>
<head>
    <div class="top-buttons">
        <a href="index.php?page=dashboard&role=<?= $_SESSION['user_role'] ?>" class="btn btn-primary">Späť na Dashboard</a>
    </div>
    <title>Spravovať ponuku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Spravovať ponuku</h1>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <h2 class="h5">Moje produkty</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Cena/Kg (€)</th>
                    <th>Dostupné množstvo (Kg)</th>
                    <th>Hodnotenie (počet)</th>
                    <th>Úpravy</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['price_per_unit']) ?></td>
                        <td><?= htmlspecialchars($product['available_quantity']) ?></td>
                        <td><?= htmlspecialchars($product['average_rating']) ?> (<?= htmlspecialchars($product['number_of_reviews']) ?>)</td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Vymazať</button>
                            </form>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Názov" class="form-control form-control-sm d-inline-block w-auto">
                                <input type="number" name="price_per_unit" value="<?= htmlspecialchars($product['price_per_unit']) ?>" step="0.01" placeholder="Cena/Kg (€)" class="form-control form-control-sm d-inline-block w-auto">
                                <input type="number" name="available_quantity" value="<?= htmlspecialchars($product['available_quantity']) ?>" placeholder="Dostupné množstvo (Kg)" class="form-control form-control-sm d-inline-block w-auto">
                                <button type="submit" name="update_product" class="btn btn-primary btn-sm">Upraviť</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="h5 mt-4">Pridať nový produkt</h2>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Názov produktu</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price_per_unit" class="form-label">Cena (€)</label>
                <input type="number" id="price_per_unit" name="price_per_unit" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="available_quantity" class="form-label">Množstvo</label>
                <input type="number" id="available_quantity" name="available_quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Podkategória</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <option value="">-- Vyberte podkategóriu --</option>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option value="<?= htmlspecialchars($subcategory['id']) ?>"><?= htmlspecialchars($subcategory['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="create_product" class="btn btn-success">Pridať produkt</button>
        </form>
    </div>
</body>
</html>
