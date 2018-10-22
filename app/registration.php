<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="styles/bootstrap.css">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="styles/fontawesome_all.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="styles/reg_login.css">

  <title>App Page</title>
</head>

<body>
  <div class="container">
    <div class="card mx-auto mt-5">
      <img class="card-img-top" src="../../templates/evipod/images/agriculture-barley-field-beautiful-512.jpg" alt="Card image cap">
      <div class="card-body">
        <h4 class="card-title text-center">REGISTRACIJA</h4>
        <hr>
        <form>
          <div class="form-group">
            <label for="registrationName">Ime</label>
            <input type="text" class="form-control" id="registrationName" placeholder="Unesite ime...">
          </div>
          <div class="form-group">
            <label for="registrationEmail">Email</label>
            <input type="email" class="form-control" id="registrationEmail" placeholder="Unesite email...">
          </div>
          <div class="form-group">
            <label for="registrationPass">Lozinka</label>
            <input type="password" class="form-control" id="registrationPass" placeholder="Unesite lozinku...">
          </div>
          <div class="form-group">
            <label for="registrationPassConfirm">Ponovite lozinku</label>
            <input type="password" class="form-control" id="registrationPassConfirm" placeholder="Ponovite lozinku...">
          </div>
          <button type="submit" class="btn btn-primary">Registracija</button>
        </form>
        <hr>
        <div class="form-row text-center">
          <div class="col-md-6 mt-3">
            <i class="fas fa-arrow-alt-circle-left"></i>&nbsp;
            <a href=".">Natrag</a>
          </div>
          <div class="col-md-6 mt-3">
            <i class="fas fa-sign-in-alt"></i>&nbsp;
            <a href="login">Prijava</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="scripts/jquery-3.3.1.min.js"></script>
  <script src="scripts/bootstrap.bundle.js"></script>
</body>

</html>