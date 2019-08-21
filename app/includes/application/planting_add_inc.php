<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['plantingAdd'])) {
  var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $plantingField = htmlentities(trim($_POST['plantingField']));
  $plantingName = htmlentities(trim($_POST['plantingName']));
  $plantingCount = htmlentities(trim($_POST['plantingCount']));
  $plantingDate = htmlentities(trim($_POST['plantingDate']));
  $plantingSource = htmlentities(trim($_POST['plantingSource']));
  $plantingNote = htmlentities(trim($_POST['plantingNote']));

  // Provjera ispravnosti ID zemljista
  if (filter_var($plantingField, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
  }

  // Provjera da li je ime kultivara prazno
  if ($plantingName == "") {
    redirectWithToastError("warning", "Naziv kultivara je obavezan!", "../../planting");
  }

  // Provjera formata broja sjemenki
  if ($plantingCount != "" && !preg_match('/^[0-9]{1,11}$/', $plantingCount)) {
    redirectWithToastError("warning", "Neispravna veličina zemljišta!", "../../planting");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (strlen(trim($_POST['plantingSource'])) > 100 || strlen(trim($_POST['plantingNote'])) > 100) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../planting");
  }

  // Provjera ispravnosti datuma
  if (!validateDate($plantingDate)) {
    redirectWithToastError("warning", "Unesen neispravan format datuma!", "../../planting");
  }
} else {
  header('Location: ../../');
}
