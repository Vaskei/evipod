<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['businessEdit'])) {
  var_dump($_POST);
  $userID = intval($_SESSION['user_id']);
  $businessId = $_POST['businessEdit'];
  $businessName = htmlentities(trim($_POST['businessNameEdit']));
  $businessOwner = htmlentities(trim($_POST['businessOwnerEdit']));
  $businessOIB = htmlentities(trim($_POST['businessOIBEdit']));
  $businessMIBPG = htmlentities(trim($_POST['businessMIBPGEdit']));
  $businessCounty = htmlentities(trim($_POST['businessCountyEdit']));
  $businessLocation = htmlentities(trim($_POST['businessLocationEdit']));
  $businessPost = htmlentities(trim($_POST['businessPostEdit']));
  $businessAddress = htmlentities(trim($_POST['businessAddressEdit']));
  $businessEmail = htmlentities(trim($_POST['businessEmailEdit']));
  $businessTel = htmlentities(trim($_POST['businessTelEdit']));
  $businessMob = htmlentities(trim($_POST['businessMobEdit']));

  // Provjera ispravnosti ID gospodarstva
  if (filter_var($businessId, FILTER_VALIDATE_INT) == false) {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../business");
  }

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

  // Azuriranje gospodarstva
  // $query = $conn->prepare("INSERT INTO business(business_name, user_id, business_owner, business_oib, business_mibpg, business_county, business_location, business_post, business_address, business_email, business_tel, business_mob) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
  $query = $conn->prepare("UPDATE business SET business_name=?, business_owner=?, business_oib=?, business_mibpg=?, business_county=?, business_location=?, business_post=?, business_address=?, business_email=?, business_tel=?, business_mob=? WHERE business_id=? AND user_id=?");
  $query->bind_param("sssssssssssii", $businessName, $businessOwner, $businessOIB, $businessMIBPG, $businessCounty, $businessLocation, $businessPost, $businessAddress, $businessEmail, $businessTel, $businessMob, $businessId, $userID);
  if ($query->execute()) {
    redirectWithToastSuccess("success", "Uspjeh.", "Gospodarstvo ažurirano.", "../../business");
  } else {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../business");
  }
} else {
  header('Location: ../../');
}
