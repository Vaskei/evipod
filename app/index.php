<?php
session_start();
// if (!isset($_SESSION['user_id'])) header("Location: ../");
// ob_start();
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
  <link rel="stylesheet" href="./styles/bootstrap_solar.css">

  <title>App Page</title>
</head>

<body>
  <div class="container">
    <h1>App Page</h1>
    <a class="btn btn-primary" href="../" role="button">Back</a>
    <a class="btn btn-secondary" href="./includes/logout.php" role="button">Logout</a>
    <p><?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : "Nema prijavljenog korisnika."; ?></p>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./scripts/jquery-3.3.1.min.js"></script>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
</body>

</html>