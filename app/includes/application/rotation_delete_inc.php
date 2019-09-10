<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['rotationDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $rotationId = $_POST['rotationDelete'];

  // Provjera valjanosti ID-a
  if (filter_var($rotationId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../rotation");
  }

  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    $query = $conn->prepare("DELETE rotation FROM rotation INNER JOIN fields ON rotation.field_id = fields.field_id WHERE rotation.rotation_id = ? AND fields.business_id = ?");
    $query->bind_param("ii", $rotationId, $currentBusinessId);
    $query->execute();
    if ($query->affected_rows >= 1) {
      redirectWithToastSuccess("info", "Uspjeh.", "Plodored obrisan.", "../../rotation");
    } else {
      redirectWithToastError("warning", "Greška kod brisanja. Pokušajte ponovno.", "../../rotation");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../rotation");
  }
} else {
  header('Location: ../../');
}
