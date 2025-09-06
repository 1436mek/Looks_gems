<?php require_once 'includes/config.php'; ?>
<?php
// Simple backend for contact form
$success = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name && $email && $message && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // You can replace this with database storage or email sending
        $to = 'support@looksgems.com';
        $mail_subject = "Contact Form: " . ($subject ?: 'No Subject');
        $mail_message = "Name: $name\nEmail: $email\nSubject: $subject\nMessage:\n$message";
        $headers = "From: $email";
        // Uncomment the next line to actually send email (if mail() is configured)
        // $success = mail($to, $mail_subject, $mail_message, $headers);
        $success = true; // Simulate success for now
    } else {
        $error = 'Please fill in all required fields with a valid email.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Looks Gems</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/theme.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container py-5">
  <h1 class="mb-4">Contact Us</h1>
  <p class="lead">We'd love to hear from you! Whether you have a question about our jewellery, your order, or anything else, our team is ready to help.</p>
  <?php if ($success): ?>
    <div class="alert alert-success">Thank you for contacting us! We'll get back to you soon.</div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <div class="row g-5 align-items-center">
    <div class="col-md-6">
      <form action="" method="post" class="bg-light p-4 rounded shadow-sm">
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label for="subject" class="form-label">Subject</label>
          <input type="text" class="form-control" id="subject" name="subject" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>">
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="5" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="btn btn-pink px-4 py-2">Send Message</button>
      </form>
    </div>
    <div class="col-md-6">
      <div class="bg-white p-4 rounded shadow-sm h-100">
        <h5 class="fw-bold text-pink mb-3">Contact Information</h5>
        <p class="mb-2"><i class="bi bi-envelope-fill text-pink me-2"></i> support@looksgems.com</p>
        <p class="mb-2"><i class="bi bi-telephone-fill text-pink me-2"></i> +1 234 567 8901</p>
        <p class="mb-2"><i class="bi bi-geo-alt-fill text-pink me-2"></i> 123 Mumbai, India .</p>
        <hr>
        <h6 class="fw-bold">Customer Care Hours</h6>
        <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
        <hr>
        <h6 class="fw-bold">Follow Us</h6>
        <a href="#" class="text-pink me-3 fs-4"><i class="bi bi-instagram"></i></a>
        <a href="#" class="text-pink me-3 fs-4"><i class="bi bi-facebook"></i></a>
        <a href="#" class="text-pink fs-4"><i class="bi bi-pinterest"></i></a>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Ensure Bootstrap dropdowns work for all menus
  var dropdownToggles = document.querySelectorAll('.dropdown-toggle');
  dropdownToggles.forEach(function(toggle) {
    toggle.addEventListener('click', function(e) {
      e.preventDefault();
      var menu = toggle.nextElementSibling;
      if (menu && menu.classList.contains('dropdown-menu')) {
        menu.classList.toggle('show');
      }
    });
  });
  // Close dropdowns when clicking outside
  document.addEventListener('click', function(e) {
    dropdownToggles.forEach(function(toggle) {
      var menu = toggle.nextElementSibling;
      if (menu && menu.classList.contains('dropdown-menu')) {
        if (!toggle.contains(e.target) && !menu.contains(e.target)) {
          menu.classList.remove('show');
        }
      }
    });
  });
  // Fix offer card buttons
  var offerLinks = [
    { selector: 'a[href="rings.php"]', target: 'category_rings.php' },
    { selector: 'a[href="bracelets.php"]', target: 'category_bracelets.php' },
    { selector: 'a[href="earrings.php"]', target: 'category_earrings.php' },
    { selector: 'a[href="necklaces.php"]', target: 'category_necklaces.php' }
  ];
  offerLinks.forEach(function(link) {
    var btn = document.querySelector(link.selector);
    if (btn) btn.setAttribute('href', link.target);
  });
});
</script>
</body>
</html>