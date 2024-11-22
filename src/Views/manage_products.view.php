<!DOCTYPE html>
<html>
<head>
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
                    <th>Cena (€)</th>
                    <th>Množstvo</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td><?= htmlspecialchars($product['quantity']) ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <button type="submit" name="delete_product" class="btn btn-danger btn-sm">Vymazať</button>
                            </form>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Názov" class="form-control form-control-sm d-inline-block w-auto">
                                <input type="number" name="price" value="<?= htmlspecialchars($product['price']) ?>" step="0.01" placeholder="Cena" class="form-control form-control-sm d-inline-block w-auto">
                                <input type="number" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" placeholder="Množstvo" class="form-control form-control-sm d-inline-block w-auto">
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
                <label for="price" class="form-label">Cena (€)</label>
                <input type="number" id="price" name="price" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Množstvo</label>
                <input type="number" id="quantity" name="quantity" class="form-control" required>
            </div>
            <button type="submit" name="create_product" class="btn btn-success">Pridať produkt</button>
        </form>
    </div>
</body>
</html>
