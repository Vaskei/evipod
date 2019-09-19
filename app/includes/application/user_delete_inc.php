<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
if ($_SESSION['user_role'] != 'admin') header("Location: ../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['userDelete'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $deleteId = htmlentities(trim($_POST['userDelete']));

  // Provjera ispravnosti ID obrade tla
  if (filter_var($deleteId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../admin");
  }

  // Dohvacanje korisnika
  $query = $conn->prepare("SELECT * FROM users WHERE user_id=? LIMIT 1");
  $query->bind_param("i", $deleteId);
  $query->execute();
  $user = $query->get_result();
  if ($user->num_rows > 0) {
    $query = $conn->prepare("DELETE users FROM users WHERE user_id=?");
    $query->bind_param("i", $deleteId);
    $query->execute();
    if ($query->affected_rows > 0) {
      redirectWithToastSuccess("success", "Uspjeh.", "Korisnik obrisan.", "../../admin");
    } else {
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../admin");
    }  
  } else {
    redirectWithToastError("warning", "Korisnik ne postoji.", "../../admin");
  }  
} else {
  header('Location: ../../');
}
