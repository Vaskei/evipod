<?php
session_start();
require_once '../connection.php';
require_once '../functions.php';

if (!isset($_GET['email']) || !isset($_GET['token'])) {
  header("Location: ../../membership");
  exit();
} else {
  $email = trim($_GET['email']);
  $token = trim(htmlentities($_GET['token']));
  // Provjera ispravnosti Email adrese
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Nepodržani format Email adrese!", "../../membership");
    // Provjera ispravnosti tokena
  } else if (!preg_match("/^[a-zA-Z0-9]{20}$/", $token)) {
    redirectWithMsg("warning", "Nepodržan token!", "../../membership");
  } else {
    // Provjera da li se Email adresa i token poklapaju
    $query = $conn->prepare("SELECT * FROM users WHERE user_email=? AND token_confirm=? AND is_email_confirmed=?");
    $query->bind_param("ssi", $email, $token, $emailConfirmed = 0);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      $query = $conn->prepare("UPDATE users SET is_email_confirmed=?, token_confirm=? WHERE user_email=?");
      $query->bind_param("iss", $emailConfirmed = 1, $token = '', $email);
      $query->execute();
      if ($query->affected_rows >= 1) {
        redirectWithMsg("success", "Korisnički račun aktiviran.", "../../membership");
      } else {
        redirectWithMsg("warning", "Greška prilikom aktivacije računa!", "../../membership");
      }
    } else {
      redirectWithMsg("warning", "Podaci za aktivaciju se ne poklapaju ili je račun aktiviran!", "../../membership");
    }
  }
}
