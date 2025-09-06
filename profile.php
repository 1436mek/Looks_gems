<?php
require_once 'includes/config.php';
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT name, email, address, profile_image, created_at FROM users WHERE id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $address, $profile_image, $created_at);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body { background-color: #fffdf8; font-family: 'Playfair Display', serif; }

    /* Profile Header */
    .profile-header {
      background: linear-gradient(120deg, #E6A4B4, #d4af37);
      padding: 3rem 1rem 6rem;
      color: #fff;
      text-align: center;
      position: relative;
    }
    .profile-header::after {
      content: '';
      position: absolute;
      inset: 0;
      background-image: url('assets/sparkle.png'); /* small sparkle transparent image */
      opacity: 0.08;
    }

    /* Profile Card */
    .profile-main-card {
      max-width: 700px;
      margin: -5rem auto 2rem;
      border-radius: 1.5rem;
      box-shadow: 0 8px 40px rgba(0,0,0,0.05);
      background: #fff;
      padding: 2.5rem;
      position: relative;
      z-index: 2;
    }
    .profile-img {
      width: 140px;
      height: 140px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #fff;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      margin-top: -90px;
      background: #fff;
    }
    .profile-title {
      font-weight: 700;
      font-size: 2.2rem;
      margin-top: 1rem;
      color: #d4af37;
    }
    .profile-sub {
      font-size: 1rem;
      color: #a18c76;
    }

    /* Details Section */
    .profile-details {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      margin-top: 2rem;
    }
    .profile-detail {
      flex: 1 1 220px;
      background: #fffaf4;
      border: 1px solid #f4e4d4;
      border-radius: 1rem;
      padding: 1rem 1.2rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      transition: all 0.3s ease;
    }
    .profile-detail:hover {
      background: #fff3e6;
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .profile-detail i {
      color: #d4af37;
      font-size: 1.5rem;
    }
    .profile-label {
      color: #a18c76;
      font-weight: 600;
    }
    .profile-value {
      color: #333;
      font-weight: 500;
      word-break: break-word;
    }

    /* Actions */
    .profile-actions {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
    }
    .btn-gold {
      background: linear-gradient(120deg, #d4af37, #e6c97c);
      color: #fff;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-gold:hover {
      background: linear-gradient(120deg, #c9a131, #d4af37);
      color: #fff;
    }
    .btn-outline-gold {
      border: 2px solid #d4af37;
      color: #d4af37;
      background: transparent;
    }
    .btn-outline-gold:hover {
      background: #d4af37;
      color: #fff;
    }

    @media (max-width: 767px) {
      .profile-details { flex-direction: column; }
      .profile-actions { flex-direction: column; }
    }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<!-- Profile Header -->
<div class="profile-header">
  <h1>My Profile</h1>
  <p class="mb-0">Manage your account, orders & preferences</p>
</div>

<!-- Profile Card -->
<div class="container">
  <div class="profile-main-card text-center">
    <img src="<?= $profile_image ? 'assets/' . htmlspecialchars($profile_image) : 'assets/default_profile.png' ?>" 
         alt="Profile Image" class="profile-img">
    <div class="profile-title"><?= htmlspecialchars($name) ?></div>
    <div class="profile-sub">Looks Gems Member</div>

    <div class="profile-details mt-4 text-start">
      <div class="profile-detail">
        <i class="bi bi-envelope"></i>
        <div>
          <div class="profile-label">Email</div>
          <div class="profile-value"><?= htmlspecialchars($email) ?></div>
        </div>
      </div>
      <div class="profile-detail">
        <i class="bi bi-geo-alt"></i>
        <div>
          <div class="profile-label">Address</div>
          <div class="profile-value"><?= htmlspecialchars($address) ?: 'Not set' ?></div>
        </div>
      </div>
      <div class="profile-detail">
        <i class="bi bi-calendar-heart"></i>
        <div>
          <div class="profile-label">Joined</div>
          <div class="profile-value"><?= date('d M Y', strtotime($created_at)) ?></div>
        </div>
      </div>
    </div>

    <div class="profile-actions">
      <a href="edit_profile.php" class="btn btn-gold flex-grow-1 py-2"><i class="bi bi-pencil me-2"></i>Edit Profile</a>
      <a href="logout.php" class="btn btn-outline-gold flex-grow-1 py-2"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
