<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
if ($_SESSION['user_role'] != 'admin') header("Location: ./");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Admin";
$userId = $_SESSION['user_id'];
?>
<?php include('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include('./includes/partials/index_header.php'); ?>

  <?php include('./includes/partials/index_sidebar.php'); ?>

  <!-- Modal za blokiranje korisnika -->
  <form method="POST" action="./includes/application/user_ban_inc.php">
    <div class="modal fade" id="userBanModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-warning text-white">
            <h5 class="modal-title font-weight-bold" id="userBanModalTitle">Blokiranje korisnika</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-3">
                <p class="text-center"><i class="fas fa-user-lock fa-4x"></i></p>
              </div>
              <div class="col-9 align-self-center">
                <p class="font-weight-bold">Blokirati odabranog korisnika?</p>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="userBan" id="userBan" class="btn btn-warning"><i class="fas fa-user-lock"></i>&nbsp;&nbsp;Blokiraj</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za deblokiranje korisnika -->
  <form method="POST" action="./includes/application/user_unban_inc.php">
    <div class="modal fade" id="userUnbanModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-success text-white">
            <h5 class="modal-title font-weight-bold" id="userUnbanModalTitle">Deblokiranje korisnika</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-3">
                <p class="text-center"><i class="fas fa-user-check fa-4x"></i></p>
              </div>
              <div class="col-9 align-self-center">
                <p class="font-weight-bold">Deblokirati odabranog korisnika?</p>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="userUnban" id="userUnban" class="btn btn-success"><i class="fas fa-user-check"></i>&nbsp;&nbsp;Deblokiraj</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje korisnika -->
  <form method="POST" action="./includes/application/user_delete_inc.php">
    <div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="userDeleteModalTitle">Brisanje korisnika</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-3">
                <p class="text-center"><i class="fas fa-user-slash fa-4x"></i></p>
              </div>
              <div class="col-9 align-self-center">
                <p class="font-weight-bold">Obrisati odabranog korisnika?</p>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="userDelete" id="userDelete" class="btn btn-danger"><i class="fas fa-user-slash"></i>&nbsp;&nbsp;Obriši</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za uredivanje gospodarstva -->
  <form method="POST" action="./includes/application/business_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="businessEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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
                <input type="text" class="form-control form-control-sm" id="businessNameEdit" name="businessNameEdit" placeholder="Naziv subjekta" maxlength="100" required>
                <div class="invalid-feedback">
                  Naziv subjekta je obavezan (max 100 znakova).
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessOwnerEdit" class="col-sm-2 col-form-label col-form-label-sm">Vlasnik:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessOwnerEdit" name="businessOwnerEdit" placeholder="Vlasnik subjekta" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessOIBEdit" class="col-sm-2 col-form-label col-form-label-sm">OIB:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessOIBEdit" name="businessOIBEdit" placeholder="OIB subjekta ili vlasnika (osobni identifikacijski broj)" pattern="^[0-9]{11}$">
                <div class="invalid-feedback">
                  Neispravan format OIB-a.
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessMIBPGEdit" class="col-sm-2 col-form-label col-form-label-sm">MIBPG:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessMIBPGEdit" name="businessMIBPGEdit" placeholder="MIBPG subjekta (matični identifikacijski broj poljoprivrednog gospodarstva)" pattern="^[0-9]{1,7}$">
                <div class="invalid-feedback">
                  Neispravan format MIBPG-a.
                </div>
              </div>
            </div>
            <h5 class="text-muted">Lokacija</h5>
            <div class="form-group row pl-3">
              <label for="businessCountyEdit" class="col-sm-2 col-form-label col-form-label-sm">Županija:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessCountyEdit" name="businessCountyEdit" placeholder="Naziv županije" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessLocationEdit" class="col-sm-2 col-form-label col-form-label-sm">Mjesto:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessLocationEdit" name="businessLocationEdit" placeholder="Mjesto subjekta" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessPostEdit" class="col-sm-2 col-form-label col-form-label-sm">Pošta:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessPostEdit" name="businessPostEdit" placeholder="Pošta subjekta" pattern="^[0-9]{5}$">
                <div class="invalid-feedback">
                  Neispravan format poštanskog broja.
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessAddressEdit" class="col-sm-2 col-form-label col-form-label-sm">Adresa:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessAddressEdit" name="businessAddressEdit" placeholder="Adresa subjekta" maxlength="100">
              </div>
            </div>
            <h5 class="text-muted">Kontakt informacije</h5>
            <div class="form-group row pl-3">
              <label for="businessEmailEdit" class="col-sm-2 col-form-label col-form-label-sm">E-mail:</label>
              <div class="col-sm-10">
                <input type="email" class="form-control form-control-sm" id="businessEmailEdit" name="businessEmailEdit" placeholder="E-mail adresa" maxlength="100">
                <div class="invalid-feedback">
                  Neispravan format Email adrese.
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessTelEdit" class="col-sm-2 col-form-label col-form-label-sm">Tel:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessTelEdit" name="businessTelEdit" placeholder="Broj telefona" maxlength="100" pattern="^[0-9]{1,100}$">
                <div class="invalid-feedback">
                  Neispravan format broja telefona.
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="businessMobEdit" class="col-sm-2 col-form-label col-form-label-sm">Mob:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="businessMobEdit" name="businessMobEdit" placeholder="Broj mobitela" maxlength="100" pattern="^[0-9]{1,100}$">
                <div class="invalid-feedback">
                  Neispravan format broja mobitela.
                </div>
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
            <dt class="col-sm-3">Naziv:</dt>
            <dd class="col-sm-9" id="businessNameInfo"></dd>
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
          <i class="fas fa-user-shield"></i><strong>&nbsp;&nbsp;Admin</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="usersTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="usersListTab" data-toggle="tab" href="#usersList" role="tab">Lista korisnika</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="usersAddTab" data-toggle="tab" href="#usersAdd" role="tab">Postavke odredišne stranice</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="usersTabContent">
            <!-- Div/tab za listu korisnika -->
            <div class="tab-pane fade show active" id="usersList" role="tabpanel">
              <h3>Lista korisnika</h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="usersTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Email</th>
                    <th>Registriran</th>
                    <th style="width: 10%">Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT * FROM users WHERE user_id != ? ORDER BY created_at");
                  $query->bind_param("i", $userId);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['user_id']}</td>";
                      echo "<td class='align-middle'>{$row['user_name']}</td>";
                      echo "<td class='align-middle'>{$row['user_email']}</td>";
                      echo "<td class='align-middle'>{$row['created_at']}</td>";
                      echo "<td class='align-middle'><div class='btn-group btn-group-sm d-flex' role='group'>";
                      echo $row['is_banned'] == 0 ? "<button type='button' class='btn btn-link text-warning userBanBtn' title='Ban' data-user-id-ban='{$row['user_id']}'><i class='fas fa-user-lock'></i></button>"
                        : "<button type='button' class='btn btn-link text-success userUnbanBtn' title='Unban' data-user-id-unban='{$row['user_id']}'><i class='fas fa-user-check'></i></button>";
                      echo "<button type='button' class='btn btn-link text-danger userDeleteBtn' title='Izbriši' data-user-id-delete='{$row['user_id']}'><i class='fas fa-user-slash'></i></button>";
                      echo "</div></td>";
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
              <form method="POST" action="./includes/application/business_add_inc.php" class="needs-validation" novalidate>
                <h5 class="text-muted">Osnovne informacije</h5>
                <div class="form-group row pl-3">
                  <label for="businessName" class="col-sm-2 col-form-label col-form-label-sm">Naziv:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessName" name="businessName" placeholder="Naziv subjekta" maxlength="100" required>
                    <div class="invalid-feedback">
                      Naziv subjekta je obavezan (max 100 znakova).
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessOwner" class="col-sm-2 col-form-label col-form-label-sm">Vlasnik:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessOwner" name="businessOwner" placeholder="Vlasnik subjekta" maxlength="100">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessOIB" class="col-sm-2 col-form-label col-form-label-sm">OIB:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessOIB" name="businessOIB" placeholder="OIB subjekta ili vlasnika (osobni identifikacijski broj)" pattern="^[0-9]{11}$">
                    <div class="invalid-feedback">
                      Neispravan format OIB-a.
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessMIBPG" class="col-sm-2 col-form-label col-form-label-sm">MIBPG:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessMIBPG" name="businessMIBPG" placeholder="MIBPG subjekta (matični identifikacijski broj poljoprivrednog gospodarstva)" pattern="^[0-9]{1,7}$">
                    <div class="invalid-feedback">
                      Neispravan format MIBPG-a.
                    </div>
                  </div>
                </div>
                <h5 class="text-muted">Lokacija</h5>
                <div class="form-group row pl-3">
                  <label for="businessCounty" class="col-sm-2 col-form-label col-form-label-sm">Županija:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessCounty" name="businessCounty" placeholder="Naziv županije" maxlength="100">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessLocation" class="col-sm-2 col-form-label col-form-label-sm">Mjesto:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessLocation" name="businessLocation" placeholder="Mjesto subjekta" maxlength="100">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessPost" class="col-sm-2 col-form-label col-form-label-sm">Pošta:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessPost" name="businessPost" placeholder="Pošta subjekta" pattern="^[0-9]{5}$">
                    <div class="invalid-feedback">
                      Neispravan format poštanskog broja.
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessAddress" class="col-sm-2 col-form-label col-form-label-sm">Adresa:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessAddress" name="businessAddress" placeholder="Adresa subjekta" maxlength="100">
                  </div>
                </div>
                <h5 class="text-muted">Kontakt informacije</h5>
                <div class="form-group row pl-3">
                  <label for="businessEmail" class="col-sm-2 col-form-label col-form-label-sm">E-mail:</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control form-control-sm" id="businessEmail" name="businessEmail" placeholder="E-mail adresa" maxlength="100">
                    <div class="invalid-feedback">
                      Neispravan format Email adrese.
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessTel" class="col-sm-2 col-form-label col-form-label-sm">Tel:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessTel" name="businessTel" placeholder="Broj telefona" maxlength="100" pattern="^[0-9]{1,100}$">
                    <div class="invalid-feedback">
                      Neispravan format broja telefona.
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessMob" class="col-sm-2 col-form-label col-form-label-sm">Mob:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessMob" name="businessMob" placeholder="Broj mobitela" maxlength="100" pattern="^[0-9]{1,100}$">
                    <div class="invalid-feedback">
                      Neispravan format broja mobitela.
                    </div>
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

</body>


</html>