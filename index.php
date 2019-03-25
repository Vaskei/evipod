<?php
session_start();
if (isset($_SESSION['user_id'])) header("Location: ./app");
$title = "Evipod - Uvod"
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./styles/bootstrap_solar.css">

  <title>Landing Page</title>
</head>

<body>
  <div class="container">
    <div class="jumbotron mt-5">
      <h1 class="display-4">Landing Page</h1>
      <p class="lead">Ovo je pocetna stranica aplikacije koju vide gosti.</p>
      <hr class="my-4">
      <p>Stranica nudi misc informacije i poveznicu za registraciju.</p>
      <a class="btn btn-info" href="./app/membership" role="button">Membership</a>
    </div>
    <!-- <h1>Landing Page</h1>
    <a class="btn btn-primary" href="./app" role="button">App</a>
    <a class="btn btn-info" href="./app/membership" role="button">Membership</a> -->
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./scripts/jquery-3.3.1.min.js"></script>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
</body>

</html>