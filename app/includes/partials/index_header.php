<?php
// Dohvacanje korisnika
$queryUser = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
$queryUser->bind_param("i", $userId);
$queryUser->execute();
$resultUser = $queryUser->get_result()->fetch_assoc();

// Dohvacanje svih gospodarstva
$queryBusiness = $conn->prepare("SELECT * FROM business WHERE user_id = ?");
$queryBusiness->bind_param("i", $userId);
$queryBusiness->execute();
$resultBusiness = $queryBusiness->get_result();

// Dohvacanje trenutno selektiranog gospodarstva
if ($resultUser['current_business_id'] != NULL) {
  $queryCurrentBusiness = $conn->prepare("SELECT * FROM business WHERE business_id = ? LIMIT 1");
  $queryCurrentBusiness->bind_param("i", $resultUser['current_business_id']);
  $queryCurrentBusiness->execute();
  $resultCurrentBusiness = $queryCurrentBusiness->get_result()->fetch_assoc();
}
?>
<header class="header">
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-secondary border-bottom border-dark">

    <span id="sidebarToggle">
      <i class="far fa-caret-square-right fa-2x d-lg-none"></i>
    </span>
    <a class="navbar-brand d-none d-lg-block brandTopScroll" href="">Evipod</a>
    <a class="navbar-brand text-light d-lg-none brandTopScroll" href="">
      <?php
      if ($resultUser['current_business_id'] != NULL) {
        echo strlen($resultCurrentBusiness['business_name']) > 20 ? substr($resultCurrentBusiness['business_name'], 0, 20)."..." : $resultCurrentBusiness['business_name'];
      }
      ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <?php if ($resultUser['current_business_id'] != NULL) : ?>
        <span class="navbar-text text-light font-weight-bold mr-2 d-none d-lg-block">
          <?php echo strlen($resultCurrentBusiness['business_name']) > 20 ? substr($resultCurrentBusiness['business_name'], 0, 20)."..." : $resultCurrentBusiness['business_name']; ?>
        </span>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="opgSelectDropdownBtn" role="button" data-toggle="dropdown">
            <i class="fas fa-building fa-lg"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" id="opgSelect">
            <?php
              while ($rowBusiness = $resultBusiness->fetch_assoc()) {
                // echo "<a class='dropdown-item' href='' data-opgid='{$rowBusiness['business_id']}'>{$rowBusiness['business_name']}</a>";
                echo "
                <form action='./includes/application/switch_business_inc.php' method='POST'>
                  <input type='hidden' name='businessId' value='" . $rowBusiness['business_id'] . "' />
                  <input type='submit' value='". $rowBusiness['business_name'] ."' class='dropdown-item opgSelectBtn'></input>
                </form>
                ";
              }
              ?>
          </div>
        </li>
        <?php endif; ?>
        <li class="nav-item dropdown ml-lg-3">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
            <i class="fas fa-id-card-alt fa-lg"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Postavke</a>
            <a class="dropdown-item" href="#">Informacije</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="./includes/membership/logout.php">Odjava</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>