<?php
session_start();
if (isset($_SESSION['user_id'])) header("Location: ../");
// ob_start();
require_once "../connection.php";
require_once '../functions.php';

if (isset($_POST['loginSubmit'])) {
  $userEmail = trim($_POST['loginEmail']);
  $userPass = trim($_POST['loginPass']);

  // Provjera ispravnosti Email adrese
  if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Neispravno uneseni podaci. Pokušajte ponovno.", "../../membership");
    // Provjera ispravnosti tokena
  } else if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,50}$/", $userPass)) {
    redirectWithMsg("warning", "Neispravno uneseni podaci. Pokušajte ponovno.", "../../membership");
  } else {
    // Dohvacanje korisnika
    $query = $conn->prepare("SELECT * FROM users WHERE user_email=? LIMIT 1");
    $query->bind_param("s", $userEmail);
    $query->execute();
    $user = $query->get_result()->fetch_assoc();
    // Provjera da li je korisnicki racun aktiviran
    if (!empty($user['user_email']) && $user['is_email_confirmed'] === 0 && $user['token_confirm'] != "") {
      redirectWithMsg("light", "Korisnički račun nije aktiviran. Provjerite svoj Email.", "../../membership");
    } elseif ($user['is_banned'] == 1) {  
      // Provjera da li je korisnicki racun blokiran
      redirectWithMsg("warning", "Korisnički račun je blokiran.", "../../membership");
    } else {
      // Provjera da li korisnik postoji i podudaranje unesene lozinke
      if ($user && password_verify($userPass, $user['user_password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];
        header("Location: ../../");
      } else {
        redirectWithMsg("secondary", "Neispravno uneseni podaci. Pokušajte ponovno.", "../../membership");
      }
    }
  }
} else {
  header("Location: ../../membership");
  exit();
}
