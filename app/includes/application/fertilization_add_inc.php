<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['fertilizationAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $fertilizationFieldId = htmlentities(trim($_POST['fertilizationField']));
  $fertilizationName = htmlentities(trim($_POST['fertilizationName']));
  $fertilizationDate = htmlentities(trim($_POST['fertilizationDate']));
  $fertilizationAmount = htmlentities(trim($_POST['fertilizationAmount']));
  $fertilizationNote = htmlentities(trim($_POST['fertilizationNote']));

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
  if (strlen(trim($_POST['fertilizationName'])) > 100 || strlen(trim($_POST['fertilizationNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $fertilizationDate)));
  // var_dump($mysqlDate);

  // Provjera da li postoji korisnik sa odabranim zemljistem
  $query = $conn->prepare("SELECT * FROM fields INNER JOIN users ON fields.business_id = users.current_business_id WHERE users.user_id = ? AND fields.field_id = ?");
  $query->bind_param("ii", $userId, $fertilizationFieldId);
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
        $query = $conn->prepare("INSERT INTO fertilization(field_id, business_id, fertilization_name, fertilization_date, fertilization_amount, fertilization_note) VALUES (?,?,?,?,?,?)");
        $query->bind_param("iissds", $fertilizationFieldId, $businessId, $fertilizationName, $mysqlDate, $fertilizationAmount, $fertilizationNote);
        $query->execute();
        if ($query->affected_rows >= 1) {
          redirectWithToastSuccess("success", "Uspjeh.", "Gnojidba dodana.", "../../activities");
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
