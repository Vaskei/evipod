<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['tillageDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $tillageId = $_POST['tillageDelete'];

  // Provjera valjanosti ID-a
  if (filter_var($tillageId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../activities");
  }

  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    $query = $conn->prepare("DELETE tillage FROM tillage INNER JOIN fields ON tillage.field_id = fields.field_id WHERE tillage.tillage_id = ? AND fields.business_id = ?");
    $query->bind_param("ii", $tillageId, $currentBusinessId);
    $query->execute();
    if ($query->affected_rows >= 1) {
      redirectWithToastSuccess("info", "Uspjeh.", "Obrada tla obrisana.", "../../activities");
    } else {
      redirectWithToastError("warning", "Greška kod brisanja. Pokušajte ponovno.", "../../activities");
    }
  } else {
    redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../activities");
  }
} else {
  header('Location: ../../');
}
