<?php
session_start();
if (isset($_SESSION['user_id'])) header("Location: ./app");
require_once "./app/includes/connection.php";
$query = $conn->query("SELECT * FROM landing_page WHERE id = 1");
if ($query) {
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
          <h1 class="text-uppercase text-white display-4">Dobrodošli u Evipod</h1>
          <hr class="divider">
        </div>
        <div class="col-lg-8 align-self-baseline">
          <p class="h4 text-light">Web aplikacija za evidentiranje poljoprivredne djelatnosti.</p>
          <p class="mb-5 h4 text-light">Aplikacija omogućuje korisniku evidentiranje resursa (gospodarstva, zemljišta), nasada (sadnja/sjetva), aktivnosti (zaštita, gnojidba, obrada tla, njega usjeva/nasada), te rezultate (berba/žetva).</p>
          <a class="btn btn-primary" href="./app/membership">Prijava / Registracija</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Usluge -->
  <section class="bg-gray" id="services">
    <div class="container">
      <div class="row align-items-center justify-content-center text-center mb-5">
        <div class="col-lg-10 align-self-end">
          <h2 class="text-center mt-5">Usluge</h2>
          <hr class="divider my-4">
        </div>
        <div class="col-lg-8 col-md-10 align-self-start">
          <p class="mb-5 h4">Web aplikacija Evipod nudi brojne mogućnosti koje olakšavaju rad i poslovanje modernom poljoprivredniku, sve na jednom centraliziranom mjestu.</p>
        </div>
      </div>
      <div class="row align-items-top justify-content-center text-center mb-5">
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-map-marker-alt text-primary mb-4"></i>
            <h3 class="h4 mb-2">Centralizirano</h3>
            <p class="text-muted mb-0">Svi podaci i evidencije su na jednome mjestu, uvijek dostupni.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
            <h3 class="h4 mb-2">Neovisno o uređaju</h3>
            <p class="text-muted mb-0">Računalo, laptop, mobitel ili tablet. Pristup aplikaciji moguć je sa svakog modernog uređaja s internet konekcijom.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-globe text-primary mb-4"></i>
            <h3 class="h4 mb-2">Bilo gdje</h3>
            <p class="text-muted mb-0">Mogućnost uporabe aplikacije doma ili na polju/poslu. Jedini uvjet je prisutnost internet veze.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-calendar-alt text-primary mb-4"></i>
            <h3 class="h4 mb-2">Podrška</h3>
            <p class="text-muted mb-0">Podrška 24 sata, 7 dana u tjednu. Osim na blagdane.</p>
          </div>
        </div>
      </div>
  </section>

  <!-- Kontakt -->
  <section id="contact">
    <div class="container text-white d-flex h-100">
      <div class="row align-self-center w-100">
        <!-- <div class="col-md-6 mx-auto">
          <h2 class="text-center my-4">Korisni linkovi</h2>
          <ul class="unstyled-list">
            <li>
              <h5>
                MEV
                <br>
                <small><a href="https://www.mev.hr" target="_blank" rel="noopener noreferrer">Međimursko veleučilište u Čakovcu</a></small>
              </h5>
            </li>
            <li>
              <h5>
                ARKOD
                <br>
                <small><a href="http://preglednik.arkod.hr/ARKOD-Web/" target="_blank" rel="noopener noreferrer">ARKOD Preglednik</a></small>
              </h5>
            </li>
            <li>
              <h5>
                Ministarstvo poljoprivrede
                <br>
                <small><a href="https://fis.mps.hr/trazilicaszb/" target="_blank" rel="noopener noreferrer">Popis registriranih sredstava za zaštitu bilja</a></small>
              </h5>
            </li>
            <li>
              <h5>
                Savjetodavna služba
                <br>
                <small><a href="https://www.savjetodavna.hr" target="_blank" rel="noopener noreferrer">Uprava za stručnu podršku razvoju poljoprivrede i ribarstva</a></small>
              </h5>
            </li>
          </ul>
        </div> -->
        <div class="col-md-6 mx-auto text-center">
          <h2 class="text-center my-4">Kontaktirajte nas</h2>
          <ul class="unstyled-list px-0">
            <li>
              <p>Za sva pitanja stojimo Vam na raspolaganju putem dolje navedenih podataka:</p>
            </li>
            <li>
              <p>
                Međimursko veleučilište u Čakovcu
                <br>
                BANA JOSIPA JELAČIĆA 22a
                <br>
                40 000 Čakovec
                <br>
                Hrvatska
              </p>
            </li>
            <li>
              <p>
                Web: <a href="https://www.mev.hr" target="_blank" rel="noopener noreferrer">https://www.mev.hr</a>
                <br>
                E-mail: <a href="mailto:veleuciliste@mev.hr">veleuciliste@mev.hr</a>
              </p>
            </li>
            <li>
              <p>
                Tajništvo
                <br>
                Tel: +385(0)40396 990
                <br>
                Fax: +385(0)40396 980
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