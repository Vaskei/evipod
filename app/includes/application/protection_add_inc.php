<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['protectionAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $protectionFieldId = htmlentities(trim($_POST['protectionField']));
  $protectionName = htmlentities(trim($_POST['protectionName']));
  $protectionOrganism = htmlentities(trim($_POST['protectionOrganism']));
  $protectionDate = htmlentities(trim($_POST['protectionDate']));
  $protectionAmount = htmlentities(trim($_POST['protectionAmount']));
  $protectionAmountUnit = htmlentities(trim($_POST['protectionAmountUnit']));
  $protectionPlant = htmlentities(trim($_POST['protectionPlant']));
  $protectionNote = htmlentities(trim($_POST['protectionNote']));

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
  if (strlen(trim($_POST['protectionName'])) > 100 || strlen(trim($_POST['protectionOrganism'])) > 100 || strlen(trim($_POST['protectionPlant'])) > 100 || strlen(trim($_POST['protectionNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. hh:mm u MySQL format YYYY-MM-DD hh:mm:00)
  $mysqlDate = date('Y-m-d H:i:00', strtotime(str_replace(' ', '', $protectionDate)));
  // var_dump($mysqlDate);

  // Provjera da li postoji korisnik sa odabranim zemljistem
  $query = $conn->prepare("SELECT * FROM fields INNER JOIN users ON fields.business_id = users.current_business_id WHERE users.user_id = ? AND fields.field_id = ?");
  $query->bind_param("ii", $userId, $protectionFieldId);
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
        $query = $conn->prepare("INSERT INTO protection(field_id, business_id, protection_name, protection_organism, protection_date, protection_amount, protection_amount_unit, protection_plant, protection_note) VALUES (?,?,?,?,?,?,?,?,?)");
        $query->bind_param("iisssdsss", $protectionFieldId, $businessId, $protectionName, $protectionOrganism, $mysqlDate, $protectionAmount, $protectionAmountUnit, $protectionPlant, $protectionNote);
        $query->execute();
        if ($query->affected_rows >= 1) {
          redirectWithToastSuccess("success", "Uspjeh.", "Zaštita dodana.", "../../activities");
        } else {
          redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
        }
      } else {
        redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../activities");
      }
    } else {
      redirectWithToastError("warning", "Greška kod dohvata korisnika. Pokušajte ponovno.", "../../activities");
    }
  } else {
    // Korisnik i zemljiste se ne podudaraju, vracamo korisnika s greskom
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }
} else {
  header('Location: ../../');
}
