<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['settingsSubmit'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $oldPassword = htmlentities(trim($_POST['oldPassword']));
  $newPassword = htmlentities(trim($_POST['newPassword']));
  $newPasswordRepeat = htmlentities(trim($_POST['newPasswordRepeat']));

  // Provjera da li su polja prazna
  if ($oldPassword == "" || $newPassword == "" || $newPasswordRepeat == "") {
    redirectWithToastError("warning", "Sva polja su obavezna!", "../../settings");
  }

  // Provjera formata lozinki
  if (!preg_match("/^[a-zA-Z0-9]{6,50}$/", $oldPassword) || !preg_match("/^[a-zA-Z0-9]{6,50}$/", $newPassword) || !preg_match("/^[a-zA-Z0-9]{6,50}$/", $newPasswordRepeat)) {
    redirectWithToastError("warning", "Lozinka može imati samo slova i brojke! Min. 6 i max. 50 znakova!", "../../settings");
  }

  // Provjera da li se lozinke podudaraju
  if ($newPassword != $newPasswordRepeat) {
    redirectWithToastError("warning", "Lozinke se ne podudaraju!", "../../settings");
  }

  // Dohvacanje korisnika
  $query = $conn->prepare("SELECT * FROM users WHERE user_id=? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $user = $query->get_result()->fetch_assoc();
  var_dump($user);
  if ($user && password_verify($oldPassword, $user['user_password'])) {
    $query = $conn->prepare("UPDATE users SET user_password=? WHERE user_id=?");
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $query->bind_param("si", $newPasswordHash, $userId);
    $query->execute();
    if ($query->affected_rows >= 1) {
      redirectWithToastSuccess("success", "Uspjeh.", "Lozinka izmjenjena.", "../../settings");
    } elseif ($query->affected_rows == 0) {
      redirectWithToastError("warning", "Lozinka nije izmjenjena.", "../../settings");
    } else {
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../settings");
    }
  } else {
    redirectWithToastError("warning", "Neispravna lozinka!", "../../settings");
  }
  
} else {
  header('Location: ../../');
}
