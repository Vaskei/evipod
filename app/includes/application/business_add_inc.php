<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['businessAdd'])) {
  // var_dump($_POST);
  $userID = intval($_SESSION['user_id']);
  $businessName = trim(htmlentities($_POST['businessName']));
  $businessOwner = trim(htmlentities($_POST['businessOwner']));
  $businessOIB = trim(htmlentities($_POST['businessOIB']));
  $businessMIBPG = trim(htmlentities($_POST['businessMIBPG']));
  $businessCounty = trim(htmlentities($_POST['businessCounty']));
  $businessLocation = trim(htmlentities($_POST['businessLocation']));
  $businessPost = trim(htmlentities($_POST['businessPost']));
  $businessAddress = trim(htmlentities($_POST['businessAddress']));
  $businessEmail = trim(htmlentities($_POST['businessEmail']));
  $businessTel = trim(htmlentities($_POST['businessTel']));
  $businessMob = trim(htmlentities($_POST['businessMob']));
  $businessAdd = trim(htmlentities($_POST['businessAdd']));

  // var_dump($businessOIB);
  // var_dump($businessMIBPG);

  // Provjera da li je ime gospodarstva prazno
  if ($businessName == "") {
    redirectWithToastError("warning", "Naziv subjekta je obavezan!", "../../business");
  }

  // Provjera OIB formata ukoliko je upisan
  if ($businessOIB != "" && !preg_match('/^[0-9]{11}$/', $businessOIB)) {
    redirectWithToastError("warning", "Neispravan format OIB-a!", "../../business");
  }

  // Provjera MIBPG formata ukoliko je upisan
  if ($businessMIBPG != "" && !preg_match('/^[0-9]{1,7}$/', $businessMIBPG)) {
    redirectWithToastError("warning", "Neispravan format MIBPG-a!", "../../business");
  }

  // Provjera poštanskog broja ukoliko je unesen
  if ($businessPost != "" && !preg_match('/^[0-9]{5}$/', $businessPost)) {
    redirectWithToastError("warning", "Neispravan format poštanskog broja!", "../../business");
  }

  // Upis gospodarstva u bazu podataka
  if ($query = $conn->prepare("INSERT INTO business(business_name, user_id, business_owner, business_oib, business_mibpg, business_county, business_location, business_post, business_address, business_email, business_tel, business_mob) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)")) {
    $query->bind_param("sissssssssss", $businessName, $userID, $businessOwner, $businessOIB, $businessMIBPG, $businessCounty, $businessLocation, $businessPost, $businessAddress, $businessEmail, $businessTel, $businessMob);
    if ($query->execute()) {
      // Dohvacanje zadnje dodanog gospodarstva, te upisivanje ID gospodarstva u sessiju i kao zadnje koristeno gospodarstvo u users tabelu
      if ($query = $conn->prepare("SELECT * FROM business WHERE user_id = ? ORDER BY business_id DESC LIMIT 1")) {
        $query->bind_param("i", $userID);
        $query->execute();
        $row = $query->get_result()->fetch_assoc();
        // var_dump($row);
        $_SESSION['last_business_id'] = $row['business_id'];
        $query = $conn->prepare("UPDATE users SET last_business_id = ? WHERE user_id = ?");
        $query->bind_param("ii", $_SESSION['last_business_id'], $userID);
        $query->execute();
      }         
      redirectWithToastSuccess("success", "Uspjeh.", "Gospodarstvo dodano.", "../../business");
    } else {
      redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../business");
    }    
  } else {
    redirectWithToastError("warning", "Greška!", "../../business");
  }
} else {
  header('Location: ../../');
}
?>