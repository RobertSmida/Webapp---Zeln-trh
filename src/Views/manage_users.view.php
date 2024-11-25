<!DOCTYPE html>
<html>
<head>
    <title>Správa užívateľov</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #E8FFD5;
             }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4">Správa užívateľov</h1>
        <a href="index.php?page=dashboard" class="btn btn-outline-primary mb-3">Späť</a>

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

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Meno</th>
                    <th>Email</th>
                    <th>Moderátor</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" class="form-control form-control-sm">
                        </td>
                        <td>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="form-control form-control-sm">
                        </td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="moderator" id="moderator-<?= $user['id'] ?>" 
                                <?= $user['moderator'] ? 'checked' : '' ?>>
                            </div>
                        </td>
                        <td>
                            <button type="submit" name="update_user" class="btn btn-primary btn-sm">Upraviť</button>
                            </form>
                            <form method="post" class="d-inline">
                                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                <button type="submit" name="delete_user" class="btn btn-danger btn-sm">Vymazať</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
