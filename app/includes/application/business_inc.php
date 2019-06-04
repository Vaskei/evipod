<?php

/*

business_id	
business_name	
user_id	
business_owner	
business_oib	
business_mibpg	
business_county	
business_location	
business_post	
business_address	
business_email	
business_tel	
business_mob

*/
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['businessAdd'])) {
  var_dump($_POST);
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

  if ($businessName == "") {
    redirectWithToast("warning", "Naziv subjekta je obavezan!", "../../business");
  }
} else {
  header('Location: ../../');
}
?>