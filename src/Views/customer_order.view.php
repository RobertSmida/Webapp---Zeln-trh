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
                    <th>Hodnotenie</th>
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
                        <?php if ($order['status'] === 'settled' && !$order['reviewed']): ?>
                            <form method="post">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <input type="hidden" name="product_id" value="<?= $order['product_id'] ?>">
                                <button type="submit" name="submit_review" value="1" class="btn btn-sm btn-outline-primary">1</button>
                                <button type="submit" name="submit_review" value="2" class="btn btn-sm btn-outline-primary">2</button>
                                <button type="submit" name="submit_review" value="3" class="btn btn-sm btn-outline-primary">3</button>
                                <button type="submit" name="submit_review" value="4" class="btn btn-sm btn-outline-primary">4</button>
                                <button type="submit" name="submit_review" value="5" class="btn btn-sm btn-outline-primary">5</button>
                            </form>

                            <?php elseif ($order['reviewed']): ?>
                                Hodnotenie odoslané
                            <?php else: ?>
                                -
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
