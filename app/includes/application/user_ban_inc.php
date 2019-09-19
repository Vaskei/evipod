<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
if ($_SESSION['user_role'] != 'admin') header("Location: ../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['userBan'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);
  // exit();
  $userId = $_SESSION['user_id'];
  $banId = htmlentities(trim($_POST['userBan']));

  // Provjera ispravnosti ID obrade tla
  if (filter_var($banId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../admin");
  }

  // Dohvacanje korisnika
  $query = $conn->prepare("SELECT * FROM users WHERE user_id=? LIMIT 1");
  $query->bind_param("i", $banId);
  $query->execute();
  $user = $query->get_result();
  if ($user->num_rows > 0) {
    $banValue = 1;
    $query = $conn->prepare("UPDATE users SET is_banned=? WHERE user_id=?");
    $query->bind_param("ii", $banValue, $banId);
    $query->execute();
    if ($query->affected_rows > 0) {
      redirectWithToastSuccess("success", "Uspjeh.", "Korisnik blokiran.", "../../admin");
    } else {
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../admin");
    }  
  } else {
    redirectWithToastError("warning", "Korisnik ne postoji.", "../../admin");
  }  
} else {
  header('Location: ../../');
}
