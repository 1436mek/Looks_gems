<?php
require_once 'includes/config.php';
$category_id = 4; // Bracelets
$category_name = 'Bracelets';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $category_name ?> - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold"><?= $category_name ?></h2>
  <div class="row g-4">
    <?php
    $sql = "SELECT * FROM products WHERE category_id = $category_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card product-card h-100 border-0 shadow" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
            <div class="position-relative" style="height:260px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top w-100 h-100" alt="<?= htmlspecialchars($row['name']) ?>" style="object-fit:cover;max-height:100%;max-width:100%;border-radius:12px;">
              <form method="post" action="wishlist.php" class="position-absolute top-0 end-0 m-2">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm rounded-circle" title="Add to Wishlist" style="background:#E6A4B4;color:#fff;border:none;box-shadow:0 2px 8px #e6a4b433;">
                  <i class="bi bi-heart"></i>
                </button>
              </form>
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title mb-2" style="color:#E6A4B4;"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text fw-bold mb-2" style="font-size:1.1rem;color:#E6A4B4;">₹<?= number_format($row['price'], 2) ?></p>
              <a href="product.php?id=<?= $row['id'] ?>" class="btn btn-outline-dark btn-sm mb-2">View</a>
              <form method="post" action="cart.php" class="mt-auto">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-bag me-1"></i> Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile;
    else: ?>
      <div class="col-12 text-center text-muted">No Bracelets found.</div>
    <?php endif; ?>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
