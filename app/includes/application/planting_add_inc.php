<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['plantingAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];                                   // ID korisnika
  $plantingFieldId = htmlentities(trim($_POST['plantingField']));   // ID odabranog zemljista
  $plantingName = htmlentities(trim($_POST['plantingName']));       // Ime kultivara
  $plantingCount = htmlentities(trim($_POST['plantingCount']));     // Broj sjemenki
  $plantingDate = htmlentities(trim($_POST['plantingDate']));       // Datum sjetve/sadnje
  $plantingSource = htmlentities(trim($_POST['plantingSource']));   // Porijeklo ili proizvodac kultivara
  $plantingNote = htmlentities(trim($_POST['plantingNote']));       // Napomena

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
  if (strlen(trim($_POST['plantingSource'])) > 100 || strlen(trim($_POST['plantingNote'])) > 100 || strlen(trim($_POST['plantingName'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../planting");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($plantingDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../planting");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $plantingDate)));
  // var_dump($mysqlDate);
  // $date = str_replace(' ', '', $plantingDate);
  // var_dump($date);
  // $timestamp = strtotime($date);
  // var_dump($timestamp);
  // $date = date('Y-m-d', $timestamp);
  // var_dump($date);

  // Provjera da li postoji korisnik sa odabranim zemljistem
  $query = $conn->prepare("SELECT * FROM fields INNER JOIN users ON fields.business_id = users.current_business_id WHERE users.user_id = ? AND fields.field_id = ?");
  $query->bind_param("ii", $userId, $plantingFieldId);
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
        $query = $conn->prepare("INSERT INTO planting(field_id, business_id, planting_name, planting_count, planting_date, planting_source, planting_note) VALUES (?,?,?,?,?,?,?)");
        $query->bind_param("iisisss", $plantingFieldId, $businessId, $plantingName, $plantingCount, $mysqlDate, $plantingSource, $plantingNote);
        $query->execute();
        if ($query->affected_rows >= 1) {
          redirectWithToastSuccess("success", "Uspjeh.", "Sadnja/sjetva dodana.", "../../planting");
        } else {
          redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
        }
      } else {
        redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../planting");
      }      
    } else {
      redirectWithToastError("warning", "Greška kod dohvata korisnika. Pokušajte ponovno.", "../../planting");
    }
  } else {
    // Korisnik i zemljiste se ne podudaraju, vracamo korisnika s greskom
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
  }  
} else {
  header('Location: ../../');
}
