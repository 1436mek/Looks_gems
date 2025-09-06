<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

// Fetch categories for dropdown
$categories = $conn->query('SELECT * FROM categories ORDER BY id ASC');

if (!$categories) {
    die("❌ Category query failed: " . $conn->error);
}
// Initialize variables
$name = $price = $stock = $material = $image = $category_id = $description = '';
$errors = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $material = trim($_POST['material']);
    $category_id = intval($_POST['category_id']);
    $image = $_FILES['image']['name'] ?? '';
    $image_tmp = $_FILES['image']['tmp_name'] ?? '';
    $description = trim($_POST['description']);

    // Validate inputs
    if (!$name) $errors[] = 'Product name is required.';
    if ($price <= 0) $errors[] = 'Price must be positive.';
    if ($stock < 0) $errors[] = 'Stock cannot be negative.';
    if (!$material) $errors[] = 'Material is required.';
    if (!$category_id) $errors[] = 'Category is required.';
    if (!$image) $errors[] = 'Product image is required.';
    if (!$description) $errors[] = 'Description is required.';

    // If no errors, proceed with file upload and database insertion
    if (empty($errors)) {
        $upload_dir = __DIR__ . '/../uploads/';

        // Ensure upload directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!is_writable($upload_dir)) {
            $errors[] = "Upload directory is not writable: " . $upload_dir;
        } else {
            $image_path = $upload_dir . basename($image);
            if (move_uploaded_file($image_tmp, $image_path)) {
                $stmt = $conn->prepare('INSERT INTO products (name, price, stock, material, image, category_id, description) VALUES (?, ?, ?, ?, ?, ?, ?)');
                
                // ✅ Corrected parameter types
                $stmt->bind_param('sdissis', $name, $price, $stock, $material, $image, $category_id, $description);
                
                if ($stmt->execute()) {
                    header('Location: products.php');
                    exit;
                } else {
                    $errors[] = 'Failed to add product: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $errors[] = 'Failed to move uploaded file.';
            }
        }
    }
}

// Fetch categories for dropdown (always fresh before form)
$categories = $conn->query('SELECT * FROM categories ORDER BY category_name');

if (!$categories) {
    die("❌ Category query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product - Admin - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Add New Product</h2>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $error): ?>
        <div><?= htmlspecialchars($error) ?></div>
      <?php endforeach; ?>
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
      <?php $categories = $conn->query('SELECT * FROM categories ORDER BY category_name'); ?>
      <select name="category_id" class="form-select" required>
        <option value="">Select Category</option>
        <?php 
        if ($categories && $categories->num_rows > 0) {
          while ($cat = $categories->fetch_assoc()) {
            echo '<option value="' . $cat['id'] . '" ' . ($cat['id'] == $category_id ? 'selected' : '') . '>' . htmlspecialchars($cat['category_name']) . '</option>';
          }
        } else {
          echo '<option disabled>No categories found in DB</option>';
        }
        ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Product Image</label>
      <input type="file" name="image" class="form-control" accept="image/*" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
    <a href="products.php" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
</body>
</html>
