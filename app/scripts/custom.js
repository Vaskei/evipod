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
    "search": {
      "smart": false
    },
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
  $('.brandTopScroll').on('click', function (e) {
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

  // Inicijalizacija Bootstrap Tooltip elementa
  // $('[data-toggle="tooltip"]').tooltip();

  // Picker za datume
  $('.date-picker').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1970,
    maxYear: parseInt(moment().add(5, 'y').format('YYYY'), 10),
    locale: {
      format: "DD. MM. YYYY.",
      applyLabel: "Potvrdi",
      cancelLabel: "Odustani",
      fromLabel: "Od",
      toLabel: "Do",
      customRangeLabel: "Custom",
      weekLabel: "Tj",
      daysOfWeek: [
        "Ned",
        "Pon",
        "Uto",
        "Sri",
        "Čet",
        "Pet",
        "Sub"
      ],
      monthNames: [
        "Siječanj",
        "Veljača",
        "Ožujak",
        "Travanj",
        "Svibanj",
        "Lipanj",
        "Srpanj",
        "Kolovoz",
        "Rujan",
        "Listopad",
        "Studeni",
        "Prosinac"
      ],
      firstDay: 1,
    }
  });

  // Picker za datume i vrijeme
  $('.date-time-picker').daterangepicker({
    singleDatePicker: true,
    timePicker: true,
    timePicker24Hour: true,
    timePickerIncrement: 15,
    showDropdowns: true,
    minYear: 1970,
    maxYear: parseInt(moment().add(5, 'y').format('YYYY'), 10),
    locale: {
      format: "DD. MM. YYYY. HH:mm",
      applyLabel: "Potvrdi",
      cancelLabel: "Odustani",
      fromLabel: "Od",
      toLabel: "Do",
      customRangeLabel: "Custom",
      weekLabel: "Tj",
      daysOfWeek: [
        "Ned",
        "Pon",
        "Uto",
        "Sri",
        "Čet",
        "Pet",
        "Sub"
      ],
      monthNames: [
        "Siječanj",
        "Veljača",
        "Ožujak",
        "Travanj",
        "Svibanj",
        "Lipanj",
        "Srpanj",
        "Kolovoz",
        "Rujan",
        "Listopad",
        "Studeni",
        "Prosinac"
      ],
      firstDay: 1,
    }
  });

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
  //         window.location.reload();
  //       } else if (data.status == 'success') {
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
  $('#businessTable tbody').on('click', '.businessEditBtn', function () {
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
          $('#businessEdit').val(data.row.business_id);
          $('#businessEditModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za brisanje gospodarstva
  $('#businessTable tbody').on('click', '.businessDeleteBtn', function () {
    let businessDeleteId = $(this).attr('data-business-id-delete');
    $.ajax({
      type: 'POST',
      url: './includes/application/business_fetch_inc.php',
      data: 'businessId=' + businessDeleteId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#businessDeleteName').html(data.row.business_name);
          $('#businessDelete').val(data.row.business_id);
          $('#businessDeleteModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za detalje gospodarstva
  $('#businessTable tbody').on('click', '.businessInfoLink', function (e) {
    let businessInfoId = $(this).attr('data-business-id-info');
    e.stopPropagation();
    e.preventDefault();
    $.ajax({
      type: 'POST',
      url: './includes/application/business_fetch_inc.php',
      data: 'businessId=' + businessInfoId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#businessInfoModalTitle').html(data.row.business_name);
          $('#businessNameInfo').html(data.row.business_name);
          $('#businessOwnerInfo').html(data.row.business_owner != "" ? data.row.business_owner : "-");
          $('#businessOIBInfo').html(data.row.business_oib != "" ? data.row.business_oib : "-");
          $('#businessMIBPGInfo').html(data.row.business_mibpg != "" ? data.row.business_mibpg : "-");
          $('#businessCountyInfo').html(data.row.business_county != "" ? data.row.business_county : "-");
          $('#businessLocationInfo').html(data.row.business_location != "" ? data.row.business_location : "-");
          $('#businessPostInfo').html(data.row.business_post != "" ? data.row.business_post : "-");
          $('#businessAddressInfo').html(data.row.business_address != "" ? data.row.business_address : "-");
          $('#businessEmailInfo').html(data.row.business_email != "" ? data.row.business_email : "-");
          $('#businessTelInfo').html(data.row.business_tel != "" ? data.row.business_tel : "-");
          $('#businessMobInfo').html(data.row.business_mob != "" ? data.row.business_mob : "-");
          let dateSplit = data.row.created_at.split(/[- :]/);
          let date = dateSplit[2] + ". " + dateSplit[1] + ". " + dateSplit[0] + ". u " + dateSplit[3] + ":" + dateSplit[4] + ":" + dateSplit[5];
          $('#businessAddedInfo').html(date);
          $('#businessInfoModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za brisanje zemljista
  $('#fieldsTable tbody').on('click', '.fieldsDeleteBtn', function () {
    let fieldsDeleteId = $(this).attr('data-fields-id-delete');
    $.ajax({
      type: 'POST',
      url: './includes/application/fields_fetch_inc.php',
      data: 'fieldsId=' + fieldsDeleteId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#fieldsDeleteName').html(data.row.field_name);
          $('#fieldsDelete').val(data.row.field_id);
          $('#fieldsDeleteModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za uredenje zemljista
  $('#fieldsTable tbody').on('click', '.fieldsEditBtn', function () {
    let fieldsEditId = $(this).attr('data-fields-id-edit');
    $.ajax({
      type: 'POST',
      url: './includes/application/fields_fetch_inc.php',
      data: 'fieldsId=' + fieldsEditId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#fieldNameEdit').val(data.row.field_name);
          $('#fieldSizeEdit').val(data.row.field_size);
          $('#fieldARKODEdit').val(data.row.field_arkod);
          $('#fieldNoteEdit').val(data.row.field_note);
          $('#fieldEdit').val(data.row.field_id);
          $('#fieldsEditModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za brisanje sjetve/sadnje
  $('#plantingTable tbody').on('click', '.plantingDeleteBtn', function () {
    let plantingDeleteId = $(this).attr('data-planting-id-delete');
    $.ajax({
      type: 'POST',
      url: './includes/application/planting_fetch_inc.php',
      data: 'plantingId=' + plantingDeleteId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#plantingDeleteField').html(data.row.field_name);
          $('#plantingDeleteName').html(data.row.planting_name);
          $('#plantingDelete').val(data.row.planting_id);
          $('#plantingDeleteModal').modal('toggle');
        }
      }
    });
  });

  // Dohvacanje podataka za uredenje sjetve/sadnje
  $('#plantingTable tbody').on('click', '.plantingEditBtn', function () {
    let plantingEditId = $(this).attr('data-planting-id-edit');
    $.ajax({
      type: 'POST',
      url: './includes/application/planting_fetch_inc.php',
      data: 'plantingId=' + plantingEditId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#plantingFieldEdit').val(data.row.field_id);
          $('#plantingNameEdit').val(data.row.planting_name);
          $('#plantingCountEdit').val(data.row.planting_count);
          let dateSplit = data.row.planting_date.split('-');
          let date = dateSplit[2] + ". " + dateSplit[1] + ". " + dateSplit[0] + ".";
          $('#plantingDateEdit').data('daterangepicker').setStartDate(date);
          $('#plantingDateEdit').data('daterangepicker').setEndDate(date);
          $('#plantingSourceEdit').val(data.row.planting_source);
          $('#plantingNoteEdit').val(data.row.planting_note);
          $('#plantingEdit').val(data.row.planting_id);
          $('#plantingEditModal').modal('toggle');
        }
      }
    });
  });

  $('#tillageAddModalBtn').on('click', function () {
    $('#tillageAddModal').modal('toggle');
  });

  $('#careAddModalBtn').on('click', function () {
    $('#careAddModal').modal('toggle');
  });

  // Modal za dodavanje zastite (SZB)
  $('#protectionAddModalBtn').on('click', function () {
    $('#protectionAddModal').modal('toggle');

    let dataList = document.getElementById('protectionNameList');
    let input = document.getElementById('protectionName');

    // Dohvat liste sredstava iz json datoteke
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
      if (request.readyState === 4) {
        if (request.status === 200) {
          let jsonData = JSON.parse(request.responseText);

          jsonData.forEach(function (item) {
            let option = document.createElement('option');
            option.value = item;
            dataList.appendChild(option);
          });

          input.placeholder = "Naziv sredstva za zaštitu bilja";
        } else {
          input.placeholder = "Greška kod dohvata liste sredstava";
        }
      }
    }

    input.placeholder = "Učitavanje liste...";

    request.open('GET', './includes/json/protection_products.json', true);
    request.send();
  });

  // Dohvacanje podataka za uredenje zastite
  $('#protectionTable tbody').on('click', '.protectionEditBtn', function () {
    let protectionEditId = $(this).attr('data-protection-id-edit');
    $.ajax({
      type: 'POST',
      url: './includes/application/protection_fetch_inc.php',
      data: 'protectionId=' + protectionEditId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#protectionFieldEdit').val(data.row.field_id);
          $('#protectionNameEdit').val(data.row.protection_name);
          $('#protectionOrganismEdit').val(data.row.protection_organism);
          let dateSplit = data.row.protection_date.split(/[- :]/);
          let date = dateSplit[2] + ". " + dateSplit[1] + ". " + dateSplit[0] + ". " + dateSplit[3] + ":" + dateSplit[4];
          $('#protectionDateEdit').data('daterangepicker').setStartDate(date);
          $('#protectionDateEdit').data('daterangepicker').setEndDate(date);
          $('#protectionAmountEdit').val(data.row.protection_amount);
          $('#protectionAmountUnitEdit').val(data.row.protection_amount_unit);
          $('#protectionPlantEdit').val(data.row.protection_plant);
          $('#protectionNoteEdit').val(data.row.protection_note);
          $('#protectionEdit').val(data.row.protection_id);
          $('#protectionEditModal').modal('toggle');

          let dataList = document.getElementById('protectionNameListEdit');
          let input = document.getElementById('protectionNameEdit');

          // Dohvat liste sredstava iz json datoteke
          let request = new XMLHttpRequest();
          request.onreadystatechange = function () {
            if (request.readyState === 4) {
              if (request.status === 200) {
                let jsonData = JSON.parse(request.responseText);

                jsonData.forEach(function (item) {
                  let option = document.createElement('option');
                  option.value = item;
                  dataList.appendChild(option);
                });
              }
            }
          }

          request.open('GET', './includes/json/protection_products.json', true);
          request.send();
        }
      }
    });
  });

  // Dohvacanje podataka za brisanje zastite
  $('#protectionTable tbody').on('click', '.protectionDeleteBtn', function () {
    let protectionDeleteId = $(this).attr('data-protection-id-delete');
    $.ajax({
      type: 'POST',
      url: './includes/application/protection_fetch_inc.php',
      data: 'protectionId=' + protectionDeleteId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#protectionDeleteName').html(data.row.protection_name);
          $('#protectionDelete').val(data.row.protection_id);
          $('#protectionDeleteModal').modal('toggle');
        }
      }
    });
  });

  // Modal za dodavanje gnojidbe
  $('#fertilizationAddModalBtn').on('click', function () {
    $('#fertilizationAddModal').modal('toggle');

    let dataList = document.getElementById('fertilizationNameList');
    let input = document.getElementById('fertilizationName');

    // Dohvat liste gnojiva iz json datoteke
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
      if (request.readyState === 4) {
        if (request.status === 200) {
          let jsonData = JSON.parse(request.responseText);

          jsonData.forEach(function (item) {
            let option = document.createElement('option');
            option.value = item;
            dataList.appendChild(option);
          });

          input.placeholder = "Naziv gnojiva";
        } else {
          input.placeholder = "Greška kod dohvata liste gnojiva";
        }
      }
    }

    input.placeholder = "Učitavanje liste...";

    request.open('GET', './includes/json/fertilizers.json', true);
    request.send();
  });

  // Dohvacanje podataka za uredenje gnojidbe
  $('#fertilizationTable tbody').on('click', '.fertilizationEditBtn', function () {
    let fertilizationEditId = $(this).attr('data-fertilization-id-edit');
    $.ajax({
      type: 'POST',
      url: './includes/application/fertilization_fetch_inc.php',
      data: 'fertilizationId=' + fertilizationEditId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          console.log(data);
          $('#fertilizationFieldEdit').val(data.row.field_id);
          $('#fertilizationNameEdit').val(data.row.fertilization_name);
          let dateSplit = data.row.fertilization_date.split('-');
          let date = dateSplit[2] + ". " + dateSplit[1] + ". " + dateSplit[0] + ".";
          $('#fertilizationDateEdit').data('daterangepicker').setStartDate(date);
          $('#fertilizationDateEdit').data('daterangepicker').setEndDate(date);
          $('#fertilizationAmountEdit').val(data.row.fertilization_amount);
          $('#fertilizationNoteEdit').val(data.row.fertilization_note);
          $('#fertilizationEdit').val(data.row.fertilization_id);
          $('#fertilizationEditModal').modal('toggle');

          let dataList = document.getElementById('fertilizationNameListEdit');
          let input = document.getElementById('fertilizationNameEdit');

          // Dohvat liste gnojiva iz json datoteke
          let request = new XMLHttpRequest();
          request.onreadystatechange = function () {
            if (request.readyState === 4) {
              if (request.status === 200) {
                let jsonData = JSON.parse(request.responseText);

                jsonData.forEach(function (item) {
                  let option = document.createElement('option');
                  option.value = item;
                  dataList.appendChild(option);
                });
              }
            }
          }

          request.open('GET', './includes/json/fertilizers.json', true);
          request.send();
        }
      }
    });
  });

  // Dohvacanje podataka za brisanje gnojidbe
  $('#fertilizationTable tbody').on('click', '.fertilizationDeleteBtn', function () {
    let fertilizationDeleteId = $(this).attr('data-fertilization-id-delete');
    $.ajax({
      type: 'POST',
      url: './includes/application/fertilization_fetch_inc.php',
      data: 'fertilizationId=' + fertilizationDeleteId,
      dataType: 'json',
      success: function (data) {
        if (data.status == 'error') {
          window.location.reload();
        } else if (data.status == 'success') {
          $('#fertilizationDeleteName').html(data.row.fertilization_name);
          $('#fertilizationDelete').val(data.row.fertilization_id);
          $('#fertilizationDeleteModal').modal('toggle');
        }
      }
    });
  });

});