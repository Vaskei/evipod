<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['fieldsDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $fieldsId = $_POST['fieldsDelete'];

  // Provjera valjanosti ID-a
  if (filter_var($fieldsId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../fields");
  }

  $query = $conn->prepare("DELETE fields FROM fields INNER JOIN business ON fields.business_id = business.business_id WHERE fields.field_id = ? AND business.user_id = ?");
  $query->bind_param("ii", $fieldsId, $userId);
  $query->execute();
  if ($query->affected_rows >= 1) {
    redirectWithToastSuccess("info", "Uspjeh.", "Zemljište obrisano.", "../../fields");
  } else {
    redirectWithToastError("warning", "Greška kod brisanja. Pokušajte ponovno.", "../../fields");
  }
} else {
  header('Location: ../../');
}
