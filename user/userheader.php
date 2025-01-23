<?php
// Your PHP code here (e.g., session_start, database connection, etc.)
?>
<!doctype html>
<html lang="en">
<head>
  <!-- meta tags and links remain the same -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="css/tiny-slider.css" rel="stylesheet">
  <link href="css/style1.css" rel="stylesheet">
  <title>Beauty and Cosmetics</title>
  <style>
    .input-group {
      width: 100%;
      position: relative;
    }
    .form-control {
      border-radius: 50px;
      padding-right: 3rem; /* Space for the icon inside the text box */
    }
    .input-group-text {
      background: transparent;
      border: none;
      padding: 0;
      position: absolute;
      right: 0;
      top: 0;
      height: 100%;
      width: 3rem; /* Adjust width as needed */
      display: flex;
      align-items: center;
      justify-content: center;
      color: #aaa; /* Icon color */
      border-radius: 50px;
    }
    .input-group .form-control {
      border-top-right-radius: 50px;
      border-bottom-right-radius: 50px;
    }
    .input-group .input-group-text {
      border-top-left-radius: 50px;
      border-bottom-left-radius: 50px;
      border-left: none; /* Ensure there's no border between the input and icon */
    }
  </style>
</head>
<body>

  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
    <div class="container">
      <a class="navbar-brand" href="index.php" style="font-size: 30px; margin-left:-150px;">Beauty and Cosmetics<span>.</span></a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsFurni">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="index.php" style="font-size: 13px">Home</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="shop.php" style="font-size: 13px">Shop</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="about.php" style="font-size: 13px">About us</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="services.php" style="font-size: 13px">Services</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="contact.php" style="font-size: 13px">Contact us</a>
          </li>
        </ul>

        <!-- Search Form with Icon Inside Text Box -->
        <form class="d-flex ms-3" action="search_results.php" method="GET">
          <div class="input-group">
            <input class="form-control" type="search" placeholder="Search products..." aria-label="Search" name="query">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
          </div>
        </form>

        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5" style="margin-right:-120px;">
          <li><a class="nav-link" href="userprofile.php"><img src="images/userprofile.svg" alt="User Profile" style="width: 24px; height: 24px;"></a></li>
          <li><a class="nav-link" href="cart.php"><img src="images/cart.png" alt="Cart" style="width: 24px; height: 24px;"></a></li>
          <li><a class="nav-link" href="wishlist.php"><img src="images/wishlist.png" alt="Cart" style="width: 30px; height: 30px;"></a></li>

        </ul>
      </div>
    </div>
  </nav>
  <!-- End Header/Navigation -->

  <!-- Bootstrap JS and dependencies (make sure to include these scripts) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>

  <!-- JavaScript for logout confirmation -->
  <script>
    document.getElementById('logout-link').addEventListener('click', function(e) {
      e.preventDefault(); // Prevent default action of the link
      var confirmation = confirm("Are you sure you want to log out?");
      if (confirmation) {
        window.location.href = 'logout.php'; // Redirect to logout.php if confirmed
      }
    });
  </script>

</body>
</html>
