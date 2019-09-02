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

  <!-- Modal za dodavanje zaštite -->
  <form method="POST" action="./includes/application/protection_add_inc.php">
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
                <select class="form-control form-control-sm" name="protectionField" id="protectionField"></select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionName" class="col-sm-3 col-form-label col-form-label-sm">Naziv SZB:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionName" name="protectionName" placeholder="Naziv sredstva za zaštitu bilja">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionOrganism" class="col-sm-3 col-form-label col-form-label-sm">Štetni organizam:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionOrganism" name="protectionOrganism" placeholder="Naziv štetnog organizma">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionDate" class="col-sm-3 col-form-label col-form-label-sm">Datum i vrijeme:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionDate" name="protectionDate" placeholder="Datum i vrijeme tretiranja">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionAmount" class="col-sm-3 col-form-label col-form-label-sm">Količina:</label>
              <div class="col-sm-7">
                <input type="text" class="form-control form-control-sm" id="protectionAmount" name="protectionAmount" placeholder="Količina SZB (kg/ha ili l/ha)">
              </div>
              <div class="col-sm-2">
                <select class="form-control form-control-sm" name="protectionAmountUnit" id="protectionAmountUnit">
                  <option value="kg/ha">kg/ha</option>
                  <option value="l/ha">l/ha</option>
                </select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionPlant" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionPlant" name="protectionPlant" placeholder="Kultura">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="protectionNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="protectionNote" name="protectionNote" placeholder="Napomena">
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

  <!-- Modal za dodavanje gnojidbe -->
  <form method="POST" action="">
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
                <select class="form-control form-control-sm" name="fertilizationField" id="fertilizationField"></select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="fertilizationDate" name="fertilizationDate" placeholder="Datum obrade tla">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationType" class="col-sm-3 col-form-label col-form-label-sm">Gnojivo:</label>
              <div class="col-sm-9">
                <input list="fertilizationTypeList" type="text" class="form-control form-control-sm" id="fertilizationType" name="fertilizationType" placeholder="Naziv gnojiva">
                <datalist id="fertilizationTypeList">
                  <!-- JSON load -->
                </datalist>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationAmount" class="col-sm-3 col-form-label col-form-label-sm">Količina (kg/ha):</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="fertilizationAmount" name="fertilizationAmount" placeholder="Količina gnojiva (kg/ha)">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="fertilizationNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="fertilizationNote" name="fertilizationNote" placeholder="Napomena">
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

  <!-- Modal za dodavanje obrade tla -->
  <form method="POST" action="">
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
                <select class="form-control form-control-sm" name="tillageField" id="tillageField"></select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="tillageDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="tillageDate" name="tillageDate" placeholder="Datum obrade tla">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="tillageType" class="col-sm-3 col-form-label col-form-label-sm">Naziv:</label>
              <div class="col-sm-9">
                <input list="tillageTypeList" type="text" class="form-control form-control-sm" id="tillageType" name="tillageType" placeholder="Naziv obrade">
                <datalist id="tillageTypeList">
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
              <label for="tillageNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="tillageNote" name="tillageNote" placeholder="Napomena">
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

  <!-- Modal za dodavanje njege usjeva/nasada -->
  <form method="POST" action="">
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
                <select class="form-control form-control-sm" name="careField" id="careField"></select>
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careDate" class="col-sm-3 col-form-label col-form-label-sm">Datum:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careDate" name="careDate" placeholder="Datum njege">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careCulture" class="col-sm-3 col-form-label col-form-label-sm">Kultura:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careCulture" name="careCulture" placeholder="Naziv kulture">
              </div>
            </div>
            <div class="form-group row pl-3">
              <label for="careType" class="col-sm-3 col-form-label col-form-label-sm">Mjera/zahvat:</label>
              <div class="col-sm-9">
                <input list="careTypeList" type="text" class="form-control form-control-sm" id="careType" name="careType" placeholder="Naziv mjere ili zahvata">
                <datalist id="careTypeList">
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
              <label for="careNote" class="col-sm-3 col-form-label col-form-label-sm">Napomena:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" id="careNote" name="careNote" placeholder="Napomena">
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

  <section class="content">
    <div class="container-fluid">
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
              <a class="nav-link rounded-0 active" id="protectionTab" data-toggle="tab" href="#protectionList" role="tab">Zaštita</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="fertilizationTab" data-toggle="tab" href="#fertilizationList" role="tab">Gnojidba</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="tillageTab" data-toggle="tab" href="#tillageList" role="tab">Obrada tla</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0 px-1" id="careTab" data-toggle="tab" href="#careList" role="tab">Njega usjeva/nasada</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="protectionList" role="tabpanel">
              <h3>
                Zaštita
                <button class="btn btn-success float-right" id="protectionAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
            </div>
            <div class="tab-pane fade" id="fertilizationList" role="tabpanel">
              <h3>
                Gnojidba
                <button class="btn btn-success float-right" id="fertilizationAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
            </div>
            <div class="tab-pane fade" id="tillageList" role="tabpanel">
              <h3>
                Obrada tla
                <button class="btn btn-success float-right" id="tillageAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
            </div>
            <div class="tab-pane fade" id="careList" role="tabpanel">
              <h3>
                Njega usjeva/nasada
                <button class="btn btn-success float-right" id="careAddModalBtn"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
              </h3>
              <hr>
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