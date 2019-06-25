// Javascript
let siteAddress = 'localhost';
// Auto-start anonimna funkcija
(function () {
  'use strict';
  window.addEventListener('load', function () {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function (form) {
      form.addEventListener('submit', function (event) {
        // Provjera da li postoje greske sa form input-ima
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');

        // Provjera i promjena submit gumba ukoliko je forma tocna prilikom klika
        if (form.checkValidity()) {
          setTimeout(function () {
            if (document.getElementById("registrationSubmit")) {
              document.getElementById("registrationSubmit").innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Registracija';
              document.getElementById("registrationSubmit").setAttribute("disabled", "");
            }
            if (document.getElementById("pwdResetSubmit")) {
              document.getElementById("pwdResetSubmit").innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Nova lozinka';
              document.getElementById("pwdResetSubmit").setAttribute("disabled", "");
            }
          }, 250);
        }

      }, false);
    });
  }, false);

})();

document.addEventListener("DOMContentLoaded", function (event) {

  // Progress bar za alertove (oznacava korisniku da ce se alert zatvoriti za nekoliko sekundi)
  var bar = document.getElementById("customBar");
  var barWidth = 100;
  if (bar) {
    var downloadTimer = setInterval(() => {
      barWidth -= 33.33333;
      bar.style.width = barWidth + '%';
      if (barWidth <= 0) {
        clearInterval(downloadTimer);
        console.log("Done");
      }
    }, 750);
  }

  // Funkcija za provjeru lozinki kod registracije
  function checkRegistrationPass() {
    var registrationPass = document.getElementById('registrationPass');
    var registrationPassConfirm = document.getElementById('registrationPassConfirm');
    if (registrationPass && registrationPassConfirm) {
      if (registrationPass.value != registrationPassConfirm.value) {
        registrationPassConfirm.setCustomValidity('Lozinke moraju biti jednake.');
      } else {
        registrationPassConfirm.setCustomValidity('');
      }
    }
  }

  // Funkcija za provjeru lozinki kod resetiranja istih
  function checkResetPass() {
    var resetPass = document.getElementById('pwdResetConfirm');
    var resetPassConfirm = document.getElementById('pwdResetConfirmRepeat');
    if (resetPass && resetPassConfirm) {
      if (resetPass.value != resetPassConfirm.value) {
        resetPassConfirm.setCustomValidity('Lozinke moraju biti jednake.');
      } else {
        resetPassConfirm.setCustomValidity('');
      }
    }
  }

  // Inicijalizacija DataTable tabele
  $(".datatable-enable").DataTable({
    // "dom": '<"d-flex justify-content-between"lf><"table-responsive"rt><"d-flex justify-content-between"ip><"clear">'
    "pageLength": 10,
    "order": [],
    "pagingType": "simple",
    "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'table-responsive'<tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-center justify-content-md-end mt-2'p>>",
    language: {
      "sEmptyTable": "Nema podataka u tablici",
      "sInfo": "Prikazano _START_ do _END_ od _TOTAL_ rezultata",
      "sInfoEmpty": "Prikazano 0 do 0 od 0 rezultata",
      "sInfoFiltered": "(iz _MAX_ ukupnih)",
      "sInfoPostFix": "",
      "sInfoThousands": ",",
      "sLengthMenu": "Prikaži _MENU_ rezultata po stranici",
      "sLoadingRecords": "Dohvaćam...",
      "sProcessing": "Obrađujem...",
      "sSearch": "Pretraži:",
      "sZeroRecords": "Ništa nije pronađeno",
      "oPaginate": {
        "sFirst": "Prva",
        "sPrevious": "Nazad",
        "sNext": "Naprijed",
        "sLast": "Zadnja"
      },
      "oAria": {
        "sSortAscending": ": aktiviraj za rastući poredak",
        "sSortDescending": ": aktiviraj za padajući poredak"
      }
    }
  });

  // Skrivanje svih alert-ova nakon X sekundi
  $(".alertFadeout").delay(3000).fadeOut();

  // Provjera podudaranja lozinki prilikom tipkanja
  $("#registrationPass, #registrationPassConfirm").keyup(checkRegistrationPass);
  $("#pwdResetConfirm, #pwdResetConfirmRepeat").keyup(checkResetPass);

  // Sidebar kontrola
  $('#sidebarToggle').on('click', function () {
    $('#sidebar').toggleClass('toggled');
    $(this).toggleClass("fa-flip-horizontal");
  });

  // Scroll na vrh stranice
  $('#brandTopScroll').on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 });
    return false;
  });

  // Collapse menija kod evidencije aktivnosti na malim (sm) ekranima
  $('#activitiesHeader').on('click', function () {
    $('.activitiesArrow').toggleClass('fa-flip-vertical');
  });

  // Inicijalizacija Bootstrap Toast elementa
  $('.toast').toast('show');

  // Promjena trenutno aktivnog gospodarstva preko AJAX-a
  // $('#opgSelect a').click(function () {
  //   let opgID = $(this).attr('data-opgid');
  //   $.ajax({
  //     type: 'POST',
  //     url: './includes/application/switch_business_inc.php',
  //     data: 'opgID=' + opgID,
  //     dataType: 'json',
  //     success: function (data) {
  //       if (data.status == 'error') {
  //         console.log('BAD');
  //         window.location.reload();
  //       } else if (data.status == 'success') {
  //         console.log('GOOD');
  //         window.location.reload();
  //       }
  //     }
  //   });
  // });

  // Zatvaranje dropdown menija prilikom odabira gospodarstva
  $('.opgSelectBtn').click(function (e) {
    e.stopPropagation();
    $('#opgSelect').dropdown('toggle');
  });

  // Dohvacanje podataka za uredenje gospodarstva
  $('.businessEditBtn').click(function () {
    let businessEditId = $(this).attr('data-business-id-edit');
    $.ajax({
      type: 'POST',
      url: './includes/application/business_fetch_inc.php',
      data: 'businessId=' + businessEditId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#businessNameEdit').val(data.row.business_name);
          $('#businessOwnerEdit').val(data.row.business_owner);
          $('#businessOIBEdit').val(data.row.business_oib);
          $('#businessMIBPGEdit').val(data.row.business_mibpg);
          $('#businessCountyEdit').val(data.row.business_county);
          $('#businessLocationEdit').val(data.row.business_location);
          $('#businessPostEdit').val(data.row.business_post);
          $('#businessAddressEdit').val(data.row.business_address);
          $('#businessEmailEdit').val(data.row.business_email);
          $('#businessTelEdit').val(data.row.business_tel);
          $('#businessMobEdit').val(data.row.business_mob);
          $('#businessEditModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za brisanje gospodarstva
  $('.businessDeleteBtn').click(function () {
    let businessDeleteId = $(this).attr('data-business-id-delete');
    console.log(businessDeleteId);
    $.ajax({
      type: 'POST',
      url: './includes/application/business_fetch_inc.php',
      data: 'businessId=' + businessDeleteId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          console.log(data);
          $('#businessDeleteName').html(data.row.business_name);
          $('#businessDeleteModal').modal('toggle');
        }
      }
    });
  })
});