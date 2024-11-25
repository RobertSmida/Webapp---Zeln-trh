<!DOCTYPE html>
<html>
<head>
    <title>Registrácia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+US+Modern:wght@100..400&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #81B299;
            color: white;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        h1 {
            font-size: 6rem;
            margin-bottom: 60px;
            font-family: 'Playwrite US Modern';
        }
        a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }
        a:hover {
            text-decoration: underline;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        input {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid lightgray;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background-color: green;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkgreen;
        }
        p {
        margin-top: 20px;
        font-size: 1rem;
        }
    </style>
</head>
<body>
    <div>
        <h1>Registrácia</h1>

        <?php if (!empty($errors)): ?>
            
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <a><?= htmlspecialchars($error) ?></a>
                    <br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="name" placeholder="meno" value="<?= htmlspecialchars($name) ?>" required>
            <br>
            <input type="email" name="email" placeholder="email" value="<?= htmlspecialchars($email) ?>" required>
            <br>
            <input type="password" name="password" placeholder="heslo" value="<?= htmlspecialchars($password) ?>" required>
            <br>
            <input type="password" name="confirm_password" placeholder="potvrdiť heslo" value="<?= htmlspecialchars($confirm_password) ?>" required>
            <br>
            <button type="submit">Registrovať sa</button>
        </form>
        
        <p><a href="index.php?page=home">Späť na hlavnú stránku</a></p>
    </div>
</body>
</html>