<?php
// Dohvacanje svih gospodarstva
$queryOPG = $conn->prepare("SELECT * FROM business WHERE user_id = ?");
$queryOPG->bind_param("i", $userID);
$queryOPG->execute();
$resultOPG = $queryOPG->get_result();

// Dohvacanje trenutno selektiranog gospodarstva
if (isset($_SESSION['last_business_id'])) {
  $queryCurrentOPG = $conn->prepare("SELECT * FROM business WHERE business_id = ? LIMIT 1");
  $queryCurrentOPG->bind_param("i", $_SESSION['last_business_id']);
  $queryCurrentOPG->execute();
  $resultCurrentOPG = $queryCurrentOPG->get_result()->fetch_assoc();
}
?>
<header class="header">
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-secondary border-bottom border-dark">

    <span id="sidebarToggle">
      <i class="far fa-caret-square-right fa-2x d-lg-none"></i>
    </span>
    <a class="navbar-brand d-none d-lg-block" href="" id="brandTopScroll">Evipod</a>
    <a class="navbar-brand text-light d-lg-none" href="" id="brandTopScroll">
      <?php
      if (isset($_SESSION['last_business_id'])) {
        echo strlen($resultCurrentOPG['business_name']) > 20 ? substr($resultCurrentOPG['business_name'], 0, 20)."..." : $resultCurrentOPG['business_name'];
      }
      ?>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <?php if (isset($_SESSION['last_business_id'])) : ?>
        <span class="navbar-text text-light font-weight-bold mr-2 d-none d-lg-block">
          <?php echo strlen($resultCurrentOPG['business_name']) > 20 ? substr($resultCurrentOPG['business_name'], 0, 20)."..." : $resultCurrentOPG['business_name']; ?>
        </span>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="opgSelectDropdownBtn" role="button" data-toggle="dropdown">
            <i class="fas fa-building fa-lg"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" id="opgSelect">
            <?php
              while ($rowOPG = $resultOPG->fetch_assoc()) {
                echo "<a class='dropdown-item' href='' data-opgid='{$rowOPG['business_id']}'>{$rowOPG['business_name']}</a>";
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