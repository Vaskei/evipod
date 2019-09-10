<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['rotationAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $rotationFieldId = htmlentities(trim($_POST['rotationField']));
  $rotationYear = htmlentities(trim($_POST['rotationYear']));
  $rotationName = htmlentities(trim($_POST['rotationName']));
  $rotationNote = htmlentities(trim($_POST['rotationNote']));

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
  if (strlen(trim($_POST['rotationName'])) > 100 || strlen(trim($_POST['rotationNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../rotation");
  }

  // Provjera da li postoji korisnik sa odabranim zemljistem
  $query = $conn->prepare("SELECT * FROM fields INNER JOIN users ON fields.business_id = users.current_business_id WHERE users.user_id = ? AND fields.field_id = ?");
  $query->bind_param("ii", $userId, $rotationFieldId);
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
        $query = $conn->prepare("INSERT INTO rotation(field_id, business_id, rotation_year, rotation_name, rotation_note) VALUES (?,?,?,?,?)");
        $query->bind_param("iisss", $rotationFieldId, $businessId, $rotationYear, $rotationName, $rotationNote);
        $query->execute();
        if ($query->affected_rows >= 1) {
          redirectWithToastSuccess("success", "Uspjeh.", "Plodored dodan.", "../../rotation");
        } else {
          redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
        }
      } else {
        redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../rotation");
      }
    } else {
      redirectWithToastError("warning", "Greška kod dohvata korisnika. Pokušajte ponovno.", "../../rotation");
    }
  } else {
    // Korisnik i zemljiste se ne podudaraju, vracamo korisnika s greskom
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
  }
} else {
  header('Location: ../../');
}
