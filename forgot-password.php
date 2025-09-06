<?php
require_once 'includes/config.php';
$email = '';
$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Dummy: always show success for security
        $success = 'If this email exists, a reset link has been sent.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Looks Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <h2 class="mb-4 text-center">Forgot Password</h2>
                <?php if ($success): ?>
                    <div class="alert alert-success"> <?= htmlspecialchars($success) ?> </div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
                <?php endif; ?>
                <form method="post" novalidate>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email) ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </form>
                <div class="mt-3 text-center">
                    <a href="login.php">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
