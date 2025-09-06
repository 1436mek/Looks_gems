<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_GET['id'])) {
    header('Location: orders.php');
    exit;
}
$order_id = intval($_GET['id']);
// Fetch order
$stmt = $conn->prepare('SELECT o.*, u.name as customer_name, u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?');
$stmt->bind_param('i', $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$order) {
    echo '<div class="container py-5"><div class="alert alert-danger">Order not found.</div></div>';
    exit;
}
// Fetch order items
$stmt = $conn->prepare('SELECT order_items.*, products.name, products.image, products.price FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = ?');
$stmt->bind_param('i', $order_id);
$stmt->execute();
$items = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details - Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold" style="color:#E6A4B4;">Order #<?= htmlspecialchars($order['id']) ?> Details</h2>
  <div class="card mb-4 p-4 shadow order-card-premium">
    <div class="row mb-2">
      <div class="col-md-6">
        <p><strong>Status:</strong> <span class="fw-bold text-success"><?= htmlspecialchars($order['status']) ?></span></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($order['date']) ?></p>
        <p><strong>Payment:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?> (<?= htmlspecialchars($order['email']) ?>)</p>
        <p><strong>Shipping Address:</strong><br><?= nl2br(htmlspecialchars($order['shipping_address'])) ?></p>
        <p><strong>Total:</strong> <span class="text-gold fw-bold">₹<?= number_format($order['total_amount'], 2) ?></span></p>
      </div>
    </div>
  </div>
  <h5 class="mb-3">Products in this Order</h5>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Product</th>
          <th>Name</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $item): ?>
        <tr>
          <td><img src="../uploads/<?= htmlspecialchars($item['image']) ?>" width="48" class="rounded"></td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td>₹<?= number_format($item['price'], 2) ?></td>
          <td><?= $item['quantity'] ?></td>
          <td>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <a href="orders.php" class="btn btn-outline-dark mt-3">Back to Orders</a>
</div>
<?php include '../includes/footer.php'; ?>
<style>
.order-card-premium {
  background: linear-gradient(120deg, #ffe0ec 60%, #fff8f0 100%);
  border-radius: 32px;
  box-shadow: 0 8px 32px rgba(230,164,180,0.18), 0 1.5px 8px rgba(250,218,221,0.12);
}
</style>
</body>
</html>
