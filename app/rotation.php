<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Plodored";
$userId = $_SESSION['user_id'];
?>
<?php include('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include('./includes/partials/index_header.php'); ?>

  <?php include('./includes/partials/index_sidebar.php'); ?>

  <?php
  // Dohvat zemljista
  $query = $conn->prepare("SELECT * FROM fields WHERE business_id = ? ORDER BY created_at");
  $query->bind_param("i", $resultUser['current_business_id']);
  $query->execute();
  $resultFields = $query->get_result();
  ?>

  <!-- Modal za uredivanje plodoreda -->
  <form method="POST" action="./includes/application/rotation_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="rotationEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="rotationEditModalTitle">Uređivanje plodoreda</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="rotationFieldEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    // Pokazivac result_set-a od prve while petlje pokazuje na kraj, pa resetiramo pokazivac na pocetak result_set-a ili sljedeca while petlja vraca null
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='rotationFieldEdit' id='rotationFieldEdit'> required";
                      while ($row = $resultFields->fetch_assoc()) {
                        echo "<option value='{$row['field_id']}'>{$row['field_name']}</option>";
                      }
                      echo "</select>";
                    } else {
                      echo "
                      <select class='form-control form-control-sm' name='' id='' required>
                        <option value='' selected required>Nema evidentiranih zemljišta.</option>
                      </select>";
                    }
                    ?>
                <?php else : ?>
                  <select class="form-control form-control-sm" name="" id="" required>
                    <option value="" selected required>Nema aktivnog gospodarstva.</option>
                  </select>
                <?php endif; ?>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="rotationYearEdit" class="col-sm-3 col-form-label col-form-label-sm">Godina:</label>
              <div class="col-sm-9">
                <select class="form-control form-control-sm" name="rotationYearEdit" id="rotationYearEdit" required>
                  <?php
                  $startYear = 1970;
                  $endYear = date('Y') + 5;
                  for ($i = $startYear; $i <= $endYear; $i++) {
                    if ($i == date('Y')) {
                      echo "<option value='{$i}' selected>{$i}.</option>";
                    } else echo "<option value='{$i}'>{$i}.</option>";
                  }
                  ?>
                </select>
                <div class="invalid-feedback">
                  Godina je obavezna.
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="rotationNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="rotationNameEdit" id="rotationNameEdit" placeholder="Kultura" maxlength="100" required>
                <div class="invalid-feedback">
                  Kultura je obavezna.
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="rotationNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="rotationNoteEdit" id="rotationNoteEdit" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="rotationEdit" id="rotationEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje plodoreda -->
  <form method="POST" action="./includes/application/rotation_delete_inc.php">
    <div class="modal fade" id="rotationDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="rotationDeleteModalTitle">Brisanje plodoreda</h5>
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
                <p class="font-weight-bold">Obrisati odabrani plodored:</p>
                <u>
                  <p id="rotationDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="rotationDelete" id="rotationDelete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Obriši</button>
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
          <i class="fas fa-sync"></i><strong>&nbsp;&nbsp;Plodored</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="rotationTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="rotationListTab" data-toggle="tab" href="#rotationList" role="tab">Lista plodoreda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="rotationAddTab" data-toggle="tab" href="#rotationAdd" role="tab">Dodaj plodored</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="rotationTabContent">
            <!-- Div/tab za listu plodoreda -->
            <div class="tab-pane fade show active" id="rotationList" role="tabpanel">
              <h3>Lista plodoreda</h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="rotationTable">
                <thead>
                  <tr>
                    <th>Zemljište (ARKOD)</th>
                    <th>Godina</th>
                    <th>Kultura</th>
                    <th>Napomena</th>
                    <th style="width: 10%">Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, rotation.* FROM rotation INNER JOIN fields ON rotation.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY rotation.rotation_year");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['field_name']}<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['rotation_year']}.</td>";
                      echo "<td class='align-middle'>{$row['rotation_name']}</td>";
                      echo "<td class='align-middle'>{$row['rotation_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info rotationEditBtn' title='Uredi' data-rotation-id-edit='{$row['rotation_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger rotationDeleteBtn' title='Izbriši' data-rotation-id-delete='{$row['rotation_id']}'><i class='fas fa-trash-alt'></i></button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Div/tab za dodavanje plodoreda -->
            <div class="tab-pane fade" id="rotationAdd" role="tabpanel">
              <h3>Dodaj plodored</h3>
              <hr>
              <form method="POST" action="./includes/application/rotation_add_inc.php" class="needs-validation" novalidate>
                <div class="form-group row pl-3">
                  <label for="rotationField" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
                  <div class="col-sm-9">
                    <?php if ($resultUser['current_business_id'] != NULL) : ?>
                      <?php
                        // Pokazivac result_set-a od prve while petlje pokazuje na kraj, pa resetiramo pokazivac na pocetak result_set-a ili sljedeca while petlja vraca null
                        $resultFields->data_seek(0);
                        if ($resultFields->num_rows > 0) {
                          echo "<select class='form-control form-control-sm' name='rotationField' id='rotationField'> required";
                          while ($row = $resultFields->fetch_assoc()) {
                            echo "<option value='{$row['field_id']}'>{$row['field_name']}</option>";
                          }
                          echo "</select>";
                        } else {
                          echo "
                      <select class='form-control form-control-sm' name='' id='' required>
                        <option value='' selected required>Nema evidentiranih zemljišta.</option>
                      </select>";
                        }
                        ?>
                    <?php else : ?>
                      <select class="form-control form-control-sm" name="" id="" required>
                        <option value="" selected required>Nema aktivnog gospodarstva.</option>
                      </select>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="rotationYear" class="col-sm-3 col-form-label col-form-label-sm">Godina:</label>
                  <div class="col-sm-9">
                    <select class="form-control form-control-sm" name="rotationYear" id="rotationYear" required>
                      <?php
                      $startYear = 1970;
                      $endYear = date('Y') + 5;
                      for ($i = $startYear; $i <= $endYear; $i++) {
                        if ($i == date('Y')) {
                          echo "<option value='{$i}' selected>{$i}.</option>";
                        } else echo "<option value='{$i}'>{$i}.</option>";
                      }
                      ?>
                    </select>
                    <div class="invalid-feedback">
                      Godina je obavezna.
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="rotationName" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" name="rotationName" id="rotationName" placeholder="Kultura" maxlength="100" required>
                    <div class="invalid-feedback">
                      Kultura je obavezna.
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="rotationNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" name="rotationNote" id="rotationNote" placeholder="Napomena" maxlength="100">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <button type="submit" name="rotationAdd" class="btn btn-success px-5"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
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
    document.querySelector('#app_rotation').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>