<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Postavke";
$userId = $_SESSION['user_id'];
?>
<?php include('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include('./includes/partials/index_header.php'); ?>

  <?php include('./includes/partials/index_sidebar.php'); ?>

  <section class="content">
    <div class="container-fluid">
      <div class="position-relative d-flex justify-content-center">

        <!-- Ispisivanje toast-a preko sesije -->
        <?php
        if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
          echo $_SESSION['msg'];
          unset($_SESSION['msg']);
        }
        ?>
      </div>

      <div class="card">
        <h5 class="card-header text-center bg-secondary">
          <i class="fas fa-user-cog"></i><strong>&nbsp;&nbsp;Postavke</strong>
        </h5>
        <div class="card-body">
          <h3>Nova lozinka</h3>
          <hr>
          <form class="needs-validation" action="./includes/application/settings_inc.php" method="POST" novalidate>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="oldPassword">Stara lozinka:</label>
                <input type="password" class="form-control form-control-sm" id="oldPassword" name="oldPassword" placeholder="Unesite staru lozinku" pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,50}$" required>
                <div class="invalid-feedback">Lozinka je krivog formata (min. 6, max. 50 znakova).</div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="newPassword">Nova lozinka:</label>
                <input type="password" class="form-control form-control-sm" id="newPassword" name="newPassword" placeholder="Unesite novu lozinku" pattern="^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,50}$" required>
                <div class="invalid-feedback">Lozinka mora imati slova i brojke (min. 6, max. 50 znakova).</div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="newPasswordRepeat">Ponovite lozinku:</label>
                <input type="password" class="form-control form-control-sm" id="newPasswordRepeat" name="newPasswordRepeat" placeholder="Ponovite novu lozinku" required>
                <div class="invalid-feedback">Lozinke moraju biti jednake.</div>
              </div>
            </div>
            <div class="form-row pt-3">
              <div class="form-group col-md-6 d-flex justify-content-end">
                <button type="submit" name="settingsSubmit" class="btn btn-info px-5"><i class="fas fa-user-cog"></i>&nbsp;&nbsp;Spremi</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php include('./includes/partials/index_footer.php'); ?>

</body>


</html>