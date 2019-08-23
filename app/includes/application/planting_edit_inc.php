<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['plantingEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];                                       // ID korisnika
  $plantingId = $_POST['plantingEdit'];                                 // ID sjetve/sadnje
  $plantingFieldId = htmlentities(trim($_POST['plantingFieldEdit']));   // ID odabranog zemljista
  $plantingName = htmlentities(trim($_POST['plantingNameEdit']));       // Ime kultivara
  $plantingCount = htmlentities(trim($_POST['plantingCountEdit']));     // Broj sjemenki
  $plantingDate = htmlentities(trim($_POST['plantingDateEdit']));       // Datum sjetve/sadnje
  $plantingSource = htmlentities(trim($_POST['plantingSourceEdit']));   // Porijeklo ili proizvodac kultivara
  $plantingNote = htmlentities(trim($_POST['plantingNoteEdit']));       // Napomena

  // Provjera ispravnosti ID sjetve/sadnje
  if (filter_var($plantingId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
  }

  // Provjera ispravnosti ID zemljista
  if (filter_var($plantingFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
  }

  // Provjera da li je ime kultivara prazno
  if ($plantingName == "") {
    redirectWithToastError("warning", "Naziv kultivara je obavezan!", "../../planting");
  }

  // Provjera formata broja sjemenki
  if ($plantingCount != "" && !preg_match('/^[0-9]{1,11}$/', $plantingCount)) {
    redirectWithToastError("warning", "Neispravna količina!", "../../planting");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['plantingSourceEdit'])) > 100 || strlen(trim($_POST['plantingNoteEdit'])) > 100 || strlen(trim($_POST['plantingNameEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../planting");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($plantingDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../planting");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $plantingDate)));

  // dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID sjetve/sadnje
    $query = $conn->prepare("SELECT * FROM planting INNER JOIN fields ON planting.business_id = fields.business_id WHERE planting.business_id = ? AND planting.planting_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $plantingId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE planting SET field_id=?, planting_name=?, planting_count=?, planting_date=?, planting_source=?, planting_note=? WHERE planting_id=? AND business_id=?");
      $query->bind_param("isisssii", $plantingFieldId, $plantingName, $plantingCount, $mysqlDate, $plantingSource, $plantingNote, $plantingId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Sadnja/sjetva ažurirana.", "../../planting");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Sadnja/sjetva nije ažurirana.", "../../planting");
      } else {
        redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
      }
    } else {
      // ID sjetve/sadnje i aktivno gospodarstvo se ne podudaraju, vracamo korisnika s greskom
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../planting");
  }
} else {
  header('Location: ../../');
}
