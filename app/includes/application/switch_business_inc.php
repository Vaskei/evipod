<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

$userId = $_SESSION['user_id'];

// var_dump($_POST);

if (isset($_POST['businessId'])) {
  // var_dump($_POST);
  $businessId = $_POST['businessId'];
  // var_dump($businessId);

  // Provjera da li je prosljedeni ID OPG-a krivog formata
  if (filter_var($businessId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("danger", "Greška kod promjene gospodarstva.", "../../");
  } else {
    // Provjera da li postoji korisnik sa OPG-om
    $query = $conn->prepare("SELECT * FROM business WHERE business_id = ? AND user_id = ? LIMIT 1");
    $query->bind_param("ii", $businessId, $userId);
    $query->execute();
    $result = $query->get_result();
    // var_dump($result);
    // Zaustavljanje skripte ukoliko nema valjanog rezultata
    if ($result->num_rows < 1) {
      redirectWithToastError("danger", "Greška kod promjene gospodarstva.", "../../");
    } else {
      // Azuriranje users tabele i sesije
      $query = $conn->prepare("UPDATE users SET current_business_id = ? WHERE user_id = ?");
      $query->bind_param("ii", $businessId, $userId);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithToastSuccess("success", "Uspjeh.", "Gospodarstvo promijenjeno.", "../../");
      } elseif ($query->affected_rows == 0) {
        redirectWithToastError("warning", "Gospodarstvo nije promijenjeno.", "../../");
      } else {
        redirectWithToastError("danger", "Greška kod promjene gospodarstva.", "../../");
      } 
    }
  }
} else {
  header('Location: ../../');
}
