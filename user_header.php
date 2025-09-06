<link rel="stylesheet" href="../css/theme.css">
<nav class="navbar shadow-sm sticky-top" style="background: var(--navbar-bg);">
  <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap py-2">
    <!-- Logo Left -->
    <a class="navbar-brand d-flex align-items-center logo-area me-3" href="index.php" style="color:var(--text-main);font-weight:bold;font-size:1.5rem;">
      <img src="../assets/logo.jpeg" alt="Looks Gems" width="44" height="44" class="me-2" style="padding:4px 8px 4px 0; border-radius:12px; box-shadow:0 2px 8px #e6a4b433; background:#fff;">
      <span style="font-family:'Playfair Display',serif;letter-spacing:1px;">Looks Gems</span>
    </a>
    
    <!-- Center Menu -->
    <div class="d-none d-md-flex align-items-center justify-content-center flex-grow-1 gap-3">
      <a class="nav-link px-3" href="about.php">About Us</a>
      <a class="nav-link px-3" href="contact.php">Contact Us</a>
      <div class="nav-item dropdown">
        <a class="nav-link px-3 dropdown-toggle" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
          <?php foreach ($categories as $cat): ?>
            <li><a class="dropdown-item" href="<?= $cat['file'] ?>"><?= htmlspecialchars($cat['name']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    
    <!-- Icons Right -->
    <div class="d-flex align-items-center gap-2 ms-auto">
      <a class="nav-link px-2 d-flex align-items-center" href="wishlist.php" title="Wishlist"><i class="bi bi-heart" style="font-size:1.3rem;"></i></a>
      <a class="nav-link px-2 d-flex align-items-center" href="orders.php" title="My Orders"><i class="bi bi-bag" style="font-size:1.3rem;"></i></a>
      <div class="dropdown">
        <a class="nav-link px-2 dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle" style="font-size:1.5rem;"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
          <li><a class="dropdown-item" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
    
    <!-- Mobile nav -->
    <div class="d-md-none w-100 mt-2">
      <div class="d-flex justify-content-center gap-2 flex-wrap">
        <a class="nav-link px-2" href="index.php">Home</a>
        <a class="nav-link px-2" href="about.php">About Us</a>
        <a class="nav-link px-2" href="contact.php">Contact Us</a>
        <div class="dropdown">
          <a class="nav-link px-2 dropdown-toggle" href="#" id="categoryDropdownMobile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoryDropdownMobile">
            <?php foreach ($categories as $cat): ?>
              <li><a class="dropdown-item" href="<?= $cat['file'] ?>"><?= htmlspecialchars($cat['name']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
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
.dropdown-menu {
  background: #fff6fa;
  border-radius: 1rem;
  border: none;
  box-shadow: 0 4px 24px #e6a4b433;
  min-width: 180px;
  padding: 0.5rem 0.2rem;
}
.dropdown-menu .dropdown-item {
  color: #B692A6;
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  border-radius: 0.7rem;
  margin: 0.1rem 0;
  padding-left: 1.2rem;
  padding-right: 1.2rem;
  transition: background 0.18s, color 0.18s;
  text-align: left;
}
.dropdown-menu .dropdown-item:hover, .dropdown-menu .dropdown-item:focus {
  background: #E6A4B4;
  color: #fff;
  margin: 0.1rem 0;
  padding-left: 1.2rem;
  padding-right: 1.2rem;
}
.dropdown-menu-end {
  right: 0;
  left: auto;
}
#profileDropdown .dropdown-menu {
  background: #fff6fa;
  border-radius: 1rem;
  border: none;
  box-shadow: 0 4px 24px #e6a4b433;
}
#profileDropdown .dropdown-item {
  color: #B692A6;
  font-family: 'Poppins', sans-serif;
  font-weight: 500;
  border-radius: 0.7rem;
  margin: 0.1rem 0.3rem;
}
#profileDropdown .dropdown-item:hover, #profileDropdown .dropdown-item:focus {
  background: #E6A4B4;
  color: #fff;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>