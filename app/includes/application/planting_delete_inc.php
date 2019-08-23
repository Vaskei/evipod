<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['plantingDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $plantingId = $_POST['plantingDelete'];

  // Provjera valjanosti ID-a
  if (filter_var($plantingId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../planting");
  }

  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    $query = $conn->prepare("DELETE planting FROM planting INNER JOIN fields ON planting.field_id = fields.field_id WHERE planting.planting_id = ? AND fields.business_id = ?");
    $query->bind_param("ii", $plantingId, $currentBusinessId);
    $query->execute();
    if ($query->affected_rows >= 1) {
      redirectWithToastSuccess("info", "Uspjeh.", "Sadnja/sjetva obrisana.", "../../planting");
    } else {
      redirectWithToastError("warning", "Greška kod brisanja. Pokušajte ponovno.", "../../planting");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../planting");
  }
} else {
  header('Location: ../../');
}
