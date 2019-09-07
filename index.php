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

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="./styles/fontawesome_all.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="./styles/custom_landing.css">

  <title>Landing Page</title>

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

  <!-- About -->
  <section class="" id="about">
    <div class="container h-100">
      <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-10 align-self-end">
          <h1 class="text-uppercase text-white display-4">Dobrodošli u Evipod</h1>
          <hr class="divider">
        </div>
        <div class="col-lg-8 align-self-baseline">
          <p class="mb-5 h4 text-light">Start Bootstrap can help you build better websites using the Bootstrap framework! Just download a theme and start customizing, no strings attached!</p>
          <a class="btn btn-primary" href="#about">Find Out More</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Services -->
  <section class="bg-gray" id="services">
    <div class="container h-100">
      <div class="row h-50 align-items-center justify-content-center text-center">
        <div class="col-lg-10 align-self-end">
          <h2 class="text-center mt-3">At Your Service</h2>
          <hr class="divider my-4">
        </div>
        <div class="col-lg-8 col-md-10 align-self-start">
          <p class="mb-5 h4">Start Bootstrap can help you build better websites using the Bootstrap framework! Just download a theme and start customizing, no strings attached!</p>
        </div>
      </div>
      <div class="row h-50 align-items-top justify-content-center text-center pb-5">
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-gem text-primary mb-4"></i>
            <h3 class="h4 mb-2">Sturdy Themes</h3>
            <p class="text-muted mb-0">Our themes are updated regularly to keep them bug free!</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
            <h3 class="h4 mb-2">Up to Date</h3>
            <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-globe text-primary mb-4"></i>
            <h3 class="h4 mb-2">Ready to Publish</h3>
            <p class="text-muted mb-0">You can use this design as is, or you can make changes!</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 text-center">
          <div class="mt-5">
            <i class="fas fa-4x fa-heart text-primary mb-4"></i>
            <h3 class="h4 mb-2">Made with Love</h3>
            <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
          </div>
        </div>
        <!-- <div class="row h-100 align-items-center justify-content-center text-center">
        <div class="col-lg-8 text-center">
          <h2 class="text-white mt-0">We've got what you need!</h2>
          <hr class="">
          <p class="text-white mb-4">Start Bootstrap has everything you need to get your new website up and running in no time! Choose one of our open source, free to download, and easy to use themes! No strings attached!</p>
          <a class="btn btn-light" href="#services">Get Started!</a>
        </div>
      </div> -->
      </div>
  </section>

  <!-- Contact -->
  <section id="contact">
    <div class="container h-100 text-white align-items-center justify-content-center d-flex">
      <div class="row ">
        <div class="col-md-6 mx-auto">
          <h2 class="text-center my-4">Korisni linkovi</h2>
          <ul class="link-list">
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
        </div>
        <div class="col-md-6 mx-auto">
          <h2 class="text-center my-4">Kontaktirajte nas</h2>
          <p>Za sva pitanja stojimo Vam na raspolaganju putem dolje navedenih podataka:</p>
          <p>
            Međimursko veleučilište u Čakovcu
            <br>
            BANA JOSIPA JELAČIĆA 22a
            <br>
            40 000 Čakovec
            <br>
            Hrvatska
          </p>
          <p>
            Web: <a href="https://www.mev.hr" target="_blank" rel="noopener noreferrer">https://www.mev.hr</a>
            <br>
            E-mail: <a href="mailto:veleuciliste@mev.hr">veleuciliste@mev.hr</a>
          </p>
          <p>
            Tajništvo
            <br>
            Tel: +385(0)40396 990
            <br>
            Fax: +385(0)40396 980
          </p>
        </div>
      </div>
    </div>
  </section>

  <footer class="py-4 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
  </footer>




  <!-- <div class="container">
    <div class="jumbotron mt-5">
      <h1 class="display-4">Landing Page</h1>
      <p class="lead">Ovo je pocetna stranica aplikacije koju vide gosti.</p>
      <hr class="my-4">
      <p>Stranica nudi misc informacije i poveznicu za registraciju.</p>
      <a class="btn btn-info" href="./app/membership" role="button">Membership</a>
    </div>
  </div> -->


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./scripts/jquery-3.3.1.min.js"></script>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
  <script src="./scripts/custom_landing.js"></script>
</body>

</html>