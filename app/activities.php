<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Evidencija djelatnosti";
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

  <!-- Modal za dodavanje zastite -->
  <form method="POST" action="./includes/application/protection_add_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="protectionAddModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="protectionAddModalTitle">Zaštita</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="protectionField" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='protectionField' id='protectionField'> required";
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
              <label for="protectionName" class="col-sm-3 col-form-label col-form-label-sm">Naziv SZB:</label>
              <div class="col-sm-9">
                <input list="protectionNameList" type="text" class="form-control form-control-sm" id="protectionName" name="protectionName" placeholder="Naziv sredstva za zaštitu bilja" maxlength="100" required>
                <div class="invalid-feedback">
                  Naziv sredstva je obavezan (max 100 znakova).
                </div>
                <datalist id="protectionNameList">
                  <!-- JSON ucitavanje -->
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionOrganism" class="col-sm-3 col-form-label col-form-label-sm">Štetni organizam:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionOrganism" name="protectionOrganism" placeholder="Naziv štetnog organizma" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionDate" class="col-sm-3 col-form-label col-form-label-sm">Datum i vrijeme:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-time-picker" id="protectionDate" name="protectionDate" placeholder="Datum i vrijeme tretiranja" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionAmount" class="col-sm-3 col-form-label col-form-label-sm">Količina:</label>
              <div class="col-sm-6">
                <input type="number" class="form-control form-control-sm" name="protectionAmount" id="protectionAmount" min="0" max="99999999" step="0.01" placeholder="Količina SZB (kg/ha ili l/ha)" pattern="^\d{0,8}(\.\d{0,2})?$">
                <div class="invalid-feedback">
                  Neispravna količina sredstva (min 0, max 99999999).
                </div>
              </div>
              <div class="col-sm-3">
                <select class="form-control form-control-sm" name="protectionAmountUnit" id="protectionAmountUnit">
                  <option value="kg/ha">kg/ha</option>
                  <option value="l/ha">l/ha</option>
                </select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionPlant" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionPlant" name="protectionPlant" placeholder="Kultura" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionNote" name="protectionNote" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="protectionAdd" id="protectionAdd" class="btn btn-success"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za uredivanje zastite -->
  <form method="POST" action="./includes/application/protection_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="protectionEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="protectionEditModalTitle">Uređivanje zaštite</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="protectionFieldEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='protectionFieldEdit' id='protectionFieldEdit'> required";
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
              <label for="protectionNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv SZB:</label>
              <div class="col-sm-9">
                <input list="protectionNameListEdit" type="text" class="form-control form-control-sm" id="protectionNameEdit" name="protectionNameEdit" placeholder="Naziv sredstva za zaštitu bilja" maxlength="100" required>
                <div class="invalid-feedback">
                  Naziv sredstva je obavezan (max 100 znakova).
                </div>
                <datalist id="protectionNameListEdit">
                  <!-- JSON ucitavanje -->
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionOrganismEdit" class="col-sm-3 col-form-label col-form-label-sm">Štetni organizam:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionOrganismEdit" name="protectionOrganismEdit" placeholder="Naziv štetnog organizma" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionDateEdit" class="col-sm-3 col-form-label col-form-label-sm">Datum i vrijeme:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-time-picker" id="protectionDateEdit" name="protectionDateEdit" placeholder="Datum i vrijeme tretiranja" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionAmountEdit" class="col-sm-3 col-form-label col-form-label-sm">Količina:</label>
              <div class="col-sm-6">
                <input type="number" class="form-control form-control-sm" name="protectionAmountEdit" id="protectionAmountEdit" min="0" max="99999999" step="0.01" placeholder="Količina SZB (kg/ha ili l/ha)" pattern="^\d{0,8}(\.\d{0,2})?$">
                <div class="invalid-feedback">
                  Neispravna količina sredstva (min 0, max 99999999).
                </div>
              </div>
              <div class="col-sm-3">
                <select class="form-control form-control-sm" name="protectionAmountUnitEdit" id="protectionAmountUnitEdit">
                  <option value="kg/ha">kg/ha</option>
                  <option value="l/ha">l/ha</option>
                </select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionPlantEdit" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionPlantEdit" name="protectionPlantEdit" placeholder="Kultura" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionNoteEdit" name="protectionNoteEdit" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="protectionEdit" id="protectionEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje zastite -->
  <form method="POST" action="./includes/application/protection_delete_inc.php">
    <div class="modal fade" id="protectionDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="protectionDeleteModalTitle">Brisanje zaštite</h5>
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
                <p class="font-weight-bold">Obrisati odabranu zaštitu:</p>
                <u>
                  <p id="protectionDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
                <!-- <small class="text-muted">Brisanjem zemljišta obrisat će se i djelatnosti vezane uz to zemljište.</small> -->
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="protectionDelete" id="protectionDelete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Obriši</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za dodavanje gnojidbe -->
  <form method="POST" action="./includes/application/fertilization_add_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="fertilizationAddModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="fertilizationAddModalTitle">Gnojidba</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="fertilizationField" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='fertilizationField' id='fertilizationField'> required";
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
              <label for="fertilizationName" class="col-sm-3 col-form-label col-form-label-sm">Gnojivo:</label>
              <div class="col-sm-9">
                <input list="fertilizationNameList" type="text" class="form-control form-control-sm" id="fertilizationName" name="fertilizationName" placeholder="Naziv gnojiva" maxlength="100" required>
                <div class="invalid-feedback">
                  Ime gnojiva je obavezno (max 100 znakova).
                </div>
                <datalist id="fertilizationNameList">
                  <!-- JSON ucitavanje -->
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="fertilizationDate" name="fertilizationDate" placeholder="Datum obrade tla" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationAmount" class="col-sm-3 col-form-label col-form-label-sm">Količina (kg/ha):</label>
              <div class="col-sm-9">
                <input type="number" class="form-control form-control-sm" name="fertilizationAmount" id="fertilizationAmount" min="0" max="99999999" step="0.01" placeholder="Količina gnojiva (kg/ha)" pattern="^\d{0,8}(\.\d{0,2})?$">
                <div class="invalid-feedback">
                  Neispravna količina gnojiva (min 0, max 99999999).
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="fertilizationNote" name="fertilizationNote" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="fertilizationAdd" id="fertilizationAdd" class="btn btn-success"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za uredivanje gnojidbe -->
  <form method="POST" action="./includes/application/fertilization_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="fertilizationEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="fertilizationEditModalTitle">Uređivanje gnojidbe</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="fertilizationFieldEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='fertilizationFieldEdit' id='fertilizationFieldEdit'> required";
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
              <label for="fertilizationNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Gnojivo:</label>
              <div class="col-sm-9">
                <input list="fertilizationNameListEdit" type="text" class="form-control form-control-sm" id="fertilizationNameEdit" name="fertilizationNameEdit" placeholder="Naziv gnojiva" maxlength="100" required>
                <div class="invalid-feedback">
                  Ime gnojiva je obavezno (max 100 znakova).
                </div>
                <datalist id="fertilizationNameListEdit">
                  <!-- JSON ucitavanje -->
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationDateEdit" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="fertilizationDateEdit" name="fertilizationDateEdit" placeholder="Datum obrade tla" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationAmountEdit" class="col-sm-3 col-form-label col-form-label-sm">Količina (kg/ha):</label>
              <div class="col-sm-9">
                <input type="number" class="form-control form-control-sm" name="fertilizationAmountEdit" id="fertilizationAmountEdit" min="0" max="99999999" step="0.01" placeholder="Količina gnojiva (kg/ha)" pattern="^\d{0,8}(\.\d{0,2})?$">
                <div class="invalid-feedback">
                  Neispravna količina gnojiva (min 0, max 99999999).
                </div>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="fertilizationNoteEdit" name="fertilizationNoteEdit" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="fertilizationEdit" id="fertilizationEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje gnojidbe -->
  <form method="POST" action="./includes/application/fertilization_delete_inc.php">
    <div class="modal fade" id="fertilizationDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="fertilizationDeleteModalTitle">Brisanje gnojidbe</h5>
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
                <p class="font-weight-bold">Obrisati odabranu zaštitu:</p>
                <u>
                  <p id="fertilizationDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
                <!-- <small class="text-muted">Brisanjem zemljišta obrisat će se i djelatnosti vezane uz to zemljište.</small> -->
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="fertilizationDelete" id="fertilizationDelete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Obriši</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za dodavanje obrade tla -->
  <form method="POST" action="./includes/application/tillage_add_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="tillageAddModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="tillageAddModalTitle">Obrada tla</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="tillageField" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='tillageField' id='tillageField'> required";
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
              <label for="tillageName" class="col-sm-3 col-form-label col-form-label-sm">Naziv:</label>
              <div class="col-sm-9">
                <input list="tillageNameList" type="text" class="form-control form-control-sm" id="tillageName" name="tillageName" placeholder="Naziv obrade" maxlength="100" required>
                <div class="invalid-feedback">
                  Naziv djelatnosti je obavezan (max 100 znakova).
                </div>
                <datalist id="tillageNameList">
                  <option value="Oranje"></option>
                  <option value="Podrivanje"></option>
                  <option value="Gruberiranje"></option>
                  <option value="Drljanje"></option>
                  <option value="Tanjuranje"></option>
                  <option value="Frezanje"></option>
                  <option value="Malčiranje"></option>
                  <option value="Košnja"></option>
                  <option value="Kultiviranje"></option>
                  <option value="Zatvaranje brazde"></option>
                  <option value="Fina predsjetvena priprema"></option>
                  <option value="Valjanje"></option>
                  <option value="Ostalo"></option>
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="tillageDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="tillageDate" name="tillageDate" placeholder="Datum obrade tla" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="tillageNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="tillageNote" name="tillageNote" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="tillageAdd" id="tillageAdd" class="btn btn-success"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za uredivanje obrade tla -->
  <form method="POST" action="./includes/application/tillage_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="tillageEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="tillageEditModalTitle">Uređivanje obrade tla</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="tillageFieldEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='tillageFieldEdit' id='tillageFieldEdit'> required";
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
              <label for="tillageNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv:</label>
              <div class="col-sm-9">
                <input list="tillageNameListEdit" type="text" class="form-control form-control-sm" id="tillageNameEdit" name="tillageNameEdit" placeholder="Naziv obrade" maxlength="100" required>
                <div class="invalid-feedback">
                  Naziv djelatnosti je obavezan (max 100 znakova).
                </div>
                <datalist id="tillageNameListEdit">
                  <option value="Oranje"></option>
                  <option value="Podrivanje"></option>
                  <option value="Gruberiranje"></option>
                  <option value="Drljanje"></option>
                  <option value="Tanjuranje"></option>
                  <option value="Frezanje"></option>
                  <option value="Malčiranje"></option>
                  <option value="Košnja"></option>
                  <option value="Kultiviranje"></option>
                  <option value="Zatvaranje brazde"></option>
                  <option value="Fina predsjetvena priprema"></option>
                  <option value="Valjanje"></option>
                  <option value="Ostalo"></option>
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="tillageDateEdit" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="tillageDateEdit" name="tillageDateEdit" placeholder="Datum obrade tla" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="tillageNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="tillageNoteEdit" name="tillageNoteEdit" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="tillageEdit" id="tillageEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje obrade tla -->
  <form method="POST" action="./includes/application/tillage_delete_inc.php">
    <div class="modal fade" id="tillageDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="tillageDeleteModalTitle">Brisanje obrade tla</h5>
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
                <p class="font-weight-bold">Obrisati odabranu obradu tla:</p>
                <u>
                  <p id="tillageDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
                <!-- <small class="text-muted">Brisanjem zemljišta obrisat će se i djelatnosti vezane uz to zemljište.</small> -->
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="tillageDelete" id="tillageDelete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Obriši</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za dodavanje njege usjeva/nasada -->
  <form method="POST" action="./includes/application/care_add_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="careAddModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="careAddModalTitle">Njega usjeva/nasada</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="careField" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='careField' id='careField'> required";
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
              <label for="careName" class="col-sm-3 col-form-label col-form-label-sm">Mjera/zahvat:</label>
              <div class="col-sm-9">
                <input list="careNameList" type="text" class="form-control form-control-sm" id="careName" name="careName" placeholder="Naziv mjere ili zahvata" maxlength="100" required>
                <div class="invalid-feedback">
                  Mjera ili zahvat je obavezan (max 100 znakova).
                </div>
                <datalist id="careNameList">
                  <option value="Rezidba"></option>
                  <option value="Uzorkovanje"></option>
                  <option value="Nadzor"></option>
                  <option value="Prorjeđivanje"></option>
                  <option value="Dorjeđivanje"></option>
                  <option value="Baliranje"></option>
                  <option value="Ispaša"></option>
                  <option value="Napasivanje travnjaka"></option>
                  <option value="Ručno odstranjivanje biljaka"></option>
                  <option value="Ostalo"></option>
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careCulture" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careCulture" name="careCulture" placeholder="Naziv kulture" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="careDate" name="careDate" placeholder="Datum njege" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careNote" name="careNote" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="careAdd" id="careAdd" class="btn btn-success"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za uredivanje njege usjeva/nasada -->
  <form method="POST" action="./includes/application/care_edit_inc.php" class="needs-validation" novalidate>
    <div class="modal fade" id="careEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="careEditModalTitle">Uređivanje njege usjeva/nasada</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="careFieldEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv zemljišta:</label>
              <div class="col-sm-9">
                <?php if ($resultUser['current_business_id'] != NULL) : ?>
                  <?php
                    $resultFields->data_seek(0);
                    if ($resultFields->num_rows > 0) {
                      echo "<select class='form-control form-control-sm' name='careFieldEdit' id='careFieldEdit'> required";
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
              <label for="careNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Mjera/zahvat:</label>
              <div class="col-sm-9">
                <input list="careNameListEdit" type="text" class="form-control form-control-sm" id="careNameEdit" name="careNameEdit" placeholder="Naziv mjere ili zahvata" maxlength="100" required>
                <div class="invalid-feedback">
                  Mjera ili zahvat je obavezan (max 100 znakova).
                </div>
                <datalist id="careNameListEdit">
                  <option value="Rezidba"></option>
                  <option value="Uzorkovanje"></option>
                  <option value="Nadzor"></option>
                  <option value="Prorjeđivanje"></option>
                  <option value="Dorjeđivanje"></option>
                  <option value="Baliranje"></option>
                  <option value="Ispaša"></option>
                  <option value="Napasivanje travnjaka"></option>
                  <option value="Ručno odstranjivanje biljaka"></option>
                  <option value="Ostalo"></option>
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careCultureEdit" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careCultureEdit" name="careCultureEdit" placeholder="Naziv kulture" maxlength="100">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careDateEdit" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm bg-white date-picker" id="careDateEdit" name="careDateEdit" placeholder="Datum njege" readonly>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careNoteEdit" name="careNoteEdit" placeholder="Napomena" maxlength="100">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="careEdit" id="careEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje njege usjeva/nasada -->
  <form method="POST" action="./includes/application/care_delete_inc.php">
    <div class="modal fade" id="careDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="careDeleteModalTitle">Brisanje njege usjeva/nasada</h5>
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
                <p class="font-weight-bold">Obrisati odabranu njegu usjeva/nasada:</p>
                <u>
                  <p id="careDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
                <!-- <small class="text-muted">Brisanjem zemljišta obrisat će se i djelatnosti vezane uz to zemljište.</small> -->
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="careDelete" id="careDelete" class="btn btn-danger"><i class="fas fa-trash-alt"></i>&nbsp;&nbsp;Obriši</button>
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
        <h5 class="card-header text-center bg-secondary d-none d-sm-block">
          <i class="fas fa-tasks"></i><strong>&nbsp;&nbsp;Evidencija djelatnosti</strong>
        </h5>
        <a class="text-body text-decoration-none d-sm-none" data-toggle="collapse" href="#activitiesHeaderCollapse" id="activitiesHeader">
          <h5 class="card-header d-flex justify-content-between bg-secondary">
            <span class="activitiesArrow">
              <i class="fas fa-caret-up"></i>
            </span>
            <span>
              <i class="fas fa-tasks"></i><strong>&nbsp;&nbsp;Evidencija djelatnosti</strong>
            </span>
            <span class="activitiesArrow">
              <i class="fas fa-caret-up"></i>
            </span>
          </h5>
        </a>
        <div class="card-header p-0 collapse show d-sm-block" id="activitiesHeaderCollapse">
          <ul class="nav nav-pills nav-justified flex-column flex-sm-row" id="activitiesTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="protectionTab" data-toggle="tab" href="#protectionList" role="tab"><i class="fas fa-flask"></i>&nbsp;&nbsp;Zaštita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="fertilizationTab" data-toggle="tab" href="#fertilizationList" role="tab"><i class="fas fa-poo"></i>&nbsp;&nbsp;Gnojidba</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="tillageTab" data-toggle="tab" href="#tillageList" role="tab"><i class="fas fa-tractor"></i>&nbsp;&nbsp;Obrada tla</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0 px-1" id="careTab" data-toggle="tab" href="#careList" role="tab"><i class="fas fa-hand-holding-heart"></i>&nbsp;&nbsp;Njega usjeva/nasada</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">

            <!-- Odjeljak zastite -->
            <div class="tab-pane fade show active" id="protectionList" role="tabpanel">
              <h3>
                Zaštita
                <button class="btn btn-success float-right" id="protectionAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="protectionTable">
                <thead>
                  <tr>
                    <th>Zemljište (ARKOD)</th>
                    <th>Sredstvo (SZB)</th>
                    <th>Štetni organizam</th>
                    <th>Datum i vrijeme</th>
                    <th>Količina</th>
                    <th>Kultura</th>
                    <th>Napomena</th>
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, protection.* FROM protection INNER JOIN fields ON protection.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id, protection.protection_date");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['field_name']}<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['protection_name']}</td>";
                      echo "<td class='align-middle'>{$row['protection_organism']}</td>";
                      echo "<td class='align-middle'>" . date('d. m. Y. H:i', strtotime($row['protection_date'])) . "</td>";
                      echo "<td class='align-middle'>{$row['protection_amount']} {$row['protection_amount_unit']}</td>";
                      echo "<td class='align-middle'>{$row['protection_plant']}</td>";
                      echo "<td class='align-middle'>{$row['protection_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info protectionEditBtn' title='Uredi' data-protection-id-edit='{$row['protection_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger protectionDeleteBtn' title='Izbriši' data-protection-id-delete='{$row['protection_id']}'><i class='fas fa-trash-alt'></i></button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Odjeljak gnojidbe -->
            <div class="tab-pane fade" id="fertilizationList" role="tabpanel">
              <h3>
                Gnojidba
                <button class="btn btn-success float-right" id="fertilizationAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="fertilizationTable">
                <thead>
                  <tr>
                    <th>Zemljište (ARKOD)</th>
                    <th>Gnojivo</th>
                    <th>Datum</th>
                    <th>Količina (kg/ha)</th>
                    <th>Napomena</th>
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, fertilization.* FROM fertilization INNER JOIN fields ON fertilization.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id, fertilization.fertilization_date");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['field_name']}<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['fertilization_name']}</td>";
                      echo "<td class='align-middle'>" . date('d. m. Y.', strtotime($row['fertilization_date'])) . "</td>";
                      echo "<td class='align-middle'>{$row['fertilization_amount']}</td>";
                      echo "<td class='align-middle'>{$row['fertilization_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info fertilizationEditBtn' title='Uredi' data-fertilization-id-edit='{$row['fertilization_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger fertilizationDeleteBtn' title='Izbriši' data-fertilization-id-delete='{$row['fertilization_id']}'><i class='fas fa-trash-alt'></i></button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Odjeljak obrade tla -->
            <div class="tab-pane fade" id="tillageList" role="tabpanel">
              <h3>
                Obrada tla
                <button class="btn btn-success float-right" id="tillageAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="tillageTable">
                <thead>
                  <tr>
                    <th>Zemljište (ARKOD)</th>
                    <th>Naziv</th>
                    <th>Datum</th>
                    <th>Napomena</th>
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, tillage.* FROM tillage INNER JOIN fields ON tillage.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id, tillage.tillage_date");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['field_name']}<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['tillage_name']}</td>";
                      echo "<td class='align-middle'>" . date('d. m. Y.', strtotime($row['tillage_date'])) . "</td>";
                      echo "<td class='align-middle'>{$row['tillage_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info tillageEditBtn' title='Uredi' data-tillage-id-edit='{$row['tillage_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger tillageDeleteBtn' title='Izbriši' data-tillage-id-delete='{$row['tillage_id']}'><i class='fas fa-trash-alt'></i></button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Odjeljak njege -->
            <div class="tab-pane fade" id="careList" role="tabpanel">
              <h3 class="d-flex">
                <div class="d-none d-sm-block">Njega usjeva/nasada</div>
                <div class="d-block d-sm-none">Njega</div>
                <button class="btn btn-success ml-auto" id="careAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="careTable">
                <thead>
                  <tr>
                    <th>Zemljište (ARKOD)</th>
                    <th>Mjera/zahvat</th>
                    <th>Kultura</th>
                    <th>Datum</th>
                    <th>Napomena</th>
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, care.* FROM care INNER JOIN fields ON care.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id, care.care_date");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>{$row['field_name']}<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['care_name']}</td>";
                      echo "<td class='align-middle'>{$row['care_culture']}</td>";
                      echo "<td class='align-middle'>" . date('d. m. Y.', strtotime($row['care_date'])) . "</td>";
                      echo "<td class='align-middle'>{$row['care_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info careEditBtn' title='Uredi' data-care-id-edit='{$row['care_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger careDeleteBtn' title='Izbriši' data-care-id-delete='{$row['care_id']}'><i class='fas fa-trash-alt'></i></button>
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
        </div>
      </div>
    </div>
  </section>

  <?php include('./includes/partials/index_footer.php'); ?>

  <script>
    document.querySelector('#app_activities').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>