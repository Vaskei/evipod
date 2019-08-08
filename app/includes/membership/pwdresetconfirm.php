<?php
session_start();
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['pwdResetConfirmSubmit'])) {
  $selector = $_POST['pwdResetConfirmSelector'];
  $token = $_POST['pwdResetConfirmToken'];
  $pwdReset = trim($_POST['pwdResetConfirm']);
  $pwdResetRepeat = trim($_POST['pwdResetConfirmRepeat']);

  // Provjera selektora i tokena
  if (ctype_xdigit($selector) === false || ctype_xdigit($token) === false) {
    redirectWithMsg("warning", "Neispravni podaci!", "../../membership");
  }
  //Provjera lozinke
  if ($pwdReset == "" || $pwdResetRepeat == "") {
    redirectWithMsg("warning", "Sva polja su obavezna!", "../../membership");
  }
  if ($pwdReset != $pwdResetRepeat) {
    redirectWithMsg("warning", "Lozinke se ne podudaraju!", "../../membership");
  }
  if (!preg_match("/^[a-zA-Z0-9]{6,50}$/", $pwdReset)) {
    redirectWithMsg("warning", "Lozinka može imati samo slova i brojke! Min. 6 i max. 50 znakova!", "../../membership");
  }

  // Trenutno vrijeme
  $currentDate = date("U");

  // Provjera da li postoji redak u tabeli sa istim selektorom i ispravnom valjanoscu
  $query = $conn->prepare("SELECT * FROM pwd_reset WHERE pwd_selector=? AND pwd_expiration>=? LIMIT 1");
  $query->bind_param("ss", $selector, $currentDate);
  $query->execute();
  $result = $query->get_result();
  if ($result->num_rows === 0) {
    redirectWithMsg("warning", "Valjanost poveznice za resetiranje lozinke je istekla. Pokušajte ponovno.", "../../membership");
  } else {
    $row = $result->fetch_assoc();
    // Pretvaranje tokena u binarni format i provjera tocnosti sa tokenom iz baze
    $tokenBin = hex2bin($token);
    $tokenCheck = password_verify($tokenBin, $row['pwd_token']);
    if ($tokenCheck === false) {
      redirectWithMsg("warning", "Valjanost poveznice je neispravna. Pokušajte ponovno.", "../../membership");
    } else if ($tokenCheck === true) {
      $tokenEmail = $row['pwd_email'];
      // Citanje korisnika sa tabele users sa istim emailom kao u tabeli pwd_reset
      $query = $conn->prepare("SELECT * FROM users WHERE user_email=? LIMIT 1");
      $query->bind_param("s", $tokenEmail);
      $query->execute();
      $result = $query->get_result();
      // Provjera da li korisnik postoji u tabeli users
      if ($result->num_rows > 0) {
        // Izmjena lozinke
        $query = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $pwdResetHash = password_hash($pwdReset, PASSWORD_DEFAULT);
        $query->bind_param("ss", $pwdResetHash, $tokenEmail);
        $query->execute();
        if ($query->affected_rows >= 1) {
          // Brisanje retka za resetiranje lozinke u tabeli pwd_reset
          $query->prepare("DELETE FROM pwd_reset WHERE pwd_email=?");
          $query->bind_param("s", $tokenEmail);
          $query->execute();
          $query->close();
          redirectWithMsgNoFadeout("success", "Lozinka izmijenjena.", "../../membership");
        } else {
          redirectWithMsg("warning", "Greška!", "../../membership");
        }
      } else {
        redirectWithMsg("warning", "Nepostojeći Email u bazi.", "../../membership");
      }
    }
  }
} else {
  header("Location: ../../membership");
  exit();
}
