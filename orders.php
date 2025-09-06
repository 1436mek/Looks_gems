<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

// Handle status filter and search
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$where = [];
if ($status_filter) {
  $where[] = "o.status = '" . $conn->real_escape_string($status_filter) . "'";
}
if ($search) {
  $search_esc = $conn->real_escape_string($search);
  $where[] = "(o.id LIKE '%$search_esc%' OR u.name LIKE '%$search_esc%')";
}
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$orders = $conn->query("
  SELECT o.id, o.user_id, u.name as customer_name, o.total_amount, o.status, o.date
  FROM orders o
  JOIN users u ON o.user_id = u.id
  $where_sql
  ORDER BY o.date DESC
");

// Handle inline status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
  $oid = intval($_POST['order_id']);
  $new_status = $conn->real_escape_string($_POST['new_status']);
  $conn->query("UPDATE orders SET status='$new_status' WHERE id=$oid");
  header('Location: orders.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
  <style>
    .order-action-btn { border-radius: 8px; font-size: 0.95rem; margin-right: 4px; }
    @media (max-width: 768px) { .table-responsive { font-size: 0.95rem; } }
    .order-card-premium {
      background: linear-gradient(120deg, #ffe0ec 60%, #fff8f0 100%);
      border-radius: 32px;
      box-shadow: 0 8px 32px rgba(230,164,180,0.18), 0 1.5px 8px rgba(250,218,221,0.12);
      transition: box-shadow 0.2s, transform 0.2s;
    }
    .order-card-premium:hover {
      box-shadow: 0 12px 40px rgba(230,164,180,0.22), 0 2px 12px rgba(250,218,221,0.16);
      transform: translateY(-2px) scale(1.01);
    }
    @media (max-width: 768px) {
      .order-card-premium { padding: 1.2rem !important; border-radius: 18px; }
    }
  </style>
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold" style="color:#E6A4B4;letter-spacing:2px;">Manage Orders</h2>
  <div class="card border-0 shadow-lg p-4 mb-4 order-card-premium">
    <form class="row g-3 mb-3" method="get" action="">
      <div class="col-md-3">
        <select name="status" class="form-select rounded-pill">
          <option value="">All Statuses</option>
          <option value="Pending"<?= $status_filter==='Pending'?' selected':'' ?>>Pending</option>
          <option value="Completed"<?= $status_filter==='Completed'?' selected':'' ?>>Completed</option>
          <option value="Cancelled"<?= $status_filter==='Cancelled'?' selected':'' ?>>Cancelled</option>
        </select>
      </div>
      <div class="col-md-6">
        <input type="text" name="search" class="form-control rounded-pill" placeholder="Search by Order ID or Customer" value="<?= htmlspecialchars($search) ?>">
      </div>
      <div class="col-md-3">
        <button type="submit" class="btn btn-pink w-100 rounded-pill">Filter/Search</button>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0" style="background:#fff;border-radius:12px;overflow:hidden;">
        <thead class="table-light">
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total (₹)</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($order = $orders->fetch_assoc()): ?>
            <tr style="border-radius:8px;">
              <td class="fw-bold text-gold">#<?= $order['id'] ?></td>
              <td><?= htmlspecialchars($order['customer_name']) ?></td>
              <td style="color:#E6A4B4;font-weight:600;">₹<?= number_format($order['total_amount'], 2) ?></td>
              <td>
                <form method="post" class="d-inline">
                  <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                  <select name="new_status" class="form-select form-select-sm rounded-pill d-inline w-auto" style="min-width:110px;">
                    <option value="Pending"<?= $order['status']==='Pending'?' selected':'' ?>>Pending</option>
                    <option value="Completed"<?= $order['status']==='Completed'?' selected':'' ?>>Completed</option>
                    <option value="Cancelled"<?= $order['status']==='Cancelled'?' selected':'' ?>>Cancelled</option>
                  </select>
                  <button type="submit" class="btn btn-sm btn-outline-pink order-action-btn">Update</button>
                </form>
                <span class="badge px-3 py-2 rounded-pill bg-<?= $order['status'] === 'Pending' ? 'warning' : ($order['status'] === 'Completed' ? 'success' : 'danger') ?>">
                  <?= htmlspecialchars($order['status']) ?>
                </span>
              </td>
              <td><?= $order['date'] ?></td>
              <td>
                <a href="order_details.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-primary order-action-btn">View</a>
                <a href="edit_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-success order-action-btn">Edit</a>
                <a href="delete_order.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-outline-danger order-action-btn" onclick="return confirm('Delete this order?')">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
