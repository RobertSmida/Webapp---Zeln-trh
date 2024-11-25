<!DOCTYPE html>
<html>
<head>
    <title>Moje samozbery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-buttons {
            margin-top: 20px;
        }
        .participant-list {
            max-height: 100px;
            overflow-y: auto;
        }
        .participant-list li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Moje samozbery</h1>
    <a href="index.php?page=dashboard" class="btn btn-outline-primary top-buttons">Späť na Dashboard</a>

    <?php if (empty($harvest_events)): ?>
        <p>Nemáte žiadne samozbery.</p>
    <?php else: ?>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Názov</th>
                    <th>Lokalita</th>
                    <th>Začiatok</th>
                    <th>Koniec</th>
                    <th>Kapacita</th>
                    <th>Počet účastníkov</th>
                    <th>Účastníci</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($harvest_events as $event): ?>
                    <tr>
                        <td><?= htmlspecialchars($event['name']) ?></td>
                        <td><?= htmlspecialchars($event['location']) ?></td>
                        <td><?= htmlspecialchars($event['start_date']) ?></td>
                        <td><?= htmlspecialchars($event['end_date']) ?></td>
                        <td><?= htmlspecialchars($event['max_capacity']) ?></td>
                        <td><?= htmlspecialchars($event['participant_count']) ?>/<?= htmlspecialchars($event['max_capacity']) ?></td>
                        <td>
                            <?php if (!empty($event['participants'])): ?>
                                <ul class="participant-list">
                                    <?php foreach ($event['participants'] as $participant): ?>
                                        <li><?= htmlspecialchars($participant) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                Žiadni účastníci
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
