<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['fieldAdd'])) {
  $userId = intval($_SESSION['user_id']);
  $fieldName = htmlentities(trim($_POST['fieldName']));
  $fieldSize = htmlentities(trim($_POST['fieldSize']));
  $fieldARKOD = htmlentities(trim($_POST['fieldARKOD']));
  $fieldNote = htmlentities(trim($_POST['fieldNote']));

  if ($fieldName == "") {
    redirectWithToastError("warning", "Naziv zemljišta je obavezan!", "../../fields");
  }

  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  if ($query->execute()) {
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $businessId = $row['current_business_id'];
      if ($businessId != null) {
        
      } else {
        redirectWithToastError("warning", "Nema aktivnog gospodarstva.", "../../fields");
      }      
    } else {
      redirectWithToastError("warning", "Greška kod dohvata korisnika. Pokušajte ponovno.", "../../fields");
    }  
  } else {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../fields");
  }
} else {
  header('Location: ../../');
}


?>