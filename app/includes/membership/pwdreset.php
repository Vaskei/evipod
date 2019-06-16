<?php
session_start();
require_once '../connection.php';
require_once '../functions.php';

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['pwdResetSubmit'])) {
  $resetEmail = trim($_POST['pwdResetEmail']);

  // Provjera da li su polja prazna
  if ($resetEmail == "") {
    redirectWithMsg("warning", "Email je obavezan!", "../../passwordreset");
  }
  // Provjera da li se Email adresa valjana
  if (filter_var($resetEmail, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Nepodržani format Email adrese!", "../../passwordreset");
  }

  // Provjera da li Email postoji u tabeli korisnika
  $query = $conn->prepare("SELECT * FROM users WHERE user_email=?");
  $query->bind_param("s", $resetEmail);
  if ($query->execute()) {
    $result = $query->get_result();
    if ($result->num_rows === 0) {
      redirectWithMsg("warning", "Pogrešan Email! Pokušajte ponovno.", "../../passwordreset");
    }
  } else {
    redirectWithMsg("warning", "Greška!", "../../passwordreset");
  }


  // Ukoliko postoji uneseni Email u tabeli za resetiranje lozinke, brisemo isti (isteklo dozvoljeno vrijeme za resetiranje lozinke)
  $query = $conn->prepare("DELETE FROM pwd_reset WHERE pwd_email=?");
  $query->bind_param("s", $resetEmail);
  if ($query->execute()) {
    // Generiranje selektora, tokena, poveznicu i datum valjanosti
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = 'http://localhost/evipod/app/passwordresetconfirm.php?selector=' . $selector . '&token=' . bin2hex($token);

    // Vrijeme valjansoti = trenutno vrijeme + 900 sek
    $expiration = date('U') + 900;
    // var_dump(date('d.m.Y H:i:s', $expiration));

    // Podaci za spajanje na Gmail korisnicki racun
    require_once '../../../templates/techgmail.php';

    // Inicijalizacija PHPMailer klase i kreiranje email-a
    $mail = new PHPMailer;
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = $techusername;
    $mail->Password = $techpassword;

    $email = $techusername;

    $mail->setFrom($email, 'Evipod');
    $mail->addAddress($resetEmail);
    $mail->Subject = 'Evipod - Zaboravljena lozinka';
    $mail->CharSet = 'utf-8';
    $mail->isHTML(true);
    $mail->Body = '
        Poštovani, <br><br>
        Zatražili Ste resetiranje lozinke za pristup Evipod aplikaciji.<br>
        Za resetiranje lozinke, pritisnite poveznicu ispod (valjanost poveznice je 15min):<br><br>
        <a href="' . $url . '">Resetiranje lozinke.</a>';

    // Upis podataka u pwd_reset tabelu i slanje Emaila
    $query = $conn->prepare("INSERT INTO pwd_reset(pwd_email, pwd_selector, pwd_token, pwd_expiration) VALUES (?,?,?,?)");
    $hashedToken = password_hash($token, PASSWORD_DEFAULT);
    $query->bind_param("ssss", $resetEmail, $selector, $hashedToken, $expiration);
    if ($mail->send() && $query->execute()) {
      $query->close();
      redirectWithMsgNoFadeout("info", "Provjerite svoj Email za daljnje upute.", "../../membership");
    } else {
      redirectWithMsg("warning", "Greška!", "../../passwordreset");
    }
  } else {
    redirectWithMsg("warning", "Greška!", "../../passwordreset");
  }
} else {
  header("Location: ../../passwordreset");
  exit();
}
