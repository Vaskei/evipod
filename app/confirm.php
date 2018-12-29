<?php
session_start();
require_once './includes/connection.php';
require_once './includes/functions.php';

if (!isset($_GET['email']) || !isset($_GET['token'])) {
  header("Location: ./membership");
  exit();
} else {
  $email = trim($_GET['email']);
  $token = trim(htmlentities($_GET['token']));
  // Provjera ispravnosti Email adrese
  if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Nepodržani format Email adrese!", "./membership");
  // Provjera ispravnosti tokena
  } else if (!preg_match("/^[a-zA-Z0-9]{20}$/", $token)) {
    redirectWithMsg("warning", "Nepodržan token!", "./membership");
  } else {
    // Provjera da li se Email adresa i token poklapaju
    if ($query = $conn->prepare("SELECT * FROM users WHERE user_email=? AND tokenConfirm=? AND isEmailConfirmed=?")) {
      $query->bind_param("ssi", $email, $token, $emailConfirmed = 0);
      if ($query->execute()) {
        $result = $query->get_result();
        if ($result->num_rows > 0) {
          $query = $conn->prepare("UPDATE users SET isEmailConfirmed=?, tokenConfirm=? WHERE user_email=?");
          $query->bind_param("iss", $emailConfirmed = 1, $token = '', $email);
          if ($query->execute()) {
            redirectWithMsg("success", "Korisnički račun aktiviran.", "./membership");
          } else {
            redirectWithMsg("warning", "Greška prilikom aktivacije računa!", "./membership");
          }
        } else {
          redirectWithMsg("warning", "Podaci za aktivaciju se ne poklapaju!", "./membership");
        }
      } else {
        redirectWithMsg("warning", "Greška prilikom čitanja baze!", "./membership");
      }
    } else {
      redirectWithMsg("warning", "Greška!", "./membership");
    }
  }
}
?>