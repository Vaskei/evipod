<?php
session_start();
if (isset($_SESSION['user_id'])) header("Location: ./");
// ob_start();
require_once "./includes/connection.php";
require_once './includes/functions.php';

if (isset($_POST['loginSubmit'])) {
  $userEmail = trim($_POST['loginEmail']);
  $userPass = trim($_POST['loginPass']);

  // Provjera ispravnosti Email adrese
  if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Nepodržani format Email adrese!", "./membership");
  // Provjera ispravnosti tokena
  } else if (!preg_match("/^[a-zA-Z0-9]{6,50}$/", $userPass)) {
    redirectWithMsg("warning", "Lozinka može imati samo slova i brojke! Min. 6 i max. 50 znakova!", "./membership");
  } else {
    // Dohvacanje korisnika
    if ($query = $conn->prepare("SELECT * FROM users WHERE user_email=? LIMIT 1")) {
      $query->bind_param("s", $userEmail);
      if ($query->execute()) {
        $user = $query->get_result()->fetch_assoc();
        // Provjera da li je korisnicki racun aktiviran
        if ($user['isEmailConfirmed'] == 0 || $user['tokenConfirm'] != "") {
          redirectWithMsg("light", "Korisnički račun nije aktiviran. Provjerite svoj Email.", "./membership");
        } else {
          // Provjera da li korisnik postoji i podudaranje unesene lozinke
          if ($user && password_verify($userPass, $user['user_password'])) {
            //var_dump($user);
            $_SESSION['user_id'] = $user['user_id'];
            header("Location: ./");
            //var_dump($_SESSION);
          } else {
            redirectWithMsg("secondary", "Neispravno uneseni podaci. Pokušajte ponovno.", "./membership");
          }
        }
      } else {
        redirectWithMsg("warning", "Greška!", "./membership");
      }
    } else {
      redirectWithMsg("warning", "Greška!", "./membership");
    }

  }
} else {
  header("Location: ./membership");
  exit();
}
?>