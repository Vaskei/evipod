<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['careEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $careId = htmlentities(trim($_POST['careEdit']));
  $careFieldId = htmlentities(trim($_POST['careFieldEdit']));
  $careName = htmlentities(trim($_POST['careNameEdit']));
  $careCulture = htmlentities(trim($_POST['careCultureEdit']));
  $careDate = htmlentities(trim($_POST['careDateEdit']));
  $careNote = htmlentities(trim($_POST['careNoteEdit']));

  // Provjera ispravnosti ID njege
  if (filter_var($careId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera ispravnosti ID zemljista
  if (filter_var($careFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera da li je naziv njege prazan
  if ($careName == "") {
    redirectWithToastError("warning", "Mjera ili zahvat je obavezan!", "../../activities");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($careDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../activities");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['careNameEdit'])) > 100 || strlen(trim($_POST['careCultureEdit'])) > 100 || strlen(trim($_POST['careNoteEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $careDate)));
  // var_dump($mysqlDate);

  // Dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID obrade tla
    $query = $conn->prepare("SELECT * FROM care INNER JOIN fields ON care.business_id = fields.business_id WHERE care.business_id = ? AND care.care_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $careId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE care SET field_id=?, care_name=?, care_culture=?, care_date=?, care_note=? WHERE care_id=? AND business_id=?");
      $query->bind_param("issssii", $careFieldId, $careName, $careCulture, $mysqlDate, $careNote, $careId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Njega ažurirana.", "../../activities");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Njega nije ažurirana.", "../../activities");
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
