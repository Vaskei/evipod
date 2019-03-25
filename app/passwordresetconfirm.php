<?php
session_start();
require_once './includes/functions.php';
if (isset($_SESSION['user_id'])) header("Location: ./");
$selector = $_GET['selector'];
$token = $_GET['token'];
if (empty($selector) || empty($token) || ctype_xdigit($selector) === false || ctype_xdigit($token) === false) {
  redirectWithMsg("warning", "Neispravni podaci!", "./membership");
}
// ob_start();
require_once "./includes/connection.php";
$title = "Evipod - Nova lozinka"
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
  <link rel="stylesheet" href="./styles/membership.css">
  <link rel="stylesheet" href="./styles/custom.css">

  <title><?php echo isset($title) ? $title : 'Evipod' ; ?></title>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8 col-lg-6">
        <div class="card card-tabs-custom">
          <div class="card-body pb-0">
            <img class="card-img-top" src="./images/cyber-security-cybersecurity-device-512.jpg">
            <div class="card-body">
              <h4 class="card-title text-center">NOVA LOZINKA</h4>
              <hr>
              <form class="needs-validation" method="POST" action="./includes/pwdresetconfirm.php" novalidate>
                <div class="form-group">
                  <label for="pwdResetConfirm">Nova lozinka</label>
                  <input type="password" class="form-control" id="pwdResetConfirm" name="pwdResetConfirm" placeholder="Unesite novu lozinku..."
                    required pattern="^[a-zA-Z0-9]{6,50}$">
                  <div class="invalid-feedback">Lozinka može imati samo slova i brojke (min. 6, max. 50 znakova).</div>
                </div>
                <div class="form-group">
                  <label for="pwdResetConfirmRepeat">Ponovite novu lozinku</label>
                  <input type="password" class="form-control" id="pwdResetConfirmRepeat" name="pwdResetConfirmRepeat"
                    placeholder="Ponovite novu lozinku..." required pattern="^[a-zA-Z0-9]{6,50}$">
                  <div class="invalid-feedback" id="password_match">Lozinke moraju biti jednake.</div>
                </div>
                <input type="hidden" name="pwdResetConfirmSelector" value="<?php echo $selector; ?>">
                <input type="hidden" name="pwdResetConfirmToken" value="<?php echo $token; ?>">
                <button type="submit" name="pwdResetConfirmSubmit" class="btn btn-primary"><i class="fas fa-passport"></i>&nbsp;Nova
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