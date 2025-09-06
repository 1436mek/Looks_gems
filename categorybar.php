<?php
// Horizontal category bar with icons
require_once 'includes/config.php';
$categories = [
    ['name' => 'Rings', 'icon' => 'bi-gem', 'id' => 1],
    ['name' => 'Bracelets', 'icon' => 'bi-bezier', 'id' => 2],
    ['name' => 'Earrings', 'icon' => 'bi-stars', 'id' => 3],
    ['name' => 'Necklaces', 'icon' => 'bi-link-45deg', 'id' => 4],
];
$current_cat = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<link rel="stylesheet" href="css/theme.css">
<div class="category-bar-outer py-3" style="background: var(--navbar-bg-alt);">
  <div class="container">
    <div class="d-flex flex-column align-items-center">
      <span class="fw-bold mb-2" style="color: var(--text-main); font-size:1.3rem; letter-spacing:1px;">Jewellery</span>
      <div class="d-flex flex-wrap justify-content-center gap-3">
        <?php foreach ($categories as $cat): ?>
          <a href="category.php?id=<?= $cat['id'] ?>"
             class="text-decoration-none d-flex align-items-center px-4 py-2 category-link<?= ($current_cat === $cat['id']) ? ' active' : '' ?>"
             style="font-weight:600; color:var(--text-main); font-size:1.1rem; border-radius:2rem; border:2px solid var(--category-icon); background: #fff;">
            <i class="bi <?= $cat['icon'] ?> me-2" style="color: var(--category-icon); font-size:1.3rem;"></i> <?= $cat['name'] ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
<style>
.category-bar-outer {
  border-bottom: 2px solid var(--category-icon);
}
.category-link {
  transition: background 0.2s, color 0.2s, border 0.2s;
  background: #fff;
}
.category-link.active, .category-link:hover {
  background: var(--category-icon) !important;
  color: var(--text-main) !important;
  border: 2px solid var(--button-bg) !important;
}
@media (max-width: 600px) {
  .category-link {
    font-size: 1rem;
    padding: 0.5rem 1rem;
  }
  .category-bar-outer .container {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }
}
</style>
