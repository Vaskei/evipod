<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['harvestAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $harvestFieldId = htmlentities(trim($_POST['harvestField']));
  $harvestName = htmlentities(trim($_POST['harvestName']));
  $harvestAmount = htmlentities(trim($_POST['harvestAmount']));
  $harvestAmountUnit = htmlentities(trim($_POST['harvestAmountUnit']));
  $harvestDate = htmlentities(trim($_POST['harvestDate']));
  $harvestNote = htmlentities(trim($_POST['harvestNote']));

  // Provjera ispravnosti ID zemljista
  if (filter_var($harvestFieldId, FILTER_VALIDATE_INT) == false) {
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
  if (strlen(trim($_POST['harvestName'])) > 100 || strlen(trim($_POST['harvestNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../harvest");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $harvestDate)));
  // var_dump($mysqlDate);

  // Provjera da li postoji korisnik sa odabranim zemljistem
  $query = $conn->prepare("SELECT * FROM fields INNER JOIN users ON fields.business_id = users.current_business_id WHERE users.user_id = ? AND fields.field_id = ?");
  $query->bind_param("ii", $userId, $harvestFieldId);
  $query->execute();
  $result = $query->get_result();
  if ($result->num_rows > 0) {
    // Korisnik s odabranim zemljistem postoji, dohvacanje aktivnog gospodarstva
    $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
    $query->bind_param("i", $userId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $businessId = $row['current_business_id'];
      if ($businessId != NULL) {
        $query = $conn->prepare("INSERT INTO harvest(field_id, business_id, harvest_name, harvest_amount, harvest_amount_unit, harvest_date, harvest_note) VALUES (?,?,?,?,?,?,?)");
        $query->bind_param("iisisss", $harvestFieldId, $businessId, $harvestName, $harvestAmount, $harvestAmountUnit, $mysqlDate, $harvestNote);
        $query->execute();
        if ($query->affected_rows >= 1) {
          redirectWithToastSuccess("success", "Uspjeh.", "Berba/žetva dodana.", "../../harvest");
        } else {
          redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
        }
      } else {
        redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../harvest");
      }
    } else {
      redirectWithToastError("warning", "Greška kod dohvata korisnika. Pokušajte ponovno.", "../../harvest");
    }
  } else {
    // Korisnik i zemljiste se ne podudaraju, vracamo korisnika s greskom
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
  }
} else {
  header('Location: ../../');
}
