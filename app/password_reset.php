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
  <link rel="stylesheet" href="./styles/membership.css">
  <link rel="stylesheet" href="./styles/custom.css">

  <title>Prijava / Registracija</title>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8 col-lg-6">
        <div class="card card-tabs-custom">
          <div class="card-body pb-0">
            <img class="card-img-top" src="./images/chain-key-lock-512.jpg">
            <div class="card-body">
              <h4 class="card-title text-center">ZABORAVILI STE LOZINKU?</h4>
              <h6 class="card-subtitle text-justify small">Ukoliko ste se već registrirali na našoj aplikaciji, a zaboravili ste lozinku, molimo <strong>upišite svoju e-mail adresu</strong>. Upute za promjenu lozinke doći će vam e-mailom.</h6>
              <hr>
              <form method="POST" action=""> <!-- TODO: staviti novalidate forme -->
                <div class="form-group">
                  <label for="pwdResetEmail">Email</label>
                  <input type="email" class="form-control" id="pwdResetEmail" name="pwdResetEmail" placeholder="Unesite email..."> <!-- TODO: required input -->
                </div>
                <button type="submit" name="pwdResetSubmit" class="btn btn-primary"><i class="fas fa-passport"></i>&nbsp;Nova
                  lozinka</button>
                <a class="btn btn-secondary" href="./membership" role="button"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp;Natrag</a>
              </form>
              <hr>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="./scripts/jquery-3.3.1.min.js"></script>
  <script src="./scripts/bootstrap.bundle.min.js"></script>
  <script src="./scripts/custom.js"></script>
</body>

</html>