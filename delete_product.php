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
$stmt = $conn->prepare('DELETE FROM products WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->close();
header('Location: products.php');
exit;
?>
