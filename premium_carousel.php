<!-- Premium Carousel Section -->
<style>
  .carousel-wrapper {
    background: #FAF3E0;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    padding: 0;
    margin-bottom: 2.5rem;
    border-radius: 0;
    overflow: hidden;
    width: 100vw;
    max-width: 100vw;
    position: relative;
    left: 50%;
    right: 50%;
    margin-left: -50vw;
    margin-right: -50vw;
  }
  #mainCarousel {
    border-radius: 0 !important;
  }
  .carousel-inner {
    border-radius: 0 !important;
  }
  .carousel-item {
    position: relative;
  }
  .carousel-item::before {
    content: '';
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    background: linear-gradient(
      to top,
      rgba(0, 0, 0, 0.4) 0%,
      rgba(0, 0, 0, 0.2) 50%,
      rgba(0, 0, 0, 0) 100%
    );
    z-index: 1;
    pointer-events: none;
  }
  .carousel-item img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 0 !important;
    margin: 0;
  }
  .carousel-caption {
    position: absolute;
    left: 50%;
    top: 50%;
    right: auto;
    bottom: auto;
    transform: translate(-50%, -50%);
    text-align: center;
    align-items: center;
    justify-content: center;
    background: none;
    padding: 2.5rem 3rem;
    border-radius: 0;
    max-width: 80%;
    min-width: 260px;
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
    z-index: 2;
  }
  .carousel-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.7rem;
    font-weight: 900;
    color: #fff;
    text-shadow: 0 4px 12px rgba(0,0,0,0.32);
    margin-bottom: 0.2em;
    letter-spacing: 1px;
    line-height: 1.1;
  }
  .carousel-desc {
    font-family: 'Poppins', sans-serif;
    font-size: 1.15rem;
    color: #fff;
    max-width: 500px;
    margin-bottom: 0.5em;
    font-weight: 400;
    line-height: 1.5;
    text-shadow: 0 2px 8px rgba(0,0,0,0.18);
  }
  .carousel-btn {
    background: #E6A4B4;
    color: #fff;
    border: none;
    border-radius: 2rem;
    font-weight: 700;
    padding: 0.8rem 2.5rem;
    font-size: 1.15rem;
    box-shadow: 0 2px 12px #e6a4b433;
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    letter-spacing: 0.5px;
    outline: none;
  }
  .carousel-btn:hover, .carousel-btn:focus {
    background: #B692A6;
    color: #fff;
    box-shadow: 0 4px 18px #b692a633;
    transform: translateY(-2px) scale(1.04);
  }
  .carousel-control-prev, .carousel-control-next {
    width: 48px;
    height: 48px;
    top: 50%;
    transform: translateY(-50%);
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 8px #e6a4b433;
    opacity: 1;
    border: none;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .carousel-control-prev:hover, .carousel-control-next:hover {
    background: #E6A4B4;
  }
  .carousel-control-prev-icon, .carousel-control-next-icon {
    filter: invert(60%) sepia(10%) saturate(0%) hue-rotate(180deg) brightness(90%);
    width: 1.5rem;
    height: 1.5rem;
    transition: filter 0.2s;
  }
  .carousel-control-prev:hover .carousel-control-prev-icon,
  .carousel-control-next:hover .carousel-control-next-icon {
    filter: invert(100%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(200%);
  }
  .carousel-indicators [data-bs-target] {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #e0e0e0;
    margin: 0 6px;
    border: none;
    opacity: 1;
    transition: background 0.2s;
  }
  .carousel-indicators .active {
    background: #B692A6;
  }
  @media (max-width: 767px) {
    .carousel-item img {
      height: 250px;
    }
    .carousel-caption {
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      max-width: 95%;
      padding: 1.2rem 1rem;
      border-radius: 0;
      gap: 0.8rem;
    }
    .carousel-title {
      font-size: 1.5rem;
    }
    .carousel-desc {
      font-size: 1rem;
      margin-bottom: 1.2rem;
    }
    .carousel-btn {
      font-size: 1rem;
      padding: 0.5rem 1.5rem;
    }
  }
</style>
<div class="container mb-5">
  <div class="carousel-wrapper">
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2500">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="assets/ring6.jpg" class="d-block w-100" alt="Luxury Jewellery 1">
          <div class="carousel-caption d-flex flex-column justify-content-center h-100">
            <h2 class="carousel-title">Timeless Elegance</h2>
            <p class="carousel-desc">Indulge in our premium collection</p>
            <a href="../category_rings.php" class="btn carousel-btn">Shop Now</a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/neck10.jpg" class="d-block w-100" alt="Luxury Jewellery 2">
          <div class="carousel-caption d-flex flex-column justify-content-center h-100">
            <h2 class="carousel-title">Radiant Beauty</h2>
            <p class="carousel-desc">Shine bright with every piece</p>
            <a href="../category_bracelets.php" class="btn carousel-btn">Shop Now</a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="assets/pic5.jpg" class="d-block w-100" alt="Luxury Jewellery 3">
          <div class="carousel-caption d-flex flex-column justify-content-center h-100">
            <h2 class="carousel-title">Modern Glamour</h2>
            <p class="carousel-desc">Elevate your everyday style</p>
            <a href="../category_necklaces.php" class="btn carousel-btn">Shop Now</a>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</div>
