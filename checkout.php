<?php
require_once 'includes/config.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
$user_id = $_SESSION['user_id'];
$errors = [];
$success = false;
// Fetch cart items
$stmt = $conn->prepare('SELECT cart.id as cart_id, products.*, cart.quantity FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$cart_items = $stmt->get_result();
$stmt->close();
$total = 0;
foreach ($cart_items as $item) {
  $total += $item['price'] * $item['quantity'];
}
// Handle checkout form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $address = trim($_POST['address'] ?? '');
  $payment = $_POST['payment'] ?? '';
  if (!$address) $errors[] = 'Shipping address is required.';
  if (!$payment) $errors[] = 'Select a payment method.';
  if (empty($errors) && $cart_items->num_rows > 0) {
    // Create order
    $stmt = $conn->prepare('INSERT INTO orders (user_id, total_amount, shipping_address, payment_method, status) VALUES (?, ?, ?, ?, "Pending")');
    $stmt->bind_param('idss', $user_id, $total, $address, $payment);
    if ($stmt->execute()) {
      $order_id = $stmt->insert_id;
      // Insert order items
      foreach ($cart_items as $item) {
        $stmt2 = $conn->prepare('INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)');
        $stmt2->bind_param('iii', $order_id, $item['id'], $item['quantity']);
        $stmt2->execute();
        $stmt2->close();
      }
      // Clear cart
      $conn->query('DELETE FROM cart WHERE user_id = ' . intval($user_id));
      header('Location: order-confirmation.php?id=' . $order_id);
      exit;
    } else {
      $errors[] = 'Failed to place order.';
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Checkout</h2>
  <?php if ($success): ?>
    <div class="alert alert-success">Your order has been placed successfully!</div>
    <a href="orders.php" class="btn btn-pink">View My Orders</a>
  <?php else: ?>
    <?php foreach ($errors as $err): ?>
      <div class="alert alert-danger"> <?= htmlspecialchars($err) ?> </div>
    <?php endforeach; ?>
    <?php if ($cart_items->num_rows > 0): ?>
      <div class="row g-4">
        <div class="col-lg-7">
          <h5 class="mb-3">Shipping Details</h5>
          <form method="post" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
              <label for="address" class="form-label">Shipping Address</label>
              <textarea name="address" id="address" class="form-control" rows="3" required><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Payment Method</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment" id="cod" value="COD" <?= (($_POST['payment'] ?? '') == 'COD') ? 'checked' : '' ?>>
                <label class="form-check-label" for="cod">Cash on Delivery</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment" id="online" value="Online" <?= (($_POST['payment'] ?? '') == 'Online') ? 'checked' : '' ?>>
                <label class="form-check-label" for="online">Online Payment</label>
              </div>
            </div>
            <button type="submit" class="btn btn-pink px-4">Place Order</button>
          </form>
        </div>
        <div class="col-lg-5">
          <h5 class="mb-3">Order Summary</h5>
          <div class="card p-3 shadow-sm">
            <?php foreach ($cart_items as $item): ?>
              <div class="d-flex align-items-center mb-2">
                <img src="uploads/<?= htmlspecialchars($item['image']) ?>" width="48" class="rounded me-2">
                <div>
                  <div class="fw-bold"><?= htmlspecialchars($item['name']) ?></div>
                  <div class="small text-muted">Qty: <?= $item['quantity'] ?></div>
                </div>
                <div class="ms-auto">₹<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
              </div>
            <?php endforeach; ?>
            <hr>
            <div class="d-flex justify-content-between fw-bold">
              <span>Total:</span>
              <span>₹<?= number_format($total, 2) ?></span>
            </div>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-info">Your cart is empty. <a href="index.php">Shop now</a></div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
