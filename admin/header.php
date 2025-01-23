<!doctype html>
<html lang="en">
<head>
  <!-- meta tags and links remain the same --> 
  <link href="bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="tiny-slider.css" rel="stylesheet">
  <link href="style1.css" rel="stylesheet">
   <title>Beauty and Cosmetics</title>
</head>

<body>

  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

    <div class="container">
      <a class="navbar-brand me-auto" href="index.php">Beauty and Cosmetics<span>.</span></a> <!-- Added me-auto class -->

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsFurni">
        <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'manage_user.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="manage_user.php">Manage User</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'manageorder.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="manage_orders.php">Manage Order</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'managecontact.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="managecontact.php">Manage Contact</a>
          </li>
          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'adminprofile.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="adminprofile.php">Admin Profile</a>
          </li>

          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'adminprofile.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="manage_shop.php">manage shop</a>
          </li>

          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'adminprofile.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="manage_about.php">manage about</a>
          </li>

          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'adminprofile.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="manage_services.php">manage services</a>
          </li>

          <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'adminprofile.php' ? 'active' : ''; ?>">
            <a class="nav-link" href="manage_contact.php">manage contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Header/Navigation -->
