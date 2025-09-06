<?php
require_once '../includes/config.php';
// This file is no longer needed. Admins and users can log in from the main login.php page.
header('Location: ../login.php');
exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Looks Gems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 shadow-sm">
                <h2 class="mb-4 text-center">Admin Login</h2>
                <p class="text-center">You are being redirected to the main login page.</p>
            </div>
        </div>
    </div>
</div>
</body>
</html>
