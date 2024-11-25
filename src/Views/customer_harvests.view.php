<!DOCTYPE html>
<html>
<head>
    <title>Samozbery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-buttons {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Samozbery</h1>
    <a href="index.php?page=dashboard" class="btn btn-outline-primary top-buttons">Späť na Dashboard</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" id="message">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" id="message">
            <?= htmlspecialchars($_GET['error']) ?>
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

    <h2>Samozbery, na ktoré ste sa prihlásili</h2>
    <?php if (empty($joined_harvest_events)): ?>
        <p>Nie ste prihlásený na žiadne samozbery.</p>
    <?php else: ?>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Lokalita</th>
                    <th>Začiatok</th>
                    <th>Koniec</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($joined_harvest_events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><?= htmlspecialchars($event['start_date']) ?></td>
                        <td><?= htmlspecialchars($event['end_date']) ?></td>
                        <td>
                            <form method="post" action="index.php?page=customer_harvests">
                                <input type="hidden" name="harvest_event_id" value="<?= $event['id'] ?>">
                                <button type="submit" name="leave_harvest" class="btn btn-danger btn-sm">Odhlásiť sa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Dostupné samozbery</h2>
    <?php if (empty($available_harvest_events)): ?>
        <p>Žiadne dostupné samozbery na prihlásenie.</p>
    <?php else: ?>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Lokalita</th>
                    <th>Začiatok</th>
                    <th>Koniec</th>
                    <th>Kapacita</th>
                    <th>Počet účastníkov</th>
                    <th>Farmár</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($available_harvest_events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><?= htmlspecialchars($event['start_date']) ?></td>
                        <td><?= htmlspecialchars($event['end_date']) ?></td>
                        <td><?= htmlspecialchars($event['max_capacity']) ?></td>
                        <td><?= htmlspecialchars($event['participant_count']) ?>/<?= htmlspecialchars($event['max_capacity']) ?></td>
                        <td>
                            <?php
                            $stmt = $db->prepare("SELECT name FROM users WHERE id = ?");
                            $stmt->execute([$event['farmer_id']]);
                            $farmer = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo htmlspecialchars($farmer['name']);
                            ?>
                        </td>
                        <td>
                            <form method="post" action="index.php?page=customer_harvests">
                                <input type="hidden" name="harvest_event_id" value="<?= $event['id'] ?>">
                                <button type="submit" name="join_harvest" class="btn btn-success btn-sm">Prihlásiť sa</button>
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
