<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['rotationEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $rotationId = htmlentities(trim($_POST['rotationEdit']));
  $rotationFieldId = htmlentities(trim($_POST['rotationFieldEdit']));
  $rotationYear = htmlentities(trim($_POST['rotationYearEdit']));
  $rotationName = htmlentities(trim($_POST['rotationNameEdit']));
  $rotationNote = htmlentities(trim($_POST['rotationNoteEdit']));

  // Provjera ispravnosti ID plodoreda
  if (filter_var($rotationId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
  }

  // Provjera ispravnosti ID zemljista
  if (filter_var($rotationFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
  }

  // Provjera da li je ime obrada tla prazna
  if ($rotationName == "") {
    redirectWithToastError("warning", "Naziv kultivara je obavezan!", "../../rotation");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($rotationYear, 'Y')) {
    redirectWithToastError("warning", "Unesen neispravan format godine!", "../../rotation");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['rotationNameEdit'])) > 100 || strlen(trim($_POST['rotationNoteEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../rotation");
  }

  // Dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID plodoreda
    $query = $conn->prepare("SELECT * FROM rotation INNER JOIN fields ON rotation.business_id = fields.business_id WHERE rotation.business_id = ? AND rotation.rotation_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $rotationId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE rotation SET field_id=?, rotation_year=?, rotation_name=?, rotation_note=? WHERE rotation_id=? AND business_id=?");
      $query->bind_param("isssii", $rotationFieldId, $rotationYear, $rotationName, $rotationNote, $rotationId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Plodored ažuriran.", "../../rotation");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Plodored nije ažuriran.", "../../rotation");
      } else {
        redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
      }
    } else {
      // ID zastite i aktivno gospodarstvo se ne podudaraju, vracamo korisnika s greskom
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../rotation");
  }
} else {
  header('Location: ../../');
}
