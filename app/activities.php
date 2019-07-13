<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Evidencija djelatnosti";
$userId = $_SESSION['user_id'];
?>
<?php include ('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include ('./includes/partials/index_header.php'); ?>

  <?php include ('./includes/partials/index_sidebar.php'); ?>

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
              <a class="nav-link rounded-0" id="soilPreparationTab" data-toggle="tab" href="#soilPreparationList" role="tab">Obrada tla</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0 px-1" id="cropCareTab" data-toggle="tab" href="#cropCareList" role="tab">Njega usjeva/nasada</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="protectionList" role="tabpanel">
              <h3>Zaštita</h3>
            </div>
            <div class="tab-pane fade" id="fertilizationList" role="tabpanel">
              <h3>Gnojidba</h3>
            </div>
            <div class="tab-pane fade" id="soilPreparationList" role="tabpanel">
              <h3>Obrada tla</h3>
            </div>
            <div class="tab-pane fade" id="cropCareList" role="tabpanel">
              <h3>Njega usjeva/nasada</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include ('./includes/partials/index_footer.php'); ?>

  <script>
  document.querySelector('#app_activities').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>