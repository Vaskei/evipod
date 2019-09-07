<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Početna";
$userId = $_SESSION['user_id'];
?>
<?php include('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include('./includes/partials/index_header.php'); ?>

  <?php include('./includes/partials/index_sidebar.php'); ?>

  <?php
  if ($resultUser['current_business_id'] != NULL) {
    //Dohvat sadnje
    $query = $conn->prepare("SELECT fields.field_name, planting.planting_name, planting.planting_date FROM planting INNER JOIN fields ON planting.field_id = fields.field_id WHERE planting.business_id = ? ORDER BY planting.planting_date DESC LIMIT 3");
    $query->bind_param("i", $resultUser['current_business_id']);
    $query->execute();
    $resultPlanting = $query->get_result();
    //Dohvat zastite
    $query = $conn->prepare("SELECT fields.field_name, protection.protection_name, protection.protection_date FROM protection INNER JOIN fields ON protection.field_id = fields.field_id WHERE protection.business_id = ? ORDER BY protection.protection_date DESC LIMIT 3");
    $query->bind_param("i", $resultUser['current_business_id']);
    $query->execute();
    $resultProtection = $query->get_result();
    //Dohvat gnojidbe
    $query = $conn->prepare("SELECT fields.field_name, fertilization.fertilization_name, fertilization.fertilization_date FROM fertilization INNER JOIN fields ON fertilization.field_id = fields.field_id WHERE fertilization.business_id = ? ORDER BY fertilization.fertilization_date DESC LIMIT 3");
    $query->bind_param("i", $resultUser['current_business_id']);
    $query->execute();
    $resultFertilization = $query->get_result();
    //Dohvat obrade tla
    $query = $conn->prepare("SELECT fields.field_name, tillage.tillage_name, tillage.tillage_date FROM tillage INNER JOIN fields ON tillage.field_id = fields.field_id WHERE tillage.business_id = ? ORDER BY tillage.tillage_date DESC LIMIT 3");
    $query->bind_param("i", $resultUser['current_business_id']);
    $query->execute();
    $resultTillage = $query->get_result();
    //Dohvat njege
    $query = $conn->prepare("SELECT fields.field_name, care.care_name, care.care_date FROM care INNER JOIN fields ON care.field_id = fields.field_id WHERE care.business_id = ? ORDER BY care.care_date DESC LIMIT 3");
    $query->bind_param("i", $resultUser['current_business_id']);
    $query->execute();
    $resultCare = $query->get_result();
    //Dohvat berbe
    $query = $conn->prepare("SELECT fields.field_name, harvest.harvest_name, harvest.harvest_amount, harvest.harvest_amount_unit, harvest_date FROM harvest INNER JOIN fields ON harvest.field_id = fields.field_id WHERE harvest.business_id = ? ORDER BY harvest.harvest_date DESC LIMIT 3");
    $query->bind_param("i", $resultUser['current_business_id']);
    $query->execute();
    $resultHarvest = $query->get_result();
  }
  ?>

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
          <i class="fas fa-home"></i><strong>&nbsp;&nbsp;Start</strong>
        </h5>
        <div class="card-body">
          <h3>Zadnje aktivnosti</h3>
          <hr>
          <div class="row">
            <div class="col-md-6 col-lg-4 pb-4">
              <div class="card">
                <h5 class="card-header"><strong>Sadnja/sjetva</strong></h5>
                <div class="card-body px-2 pt-2 pb-0 px-2 pt-2 pb-0">
                  <?php
                  if ($resultPlanting->num_rows > 0) {
                    while ($row = $resultPlanting->fetch_assoc()) {
                      echo "<div class='latest-activity latest-1 text-truncate'>
                            {$row['planting_name']} <small class='text-muted pl-2'>{$row['field_name']}, " . date('d. m. Y.', strtotime($row['planting_date'])) . "</small>
                            </div>";
                    }
                  } else {
                    echo "<div class='latest-activity latest-1 text-truncate'>Nema zabilježene sadnje/sjetve.</div>";
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-4">
              <div class="card">
                <h5 class="card-header"><strong>Zaštita</strong></h5>
                <div class="card-body px-2 pt-2 pb-0">
                  <?php
                  if ($resultProtection->num_rows > 0) {
                    while ($row = $resultProtection->fetch_assoc()) {
                      echo "<div class='latest-activity latest-2 text-truncate'>
                            {$row['protection_name']} <small class='text-muted pl-2'>{$row['field_name']}, " . date('d. m. Y.', strtotime($row['protection_date'])) . "</small>
                            </div>";
                    }
                  } else {
                    echo "<div class='latest-activity latest-2 text-truncate'>Nema zabilježene zaštite.</div>";
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-4">
              <div class="card">
                <h5 class="card-header"><strong>Gnojidba</strong></h5>
                <div class="card-body px-2 pt-2 pb-0">
                  <?php
                  if ($resultFertilization->num_rows > 0) {
                    while ($row = $resultFertilization->fetch_assoc()) {
                      echo "<div class='latest-activity latest-3 text-truncate'>
                            {$row['fertilization_name']} <small class='text-muted pl-2'>{$row['field_name']}, " . date('d. m. Y.', strtotime($row['fertilization_date'])) . "</small>
                            </div>";
                    }
                  } else {
                    echo "<div class='latest-activity latest-3 text-truncate'>Nema zabilježene gnojidbe.</div>";
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-4">
              <div class="card">
                <h5 class="card-header"><strong>Obrada tla</strong></h5>
                <div class="card-body px-2 pt-2 pb-0">
                  <?php
                  if ($resultTillage->num_rows > 0) {
                    while ($row = $resultTillage->fetch_assoc()) {
                      echo "<div class='latest-activity latest-4 text-truncate'>
                            {$row['tillage_name']} <small class='text-muted pl-2'>{$row['field_name']}, " . date('d. m. Y.', strtotime($row['tillage_date'])) . "</small>
                            </div>";
                    }
                  } else {
                    echo "<div class='latest-activity latest-4 text-truncate'>Nema zabilježene obrade tla.</div>";
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-4">
              <div class="card">
                <h5 class="card-header"><strong>Njega usjeva/nasada</strong></h5>
                <div class="card-body px-2 pt-2 pb-0">
                  <?php
                  if ($resultCare->num_rows > 0) {
                    while ($row = $resultCare->fetch_assoc()) {
                      echo "<div class='latest-activity latest-5 text-truncate'>
                            {$row['care_name']} <small class='text-muted pl-2'>{$row['field_name']}, " . date('d. m. Y.', strtotime($row['care_date'])) . "</small>
                            </div>";
                    }
                  } else {
                    echo "<div class='latest-activity latest-5 text-truncate'>Nema zabilježene njege usjeva/nasada.</div>";
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 pb-4">
              <div class="card">
                <h5 class="card-header"><strong>Berba/žetva</strong></h5>
                <div class="card-body px-2 pt-2 pb-0">
                  <?php
                  if ($resultHarvest->num_rows > 0) {
                    while ($row = $resultHarvest->fetch_assoc()) {
                      echo "<div class='latest-activity latest-6 text-truncate'>
                            {$row['harvest_name']} <small class='text-muted pl-2'>{$row['harvest_amount']}{$row['harvest_amount_unit']}, {$row['field_name']}, " . date('d. m. Y.', strtotime($row['harvest_date'])) . "</small>
                            </div>";
                    }
                  } else {
                    echo "<div class='latest-activity latest-5 text-truncate'>Nema zabilježene berbe/žetve.</div>";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </section>

  <?php include('./includes/partials/index_footer.php'); ?>

  <script>
    document.querySelector('#app_index').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>