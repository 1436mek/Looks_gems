<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}
// Fetch all products
$result = $conn->query('SELECT products.*, categories.category_name FROM products LEFT JOIN categories ON products.category_id = categories.id ORDER BY products.id DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Products - Admin - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center fw-bold" style="color:#E6A4B4;letter-spacing:2px;">Manage Products</h2>
  <a href="add_product.php" class="btn btn-primary mb-3">Add New Product</a>
  <div class="row g-4">
    <?php while ($row = $result->fetch_assoc()): ?>
    <div class="col-md-4 col-lg-3">
      <div class="card product-card h-100 border-0 shadow" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
        <div class="position-relative" style="height:260px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
          <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top w-100 h-100" alt="<?= htmlspecialchars($row['name']) ?>" style="object-fit:cover;max-height:100%;max-width:100%;border-radius:12px;">
          <form method="post" action="../wishlist.php" class="position-absolute top-0 end-0 m-2">
            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
            <button type="submit" class="btn btn-sm rounded-circle" title="Add to Wishlist" style="background:#E6A4B4;color:#fff;border:none;box-shadow:0 2px 8px #e6a4b433;">
              <i class="bi bi-heart"></i>
            </button>
          </form>
        </div>
        <div class="card-body d-flex flex-column">
          <h5 class="card-title fw-bold mb-1" style="color:#E6A4B4;"><?= htmlspecialchars($row['name']) ?></h5>
          <span class="badge bg-light text-gold mb-2" style="font-size:1rem;"><?= htmlspecialchars($row['category_name']) ?></span>
          <p class="card-text mb-2" style="font-size:1.1rem;">₹<?= number_format($row['price'], 2) ?></p>
          <p class="mb-2"><small>Stock: <?= $row['stock'] ?> | Material: <?= htmlspecialchars($row['material']) ?></small></p>
          <div class="mt-auto d-flex gap-2">
            <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary w-50"><i class="bi bi-pencil"></i> Edit</a>
            <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger w-50" onclick="return confirm('Delete this product?')"><i class="bi bi-trash"></i> Delete</a>
          </div>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
