<?php
require_once 'includes/config.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5 text-center">
  <h2 class="mb-4">Thank You for Your Order!</h2>
  <p>Your order has been placed successfully. We appreciate your business!</p>
  <a href="category_rings.php" class="btn btn-primary mt-3">Continue Shopping</a>
</div>
</body>
</html>