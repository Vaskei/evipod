<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['protectionEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $protectionId = htmlentities(trim($_POST['protectionEdit']));
  $protectionFieldId = htmlentities(trim($_POST['protectionFieldEdit']));
  $protectionName = htmlentities(trim($_POST['protectionNameEdit']));
  $protectionOrganism = htmlentities(trim($_POST['protectionOrganismEdit']));
  $protectionDate = htmlentities(trim($_POST['protectionDateEdit']));
  $protectionAmount = htmlentities(trim($_POST['protectionAmountEdit']));
  $protectionAmountUnit = htmlentities(trim($_POST['protectionAmountUnitEdit']));
  $protectionPlant = htmlentities(trim($_POST['protectionPlantEdit']));
  $protectionNote = htmlentities(trim($_POST['protectionNoteEdit']));

  // Provjera ispravnosti ID zastite
  if (filter_var($protectionId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera ispravnosti ID zemljista
  if (filter_var($protectionFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera da li je ime sredstva prazno
  if ($protectionName == "") {
    redirectWithToastError("warning", "Sredstvo je obavezno!", "../../activities");
  }

  // Provjera ispravnosti datuma
  if (!validateDateTime($protectionDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../activities");
  }

  // Provjera formata kolicine sredstva
  if ($protectionAmount != "" && !preg_match('/^\d{0,8}(\.\d{0,2})?$/', $protectionAmount)) {
    redirectWithToastError("warning", "Neispravna količina sredstva!", "../../activities");
  }

  // Provjera formata jedinice kolicine
  if ($protectionAmountUnit == "kg/ha" || $protectionAmountUnit == "l/ha") {
    // OK
  } else {
    redirectWithToastError("warning", "Neispravan format količine sredstva!", "../../activities");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['protectionNameEdit'])) > 100 || strlen(trim($_POST['protectionOrganismEdit'])) > 100 || strlen(trim($_POST['protectionPlantEdit'])) > 100 || strlen(trim($_POST['protectionNoteEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. hh:mm u MySQL format YYYY-MM-DD hh:mm:00)
  $mysqlDate = date('Y-m-d H:i:00', strtotime(str_replace(' ', '', $protectionDate)));
  // var_dump($mysqlDate);

  // dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID zastite
    $query = $conn->prepare("SELECT * FROM protection INNER JOIN fields ON protection.business_id = fields.business_id WHERE protection.business_id = ? AND protection.protection_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $protectionId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE protection SET field_id=?, protection_name=?, protection_organism=?, protection_date=?, protection_amount=?, protection_amount_unit=?, protection_plant=?, protection_note=? WHERE protection_id=? AND business_id=?");
      $query->bind_param("isssdsssii", $protectionFieldId, $protectionName, $protectionOrganism, $mysqlDate, $protectionAmount, $protectionAmountUnit, $protectionPlant, $protectionNote, $protectionId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Zaštita ažurirana.", "../../activities");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Zaštita nije ažurirana.", "../../activities");
      } else {
        redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
      }
    } else {
      // ID zastite i aktivno gospodarstvo se ne podudaraju, vracamo korisnika s greskom
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../activities");
  }
} else {
  header('Location: ../../');
}
