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
              <table class="table table-sm table-bordered table-hover text-center datatable-enable" id="fieldsTable">
                <thead>
                  <tr>
                    <th>Naziv</th>
                    <th>Površina (ha)</th>
                    <th>ARKOD ID</th>
                    <th>Napomena</th>
                    <th>Opcije</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $query = $conn->prepare("SELECT * FROM fields WHERE business_id = ? ORDER BY created_at");
                  // $query->bind_param("i", $resultUser['current_business_id']);
                  // $query->execute();
                  // $result = $query->get_result();
                  // if ($result->num_rows > 0) {
                  //   while ($row = $result->fetch_assoc()) {
                  //     echo "<tr>";
                  //     echo "<td>" . truncate($row['field_name'], 20) . "</td>";
                  //     echo "<td>{$row['field_size']}</td>";
                  //     echo $row['field_arkod'] != '' ? "<td><a href='http://preglednik.arkod.hr/ARKOD-Web/#layers=OSNOVNI%20PROSTORNI%20PODACI,DOF-client,ZU-client&map_sc=7142&query=LPIS:ID:{$row['field_arkod']}&feature=LPIS:{$row['field_arkod']}' target='_blank' rel='noopener noreferrer'><i class='fas fa-map-marker-alt px-2'></i></a>{$row['field_arkod']}</td>" : "<td>-</td>";
                  //     echo "<td>{$row['field_note']}</td>";
                  //     echo "<td class='align-middle'>
                  //             <div class='btn-group btn-group-sm d-flex' role='group'>
                  //               <button type='button' class='btn btn-primary w-100 fieldsEditBtn' data-fields-id-edit='{$row['field_id']}'>Uredi</button>
                  //               <button type='button' class='btn btn-danger w-100 fieldsDeleteBtn' data-fields-id-delete='{$row['field_id']}'>Briši</button>
                  //             </div>
                  //           </td>";
                  //     echo "</tr>";
                  //   }
                  // }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Div/tab za dodavanje zemljista -->
            <div class="tab-pane fade" id="fieldsAdd" role="tabpanel">
              <h3>Dodaj zemljište</h3>
              <hr>
              <form method="POST" action="./includes/application/TODO.php">
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
    document.querySelector('#app_planting').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>