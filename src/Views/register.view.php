<!DOCTYPE html>
<html>
<head>
    <title>Registrácia</title>
</head>
<body>
    <h1>Registrácia nového užívateľa</h1>
    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="post">
        <label for="name">Meno:</label>
        <input type="text" name="name" id="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="confirm_password">Potvrdenie hesla:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <br>
        <button type="submit">Registrovať sa</button>
    </form>
    <a href="index.php?page=home">Späť na hlavnú stránku</a>
</body>
</html>