<?php
session_start();
require_once './includes/connection.php';
require_once './includes/functions.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;

use League\OAuth2\Client\Provider\Google;

require './includes/PHPMailer/Exception.php';
require './includes/PHPMailer/PHPMailer.php';
require './includes/PHPMailer/OAuth.php';
require './includes/PHPMailer/SMTP.php';

/* 
userName = min 3 znakova, max 100 znakova
userEmail = filter_var
userPass = min 6 znakova, max 50 znakova, slova i brojke

 */

if (isset($_POST['registrationSubmit'])) {
  // var_dump($_POST);
  $userName = htmlentities(trim($_POST['registrationName']));
  $userEmail = trim($_POST['registrationEmail']);
  $userPass = trim($_POST['registrationPass']);
  $userPassConfirm = trim($_POST['registrationPassConfirm']);

  // Provjera da li su polja prazna
  if ($userName == "" || $userEmail == "" || $userPass == "" || $userPassConfirm == "") {
    redirectWithMsg("warning", "Sva polja su obavezna!", "./membership");
  } 
  // Provjera da li se lozinke poklapaju
  else if ($userPass != $userPassConfirm) {
    redirectWithMsg("warning", "Lozinke se ne podudaraju!", "./membership");
  } 
  // Provjera da li se Email adresa valjana
  else if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Nepodržani format Email adrese!", "./membership");
  } 
  // Provjera da li je ime korisnika u zadanim granicama
  else if (strlen($userName) < 3 || strlen($userName) > 100) {
    redirectWithMsg("warning", "Ime može imati min. 3 i max. 100 znakova!", "./membership");
  } 
  // Provjera da li korisnicka zaporka ima nedozvoljene znakove
  else if (!preg_match("/^[a-zA-Z0-9]{6,50}$/", $userPass)) {
    redirectWithMsg("warning", "Lozinka može imati samo slova i brojke! Min. 6 i max. 50 znakova!", "./membership");
  } else {
    // Provjera da li postoji korisnik sa unesenom Email adresom
    if ($query = $conn->prepare("SELECT * FROM users WHERE user_email=? LIMIT 1")) {
      $query->bind_param("s", $userEmail);
      if ($query->execute()) {
        $result = $query->get_result();
        if ($result->num_rows > 0) {
          redirectWithMsg("warning", "Email već postoji u bazi.", "./membership");
        } else {
          // Generiranje tokena
          $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
          $token = substr(str_shuffle($token), 0, 20);
          //var_dump($token);

          // Password hash
          $userPassHash = password_hash($userPass, PASSWORD_DEFAULT);
          //var_dump($userPassHash);

          // Podaci za spajanje na Gmail korisnicki racun
          require_once '../templates/techgmail.php';
          //var_dump($techusername);
          //var_dump($techpassword);
          //var_dump($techtoken);

          // Inicijalizacija PHPMailer klase i kreiranje email-a
          date_default_timezone_set('Etc/UTC');
          require '../vendor/autoload.php';
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
          $mail->AuthType = 'XOAUTH2';
          $email = $techusername;
          $clientId = $techclientID;
          $clientSecret = $techclientSecret;
          $refreshToken = $techtoken;
          $provider = new Google(
            [
              'clientId' => $clientId,
              'clientSecret' => $clientSecret,
            ]
          );
          $mail->setOAuth(
            new OAuth(
              [
                'provider' => $provider,
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'refreshToken' => $refreshToken,
                'userName' => $email,
              ]
            )
          );
          $mail->setFrom($email, 'Evipod');
          $mail->addAddress($userEmail, $userName);
          $mail->Subject = 'Evipod - Aktivacija računa';
          $mail->CharSet = 'utf-8';
          $mail->isHTML(true);
          $mail->Body = '
            Pozdrav ' . $userName . '.<br><br>
            Hvala što Ste izradili Evipod račun.<br>
            Za aktiviranje korisničkog računa i korištenje aplikacije, pritisnite poveznicu ispod:<br><br>
            <a href="http://localhost/evipod/app/confirm.php?email=' . $userEmail . '&token=' . $token . '">Potvrdite Svoj Račun.</a>';

          // Zapisivanje korisnickog racuna u bazu i slanje email-a sa linkom za potvrdu racuna
          if ($query = $conn->prepare("INSERT INTO users(user_name, user_email, user_password, tokenConfirm) VALUES (?,?,?,?)")) {
            $query->bind_param("ssss", $userName, $userEmail, $userPassHash, $token);
            if ($mail->send() && $query->execute()) {
              redirectWithMsgNoFadeout("info", "Korisnički račun kreiran. Provjerite svoj Email za daljnje upute.", "./membership");
            } else {
              redirectWithMsg("warning", "Nije bilo moguće kreirati korisnika!", "./membership");
            }
          } else {
            redirectWithMsg("warning", "Greška!", "./membership");
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