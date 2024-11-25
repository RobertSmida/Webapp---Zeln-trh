<!DOCTYPE html>
<html>
<head>
    <title>Spravovať kategórie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E8FFD5;
             }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        
        <h1 class="mb-3">Správa kategórií</h1>
        <a class="btn btn-outline-primary mb-3" href="index.php?page=dashboard" role="button">Späť</a>

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

        <h2 class="h4">Čakajúce kategórie</h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Nadkategória</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($unacceptedCategories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= htmlspecialchars($category['parent_name']) ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                                <button type="submit" name="accept_category" class="btn btn-success btn-sm">Akceptovať</button>
                            </form>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                                <button type="submit" name="reject_category" class="btn btn-danger btn-sm">Odmietnuť</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="h4 mt-5">Akceptované kategórie</h2>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Nadkategória</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            
            <tbody>
                <?php foreach ($acceptedCategories as $category): ?>
                    <tr>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" class="form-control">
                        </td>
                        <td><?= htmlspecialchars($category['parent_name']) ?></td>
                        <td>
                            <button type="submit" name="update_category" class="btn btn-primary btn-sm">Upraviť</button>
                            <button type="submit" name="delete_category" class="btn btn-danger btn-sm">Vymazať</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
