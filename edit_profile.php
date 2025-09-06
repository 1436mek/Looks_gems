<?php
require_once 'includes/config.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT name, email, address, profile_image FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $address, $profile_image);
$stmt->fetch();
$stmt->close();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_name = trim($_POST['name']);
    $new_email = trim($_POST['email']);
    $new_address = trim($_POST['address']);
    $new_image = $_FILES['profile_image']['name'] ?? '';
    $image_tmp = $_FILES['profile_image']['tmp_name'] ?? '';
    if (!$new_name) $errors[] = 'Name is required.';
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email.';
    if (empty($errors)) {
        if ($new_image) {
            // Ensure uploads directory exists
            $upload_dir = __DIR__ . '/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $image_path = 'uploads/' . basename($new_image);
            if (move_uploaded_file($image_tmp, $upload_dir . basename($new_image))) {
                $profile_image = basename($new_image);
            } else {
                $errors[] = 'Failed to upload image.';
            }
        }
        if (empty($errors)) {
            $stmt = $conn->prepare('UPDATE users SET name=?, email=?, address=?, profile_image=? WHERE id=?');
            $stmt->bind_param('ssssi', $new_name, $new_email, $new_address, $profile_image, $user_id);
            if ($stmt->execute()) {
                $_SESSION['user_name'] = $new_name;
                $_SESSION['user_email'] = $new_email;
                header('Location: profile.php');
                exit;
            } else {
                $errors[] = 'Failed to update profile.';
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
  <title>Edit Profile - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
  <style>
    .profile-card { max-width: 500px; border-radius: 1.5rem; box-shadow: 0 6px 32px #e6a4b433; background: #fff; }
    .profile-img { width: 120px; height: 120px; object-fit: cover; border-radius: 50%; box-shadow: 0 2px 12px #e6a4b433; }
    .profile-label { color: #B692A6; font-weight: 600; }
    .profile-value { color: #333; font-weight: 500; }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4 text-center">Edit Profile</h2>
  <div class="card p-4 profile-card mx-auto">
    <?php if ($errors): ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $error) echo '<div>' . htmlspecialchars($error) . '</div>'; ?>
      </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="text-center mb-4">
        <img src="<?= $profile_image ? 'uploads/' . htmlspecialchars($profile_image) : 'assets/default_profile.png' ?>" alt="Profile Image" class="profile-img mb-2">
        <div class="mb-2">
          <input type="file" name="profile_image" class="form-control" accept="image/*">
        </div>
      </div>
      <div class="mb-3">
        <label class="profile-label">Name</label>
        <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($name) ?>">
      </div>
      <div class="mb-3">
        <label class="profile-label">Email</label>
        <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($email) ?>">
      </div>
      <div class="mb-3">
        <label class="profile-label">Address</label>
        <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($address) ?></textarea>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-pink flex-grow-1">Save Changes</button>
        <a href="profile.php" class="btn btn-outline-secondary flex-grow-1">Cancel</a>
      </div>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
