<!DOCTYPE html>
<html>
<head>
    <title>Upraviť profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #81B299;
            color: white;
            font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            color: black;
            width: 400px;
        }
        .form-container h1 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .form-container input {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid lightgray;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            background-color: green;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }
        .form-container button:hover {
            background-color: darkgreen;
        }
        .form-container .delete-btn {
            background-color: red;
        }
        .form-container .delete-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="top-buttons">
            <a href="index.php?page=dashboard&role=<?= $_SESSION['user_role'] ?>" class="btn btn-outline-primary">Späť</a>
        </div>
        <br></br>

        <h1>Upraviť profil</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="list-group ms-2">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" placeholder="Meno" required>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="Email" required>
            <input type="password" name="current_password" placeholder="Aktuálne heslo">
            <input type="password" name="new_password" placeholder="Nové heslo">
            <input type="password" name="confirm_password" placeholder="Potvrdiť nové heslo">
            
            <button type="submit" name="update_profile">Uložiť zmeny</button>
        </form>

        <form method="post">
            <button type="submit" name="delete_profile" class="delete-btn mt-2">Vymazať profil</button>
        </form>
    </div>
</body>
</html>
