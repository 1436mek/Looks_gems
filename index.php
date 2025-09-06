<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Looks Gems - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/theme.css">
  <style>
    .banner-premium {
      position: relative;
      width: 100%;
      height: 400px;
      background: url('assets/banner4.jpg') center center/cover no-repeat;
      border-radius: 20px;
      box-shadow: 0 6px 32px #e6a4b455;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      margin-bottom: 2rem;
    }
    .banner-premium::before {
      content: '';
      position: absolute;
      left: 0; top: 0; width: 100%; height: 100%;
      background: linear-gradient(to bottom, rgba(230,164,180,0) 0%, rgba(230,164,180,0.7) 100%);
      z-index: 1;
    }
    .banner-content {
      position: relative;
      z-index: 2;
      text-align: center;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100%;
    }
    .banner-heading {
      font-family: 'Playfair Display', serif;
      color: #fff;
      font-size: 2.7rem;
      font-weight: bold;
      text-shadow: 0 3px 6px rgba(0,0,0,0.3);
      margin-bottom: 1rem;
    }
    .banner-subheading {
      font-family: 'Poppins', sans-serif;
      color: #fff;
      font-size: 1.2rem;
      font-weight: 400;
      text-shadow: 0 2px 6px rgba(0,0,0,0.18);
      margin-bottom: 2rem;
    }
    .banner-btn {
      background: #E6A4B4;
      color: #fff;
      border: none;
      font-weight: 600;
      border-radius: 2rem;
      padding: 0.7rem 2.2rem;
      font-size: 1.1rem;
      box-shadow: 0 2px 8px #e6a4b433;
      transition: background 0.2s;
    }
    .banner-btn:hover, .banner-btn:focus {
      background: #B692A6;
      color: #fff;
    }
    @media (max-width: 767px) {
      .banner-premium {
        height: 250px;
      }
      .banner-heading {
        font-size: 1.5rem;
      }
      .banner-subheading {
        font-size: 1rem;
      }
      .banner-btn {
        font-size: 1rem;
        padding: 0.5rem 1.5rem;
      }
    }
    .discount-section {
      background: url('assets/discount-bg.jpg') center/cover no-repeat;
      position: relative;
    }
    .discount-section .overlay {
      background: rgba(230,164,180,0.75); /* Dusty Rose overlay */
      position: absolute;
      inset: 0;
      z-index: 1;
    }
    .discount-section .container {
      z-index: 2;
      position: relative;
    }
    .discount-section h2 {
      color: #fff;
      font-family: 'Playfair Display', serif;
      font-weight: 700;
      letter-spacing: 1px;
    }
    .discount-section h2 span {
      color: #F8C471; /* Gold accent */
    }
    .discount-section p {
      color: #fff;
      font-family: 'Poppins', sans-serif;
      font-size: 1.1rem;
    }
    .discount-section input[type="email"] {
      border-radius: 2rem;
      border: 1.5px solid #E6A4B4;
      padding: 0.7rem 1.2rem;
      font-family: 'Poppins', sans-serif;
      font-size: 1rem;
      color: #B692A6;
      background: #fff;
      box-shadow: 0 2px 8px #e6a4b422;
    }
    .discount-section input[type="email"]:focus {
      border-color: #B692A6;
      outline: none;
      box-shadow: 0 0 0 2px #E6A4B433;
    }
    .discount-section button[type="submit"] {
      background: #E6A4B4;
      color: #fff;
      border: none;
      border-radius: 2rem;
      font-weight: 700;
      padding: 0.7rem 2.2rem;
      font-size: 1.1rem;
      box-shadow: 0 2px 8px #e6a4b433;
      transition: background 0.2s;
    }
    .discount-section button[type="submit"]:hover,
    .discount-section button[type="submit"]:focus {
      background: #B692A6;
      color: #fff;
    }
    .card .btn:hover, .card .btn:focus {
      background: #B692A6 !important;
      color: #fff !important;
      box-shadow: 0 4px 16px #e6a4b455;
    }
  </style>
</head>
<body>
<?php include 'includes/navbar.php'; ?>
<div style="width:100vw;position:relative;left:50%;right:50%;margin-left:-50vw;margin-right:-50vw;">
  <?php include 'includes/premium_carousel.php'; ?>
</div>

<!-- Featured Products Section -->
<div class="container mb-5">
  <h2 class="mb-4 text-center fw-bold" style="color:#E6A4B4;letter-spacing:2px;">Featured Products</h2>
  <div class="row g-4">
    <?php
    $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 8";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card product-card h-100 border-0 shadow" style="background:linear-gradient(135deg,#fadadd 60%,#fff8f0 100%);">
            <div class="position-relative" style="height:260px;overflow:hidden;display:flex;align-items:center;justify-content:center;">
              <img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="card-img-top w-100 h-100" alt="<?= htmlspecialchars($row['name']) ?>" style="object-fit:cover;max-height:100%;max-width:100%;border-radius:12px;">
              <form method="post" action="wishlist.php" class="position-absolute top-0 end-0 m-2">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-sm rounded-circle" title="Add to Wishlist" style="background:#E6A4B4;color:#fff;border:none;box-shadow:0 2px 8px #e6a4b433;">
                  <i class="bi bi-heart"></i>
                </button>
              </form>
            </div>
            <div class="card-body d-flex flex-column">
              <h5 class="card-title mb-2" style="color:#E6A4B4;"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text fw-bold mb-2" style="font-size:1.1rem;color:#E6A4B4;">₹<?= number_format($row['price'], 2) ?></p>
              <a href="product.php?id=<?= $row['id'] ?>" class="btn btn-outline-dark btn-sm mb-2">View</a>
              <form method="post" action="cart.php" class="mt-auto">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-bag me-1"></i> Add to Cart</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
      
    <?php else: ?>
      <div class="col-12 text-center text-muted">No featured products found.</div>
    <?php endif; ?>
  </div>
</div>
<!-- Special Offers Section -->
<div class="container mb-5">
  <h2 class="mb-4 text-center fw-bold" style="color:#E6A4B4;letter-spacing:2px;">Special Offers</h2>
  <div class="row g-4">
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card p-4 text-center border-0 shadow" style="border-radius:20px;">
        <h4 class="fw-bold mb-2" style="color:#E6A4B4;">Festive Sale</h4>
        <p class="mb-3">Get 20% off on all diamond rings. Limited time only!</p>
        <a href="category_rings.php" class="btn btn-lg w-100" style="background:#e6a4b4;color:#fff;border-radius:2rem;font-weight:600;box-shadow:0 2px 8px #e6a4b433;transition:background 0.2s;">Shop Rings</a>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card p-4 text-center border-0 shadow" style="border-radius:20px;">
        <h4 class="fw-bold mb-2" style="color:#E6A4B4;">Necklace Nirvana</h4>
        <p class="mb-3">Flat 15% off on all necklaces this week only!</p>
        <a href="category_necklaces.php" class="btn btn-lg w-100" style="background:#e6a4b4;color:#fff;border-radius:2rem;font-weight:600;box-shadow:0 2px 8px #e6a4b433;transition:background 0.2s;">Shop Necklaces</a>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card p-4 text-center border-0 shadow" style="border-radius:20px;">
        <h4 class="fw-bold mb-2" style="color:#E6A4B4;">Bracelet Bonanza</h4>
        <p class="mb-3">Flat ₹500 off on select bracelets.</p>
        <a href="category_bracelets.php" class="btn btn-lg w-100" style="background:#e6a4b4;color:#fff;border-radius:2rem;font-weight:600;box-shadow:0 2px 8px #e6a4b433;transition:background 0.2s;">Shop Bracelets</a>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-6">
      <div class="card p-4 text-center border-0 shadow" style="border-radius:20px;">
        <h4 class="fw-bold mb-2" style="color:#E6A4B4;">Earring Extravaganza</h4>
        <p class="mb-3">Buy 1 Get 1 Free on all earrings.</p>
        <a href="category_earrings.php" class="btn btn-lg w-100" style="background:#e6a4b4;color:#fff;border-radius:2rem;font-weight:600;box-shadow:0 2px 8px #e6a4b433;transition:background 0.2s;">Shop Earrings</a>
      </div>
    </div>
    
  </div>
</div>
<!-- Discount Subscription Section -->
<div class="discount-section text-center py-5 mb-5">
  <div class="overlay"></div>
  <div class="container position-relative">
    <h2 class="fw-bold mb-3">GET <span>10%</span> DISCOUNT</h2>
    <p class="mb-4">
      Subscribe to the LOOKS AND GEMS mailing list to receive updates on new arrivals,
      special offers and other discount information.
    </p>
    <form class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-2" method="post" action="subscribe.php">
      <input type="email" name="email" class="form-control w-auto" placeholder="Your email address here" required style="min-width: 280px;">
      <button type="submit" class="btn fw-bold">SUBSCRIBE</button>
    </form>
  </div>
</div>
<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Enable Bootstrap dropdowns for all .dropdown-toggle elements
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
});
</script>
</body>
</html>
