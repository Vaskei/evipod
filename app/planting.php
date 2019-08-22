<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Zemljišta";
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
          <i class="fas fa-seedling"></i><strong>&nbsp;&nbsp;Sadnja/sjetva</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="plantingTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="plantingListTab" data-toggle="tab" href="#plantingList" role="tab">Lista sadnje/sjetve</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="plantingAddTab" data-toggle="tab" href="#plantingAdd" role="tab">Dodaj
                sadnju/sjetvu</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="plantingListContent">
            <!-- Div/tab za listu zemljista -->
            <div class="tab-pane fade show active" id="plantingList" role="tabpanel">
              <h3>Lista sadnje/sjetve</h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="plantingTable">
                <thead>
                  <tr>
                    <th>Zemljište (ARKOD)</th>
                    <th>Kultivar</th>
                    <th>Sjeme (kg/ha)</th>
                    <th>Datum</th>
                    <th>Porijeklo</th>
                    <th>Napomena</th>
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, planting.* FROM planting INNER JOIN fields ON planting.field_id = fields.field_id WHERE fields.business_id = ? ORDER BY fields.field_id");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='align-middle'>" . truncate($row['field_name'], 20) . "<p class='mb-0 text-muted'><small>" . $row['field_arkod'] . "</small></p></td>";
                      echo "<td class='align-middle'>{$row['planting_name']}</td>";
                      echo "<td class='align-middle'>{$row['planting_count']}</td>";
                      echo "<td class='align-middle'>" . date('d. m. Y.', strtotime($row['planting_date'])) . "</td>";
                      echo "<td class='align-middle'>{$row['planting_source']}</td>";
                      echo "<td class='align-middle'>{$row['planting_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info plantingEditBtn' data-planting-id-edit='{$row['planting_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger plantingDeleteBtn' data-planting-id-delete='{$row['planting_id']}'><i class='fas fa-trash-alt'></i></button>
                              </div>
                            </td>";
                      echo "</tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Div/tab za dodavanje zemljista -->
            <div class="tab-pane fade" id="plantingAdd" role="tabpanel">
              <h3>Dodaj sadnju/sjetvu</h3>
              <hr>
              <form method="POST" action="./includes/application/planting_add_inc.php">
                <div class="form-group row pl-3">
                  <label for="plantingField" class="col-sm-2 col-form-label col-form-label-sm">Naziv zemljišta:</label>
                  <div class="col-sm-10">
                    <?php if ($resultUser['current_business_id'] != NULL) : ?>
                    <?php
                      $query = $conn->prepare("SELECT * FROM fields WHERE business_id = ? ORDER BY created_at");
                      $query->bind_param("i", $resultUser['current_business_id']);
                      $query->execute();
                      $result = $query->get_result();
                      if ($result->num_rows > 0) {
                        echo "<select class='form-control form-control-sm' name='plantingField' id='plantingField'>";
                        while ($row = $result->fetch_assoc()) {
                          echo "<option value='{$row['field_id']}'>{$row['field_name']}</option>";
                        }
                        echo "</select>";
                      } else {
                        echo "
                        <select class='form-control form-control-sm' name='' id='' disabled='disabled'>
                          <option value=''>Nema evidentiranih zemljišta.</option>
                        </select>";
                      }
                      ?>
                    <?php else : ?>
                    <select class="form-control form-control-sm" name="" id="" disabled="disabled">
                      <option value="">Nema aktivnog gospodarstva.</option>
                    </select>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="plantingName" class="col-sm-2 col-form-label col-form-label-sm">Kultivar:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="plantingName" id="plantingName" placeholder="Kultivar / sadni materijal">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="plantingCount" class="col-sm-2 col-form-label col-form-label-sm">Sjeme (kg/ha):</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control form-control-sm" name="plantingCount" id="plantingCount" min="0" max="99999999999" step="1" placeholder="Sjeme (kg/ha)">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="plantingDate" class="col-sm-2 col-form-label col-form-label-sm">Datum:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm bg-white" name="plantingDate" id="plantingDate" placeholder="Datum sjetve / sadnje" readonly>
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="plantingSource" class="col-sm-2 col-form-label col-form-label-sm">Porijeklo:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="plantingSource" id="plantingSource" placeholder="Porijeklo sjemena / sadnica (ili proizvođač)">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="plantingNote" class="col-sm-2 col-form-label col-form-label-sm">Napomena:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="plantingNote" id="plantingNote" placeholder="Napomena">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <button type="submit" name="plantingAdd" class="btn btn-success px-5"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
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
    document.querySelector('#app_planting').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>