<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['tillageEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $tillageId = htmlentities(trim($_POST['tillageEdit']));
  $tillageFieldId = htmlentities(trim($_POST['tillageFieldEdit']));
  $tillageName = htmlentities(trim($_POST['tillageNameEdit']));
  $tillageDate = htmlentities(trim($_POST['tillageDateEdit']));
  $tillageNote = htmlentities(trim($_POST['tillageNoteEdit']));

  // Provjera ispravnosti ID obrade tla
  if (filter_var($tillageId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera ispravnosti ID zemljista
  if (filter_var($tillageFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  // Provjera da li je ime obrada tla prazna
  if ($tillageName == "") {
    redirectWithToastError("warning", "Naziv djelatnosti je obavezan!", "../../activities");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($tillageDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../activities");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['tillageNameEdit'])) > 100 || strlen(trim($_POST['tillageNoteEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $tillageDate)));
  // var_dump($mysqlDate);

  // Dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID obrade tla
    $query = $conn->prepare("SELECT * FROM tillage INNER JOIN fields ON tillage.business_id = fields.business_id WHERE tillage.business_id = ? AND tillage.tillage_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $tillageId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE tillage SET field_id=?, tillage_name=?, tillage_date=?, tillage_note=? WHERE tillage_id=? AND business_id=?");
      $query->bind_param("isssii", $tillageFieldId, $tillageName, $mysqlDate, $tillageNote, $tillageId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Obrada tla ažurirana.", "../../activities");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Obrada tla nije ažurirana.", "../../activities");
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
