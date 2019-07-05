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

  <!-- Modal za uredivanje gospodarstva -->
  <form method="POST" action="./includes/application/business_edit_inc.php">
    <div class="modal fade" id="businessEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="businessEditModalTitle">Uređivanje gospodarstva</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h5 class="text-muted">Osnovne informacije</h5>
            <div class="form-group row pl-3">
              <label for="businessNameEdit" class="col-sm-2 col-form-label col-form-label-sm">Naziv:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessNameEdit" name="businessNameEdit" placeholder="Naziv subjekta">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessOwnerEdit" class="col-sm-2 col-form-label col-form-label-sm">Vlasnik:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessOwnerEdit" name="businessOwnerEdit" placeholder="Vlasnik subjekta">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessOIBEdit" class="col-sm-2 col-form-label col-form-label-sm">OIB:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessOIBEdit" name="businessOIBEdit" placeholder="OIB subjekta ili vlasnika (osobni identifikacijski broj)">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessMIBPGEdit" class="col-sm-2 col-form-label col-form-label-sm">MIBPG:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessMIBPGEdit" name="businessMIBPGEdit" placeholder="MIBPG subjekta (matični identifikacijski broj poljoprivrednog gospodarstva)">
              </div>
            </div>
            <h5 class="text-muted">Lokacija</h5>
            <div class="form-group row pl-3">
              <label for="businessCountyEdit" class="col-sm-2 col-form-label col-form-label-sm">Županija:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessCountyEdit" name="businessCountyEdit" placeholder="Naziv županije">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessLocationEdit" class="col-sm-2 col-form-label col-form-label-sm">Mjesto:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessLocationEdit" name="businessLocationEdit" placeholder="Mjesto subjekta">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessPostEdit" class="col-sm-2 col-form-label col-form-label-sm">Pošta:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessPostEdit" name="businessPostEdit" placeholder="Pošta subjekta">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessAddressEdit" class="col-sm-2 col-form-label col-form-label-sm">Adresa:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessAddressEdit" name="businessAddressEdit" placeholder="Adresa subjekta">
              </div>
            </div>
            <h5 class="text-muted">Kontakt informacije</h5>
            <div class="form-group row pl-3">
              <label for="businessEmailEdit" class="col-sm-2 col-form-label col-form-label-sm">E-mail:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessEmailEdit" name="businessEmailEdit" placeholder="E-mail adresa">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessTelEdit" class="col-sm-2 col-form-label col-form-label-sm">Tel:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessTelEdit" name="businessTelEdit" placeholder="Broj telefona">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessMobEdit" class="col-sm-2 col-form-label col-form-label-sm">Mob:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessMobEdit" name="businessMobEdit" placeholder="Broj mobitela">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="businessEdit" id="businessEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje gospodarstva -->
  <form method="POST" action="./includes/application/business_delete_inc.php">
    <div class="modal fade" id="businessDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="businessDeleteModalTitle">Brisanje gospodarstva</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-3">
                <p class="text-center"><i class="fas fa-trash-alt fa-4x"></i></p>
              </div>
              <div class="col-9">
                <p class="font-weight-bold">Obrisati odabrano gospodarstvo:</p>
                <u>
                  <p id="businessDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
                <small class="text-muted">Brisanjem gospodarstva obrisat će se i djelatnosti vezane uz to gospodarstvo.</small>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="businessDelete" id="businessDelete" class="btn btn-danger"><i class="fas fa-edit"></i>&nbsp;&nbsp;Obriši</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za detalje gospodarstva -->
  <div class="modal fade" id="businessInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold text-truncate" id="businessInfoModalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <dl class="row">
            <dt class="col-sm-3">Vlasnik:</dt>
            <dd class="col-sm-9" id="businessOwnerInfo"></dd>
            <dt class="col-sm-3">OIB:</dt>
            <dd class="col-sm-9" id="businessOIBInfo"></dd>
            <dt class="col-sm-3">MIBPG:</dt>
            <dd class="col-sm-9" id="businessMIBPGInfo"></dd>
            <dt class="col-sm-3">Županija:</dt>
            <dd class="col-sm-9" id="businessCountyInfo"></dd>
            <dt class="col-sm-3">Mjesto:</dt>
            <dd class="col-sm-9" id="businessLocationInfo"></dd>
            <dt class="col-sm-3">Pošta:</dt>
            <dd class="col-sm-9" id="businessPostInfo"></dd>
            <dt class="col-sm-3">Adresa:</dt>
            <dd class="col-sm-9" id="businessAddressInfo"></dd>
            <dt class="col-sm-3">E-mail:</dt>
            <dd class="col-sm-9" id="businessEmailInfo"></dd>
            <dt class="col-sm-3">Tel:</dt>
            <dd class="col-sm-9" id="businessTelInfo"></dd>
            <dt class="col-sm-3">Mob:</dt>
            <dd class="col-sm-9" id="businessMobInfo"></dd>
            <dt class="col-sm-3">Dodano:</dt>
            <dd class="col-sm-9" id="businessAddedInfo"></dd>
          </dl>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
        </div>
      </div>
    </div>
  </div>

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
              <table class="table table-sm table-bordered table-hover text-center datatable-enable">
                <thead>
                  <tr>
                    <th>Naziv</th>
                    <th>Vlasnik</th>
                    <th>OIB</th>
                    <th>MIBPG</th>
                    <!-- <th>Županija</th>
                    <th>Mjesto</th>
                    <th>Pošta</th>
                    <th>Adresa</th>
                    <th>E-mail</th>
                    <th>Tel</th>
                    <th>Mob</th>
                    <th>Dodano</th> -->
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT * FROM business WHERE user_id = ? ORDER BY created_at");
                  $query->bind_param("i", $userID);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td><a href='' class='businessInfoLink' data-business-id-info='{$row['business_id']}'>{$row['business_name']}</a></td>";
                      echo "<td>{$row['business_owner']}</td>";
                      echo "<td>{$row['business_oib']}</td>";
                      echo "<td>{$row['business_mibpg']}</td>";
                      // echo "<td>{$row['business_county']}</td>";
                      // echo "<td>{$row['business_location']}</td>";
                      // echo "<td>{$row['business_post']}</td>";
                      // echo "<td>{$row['business_address']}</td>";
                      // echo "<td>{$row['business_email']}</td>";
                      // echo "<td>{$row['business_tel']}</td>";
                      // echo "<td>{$row['business_mob']}</td>";
                      // echo "<td>{$row['created_at']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-primary w-100 businessEditBtn' data-business-id-edit='{$row['business_id']}'>Uredi</button>
                                <button type='button' class='btn btn-danger w-100 businessDeleteBtn' data-business-id-delete='{$row['business_id']}'>Briši</button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
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