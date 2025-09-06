<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}
// Fetch summary stats
$pending_orders = $conn->query("SELECT COUNT(*) as c FROM orders WHERE status = 'Pending'")->fetch_assoc()['c'];
$total_orders = $conn->query("SELECT COUNT(*) as c FROM orders")->fetch_assoc()['c'];
$products = $conn->query('SELECT COUNT(*) as c FROM products')->fetch_assoc()['c'];
// Fetch recent orders (last 5)
$recent_orders = $conn->query('SELECT id, user_id, total_amount, status, date FROM orders ORDER BY date DESC LIMIT 5');
// Fetch top products (by order count)
$top_products = $conn->query('SELECT p.id, p.name, p.image, COUNT(o.id) as order_count FROM products p LEFT JOIN order_items oi ON p.id = oi.product_id LEFT JOIN orders o ON oi.order_id = o.id GROUP BY p.id ORDER BY order_count DESC LIMIT 5');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<div class="container py-5">
  <div class="row mb-5">
    <div class="col-12 text-center">
      <h1 class="fw-bold mb-2" style="color:#E6A4B4;letter-spacing:2px;">Welcome, Admin!</h1>
      <p class="lead" style="color:#4A4A4A;">Here's a quick overview of your jewellery store's performance.</p>
    </div>
  </div>
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card text-center p-4 border-0 shadow product-card" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
        <div class="mb-2"><i class="bi bi-clock-history display-6" style="color:#E6A4B4;"></i></div>
        <h4 class="fw-bold" style="color:#E6A4B4;">Pending Orders</h4>
        <div class="display-5 fw-bold mb-2" style="color:#fff; text-shadow: 0 2px 8px #E6A4B4;"><?= $pending_orders ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center p-4 border-0 shadow product-card" style="background:linear-gradient(135deg,#f4e1b6 60%,#fff8f0 100%);">
        <div class="mb-2"><i class="bi bi-gem display-6" style="color:#E6A4B4;"></i></div>
        <h4 class="fw-bold" style="color:#E6A4B4;">Products</h4>
        <div class="display-5 fw-bold mb-2" style="color:#fff; text-shadow: 0 2px 8px #E6A4B4;"><?= $products ?></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-center p-4 border-0 shadow product-card" style="background:linear-gradient(135deg,#fff8f0 60%,#E6A4B4 100%);">
        <div class="mb-2"><i class="bi bi-bag-heart display-6" style="color:#fff;"></i></div>
        <h4 class="fw-bold" style="color:#fff;">Total Orders</h4>
        <div class="display-5 fw-bold mb-2" style="color:#E6A4B4; text-shadow: 0 2px 8px #fff; background:rgba(255,255,255,0.2); border-radius:8px; padding:8px 0;">
          <?= $total_orders ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-4 mb-4">
    <div class="col-md-6">
      <div class="card h-100 border-0 shadow product-card">
        <div class="card-header bg-light fw-bold">Recent Orders</div>
        <ul class="list-group list-group-flush">
          <?php while ($order = $recent_orders->fetch_assoc()): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span><i class="bi bi-receipt me-2 text-gold"></i>Order #<?= $order['id'] ?> | ₹<?= number_format($order['total_amount'], 2) ?> | <span class="badge bg-success"><?= htmlspecialchars($order['status']) ?></span></span>
              <span class="text-muted small"><i class="bi bi-calendar me-1"></i><?= htmlspecialchars($order['date']) ?></span>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100 border-0 shadow product-card">
        <div class="card-header bg-light fw-bold">Top Products</div>
        <ul class="list-group list-group-flush">
          <?php while ($prod = $top_products->fetch_assoc()): ?>
            <li class="list-group-item d-flex align-items-center">
              <img src="../uploads/<?= htmlspecialchars($prod['image']) ?>" width="40" class="me-2 rounded shadow-sm border">
              <span class="fw-bold me-2" style="color:#E6A4B4;"><?= htmlspecialchars($prod['name']) ?></span>
              <span class="badge bg-primary ms-auto">Ordered <?= $prod['order_count'] ?>x</span>
            </li>
          <?php endwhile; ?>
        </ul>
      </div>
    </div>
  </div>
</div>  
</body>
</html>
