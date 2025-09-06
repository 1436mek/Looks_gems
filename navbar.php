<?php
require_once __DIR__ . '/../includes/config.php';
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['admin_id']);
$categories = [
    ['name' => 'Rings', 'id' => 1, 'file' => 'category_rings.php'],
    ['name' => 'Bracelets', 'id' => 2, 'file' => 'category_bracelets.php'],
    ['name' => 'Earrings', 'id' => 3, 'file' => 'category_earrings.php'],
    ['name' => 'Necklaces', 'id' => 4, 'file' => 'category_necklaces.php'],
];

// Include the appropriate header based on user type
if ($isAdmin) {
    include __DIR__ . '/../includes/admin_header.php';
} elseif ($isLoggedIn) {
    include __DIR__ . '/../includes/user_header.php';
} else {
    include __DIR__ . '/../includes/guest_header.php';
}

// Include the navbar (if needed, based on your structure)
// include __DIR__ . '/../includes/navbar.php';

// // Include the categorybar (if needed for navigation)
// include __DIR__ . '/../includes/categorybar.php';
// 
?>