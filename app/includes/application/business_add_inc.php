<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['businessAdd'])) {
  // var_dump($_POST);
  // exit();
  $userId = $_SESSION['user_id'];
  $businessName = htmlentities(trim($_POST['businessName']));
  $businessOwner = htmlentities(trim($_POST['businessOwner']));
  $businessOIB = htmlentities(trim($_POST['businessOIB']));
  $businessMIBPG = htmlentities(trim($_POST['businessMIBPG']));
  $businessCounty = htmlentities(trim($_POST['businessCounty']));
  $businessLocation = htmlentities(trim($_POST['businessLocation']));
  $businessPost = htmlentities(trim($_POST['businessPost']));
  $businessAddress = htmlentities(trim($_POST['businessAddress']));
  $businessEmail = htmlentities(trim($_POST['businessEmail']));
  $businessTel = htmlentities(trim($_POST['businessTel']));
  $businessMob = htmlentities(trim($_POST['businessMob']));

  // Provjera da li je ime gospodarstva prazno
  if ($businessName == "") {
    redirectWithToastError("warning", "Naziv subjekta je obavezan!", "../../business");
  }

  // Provjera maksimalne duzine pojedinih podataka
  if (
    strlen(trim($_POST['businessName'])) > 100 ||
    strlen(trim($_POST['businessOwner'])) > 100 ||
    strlen(trim($_POST['businessCounty'])) > 100 ||
    strlen(trim($_POST['businessLocation'])) > 100 ||
    strlen(trim($_POST['businessAddress'])) > 100 ||
    strlen(trim($_POST['businessEmail'])) > 100
  ) {
    redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../business");
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

  // Provjera Email adrese ukoliko je unesena
  if ($businessEmail != "" && filter_var($businessEmail, FILTER_VALIDATE_EMAIL) === false) {
    redirectWithMsg("warning", "Neispravan format Email adrese!", "../../business");
  }

  // Provjera broja telefona ukoliko je unesen
  if ($businessTel != "" && !preg_match('/^[0-9]{1,100}$/', $businessTel)) {
    redirectWithToastError("warning", "Neispravan format broja telefona!", "../../business");
  }

  // Provjera brojamobitela ukoliko je unesen
  if ($businessMob != "" && !preg_match('/^[0-9]{1,100}$/', $businessMob)) {
    redirectWithToastError("warning", "Neispravan format broja mobitela!", "../../business");
  }

  // Upis gospodarstva u bazu podataka
  $query = $conn->prepare("INSERT INTO business(business_name, user_id, business_owner, business_oib, business_mibpg, business_county, business_location, business_post, business_address, business_email, business_tel, business_mob) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
  $query->bind_param("sissssssssss", $businessName, $userId, $businessOwner, $businessOIB, $businessMIBPG, $businessCounty, $businessLocation, $businessPost, $businessAddress, $businessEmail, $businessTel, $businessMob);
  $query->execute();
  if ($query->affected_rows >= 1) {
    // Dohvacanje zadnje dodanog gospodarstva, te upisivanje zadnje koristeno gospodarstvo u users tabelu
    $query = $conn->prepare("SELECT * FROM business WHERE user_id = ? ORDER BY business_id DESC LIMIT 1");
    $query->bind_param("i", $userId);
    $query->execute();
    $row = $query->get_result()->fetch_assoc();
    // var_dump($row);
    $lastBusinessId = $row['business_id'];
    $hasBusiness = 1;
    $query = $conn->prepare("UPDATE users SET current_business_id = ? WHERE user_id = ?");
    $query->bind_param("ii", $lastBusinessId, $userId);
    $query->execute();
    redirectWithToastSuccess("success", "Uspjeh.", "Gospodarstvo dodano.", "../../business");
  } else {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../business");
  }
} else {
  header('Location: ../../');
}
