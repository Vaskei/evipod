<?php include ('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include ('./includes/partials/index_header.php'); ?>

  <?php include ('./includes/partials/index_sidebar.php'); ?>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <h5 class="card-header text-center bg-secondary">
          <i class="fas fa-apple-alt"></i><strong>&nbsp;&nbsp;Gospodarstvo</strong>
        </h5>
        <div class="card-header p-0">
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                aria-controls="home" aria-selected="true">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                aria-controls="contact" aria-selected="false">Contact</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">1.</div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">2.</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">3.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include ('./includes/partials/index_footer.php'); ?>

  <script>
  document.querySelector('#app_business').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>