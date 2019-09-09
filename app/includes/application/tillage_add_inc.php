<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['tillageAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $tillageFieldId = htmlentities(trim($_POST['tillageField']));
  $tillageName = htmlentities(trim($_POST['tillageName']));
  $tillageDate = htmlentities(trim($_POST['tillageDate']));
  $tillageNote = htmlentities(trim($_POST['tillageNote']));

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
  if (strlen(trim($_POST['tillageName'])) > 100 || strlen(trim($_POST['tillageNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../activities");
  }

  // Konverzija datuma (DD. MM. YYYY. u MySQL format YYYY-MM-DD)
  $mysqlDate = date('Y-m-d', strtotime(str_replace(' ', '', $tillageDate)));
  // var_dump($mysqlDate);

  // Provjera da li postoji korisnik sa odabranim zemljistem
  $query = $conn->prepare("SELECT * FROM fields INNER JOIN users ON fields.business_id = users.current_business_id WHERE users.user_id = ? AND fields.field_id = ?");
  $query->bind_param("ii", $userId, $tillageFieldId);
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
        $query = $conn->prepare("INSERT INTO tillage(field_id, business_id, tillage_name, tillage_date, tillage_note) VALUES (?,?,?,?,?)");
        $query->bind_param("iisss", $tillageFieldId, $businessId, $tillageName, $mysqlDate, $tillageNote);
        $query->execute();
        if ($query->affected_rows >= 1) {
          redirectWithToastSuccess("success", "Uspjeh.", "Obrada tla dodana.", "../../activities");
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
