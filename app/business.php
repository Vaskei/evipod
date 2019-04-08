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
          <ul class="nav nav-pills nav-fill flex-column flex-sm-row" id="businessTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link rounded-0 active" id="businessListTab" data-toggle="tab" href="#businessList" role="tab">Lista gospodarstva</a>
            </li>
            <li class="nav-item">
              <a class="nav-link rounded-0" id="businessAddTab" data-toggle="tab" href="#businessAdd" role="tab">Dodaj
                gospodarstvo</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="businessList" role="tabpanel">
              <h3>Lista gospodarstva</h3>
            </div>
            <div class="tab-pane fade" id="businessAdd" role="tabpanel">
              <h3>Dodaj gospodarstvo</h3>
              <hr>
              <form action="">
                <h5 class="text-muted">Osnovne informacije</h5>
                <div class="form-group row pl-3">
                  <label for="businessName" class="col-sm-2 col-form-label col-form-label-sm">Naziv:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessName" placeholder="Naziv subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessOwner" class="col-sm-2 col-form-label col-form-label-sm">Vlasnik:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessOwner" placeholder="Vlasnik subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessOIB" class="col-sm-2 col-form-label col-form-label-sm">OIB:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessOIB" placeholder="OIB subjekta ili vlasnika (osobni identifikacijski broj)">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessMIBPG" class="col-sm-2 col-form-label col-form-label-sm">MIBPG:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessMIBPG" placeholder="MIBPG subjekta (matični identifikacijski broj poljoprivrednog gospodarstva)">
                  </div>
                </div>
                <h5 class="text-muted">Lokacija</h5>
                <div class="form-group row pl-3">
                  <label for="businessCounty" class="col-sm-2 col-form-label col-form-label-sm">Županija:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessCounty" placeholder="Naziv županije">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessLocation" class="col-sm-2 col-form-label col-form-label-sm">Mjesto:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessLocation" placeholder="Mjesto subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessPost" class="col-sm-2 col-form-label col-form-label-sm">Pošta:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessPost" placeholder="Pošta subjekta">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessAddress" class="col-sm-2 col-form-label col-form-label-sm">Adresa:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessAddress" placeholder="Adresa subjekta">
                  </div>
                </div>
                <h5 class="text-muted">Kontakt informacije</h5>
                <div class="form-group row pl-3">
                  <label for="businessEmail" class="col-sm-2 col-form-label col-form-label-sm">E-mail:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessEmail" placeholder="E-mail adresa">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessTel" class="col-sm-2 col-form-label col-form-label-sm">Tel:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessTel" placeholder="Broj telefona">
                  </div>
                </div>
                <div class="form-group row pl-3">
                  <label for="businessMob" class="col-sm-2 col-form-label col-form-label-sm">Mob:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control form-control-sm" id="businessMob" placeholder="Broj mobitela">
                  </div>
                </div>
                <div class="row justify-content-center">
                  <button type="submit" name="businessAdd" class="btn btn-success px-5"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Dodaj</button>
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
  document.querySelector('#app_business').classList.replace('bg-secondary', 'list-group-item-dark');
  </script>

</body>


</html>