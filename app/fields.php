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

  <!-- Modal za uredivanje zemljista -->
  <form method="POST" action="./includes/application/fields_edit_inc.php">
    <div class="modal fade" id="fieldsEditModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="fieldsEditModalTitle">Uređivanje zemljišta</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group row pl-3">
              <label for="fieldNameEdit" class="col-sm-3 col-form-label col-form-label-sm">Naziv:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="fieldNameEdit" name="fieldNameEdit" placeholder="Naziv zemljišta">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fieldSizeEdit" class="col-sm-3 col-form-label col-form-label-sm">Površina (ha):</label>
              <div class="col-sm-9">
                <input type="number" class="form-control form-control-sm" name="fieldSizeEdit" id="fieldSizeEdit" min="0" max="99999999" step="0.01" placeholder="Površina zemljišta (ha)">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fieldARKODEdit" class="col-sm-3 col-form-label col-form-label-sm">ARKOD ID:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="fieldARKODEdit" id="fieldARKODEdit" placeholder="ARKOD ID zemljišta">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fieldNoteEdit" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="fieldNoteEdit" id="fieldNoteEdit" placeholder="Napomena">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="fieldEdit" id="fieldEdit" class="btn btn-success"><i class="fas fa-edit"></i>&nbsp;&nbsp;Spremi</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Modal za brisanje zemljista -->
  <form method="POST" action="./includes/application/fields_delete_inc.php">
    <div class="modal fade" id="fieldsDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header bg-danger text-white">
            <h5 class="modal-title font-weight-bold" id="fieldsDeleteModalTitle">Brisanje zemljišta</h5>
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
                <p class="font-weight-bold">Obrisati odabrano zemljište:</p>
                <u>
                  <p id="fieldsDeleteName" class="font-weight-bold text-break mb-0"></p>
                </u>
                <small class="text-muted">Brisanjem zemljišta obrisat će se i djelatnosti vezane uz to zemljište.</small>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i>&nbsp;&nbsp;Zatvori</button>
            <button type="submit" name="fieldsDelete" id="fieldsDelete" class="btn btn-danger"><i class="fas fa-edit"></i>&nbsp;&nbsp;Obriši</button>
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
          <i class="fas fa-map-marked-alt"></i><strong>&nbsp;&nbsp;Zemljišta</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="fieldsTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="fieldsListTab" data-toggle="tab" href="#fieldsList" role="tab">Lista zemljišta</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="fieldsAddTab" data-toggle="tab" href="#fieldsAdd" role="tab">Dodaj
                zemljište</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="fieldsTabContent">
            <!-- Div/tab za listu zemljista -->
            <div class="tab-pane fade show active" id="fieldsList" role="tabpanel">
              <h3>Lista zemljišta</h3>
              <hr>
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="fieldsTable">
                <thead>
                  <tr>
                    <th>Naziv</th>
                    <th>Površina (ha)</th>
                    <th>ARKOD ID</th>
                    <th>Napomena</th>
                    <th style="width: 10%">Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = $conn->prepare("SELECT * FROM fields WHERE business_id = ? ORDER BY created_at");
                  $query->bind_param("i", $resultUser['current_business_id']);
                  $query->execute();
                  $result = $query->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . truncate($row['field_name'], 20) . "</td>";
                      echo "<td>{$row['field_size']}</td>";
                      echo $row['field_arkod'] != '' ? "<td>{$row['field_arkod']}<a href='http://preglednik.arkod.hr/ARKOD-Web/#layers=OSNOVNI%20PROSTORNI%20PODACI,DOF-client,ZU-client&map_sc=7142&query=LPIS:ID:{$row['field_arkod']}&feature=LPIS:{$row['field_arkod']}' target='_blank' rel='noopener noreferrer' title='Lokacija'><i class='fas fa-map-marker-alt px-2'></i></a></td>" : "<td>-</td>";
                      echo "<td>{$row['field_note']}</td>";
                      echo "<td class='align-middle'>
                              <div class='btn-group btn-group-sm d-flex' role='group'>
                                <button type='button' class='btn btn-link text-info fieldsEditBtn' title='Uredi' data-fields-id-edit='{$row['field_id']}'><i class='fas fa-pencil-alt'></i></button>
                                <button type='button' class='btn btn-link text-danger fieldsDeleteBtn' title='Izbriši' data-fields-id-delete='{$row['field_id']}'><i class='fas fa-trash-alt'></i></button>
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
            <div class="tab-pane fade" id="fieldsAdd" role="tabpanel">
              <h3>Dodaj zemljište</h3>
              <hr>
              <form method="POST" action="./includes/application/fields_add_inc.php">
                <div class="form-group row pl-3">
                  <label for="fieldName" class="col-sm-2 col-form-label col-form-label-sm">Naziv:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="fieldName" id="fieldName" placeholder="Naziv zemljišta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="fieldSize" class="col-sm-2 col-form-label col-form-label-sm">Površina (ha):</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control form-control-sm" name="fieldSize" id="fieldSize" min="0" max="99999999" step="0.01" placeholder="Površina zemljišta (ha)">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="fieldARKOD" class="col-sm-2 col-form-label col-form-label-sm">ARKOD ID:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="fieldARKOD" id="fieldARKOD" placeholder="ARKOD ID zemljišta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="fieldNote" class="col-sm-2 col-form-label col-form-label-sm">Napomena:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" name="fieldNote" id="fieldNote" placeholder="Napomena">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <button type="submit" name="fieldAdd" class="btn btn-success px-5"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
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
    document.querySelector('#app_fields').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>