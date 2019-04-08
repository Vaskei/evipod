<?php include ('./includes/partials/index_head.php'); ?>

<body class="bg-light">
  <?php include ('./includes/partials/index_header.php'); ?>
  
  <?php include ('./includes/partials/index_sidebar.php'); ?>

  <section class="content">
    <div class="container-fluid">
      <h1 class="mt-4">Evidencija djelatnosti</h1>
      <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on
        larger screens. When toggled using the button below, the menu will change.</p>
      <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional,
        and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the
        menu when clicked.</p>

    </div>
  </section>

  <?php include ('./includes/partials/index_footer.php'); ?>

  <script>
    document.querySelector('#app_activities').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>