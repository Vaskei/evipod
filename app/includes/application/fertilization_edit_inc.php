<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['fertilizationEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $fertilizationId = htmlentities(trim($_POST['fertilizationEdit']));
  $fertilizationFieldId = htmlentities(trim($_POST['fertilizationFieldEdit']));
  $fertilizationName = htmlentities(trim($_POST['fertilizationNameEdit']));
  $fertilizationDate = htmlentities(trim($_POST['fertilizationDateEdit']));
  $fertilizationAmount = htmlentities(trim($_POST['fertilizationAmountEdit']));
  $fertilizationNote = htmlentities(trim($_POST['fertilizationNoteEdit']));

  // Provjera ispravnosti ID gnojidbe
  if (filter_var($fertilizationId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera ispravnosti ID zemljista
  if (filter_var($fertilizationFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera da li je ime sredstva prazno
  if ($fertilizationName == "") {
    redirectWithToastError("warning", "Ime gnojiva je obavezno!", "../../activities");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($fertilizationDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../activities");
  }

  // Provjera formata kolicine sredstva
  if ($fertilizationAmount != "" && !preg_match('/^\d{0,8}(\.\d{0,2})?$/', $fertilizationAmount)) {
    redirectWithToastError("warning", "Neispravna količina gnojiva!", "../../activities");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['fertilizationNameEdit'])) > 100 || strlen(trim($_POST['fertilizationNoteEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $fertilizationDate)));
  // var_dump($mysqlDate);

  // Dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID zastite
    $query = $conn->prepare("SELECT * FROM fertilization INNER JOIN fields ON fertilization.business_id = fields.business_id WHERE fertilization.business_id = ? AND fertilization.fertilization_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $fertilizationId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE fertilization SET field_id=?, fertilization_name=?, fertilization_date=?, fertilization_amount=?, fertilization_note=? WHERE fertilization_id=? AND business_id=?");
      $query->bind_param("issdsii", $fertilizationFieldId, $fertilizationName, $mysqlDate, $fertilizationAmount, $fertilizationNote, $fertilizationId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Gnojidba ažurirana.", "../../activities");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Gnojidba nije ažurirana.", "../../activities");
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
