<?php

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
    .input-group .form-control {
      border-radius: 50px;
      padding-right: 3rem; /* Space for the icon */
    }
    .input-group-text {
      background: transparent;
      border: none;
      padding: 0;
      border-radius: 50px;
      position: absolute;
      right: 0;
      top: 0;
      height: 100%;
      width: 3rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .input-group-text i {
      color: #aaa; /* Icon color */
    }
    .search-wrapper {
      position: relative;
      width: 100%;
    }
  </style>
</head>

<body>

  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">

    <div class="container">
      <a class="navbar-brand" href="index.php" style="font-size: 28px; margin-left:-130px;">Beauty and Cosmetics<span>.</span></a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsFurni">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="shop.php">Shop</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="about.php">About us</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="services.php">Services</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="contact.php">Contact us</a>
          </li>
        </ul>

        <!-- Search Form with Icon Inside Text Box -->
        <!-- <form class="d-flex ms-5 search-wrapper" action="search_results.php" method="GET">
          <input class="form-control" type="search" placeholder="Search" aria-label="Search" name="query">  -->
          <!-- <span class="input-group-text"><i class="fas fa-search"></i></span> -->
        </form>

        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li><a class="nav-link" href="login.php" style="margin-right:-120px;"><img src="images/userprofile.svg" alt="User Profile"></a></li>
          <!-- <li><a class="nav-link" href="cart.php"><img src="images/shopping-bag.svg" alt="Cart"></a></li> -->
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Header/Navigation -->

  <!-- Other content -->

  <!-- Bootstrap JS and dependencies (make sure to include these scripts) -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php

include ("db_connection.php");
?>