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
  <link rel="stylesheet" href="styles/membership.css">

  <title>Prijava / Registracija</title>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8 col-lg-6">
        <ul class="nav nav-tabs nav-justified" id="myTabLoginReg" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login"
              aria-selected="true">Prijava</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register"
              aria-selected="false">Registracija</a>
          </li>
        </ul>
        <div class="card card-tabs-custom">
          <div class="card-body">
            <div class="tab-content" id="myTabContentLoginReg">
              <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <img class="card-img-top" src="../../templates/evipod/images/acer-agriculture-environment-512.jpg" alt="Photo by Kaboompics.com from Pexels">
                <div class="card-body">

                  <h4 class="card-title text-center">PRIJAVA</h4>
                  <hr>
                  <form>
                    <div class="form-group">
                      <label for="loginEmail">Email</label>
                      <input type="email" class="form-control" id="loginEmail" placeholder="Unesite email...">
                    </div>
                    <div class="form-group">
                      <label for="loginPass">Lozinka</label>
                      <input type="password" class="form-control" id="loginPass" placeholder="Unesite lozinku...">
                    </div>
                    <div class="form-group">
                      <label for="loginPassConfirm">Ponovite lozinku</label>
                      <input type="password" class="form-control" id="loginPassConfirm" placeholder="Ponovite lozinku...">
                    </div>
                    <button type="submitLogin" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbsp;Prijava</button>
                    <button type="button" class="btn btn-secondary"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp;Natrag</button>
                  </form>

                  <hr>
                </div>
              </div>
              <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <img class="card-img-top" src="../../templates/evipod/images/afterglow-agriculture-back-light-512.jpg"
                  alt="Photo by Felix Mittermeier from Pexels">
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
                    <button type="submitRegistration" class="btn btn-primary"><i class="fas fa-user-plus"></i>&nbsp;Registracija</button>
                    <button type="button" class="btn btn-secondary"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp;Natrag</button>
                  </form>

                  <hr>
                </div>
              </div>
            </div>
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