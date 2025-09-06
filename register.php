<?php
require_once 'includes/config.php';

$name = $email = $password = $confirm_password = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name)) {
        $errors[] = 'Full name is required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Passwords do not match.';
    }

    // Check if user already exists
    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = 'User already exists with this email.';
        }
        $stmt->close();
    }

    // Register user
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $name, $email, $hashed_password);
        if ($stmt->execute()) {
            header('Location: login.php');
            exit;
        } else {
            $errors[] = 'Registration failed. Please try again.';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Looks Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/theme.css">
    <style>
      body { background: #fdf6fa; }
      .register-card {
        border-radius: 1.5rem;
        box-shadow: 0 6px 32px #e6a4b433;
        background: #fff;
        border: none;
      }
      .register-title {
        font-family: 'Playfair Display', serif;
        color: #E6A4B4;
        font-weight: 700;
        letter-spacing: 1px;
      }
      .form-label { color: #B692A6; font-weight: 600; }
      .btn-primary {
        background: #E6A4B4;
        border: none;
        border-radius: 2rem;
        font-weight: 700;
        transition: background 0.2s;
      }
      .btn-primary:hover, .btn-primary:focus { background: #B692A6; }
      .card a { color: #B692A6; text-decoration: underline; }
      .card a:hover { color: #E6A4B4; }
      .register-form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        align-items: center;
        justify-content: center;
      }
      .register-form-row .form-group {
        flex: 1 1 200px;
        min-width: 180px;
        margin-bottom: 0;
      }
      @media (max-width: 767px) {
        .register-form-row {
          flex-direction: column;
          gap: 1rem;
        }
      }
    </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card p-4 register-card">
                <h2 class="mb-4 text-center register-title">Create Your Account</h2>
                <?php if ($errors): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error) echo '<div>' . htmlspecialchars($error) . '</div>'; ?>
                    </div>
                <?php endif; ?>
                <form method="post" novalidate>
                  <div class="register-form-row mb-4">
                    <div class="form-group">
                      <label for="name" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($name) ?>">
                    </div>
                    <div class="form-group">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">
                    </div>
                  </div>
                  <div class="register-form-row mb-4">
                    <div class="form-group">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                      <label for="confirm_password" class="form-label">Confirm Password</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="login.php">Already have an account? Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>
