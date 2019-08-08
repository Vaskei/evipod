<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['fieldAdd'])) {
  $userId = $_SESSION['user_id'];
  $fieldName = htmlentities(trim($_POST['fieldName']));
  $fieldSize = htmlentities(trim($_POST['fieldSize']));
  $fieldARKOD = htmlentities(trim($_POST['fieldARKOD']));
  $fieldNote = htmlentities(trim($_POST['fieldNote']));

  // Provjera da li je ime zemljista prazno
  if ($fieldName == "") {
    redirectWithToastError("warning", "Naziv zemljišta je obavezan!", "../../fields");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['fieldName'])) > 100 || strlen(trim($_POST['fieldNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../fields");
  }

  // Provjera formata velicine zemljista
  if ($fieldSize != "" && !preg_match('/^\d{0,8}(\.\d{0,2})?$/', $fieldSize)) {
    redirectWithToastError("warning", "Neispravna veličina zemljišta!", "../../fields");
  }

  // Provjera ARKOD formata ukoliko je upisan
  if ($fieldARKOD != "" && !preg_match('/^[0-9]{7}$/', $fieldARKOD)) {
    redirectWithToastError("warning", "Neispravan format ARKOD-a!", "../../fields");
  }

  // Dohvat korisnika da saznamo aktivno gospodarstvo
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result();
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $businessId = $row['current_business_id'];
    if ($businessId != NULL) {
      $query = $conn->prepare("INSERT INTO fields(business_id, field_name, field_size, field_arkod, field_note) VALUES (?,?,?,?,?)");
      $query->bind_param("isdis", $businessId, $fieldName, $fieldSize, $fieldARKOD, $fieldNote);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Zemljište dodano.", "../../fields");
      } else {
        redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../fields");
      }
    } else {
      redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../fields");
    }
  } else {
    redirectWithToastError("warning", "Greška kod dohvata korisnika. Pokušajte ponovno.", "../../fields");
  }
} else {
  header('Location: ../../');
}
