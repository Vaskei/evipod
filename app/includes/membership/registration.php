<?php
session_start();
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['registrationSubmit'])) {

  $userName = trim($_POST['registrationName']);
  $userPass = trim($_POST['registrationPass']);
  $userPassConfirm = trim($_POST['registrationPassConfirm']);

  // Provjera da li su polja prazna
  if ($userName == "" || $userPass == "" || $userPassConfirm == "") {
    redirectWithMsg("warning", "Sva polja su obavezna!", "../../membership");
  }
  // Provjera da li se lozinke poklapaju
  else if ($userPass != $userPassConfirm) {
    redirectWithMsg("warning", "Lozinke se ne podudaraju!", "../../membership");
  }
  // Provjera da li je ime korisnika u zadanim granicama
  else if (strlen($userName) < 3 || strlen($userName) > 20) {
    redirectWithMsg("warning", "Ime može imati min. 3 i max. 20 znakova!", "../../membership");
  }
  // Provjera da li korisnicka zaporka ima nedozvoljene znakove
  else if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{6,50}$/", $userPass)) {
    redirectWithMsg("warning", "Lozinka može imati samo slova i brojke! Min. 6 i max. 50 znakova!", "../../membership");
  } else {
    // Provjera da li postoji korisnik sa unesenim imenom
    $query = $conn->prepare("SELECT * FROM users WHERE user_name=? LIMIT 1");
    $query->bind_param("s", $userName);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows > 0) {
      redirectWithMsg("warning", "Ime već postoji u bazi.", "../../membership");
    } else {
      // Password hash
      $userPassHash = password_hash($userPass, PASSWORD_DEFAULT);

      $query = $conn->prepare("INSERT INTO users(user_name, user_password) VALUES (?,?)");
      $query->bind_param("ss", $userName, $userPassHash);
      $query->execute();
      if ($query->affected_rows >= 1) {
        $query->close();
        redirectWithMsgNoFadeout("info", "Korisnički račun kreiran.", "../../membership");
      } else {
        redirectWithMsg("warning", "Nije bilo moguće kreirati korisnika!", "../../membership");
      }
    }
  }
} else {
  header("Location: ../../membership");
  exit();
}
