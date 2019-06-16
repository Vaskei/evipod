<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
$title = "Evipod - Gospodarstvo";
$userID = $_SESSION['user_id'];
?>
<?php include('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include('./includes/partials/index_header.php'); ?>

  <?php include('./includes/partials/index_sidebar.php'); ?>


  <section class="content">
    <div class="container-fluid">
      <div class="position-relative d-flex justify-content-center">
        <!-- <div class="toast position-absolute" data-autohide="false">
          <div class="toast-header">
            <i class="fas fa-exclamation-circle fa-lg mr-2 text-danger"></i>
            <strong class="mr-auto text-danger">Bootstrap</strong>
            <button type="button" class="close text-dark" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true"><i class="fas fa-times fa-sm"></i></span>
            </button>
          </div>
          <div class="toast-body bg-white">
            Hello, world! This is a toast message. Hello, world! This is a toast message. Hello, world! This is a toast message.
          </div>
        </div> -->

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
          <i class="fas fa-apple-alt"></i><strong>&nbsp;&nbsp;Gospodarstvo</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="businessTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="businessListTab" data-toggle="tab" href="#businessList" role="tab">Lista gospodarstva</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="businessAddTab" data-toggle="tab" href="#businessAdd" role="tab">Dodaj
                gospodarstvo</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="businessTabContent">
            <!-- Div/tab za listu gospodarstva -->
            <div class="tab-pane fade show active" id="businessList" role="tabpanel">
              <h3>Lista gospodarstva</h3>
              <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover text-center datatable">
                  <thead>
                    <tr>
                      <th>Naziv</th>
                      <th>Vlasnik</th>
                      <th>OIB</th>
                      <th>MIBPG</th>
                      <th>Županija</th>
                      <th>Mjesto</th>
                      <th>Pošta</th>
                      <th>Adresa</th>
                      <th>E-mail</th>
                      <th>Tel</th>
                      <th>Mob</th>
                      <th>Opcije</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $query = $conn->prepare("SELECT * FROM business WHERE user_id = ?");
                    $query->bind_param("i", $userID);
                    $query->execute();
                    $result = $query->get_result();
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['business_name']}</td>";
                        echo "<td>{$row['business_owner']}</td>";
                        echo "<td>{$row['business_oib']}</td>";
                        echo "<td>{$row['business_mibpg']}</td>";
                        echo "<td>{$row['business_county']}</td>";
                        echo "<td>{$row['business_location']}</td>";
                        echo "<td>{$row['business_post']}</td>";
                        echo "<td>{$row['business_address']}</td>";
                        echo "<td>{$row['business_email']}</td>";
                        echo "<td>{$row['business_tel']}</td>";
                        echo "<td>{$row['business_mob']}</td>";
                        echo "<td>
                                <div class='btn-group d-flex' role='group'>
                                  <button type='button' class='btn btn-primary w-100' data-business-id-edit='{$row['business_id']}'>Uredi</button>
                                  <button type='button' class='btn btn-danger w-100' data-business-id-delete='{$row['business_id']}'>Briši</button>
                                </div>
                              </td>";
                        echo "</tr>";
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>              
            </div>

            <!-- Div/tab za dodavanje gospodarstva -->
            <div class="tab-pane fade" id="businessAdd" role="tabpanel">
              <h3>Dodaj gospodarstvo</h3>
              <hr>
              <form method="POST" action="./includes/application/business_add_inc.php">
                <h5 class="text-muted">Osnovne informacije</h5>
                <div class="form-group row pl-3">
                  <label for="businessName" class="col-sm-2 col-form-label col-form-label-sm">Naziv:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessName" name="businessName" placeholder="Naziv subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessOwner" class="col-sm-2 col-form-label col-form-label-sm">Vlasnik:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessOwner" name="businessOwner" placeholder="Vlasnik subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessOIB" class="col-sm-2 col-form-label col-form-label-sm">OIB:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessOIB" name="businessOIB" placeholder="OIB subjekta ili vlasnika (osobni identifikacijski broj)">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessMIBPG" class="col-sm-2 col-form-label col-form-label-sm">MIBPG:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessMIBPG" name="businessMIBPG" placeholder="MIBPG subjekta (matični identifikacijski broj poljoprivrednog gospodarstva)">
                  </div>
                </div>
                <h5 class="text-muted">Lokacija</h5>
                <div class="form-group row pl-3">
                  <label for="businessCounty" class="col-sm-2 col-form-label col-form-label-sm">Županija:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessCounty" name="businessCounty" placeholder="Naziv županije">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessLocation" class="col-sm-2 col-form-label col-form-label-sm">Mjesto:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessLocation" name="businessLocation" placeholder="Mjesto subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessPost" class="col-sm-2 col-form-label col-form-label-sm">Pošta:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessPost" name="businessPost" placeholder="Pošta subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessAddress" class="col-sm-2 col-form-label col-form-label-sm">Adresa:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessAddress" name="businessAddress" placeholder="Adresa subjekta">
                  </div>
                </div>
                <h5 class="text-muted">Kontakt informacije</h5>
                <div class="form-group row pl-3">
                  <label for="businessEmail" class="col-sm-2 col-form-label col-form-label-sm">E-mail:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessEmail" name="businessEmail" placeholder="E-mail adresa">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessTel" class="col-sm-2 col-form-label col-form-label-sm">Tel:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessTel" name="businessTel" placeholder="Broj telefona">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessMob" class="col-sm-2 col-form-label col-form-label-sm">Mob:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessMob" name="businessMob" placeholder="Broj mobitela">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <button type="submit" name="businessAdd" class="btn btn-success px-5"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include('./includes/partials/index_footer.php'); ?>

  <script>
  document.querySelector('#app_business').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>