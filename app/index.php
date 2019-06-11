<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../");
require_once "./includes/connection.php";
$title = "Evipod - Index";
$userID = $_SESSION['user_id'];
?>

<?php include('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include('./includes/partials/index_header.php'); ?>

  <?php include('./includes/partials/index_sidebar.php'); ?>

  <section class="content">
    <div class="container-fluid">
      <div class="position-relative d-flex justify-content-center">
        <!-- <div class="toast position-absolute" data-autohide="false">
          <div class="toast-header">
            <i class="fas fa-exclamation-circle fa-lg mr-2 text-danger"></i>
            <strong class="mr-auto text-danger">Bootstrap</strong>
            <button type="button" class="close text-dark" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true"><i class="fas fa-times fa-sm"></i></span>
            </button>
          </div>
          <div class="toast-body bg-white">
            Hello, world! This is a toast message. Hello, world! This is a toast message. Hello, world! This is a toast message.
          </div>
        </div> -->

        <!-- Ispisivanje toast-a preko sesije -->
        <?php
        if (isset($_SESSION['msg']) && $_SESSION['msg'] != '') {
          echo $_SESSION['msg'];
          unset($_SESSION['msg']);
        }
        ?>
      </div>

      <h1 class="mt-4">Start</h1>
      <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
        larger screens. When toggled using the button below, the menu will change.</p>
      <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
        and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
        menu when clicked.</p>

      <p><?php var_dump($_SESSION); ?></p>
      <p>
        <?php
        $query = "SELECT * FROM business WHERE user_id = $userID";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc()) {
          var_dump($row);
        }
        ?>
      </p>

    </div>
  </section>

  <?php include('./includes/partials/index_footer.php'); ?>

  <script>
  document.querySelector('#app_index').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>