<!DOCTYPE html>
<html>
<head>
    <title>Správa objednávok</title>
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

    <h1>Správa objednávok</h1>

    <!-- Display Success or Error Messages -->
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
                    <th>Zákazník</th>
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
                        <td><?= htmlspecialchars($order['customer_name']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td>
                            <?php if ($order['status'] === 'pending'): ?>
                                <form method="post" style="margin: 0; display: inline-block;">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <input type="hidden" name="new_status" value="processed">
                                    <button type="submit" name="update_status" class="btn btn-sm btn-success">Potvrdiť</button>
                                </form>
                                <form method="post" style="margin: 0; display: inline-block;">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <input type="hidden" name="new_status" value="cancelled">
                                    <button type="submit" name="update_status" class="btn btn-sm btn-danger">Zrušiť</button>
                                </form>
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
