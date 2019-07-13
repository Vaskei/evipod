<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Zemljišta";
$userId = $_SESSION['user_id'];
?>
<?php include ('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include ('./includes/partials/index_header.php'); ?>

  <?php include ('./includes/partials/index_sidebar.php'); ?>

  <section class="content">
    <div class="container-fluid">
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
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="fieldsList" role="tabpanel">
              <h3>Lista zemljišta</h3>
            </div>
            <div class="tab-pane fade" id="fieldsAdd" role="tabpanel">
              <h3>Dodaj zemljište</h3>
              <hr>
              <form action="">
                <div class="form-group row pl-3">
                  <label for="fieldName" class="col-sm-2 col-form-label col-form-label-sm">Naziv:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="fieldName" placeholder="Naziv zemljišta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="fieldSize" class="col-sm-2 col-form-label col-form-label-sm">Površina (ha):</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="fieldSize" placeholder="Površina zemljišta (ha)">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="fieldARKOD" class="col-sm-2 col-form-label col-form-label-sm">ARKOD ID:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="fieldARKOD" placeholder="ARKOD ID zemljišta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="fieldNote" class="col-sm-2 col-form-label col-form-label-sm">Napomena:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="fieldNote" placeholder="Napomena">
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

  <?php include ('./includes/partials/index_footer.php'); ?>

  <script>
  document.querySelector('#app_fields').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>