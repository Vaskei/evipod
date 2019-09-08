<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['harvestDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $harvestId = $_POST['harvestDelete'];

  // Provjera valjanosti ID-a
  if (filter_var($harvestId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../harvest");
  }

  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    $query = $conn->prepare("DELETE harvest FROM harvest INNER JOIN fields ON harvest.field_id = fields.field_id WHERE harvest.harvest_id = ? AND fields.business_id = ?");
    $query->bind_param("ii", $harvestId, $currentBusinessId);
    $query->execute();
    if ($query->affected_rows >= 1) {
      redirectWithToastSuccess("info", "Uspjeh.", "Berba/žetva obrisana.", "../../harvest");
    } else {
      redirectWithToastError("warning", "Greška kod brisanja. Pokušajte ponovno.", "../../harvest");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../harvest");
  }
} else {
  header('Location: ../../');
}
