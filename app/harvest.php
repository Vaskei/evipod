<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Berba/žetva";
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

  <!-- Modal za uredivanje berbe/zetve -->
  <form method="POST" action="./includes/application/harvest_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="harvestEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="harvestEditModalTitle">Uređivanje zemljišta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="harvestFieldEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    // Pokazivac result_set-a od prve while petlje pokazuje na kraj, pa resetiramo pokazivac na pocetak result_set-a ili sljedeca while petlja vraca null
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='harvestFieldEdit' id='harvestFieldEdit'> required";
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
              <label for="harvestNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="harvestNameEdit" id="harvestNameEdit" placeholder="Kultura" required>
                <div class="invalid-feedback">
                  Kultura berbe ili žetve je obavezna (max 100 znakova).
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="harvestAmountEdit" class="col-sm-3 col-form-label col-form-label-sm">Količina (kg/t):</label>
              <div class="col-sm-7">
                <input type="number" class="form-control form-control-sm" name="harvestAmountEdit" id="harvestAmountEdit" min="0" max="99999999" step="1" placeholder="Količina (kg/t)" pattern="^[0-9]{1,11}$">
                <div class="invalid-feedback">
                  Neispravna količina.
                </div>
              </div>
              <div class="col-sm-2">
                <select class="form-control form-control-sm" name="harvestAmountUnitEdit" id="harvestAmountUnitEdit">
                  <option value="kg">kg</option>
                  <option value="t">t</option>
                </select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="harvestDateEdit" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="harvestDateEdit" name="harvestDateEdit" placeholder="Datum berbe/žetve" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="harvestNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="harvestNoteEdit" id="harvestNoteEdit" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="harvestEdit" id="harvestEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje berbe/zetve -->
  <form method="POST" action="./includes/application/harvest_delete_inc.php">
    <div class="modal fade" id="harvestDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="harvestDeleteModalTitle">Brisanje berbe/žetve</h5>
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
                <p class="font-weight-bold">Obrisati odabranu berbu/žetvu:</p>
                <u>
                  <p id="harvestDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="harvestDelete" id="harvestDelete" class="btn btn-danger"><i class="fas fa-edit"></i>&nbsp;&nbsp;Obriši</button>
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
          <i class="fas fa-clipboard-check"></i><strong>&nbsp;&nbsp;Berba/žetva</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="harvestTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="harvestListTab" data-toggle="tab" href="#harvestList" role="tab">Lista berbe/žetve</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="harvestAddTab" data-toggle="tab" href="#harvestAdd" role="tab">Dodaj berbu/žetvu</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="harvestTabContent">
            <!-- Div/tab za listu berbe/zetve -->
            <div class="tab-pane fade show active" id="harvestList" role="tabpanel">
              <h3>Lista berbe/žetve</h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="harvestTable">
                <thead>
                  <tr>
                    <th>Naziv zemljišta</th>
                    <th>Kultura</th>
                    <th>Količina (kg/t)</th>
                    <th>Datum</th>
                    <th>Napomena</th>
                    <th style="width: 10%">Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, harvest.* FROM harvest INNER JOIN fields ON harvest.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id, harvest.harvest_date");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['field_name']}<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['harvest_name']}</td>";
                      echo "<td class='align-middle'>{$row['harvest_amount']} {$row['harvest_amount_unit']}</td>";
                      echo "<td class='align-middle'>" . date('d. m. Y.', strtotime($row['harvest_date'])) . "</td>";
                      echo "<td class='align-middle'>{$row['harvest_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info harvestEditBtn' title='Uredi' data-harvest-id-edit='{$row['harvest_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger harvestDeleteBtn' title='Izbriši' data-harvest-id-delete='{$row['harvest_id']}'><i class='fas fa-trash-alt'></i></button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Div/tab za dodavanje berbe/zetve -->
            <div class="tab-pane fade" id="harvestAdd" role="tabpanel">
              <h3>Dodaj berbu/žetvu</h3>
              <hr>
              <form method="POST" action="./includes/application/harvest_add_inc.php" class="needs-validation" novalidate>
                <div class="form-group row pl-3">
                  <label for="harvestField" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
                  <div class="col-sm-9">
                    <?php if ($resultUser['current_business_id'] != NULL) : ?>
                      <?php
                        // Pokazivac result_set-a od prve while petlje pokazuje na kraj, pa resetiramo pokazivac na pocetak result_set-a ili sljedeca while petlja vraca null
                        $resultFields->data_seek(0);
                        if ($resultFields->num_rows > 0) {
                          echo "<select class='form-control form-control-sm' name='harvestField' id='harvestField'> required";
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
                  <label for="harvestName" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" name="harvestName" id="harvestName" placeholder="Kultura" maxlength="100" required>
                    <div class="invalid-feedback">
                      Kultura berbe ili žetve je obavezna (max 100 znakova).
                    </div>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="harvestAmount" class="col-sm-3 col-form-label col-form-label-sm">Količina (kg/t):</label>
                  <div class="col-sm-7">
                    <input type="number" class="form-control form-control-sm" name="harvestAmount" id="harvestAmount" min="0" max="99999999" step="1" placeholder="Količina (kg/t)" pattern="^[0-9]{1,11}$">
                    <div class="invalid-feedback">
                      Neispravna količina.
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control form-control-sm" name="harvestAmountUnit" id="harvestAmountUnit">
                      <option value="kg">kg</option>
                      <option value="t">t</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="harvestDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm bg-white date-picker" id="harvestDate" name="harvestDate" placeholder="Datum berbe/žetve" readonly>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="harvestNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control form-control-sm" name="harvestNote" id="harvestNote" placeholder="Napomena" maxlength="100">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <button type="submit" name="harvestAdd" class="btn btn-success px-5"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
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
    document.querySelector('#app_harvest').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>