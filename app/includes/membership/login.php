<?php
session_start();
if (isset($_SESSION['user_id'])) header("Location: ../");
// ob_start();
require_once "../connection.php";
require_once '../functions.php';

if (isset($_POST['loginSubmit'])) {
  $userName = trim($_POST['loginName']);
  $userPass = trim($_POST['loginPass']);

  // Dohvacanje korisnika
  $query = $conn->prepare("SELECT * FROM users WHERE user_name=? LIMIT 1");
  $query->bind_param("s", $userName);
  $query->execute();
  $result = $query->get_result();
  $user = $result->fetch_assoc();
  // Provjera da li korisnik postoji
  if ($result->num_rows < 1) {
    redirectWithMsg("warning", "Korisnik ne postoji.", "../../membership");
  } elseif ($user['is_banned'] == 1) {
    // Provjera da li je korisnicki racun blokiran
    redirectWithMsg("warning", "Korisnički račun je blokiran.", "../../membership");
  } else {
    // Provjera podudaranja unesene lozinke
    if ($user && password_verify($userPass, $user['user_password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['user_role'] = $user['user_role'];
      header("Location: ../../");
    } else {
      redirectWithMsg("secondary", "Neispravno uneseni podaci. Pokušajte ponovno.", "../../membership");
    }
  }
} else {
  header("Location: ../../membership");
  exit();
}
