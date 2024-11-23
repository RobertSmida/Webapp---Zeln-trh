<!DOCTYPE html>
<html>
<head>
    <title>Moje objednávky</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .top-buttons {
            position: absolute;
            top: 15px;
            left: 15px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">

    <div class="top-buttons">
        <a href="index.php?page=dashboard" class="btn btn-primary">Späť na Dashboard</a>
    </div>

    <h1>Moje objednávky</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success" id="success-message">
            <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($orders)): ?>
        <p>Nemáte žiadne objednávky.</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Názov produktu</th>
                    <th>Cena/Kg (€)</th>
                    <th>Množstvo (Kg)</th>
                    <th>Farmár</th>
                    <th>Dátum objednávky</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['price_per_unit']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td><?= htmlspecialchars($order['farmer_name']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td>
                            <?php if ($order['status'] === 'pending' || $order['status'] === 'cancelled'): ?>
                                <?= ucfirst(htmlspecialchars($order['status'])) ?>
                            <?php elseif ($order['status'] === 'processed'): ?>
                                <form method="post" style="margin: 0;">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <button type="submit" name="confirm_delivery" class="btn btn-sm btn-success">
                                        Potvrdiť dodávku
                                    </button>
                                </form>
                            <?php elseif ($order['status'] === 'settled'): ?>
                                Settled
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($order['status'] === 'settled'): ?>
                                <?php if (empty($order['reviewed'])): ?>
                                    <form method="post" style="display: inline;">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <input type="hidden" name="product_id" value="<?= $order['product_id'] ?>">
                                        <?php for ($rating = 1; $rating <= 5; $rating++): ?>
                                            <button type="submit" name="submit_review" value="<?= $rating ?>" class="btn btn-sm btn-outline-primary">
                                                <?= $rating ?>
                                            </button>
                                        <?php endfor; ?>
                                    </form>
                                <?php else: ?>
                                    Hodnotenie odoslané
                                <?php endif; ?>
                            <?php else: ?>
                                <?= ucfirst(htmlspecialchars($order['status'])) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 1500); 
    </script>

</div>
</body>
</html>
