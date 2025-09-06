<?php
require_once 'includes/config.php';
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$product_id) {
  header('Location: index.php');
  exit;
}
$stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
if (!$product) {
  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($product['name']) ?> - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5">
  <div class="row g-4 justify-content-center">
    <div class="col-md-6">
      <div class="card product-card border-0 shadow" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
        <div class="position-relative" style="height:340px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <img src="uploads/<?= htmlspecialchars($product['image']) ?>" class="w-100 h-100" alt="<?= htmlspecialchars($product['name']) ?>" style="object-fit:cover;max-height:100%;max-width:100%;border-radius:12px;">
          <form method="post" action="wishlist.php" class="position-absolute top-0 end-0 m-2">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" class="btn btn-sm rounded-circle" title="Add to Wishlist" style="background:#E6A4B4;color:#fff;border:none;box-shadow:0 2px 8px #e6a4b433;">
              <i class="bi bi-heart"></i>
            </button>
          </form>
        </div>
        <div class="card-body">
          <h2 class="fw-bold mb-3" style="color:#E6A4B4;letter-spacing:1px;"><?= htmlspecialchars($product['name']) ?></h2>
          <p class="text-gold fw-bold fs-4 mb-3">₹<?= number_format($product['price'], 2) ?></p>
          <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
          <form method="post" action="cart.php" class="mb-3">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-bag me-1"></i> Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
