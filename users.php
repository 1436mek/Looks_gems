<?php
require_once '../includes/config.php';
if (!isset($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}

$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Users - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/theme.css">
</head>
<body>
<?php include '../includes/navbar.php'; ?>
<div class="container py-5">
  <h2 class="mb-4">Manage Users</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Registered At</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
          <td><?= $user['id'] ?></td>
          <td><?= htmlspecialchars($user['name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>
          <td><?= htmlspecialchars($user['role']) ?></td>
          <td><?= $user['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
