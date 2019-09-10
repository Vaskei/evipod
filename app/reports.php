<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
require_once './includes/functions.php';
$title = "Evipod - Izvještaji";
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
          <i class="fas fa-print"></i><strong>&nbsp;&nbsp;Izvještaji</strong>
        </h5>
        <div class="card-body">
          <h3>Izvještaji</h3>
          <a class="btn btn-primary" href="./includes/application/reports_fields_inc.php" target="_blank" rel="noopener noreferrer" role="button">Link PDF</a>
          <form action="./includes/application/reports_fields_inc.php" method="post">
            <button type="submit" class="btn btn-primary" name="fieldsPDF">PDF Test</button>
          </form>

          <hr>
          <table class="table table-sm table-bordered table-hover text-center" id="reportsTable">
            <thead>
              <tr>
                <th>Aktivnost</th>
                <th>Broj redaka</th>
                <th>PDF</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = $conn->prepare("SELECT 
              (SELECT COUNT(*) FROM fields WHERE fields.business_id = ?) AS fields_table,
              (SELECT COUNT(*) FROM planting WHERE planting.business_id = ?) AS planting_table,
              (SELECT COUNT(*) FROM protection WHERE protection.business_id = ?) AS protection_table,
              (SELECT COUNT(*) FROM fertilization WHERE fertilization.business_id = ?) AS fertilization_table,
              (SELECT COUNT(*) FROM tillage WHERE tillage.business_id = ?) AS tillage_table,
              (SELECT COUNT(*) FROM care WHERE care.business_id = ?) AS care_table,
              (SELECT COUNT(*) FROM harvest WHERE harvest.business_id = ?) AS harvest_table
              ");
              $query->bind_param("iiiiiii", $resultUser['current_business_id'], $resultUser['current_business_id'], $resultUser['current_business_id'], $resultUser['current_business_id'], $resultUser['current_business_id'], $resultUser['current_business_id'], $resultUser['current_business_id']);
              $query->execute();
              $result = $query->get_result();
              if ($result->num_rows > 0) {
                $activities = array("Zemljišta", "Sadnja/sjetva", "Zaštita", "Gnojidba", "Obrada tla", "Njega usjeva/nasada", "Berba/žetva");
                $tables = array("fieldsPDF", "plantingPDF", "protectionPDF", "fertilizationPDF", "tillagePDF", "carePDF", "harvestPDF");
                $actions = array("reports_fields_inc.php", "reports_planting_inc.php", "reports_protection_inc.php", "reports_fertilization_inc.php", "reports_tillage_inc.php", "reports_care_inc.php", "reports_harvest_inc.php");
                $fa = array("<i class='fas fa-map-marked-alt pr-2'></i>", "<i class='fas fa-seedling pr-2'></i>", "<i class='fas fa-flask pr-2'></i>", "<i class='fas fa-poo pr-2'></i>", "<i class='fas fa-tractor pr-2'></i>", "<i class='fas fa-hand-holding-heart pr-2'></i>", "<i class='fas fa-clipboard-check pr-2'></i>");
                $row = $result->fetch_array();
                // var_dump($row);exit();
                for ($index = 0; $index < count($activities); $index++) {
                  echo "<tr>";
                  echo "<td class='align-middle'>{$activities[$index]}</td>";
                  echo "<td class='align-middle'>{$row[$index]}</td>";
                  echo "<td class='align-middle'>
                          <form action='./includes/application/{$actions[$index]}' method='POST'>
                            <button type='submit' name='{$tables[$index]}' class='btn btn-info btn-sm btn-pdf' title='PDF'>{$fa[$index]}PDF</button>
                          </form>
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
  </section>

  <?php include('./includes/partials/index_footer.php'); ?>

  <script>
    document.querySelector('#app_reports').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>