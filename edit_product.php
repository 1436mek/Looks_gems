<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}
if (!isset($_GET['id'])) {
  header('Location: products.php');
  exit;
}
$id = intval($_GET['id']);
$stmt = $conn->prepare('SELECT * FROM products WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$product) {
  header('Location: products.php');
  exit;
}
$categories = $conn->query('SELECT * FROM categories ORDER BY category_name');
$name = $product['name'];
$price = $product['price'];
$stock = $product['stock'];
$material = $product['material'];
$image = $product['image'];
$category_id = $product['category_id'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $material = trim($_POST['material']);
    $category_id = intval($_POST['category_id']);
    $new_image = $_FILES['image']['name'] ?? '';
    $image_tmp = $_FILES['image']['tmp_name'] ?? '';
    if (!$name) $errors[] = 'Product name is required.';
    if ($price <= 0) $errors[] = 'Price must be positive.';
    if ($stock < 0) $errors[] = 'Stock cannot be negative.';
    if (!$material) $errors[] = 'Material is required.';
    if (!$category_id) $errors[] = 'Category is required.';
    if (empty($errors)) {
        if ($new_image) {
            $image_path = '../uploads/' . basename($new_image);
            if (move_uploaded_file($image_tmp, $image_path)) {
                $image = $new_image;
            } else {
                $errors[] = 'Failed to upload image.';
            }
        }
        if (empty($errors)) {
            $stmt = $conn->prepare('UPDATE products SET name=?, price=?, stock=?, material=?, image=?, category_id=? WHERE id=?');
            $stmt->bind_param('sdissii', $name, $price, $stock, $material, $image, $category_id, $id);
            if ($stmt->execute()) {
                header('Location: products.php');
                exit;
            } else {
                $errors[] = 'Failed to update product.';
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product - Admin - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
</head>
<body>
<?php include '../includes/admin_header.php';?>
<div class="container py-5">
  <h2 class="mb-4">Edit Product</h2>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error) echo '<div>' . htmlspecialchars($error) . '</div>'; ?>
    </div>
  <?php endif; ?>
  <form method="post" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm" style="max-width:600px;">
    <div class="mb-3">
      <label class="form-label">Product Name</label>
      <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($name) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Price (₹)</label>
      <input type="number" name="price" class="form-control" step="0.01" required value="<?= htmlspecialchars($price) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Stock</label>
      <input type="number" name="stock" class="form-control" required value="<?= htmlspecialchars($stock) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Material</label>
      <input type="text" name="material" class="form-control" required value="<?= htmlspecialchars($material) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Category</label>
      <select name="category_id" class="form-select" required>
        <option value="">Select Category</option>
        <?php while ($cat = $categories->fetch_assoc()): ?>
          <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $category_id ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Product Image</label>
      <input type="file" name="image" class="form-control" accept="image/*">
      <?php if ($image): ?>
        <img src="../uploads/<?= htmlspecialchars($image) ?>" width="80" class="mt-2 rounded shadow-sm">
      <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Update Product</button>
    <a href="products.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
</body>
</html>
