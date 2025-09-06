<?php
require_once '../includes/config.php';
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$category_name = '';
if ($category_id) {
  $stmt = $conn->prepare('SELECT category_name FROM categories WHERE id = ?');
  $stmt->bind_param('i', $category_id);
  $stmt->execute();
  $stmt->bind_result($category_name);
  $stmt->fetch();
  $stmt->close();
}

// Handle add category
if (isset($_POST['add_category'])) {
  $new_cat = trim($_POST['category_name']);
  if ($new_cat) {
    $stmt = $conn->prepare('INSERT INTO categories (category_name) VALUES (?)');
    $stmt->bind_param('s', $new_cat);
    $stmt->execute();
    $stmt->close();
    header('Location: category.php');
    exit;
  }
}
// Handle delete category
if (isset($_POST['delete_category'])) {
  $del_id = intval($_POST['delete_category']);
  $stmt = $conn->prepare('DELETE FROM categories WHERE id = ?');
  $stmt->bind_param('i', $del_id);
  $stmt->execute();
  $stmt->close();
  header('Location: category.php');
  exit;
}
// Fetch all categories
$all_cats = $conn->query('SELECT * FROM categories ORDER BY id');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $category_name ? htmlspecialchars($category_name) : 'Category' ?> - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>
<div class="container py-5">
  <div class="row mb-4">
    <div class="col-md-7 mx-auto">
      <div class="card border-0 shadow p-4" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
        <h3 class="fw-bold mb-3" style="color:#E6A4B4;">Add New Category</h3>
        <form method="post" class="d-flex gap-2">
          <input type="text" name="category_name" class="form-control" placeholder="Add new category..." required>
          <button type="submit" name="add_category" class="btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-8 mx-auto">
      <div class="card border-0 shadow p-4" style="background:linear-gradient(135deg,#fff8f0 60%,#fadadd 100%);">
        <h3 class="fw-bold mb-3" style="color:#E6A4B4;">All Categories</h3>
        <div class="list-group">
          <?php while ($cat = $all_cats->fetch_assoc()): ?>
            <div class="list-group-item d-flex justify-content-between align-items-center" style="border-radius:8px;">
              <span style="font-size:1.1rem; color:#E6A4B4; font-weight:500;"><?= htmlspecialchars($cat['category_name']) ?></span>
              <form method="post" style="margin:0;">
                <input type="hidden" name="delete_category" value="<?= $cat['id'] ?>">
                <button type="submit" class="btn btn-sm rounded-circle" style="background:#E6A4B4;color:#fff;border:none;box-shadow:0 2px 8px #e6a4b433;" onclick="return confirm('Delete this category?')"><i class="bi bi-trash"></i></button>
              </form>
            </div>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
