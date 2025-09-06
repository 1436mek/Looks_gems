<link rel="stylesheet" href="css/theme.css">
<nav class="navbar shadow-sm sticky-top" style="background: var(--navbar-bg);">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap py-2">
    <!-- Logo Left -->
    <a class="navbar-brand d-flex align-items-center logo-area me-3" href="dashboard.php" style="color:var(--text-main);font-weight:bold;font-size:1.5rem;">
      <img src="../assets/logo.jpeg" alt="Looks Gems" width="44" height="44" class="me-2" style="padding:4px 8px 4px 0; border-radius:12px; box-shadow:0 2px 8px #e6a4b433; background:#fff;">
      <span style="font-family:'Playfair Display',serif;letter-spacing:1px;">Looks Gems</span>
    </a>
    
    <!-- Center Menu -->
    <div class="d-none d-md-flex align-items-center justify-content-center flex-grow-1 gap-3">
      <a class="nav-link px-3" href="products.php">Products</a>
      <a class="nav-link px-3" href="category.php">Categories</a>
      <a class="nav-link px-3" href="orders.php">Orders</a>
      <a class="nav-link px-3" href="users.php">Users</a>
    </div>
    
    <!-- Icons Right -->
    <div class="d-flex align-items-center gap-2 ms-auto">
      <a class="nav-link px-2 d-flex align-items-center" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a>
    </div>
    
    <!-- Mobile nav -->
    <div class="d-md-none w-100 mt-2">
      <div class="d-flex justify-content-center gap-2 flex-wrap">
        <a class="nav-link px-2" href="products.php">Products</a>
        <a class="nav-link px-2" href="categories.php">Categories</a>
        <a class="nav-link px-2" href="orders.php">Orders</a>
        <a class="nav-link px-2" href="users.php">Users</a>
      </div>
    </div>
  </div>
</nav>
<style>
.navbar .nav-link, .navbar .navbar-brand {
  color: var(--text-main) !important;
  font-size: 1.08rem;
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  transition: color 0.2s;
}
.navbar .nav-link:hover, .navbar .navbar-brand:hover, .navbar .nav-link:focus {
  color: var(--button-bg) !important;
}
.logo-area {
  padding-left: 0.5rem !important;
  padding-right: 1.2rem !important;
}
.logo-area img {
  margin-right: 0.7rem !important;
  padding: 4px 8px 4px 0 !important;
  border-radius: 12px !important;
  background: #fff !important;
  box-shadow: 0 2px 8px #e6a4b433 !important;
}
.navbar .nav-link i {
  vertical-align: middle;
  transition: color 0.2s;
}
@media (max-width: 900px) {
  .navbar .container-fluid {
    flex-direction: column;
    align-items: flex-start !important;
    gap: 0.5rem !important;
  }
  .navbar .d-flex.align-items-center.flex-shrink-0 {
    flex-wrap: wrap;
    gap: 0.5rem !important;
  }
  .navbar .d-flex.align-items-center.ms-auto {
    width: 100%;
    justify-content: flex-end;
  }
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>