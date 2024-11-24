<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+US+Modern:wght@100..400&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7f8;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px lightgray;
        }
        h1 {
            text-align: center;
            color: #81B299;
            font-family: "Playwrite US Modern";
        }
        .toggle-role {
            margin-bottom: 20px;
            text-align: center;
        }
        select {
            padding: 10px;
            border: 1px solid lightgray;
            border-radius: 5px;
            font-size: 16px;
        }
        ul {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            text-decoration: none;
            color: white;
            background-color: #81B299;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
        }
        a:hover {
            background-color: green;
        }
        .secondary {
            background-color: #de645b;
        }
        .secondary:hover {
            background-color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vitajte, <?= htmlspecialchars($user['name']) ?>!</h1>

        <?php if ($user['role'] !== 'admin'): ?>
        <div class="toggle-role">
            <form method="post" action="index.php?page=dashboard">
                <label for="role">Režim:</label>
                <select name="role" id="role" onchange="this.form.submit()">
                    <option value="farmer" <?= $_SESSION['user_role'] === 'farmer' ? 'selected' : '' ?>>Predaj</option>
                    <option value="customer" <?= $_SESSION['user_role'] === 'customer' ? 'selected' : '' ?>>Nákup</option>
                </select>
            </form>
        </div>
        <?php endif; ?>

        <div class="options">
            <h2>Možnosti:</h2>
            <ul>
                <?php if ($user['role'] === 'farmer'): ?>
                    <li><a href="index.php?page=manage_products">Spravovať ponuku</a></li>
                    <li><a href="index.php?page=farmer_orders">Správa objednávok</a></li>
                    <li><a href="index.php?page=harvest_events">Moje samozbery</a></li>
                    <li><a href="index.php?page=suggest_category">Navrhnúť podkategóriu</a></li>

                <?php elseif ($user['role'] === 'customer'): ?>
                    <li><a href="index.php?page=browse_products">Prehliadať produkty</a></li>
                    <li><a href="index.php?page=customer_orders">Moje objednávky</a></li>

                <?php elseif ($user['role'] === 'admin'): ?>
                    <li><a href="index.php?page=manage_users">Spravovať užívateľov</a></li>
                    
                <?php endif; ?>
                </br>

                <?php if ($user['moderator'] == 1): ?>
                <li><a href="index.php?page=suggestions">Spravovať kategórie</a></li>
                <?php endif; ?>

                <li><a href="index.php?page=profile">Upraviť profil</a></li>
                <li><a href="index.php?page=logout" class="secondary">Odhlásiť sa</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
