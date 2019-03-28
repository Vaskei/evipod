<?php
session_start();
// if (!isset($_SESSION['user_id'])) header("Location: ../");

require_once "./includes/connection.php";
$title = "Evipod - Home"
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./styles/bootstrap_flatly.css">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="./styles/fontawesome_all.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./styles/custom.css">
  <link rel="stylesheet" href="./styles/hamburgers.css">

  <title>App Page</title>
</head>

<body class="app">
  <div class="d-flex bg-light" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-secondary border-right border-dark" id="sidebar-wrapper">
      <div class="sidebar-heading">Evipod</div>
      <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action bg-secondary text-primary">Dashboard</a>
        <a href="#" class="list-group-item list-group-item-action bg-secondary text-primary">Shortcuts</a>
        <a href="#" class="list-group-item list-group-item-action bg-secondary text-primary">Overview</a>
        <a href="#" class="list-group-item list-group-item-action bg-secondary text-primary">Events</a>
        <a href="#" class="list-group-item list-group-item-action bg-secondary text-primary">Profile</a>
        <a href="#" class="list-group-item list-group-item-action bg-secondary text-primary">Status</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-secondary border-bottom border-dark">
        <!-- <button class="btn btn-outline-dark" type="button" id="menu-toggle">
          <span class="navbar-toggler-icon"></span>
          <i class="far fa-caret-square-down fa-lg"></i>
        </button> -->

        <span id="menu-toggle">
          <i class="far fa-caret-square-left fa-2x d-sm-none d-md-block"></i>
          <i class="far fa-caret-square-right fa-2x d-none d-sm-block d-md-none"></i>
        </span>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-home fa-lg"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">OPG 1</a>
                <a class="dropdown-item" href="#">OPG 2</a>
                <a class="dropdown-item" href="#">OPG 3</a>
                <a class="dropdown-item" href="#">OPG 4</a>
                <a class="dropdown-item" href="#">OPG 5</a>
              </div>
            </li>
            <li class="nav-item dropdown ml-lg-3">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                <i class="fas fa-id-card-alt fa-lg"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#">Postavke</a>
                <a class="dropdown-item" href="#">Informacije</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Odjava</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        <h1 class="mt-4">Simple Sidebar</h1>
        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
          larger screens. When toggled using the button below, the menu will change.</p>
        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
          and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
          menu when clicked.</p>
        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
          larger screens. When toggled using the button below, the menu will change.</p>
        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
          and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
          menu when clicked.</p>
        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
          larger screens. When toggled using the button below, the menu will change.</p>
        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
          and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
          menu when clicked.</p>
        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
          larger screens. When toggled using the button below, the menu will change.</p>
        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
          and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
          menu when clicked.</p>
        <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
          larger screens. When toggled using the button below, the menu will change.</p>
        <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
          and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
          menu when clicked.</p>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./scripts/jquery-3.3.1.min.js"></script>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
  <script src="./scripts/custom.js"></script>
</body>

</html>