<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['harvestEdit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $harvestId = htmlentities(trim($_POST['harvestEdit']));
  $harvestFieldId = htmlentities(trim($_POST['harvestFieldEdit']));
  $harvestName = htmlentities(trim($_POST['harvestNameEdit']));
  $harvestAmount = htmlentities(trim($_POST['harvestAmountEdit']));
  $harvestAmountUnit = htmlentities(trim($_POST['harvestAmountUnitEdit']));
  $harvestDate = htmlentities(trim($_POST['harvestDateEdit']));
  $harvestNote = htmlentities(trim($_POST['harvestNoteEdit']));

  // Provjera ispravnosti ID zemljista
  if (filter_var($harvestFieldId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
  }

  // Provjera ispravnosti ID berbe/zetve
  if (filter_var($harvestId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
  }

  // Provjera da li je naziv berbe/zetve prazan
  if ($harvestName == "") {
    redirectWithToastError("warning", "Kultura berbe ili žetve je obavezna!", "../../harvest");
  }

  // Provjera formata kolicine
  if ($harvestAmount != "" && !preg_match('/^[0-9]{1,11}$/', $harvestAmount)) {
    redirectWithToastError("warning", "Neispravna količina!", "../../harvest");
  }

  // Provjera formata jedinice kolicine
  if ($harvestAmountUnit == "kg" || $harvestAmountUnit == "t") {
    // OK
  } else {
    redirectWithToastError("warning", "Neispravan format količine!", "../../harvest");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($harvestDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../harvest");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['harvestNameEdit'])) > 100 || strlen(trim($_POST['harvestNoteEdit'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../harvest");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $harvestDate)));
  // var_dump($mysqlDate);

  // Dohvacanje aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    // Provjera da li postoji korisnik sa ID berbe/zetve
    $query = $conn->prepare("SELECT * FROM harvest INNER JOIN fields ON harvest.business_id = fields.business_id WHERE harvest.business_id = ? AND harvest.harvest_id = ? LIMIT 1");
    $query->bind_param("ii", $currentBusinessId, $harvestId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE harvest SET field_id=?, harvest_name=?, harvest_amount=?, harvest_amount_unit=?, harvest_date=?, harvest_note=? WHERE harvest_id=? AND business_id=?");
      $query->bind_param("isisssii", $harvestFieldId, $harvestName, $harvestAmount, $harvestAmountUnit, $mysqlDate, $harvestNote, $harvestId, $currentBusinessId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Berba/žetva ažurirana.", "../../harvest");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Berba/žetva nije ažurirana.", "../../harvest");
      } else {
        redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
      }
    } else {
      // ID berbe/zetve i aktivno gospodarstvo se ne podudaraju, vracamo korisnika s greskom
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../harvest");
  }
} else {
  header('Location: ../../');
}
