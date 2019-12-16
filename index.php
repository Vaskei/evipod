<?php
session_start();
if (isset($_SESSION['user_id'])) header("Location: ./app");
require_once "./app/includes/connection.php";
$query = $conn->query("SELECT * FROM landing_page WHERE id = 1");
if ($query->num_rows > 0) {
  $row = $query->fetch_assoc();
}
$title = "Evipod - Uvod";
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="shortcut icon" type="image/png" href="../favicon.png"/>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./styles/bootstrap_solar.css">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="./styles/fontawesome_all.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./styles/custom_landing.css">

  <title>Evipod</title>

  <style>

  </style>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="56">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="#about">Evipod</a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto my-2 my-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#about">Što je Evipod?</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Usluge</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Kontakt</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Info -->
  <section class="" id="about">
    <div class="container h-100">
      <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-10 align-self-end">
          <h1 class="text-uppercase text-white display-4"><?php echo htmlentities($row['section_1_title']); ?></h1>
          <hr class="divider">
        </div>
        <div class="col-lg-8 align-self-baseline">
          <p class="h4 text-light">Web aplikacija za evidentiranje integrirane poljoprivredne djelatnosti.</p>
          <p class="mb-5 h4 text-light"><?php echo htmlentities($row['section_1_desc']); ?></p>
          <a class="btn btn-primary" href="/app/membership">Prijava / Registracija</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Usluge -->
  <section class="bg-gray" id="services">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center mb-5">
        <div class="col-lg-10 align-self-end">
          <h2 class="text-center mt-5"><?php echo htmlentities($row['section_2_title']); ?></h2>
          <hr class="divider my-4">
        </div>
        <div class="col-lg-8 col-md-10 align-self-start">
          <p class="mb-5 h4"><?php echo htmlentities($row['section_2_desc']); ?></p>
        </div>
      </div>
      <div class="row align-items-top justify-content-center text-center mb-5">
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <?php echo '<i class="fas fa-4x '. htmlentities($row['section_2_icon_1']) .' text-primary mb-4"></i>'; ?>
            <h3 class="h4 mb-2"><?php echo htmlentities($row['section_2_title_1']); ?></h3>
            <p class="text-muted mb-0"><?php echo htmlentities($row['section_2_desc_1']); ?></p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <?php echo '<i class="fas fa-4x '. htmlentities($row['section_2_icon_2']) .' text-primary mb-4"></i>'; ?>
            <h3 class="h4 mb-2"><?php echo htmlentities($row['section_2_title_2']); ?></h3>
            <p class="text-muted mb-0"><?php echo htmlentities($row['section_2_desc_2']); ?></p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
          <?php echo '<i class="fas fa-4x '. htmlentities($row['section_2_icon_3']) .' text-primary mb-4"></i>'; ?>
            <h3 class="h4 mb-2"><?php echo htmlentities($row['section_2_title_3']); ?></h3>
            <p class="text-muted mb-0"><?php echo htmlentities($row['section_2_desc_3']); ?></p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <?php echo '<i class="fas fa-4x '. htmlentities($row['section_2_icon_4']) .' text-primary mb-4"></i>'; ?>
            <h3 class="h4 mb-2"><?php echo htmlentities($row['section_2_title_4']); ?></h3>
            <p class="text-muted mb-0"><?php echo htmlentities($row['section_2_desc_4']); ?></p>
          </div>
        </div>
      </div>
  </section>

  <!-- Kontakt -->
  <section id="contact">
    <div class="container text-white d-flex h-100">
      <div class="row align-self-center w-100">
        <div class="col-md-6 mx-auto text-center">
          <h2 class="text-center my-4">Kontaktirajte nas</h2>
          <ul class="unstyled-list px-0">
            <li>
              <p>Za sva pitanja stojimo Vam na raspolaganju putem dolje navedenih podataka:</p>
            </li>
            <li>
              <p>
                <?php echo htmlentities($row['section_3_name']); ?>
                <br>
                <?php echo htmlentities($row['section_3_address']); ?>
                <br>
                <?php echo htmlentities($row['section_3_post']); ?>
              </p>
            </li>
            <li>
              <p>
                Web: <?php echo '<a href="'.htmlentities($row['section_3_website']).'" target="_blank" rel="noopener noreferrer">'.htmlentities($row['section_3_website']).'</a>'; ?>
                <br>
                E-mail: <?php echo '<a href="mailto:'.htmlentities($row['section_3_email']).'">'.htmlentities($row['section_3_email']).'</a>'; ?>
              </p>
            </li>
            <li>
              <p>
                Tel: <?php echo htmlentities($row['section_3_tel']); ?>
                <br>
                Fax: <?php echo htmlentities($row['section_3_mob']); ?>
              </p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <footer class="py-4 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; MEV - Evipod 2019</p>
    </div>
  </footer>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./scripts/jquery-3.3.1.min.js"></script>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
  <script src="./scripts/custom_landing.js"></script>
</body>

</html>