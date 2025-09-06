<?php
require_once 'includes/config.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$user_id = $_SESSION['user_id'];
$messages = [];

// Add to wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
  $product_id = intval($_POST['product_id']);
  // Check if already in wishlist
  $stmt = $conn->prepare('SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?');
  $stmt->bind_param('ii', $user_id, $product_id);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows == 0) {
    $stmt2 = $conn->prepare('INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)');
    $stmt2->bind_param('ii', $user_id, $product_id);
    $stmt2->execute();
    $stmt2->close();
    $messages[] = 'Product added to wishlist.';
  } else {
    $messages[] = 'Product already in wishlist.';
  }
  $stmt->close();
}

// Remove from wishlist
if (isset($_GET['remove'])) {
  $wish_id = intval($_GET['remove']);
  $stmt = $conn->prepare('DELETE FROM wishlist WHERE id = ? AND user_id = ?');
  $stmt->bind_param('ii', $wish_id, $user_id);
  $stmt->execute();
  $stmt->close();
  $messages[] = 'Item removed from wishlist.';
}

// Fetch wishlist items
$stmt = $conn->prepare('SELECT wishlist.id as wish_id, products.* FROM wishlist JOIN products ON wishlist.product_id = products.id WHERE wishlist.user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$wishlist_items = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Wishlist - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">My Wishlist</h2>
  <?php foreach ($messages as $msg): ?>
    <div class="alert alert-success"> <?= htmlspecialchars($msg) ?> </div>
  <?php endforeach; ?>
  <?php if ($wishlist_items->num_rows > 0): ?>
    <div class="row g-4">
      <?php while ($item = $wishlist_items->fetch_assoc()): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card product-card h-100 border-0 shadow" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
            <div class="position-relative" style="height:260px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
              <img src="uploads/<?= htmlspecialchars($item['image']) ?>" class="card-img-top w-100 h-100" alt="<?= htmlspecialchars($item['name']) ?>" style="object-fit:cover;max-height:100%;max-width:100%;border-radius:12px;">
              <a href="wishlist.php?remove=<?= $item['wish_id'] ?>" class="btn btn-sm rounded-circle position-absolute top-0 end-0 m-2" title="Remove from Wishlist" style="background:#E6A4B4;color:#fff;border:none;box-shadow:0 2px 8px #e6a4b433;" onclick="return confirm('Remove from wishlist?')">
                <i class="bi bi-trash"></i>
              </a>
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title mb-2" style="color:#E6A4B4;"><?= htmlspecialchars($item['name']) ?></h5>
              <p class="card-text fw-bold mb-2" style="font-size:1.1rem;color:#E6A4B4;">₹<?= number_format($item['price'], 2) ?></p>
              <a href="product.php?id=<?= $item['id'] ?>" class="btn btn-outline-dark btn-sm mb-2">View</a>
              <form method="post" action="cart.php" class="mb-2">
                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-bag me-1"></i> Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Your wishlist is empty.</div>
  <?php endif; ?>
</div>
</body>
</html>
