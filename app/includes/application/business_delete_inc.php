<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['businessDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  $userId = intval($_SESSION['user_id']);
  $businessId = $_POST['businessDelete'];

  // Dohvacanje trenutno aktivnog gospodarstva
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];

  // Provjera valjanosti ID-a
  if (filter_var($businessId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../business");
  }

  // Brisanje gospodarstva
  $query = $conn->prepare("DELETE FROM business WHERE business_id = ? AND user_id = ?");
  $query->bind_param("ii", $businessId, $userId);
  if ($query->execute()) {
    // Provjera da li je gospodarstvo koje brisemo isto kao i trenutno aktivno gospodarstvo
    if ($businessId == $currentBusinessId) {
      $query = $conn->prepare("SELECT * FROM business");
      $query->execute();
      $result = $query->get_result();
      // Ukoliko jos postoje gospodarstva u bazi, postavljamo zadnje dodano gospodarstvo kao aktivno
      if ($result->num_rows >= 1) {
        $query = $conn->prepare("SELECT * FROM business WHERE user_id = ? ORDER BY business_id DESC LIMIT 1");
        $query->bind_param("i", $userId);
        $query->execute();
        $row = $query->get_result()->fetch_assoc();
        $lastBusinessId = $row['business_id'];
        $query = $conn->prepare("UPDATE users SET current_business_id = ? WHERE user_id = ?");
        $query->bind_param("ii", $lastBusinessId, $userId);
        $query->execute();
        redirectWithToastSuccess("info", "Uspjeh.", "Gospodarstvo obrisano.", "../../business");
      } elseif ($result->num_rows == 0) { // Ukoliko je obrisano zadnje gospodarstvo u bazi, postavljamo potrebne podatke
        $query = $conn->prepare("UPDATE users SET current_business_id = NULL WHERE user_id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        redirectWithToastSuccess("info", "Uspjeh.", "Gospodarstvo obrisano.", "../../business");
      }
    } elseif ($businessId != $currentBusinessId) { // Provjera da li je gospodarstvo koje brisemo razlicito od aktivnog gospodarstva
      $query = $conn->prepare("SELECT * FROM business");
      $query->execute();
      $result = $query->get_result();
      if ($result->num_rows == 0) { // Ukoliko je obrisano zadnje gospodarstvo u bazi, postavljamo potrebne podatke
        $query = $conn->prepare("UPDATE users SET current_business_id = NULL WHERE user_id = ?");
        $query->bind_param("i", $userId);
        $query->execute();
        redirectWithToastSuccess("info", "Uspjeh.", "Gospodarstvo obrisano.", "../../business");
      }
      redirectWithToastSuccess("info", "Uspjeh.", "Gospodarstvo obrisano.", "../../business");
    }
  } else {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../business");
  }
} else {
  header('Location: ../../');
}
