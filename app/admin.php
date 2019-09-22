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
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="adminTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="usersListTab" data-toggle="tab" href="#usersList" role="tab">Lista korisnika</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="landingPageTab" data-toggle="tab" href="#landingPage" role="tab">Postavke odredišne stranice</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="adminTabContent">
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
                      echo "<td class='align-middle'>" . date('d. m. Y. H:i:s', strtotime($row['created_at'])) . "</td>";
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

            <!-- Div/tab za odredisnu stranicu -->
            <div class="tab-pane fade" id="landingPage" role="tabpanel">
              <h3>Postavke odredišne stranice</h3>
              <hr>
              <form method="POST" action="./includes/application/landing_page_inc.php">
                <div class="row">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x120" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h5 class="text-muted">Odjeljak 1</h5>
                    <div class="form-group row pl-3">
                      <label for="sectionOneTitle" class="col-sm-2 col-form-label col-form-label-sm">Naslov:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionOneTitle" name="sectionOneTitle" placeholder="Naslov prvog odjeljka">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionOneDesc" class="col-sm-2 col-form-label col-form-label-sm">Opis:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionOneDesc" name="sectionOneDesc" placeholder="Opis prvog odjeljka">
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row pb-4">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x120" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h5 class="text-muted">Odjeljak 2</h5>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoTitle" class="col-sm-2 col-form-label col-form-label-sm">Naslov:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoTitle" name="sectionTwoTitle" placeholder="Naslov drugog odjeljka">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoDesc" class="col-sm-2 col-form-label col-form-label-sm">Opis:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoDesc" name="sectionTwoDesc" placeholder="Opis drugog odjeljka">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row pb-4">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x120" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h6 class="text-muted">Prva usluga</h6>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoIconA" class="col-sm-2 col-form-label col-form-label-sm">Ikona:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoIconA" name="sectionTwoIconA" placeholder="Ikona prve usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoTitleA" class="col-sm-2 col-form-label col-form-label-sm">Naslov:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoTitleA" name="sectionTwoTitleA" placeholder="Naslov prve usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoDescA" class="col-sm-2 col-form-label col-form-label-sm">Opis:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoDescA" name="sectionTwoDescA" placeholder="Opis prve usluge">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row pb-4">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x120" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h6 class="text-muted">Druga usluga</h6>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoIconB" class="col-sm-2 col-form-label col-form-label-sm">Ikona:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoIconB" name="sectionTwoIconB" placeholder="Ikona druge usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoTitleB" class="col-sm-2 col-form-label col-form-label-sm">Naslov:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoTitleB" name="sectionTwoTitleB" placeholder="Naslov druge usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoDescB" class="col-sm-2 col-form-label col-form-label-sm">Opis:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoDescB" name="sectionTwoDescB" placeholder="Opis druge usluge">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row pb-4">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x120" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h6 class="text-muted">Treća usluga</h6>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoIconC" class="col-sm-2 col-form-label col-form-label-sm">Ikona:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoIconC" name="sectionTwoIconC" placeholder="Ikona treće usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoTitleC" class="col-sm-2 col-form-label col-form-label-sm">Naslov:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoTitleC" name="sectionTwoTitleC" placeholder="Naslov treće usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoDescC" class="col-sm-2 col-form-label col-form-label-sm">Opis:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoDescC" name="sectionTwoDescC" placeholder="Opis treće usluge">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x120" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h6 class="text-muted">Četvrta usluga</h6>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoIconD" class="col-sm-2 col-form-label col-form-label-sm">Ikona:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoIconD" name="sectionTwoIconD" placeholder="Ikona četvrte usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoTitleD" class="col-sm-2 col-form-label col-form-label-sm">Naslov:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoTitleD" name="sectionTwoTitleD" placeholder="Naslov četvrte usluge">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionTwoDescD" class="col-sm-2 col-form-label col-form-label-sm">Opis:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionTwoDescD" name="sectionTwoDescD" placeholder="Opis četvrte usluge">
                      </div>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-lg-6 text-center my-auto order-lg-last">
                    <img class="img-fluid mb-2" src="https://via.placeholder.com/576x240" alt="">
                  </div>
                  <div class="col-lg-6 order-lg-first">
                    <h5 class="text-muted">Odjeljak 3</h5>
                    <div class="form-group row pl-3">
                      <label for="sectionThreeName" class="col-sm-2 col-form-label col-form-label-sm">Ime:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreeName" name="sectionThreeName" placeholder="Ime tvrtke">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionThreeAddress" class="col-sm-2 col-form-label col-form-label-sm">Adresa:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreeAddress" name="sectionThreeAddress" placeholder="Adresa tvrtke">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionThreePost" class="col-sm-2 col-form-label col-form-label-sm">Poš. broj:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreePost" name="sectionThreePost" placeholder="Poštanski broj">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionThreeWebsite" class="col-sm-2 col-form-label col-form-label-sm">Web:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreeWebsite" name="sectionThreeWebsite" placeholder="Web stranica tvrtke">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionThreeEmail" class="col-sm-2 col-form-label col-form-label-sm">Email:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreeEmail" name="sectionThreeEmail" placeholder="Email tvrtke">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionThreeTel" class="col-sm-2 col-form-label col-form-label-sm">Tel:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreeTel" name="sectionThreeTel" placeholder="Broj telefona">
                      </div>
                    </div>
                    <div class="form-group row pl-3">
                      <label for="sectionThreeMob" class="col-sm-2 col-form-label col-form-label-sm">Mob:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control form-control-sm" id="sectionThreeMob" name="sectionThreeMob" placeholder="Broj mobitela">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row justify-content-center pt-5">
                  <button type="submit" name="landingPageEdit" value="edit" class="btn btn-info px-5"><i class="fas fa-pencil-alt"></i>&nbsp;&nbsp;Uredi</button>
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