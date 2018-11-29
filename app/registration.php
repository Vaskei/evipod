<?php
session_start();
require_once './includes/connection.php';
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
    $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Sva polja su obavezna!</strong></div>';
    header("Location: ./membership");
    exit();
  } 
  // Provjera da li se lozinke poklapaju
  else if ($userPass != $userPassConfirm) {
    $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Lozinke se ne podudaraju!</strong></div>';
    header("Location: ./membership");
    exit();
  } 
  // Provjera da li se Email adresa valjana
  else if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) === false) {
    $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Nepodržani format Email adrese!</strong></div>';
    header("Location: ./membership");
    exit();
  } 
  // Provjera da li je ime korisnika u zadanim granicama
  else if (strlen($userName) < 3 || strlen($userName) > 100) {
    $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Ime može imati min. 3 i max. 100 znakova!</strong></div>';
    header("Location: ./membership");
    exit();
  } 
  // Provjera da li korisnicka zaporka ima nedozvoljene znakove
  else if (!preg_match("/^[a-zA-Z0-9]{6,50}$/", $userPass)) {
    $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Lozinka može imati samo slova i brojke! Min. 6 i max. 50 znakova!</strong></div>';
    header("Location: ./membership");
    exit();
  } else {
    // Provjera da li postoji korisnik sa unsesenom Email adresom
    $query = $conn->prepare("SELECT * FROM users WHERE user_email=? LIMIT 1");
    $query->bind_param("s", $userEmail);
    if ($query->execute()) {
      $result = $query->get_result();
      if ($result->num_rows > 0) {
        $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Email već postoji u bazi.</strong></div>';
        header("Location: ./membership");
        exit();
      } else {
        $token = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
        $token = substr(str_shuffle($token), 0, 20);
        // var_dump($token);
        $userPassHash = password_hash($userPass, PASSWORD_DEFAULT);
        // var_dump($userPassHash);

        require_once '../templates/techgmail.php';
        // var_dump($techusername);
        // var_dump($techpassword);
        // var_dump($techtoken);

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
        $mail->Subject = 'Evipod - Potvrda';
        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);
        $mail->Body = '
        Pozdrav ' . $userName . '.<br><br>
        Hvala što Ste izradili Evipod račun.<br>
        Za potvrdu korisničkog računa i korištenje aplikacije, pritisnite poveznicu ispod:<br><br>
        <a href="http://localhost/evipod/app/confirm.php?email=' . $userEmail . '&token=' . $token . '">Potvrdite Svoj Račun.</a>
        ';

        $query = $conn->prepare("INSERT INTO users(user_name, user_email, user_password, tokenConfirm) VALUES (?,?,?,?)");
        $query->bind_param("ssss", $userName, $userEmail, $userPass, $token);

        if ($mail->send() && $query->execute()) {
          $_SESSION['msg'] = '<div class="alert alert-info text-center"><strong>Korisnički račun kreiran. Provjerite svoj Email za daljnje upute.</strong></div>';
          header("Location: ./membership");
        } else {
          $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Nije bilo moguće kreirati korisnika!</strong></div>';
          header("Location: ./membership");
        }
      }
    } else {
      $_SESSION['msg'] = '<div class="alert alert-warning text-center alertFadeout"><strong>Greška!</strong></div>';
      header("Location: ./membership");
    }
  }
}
?>