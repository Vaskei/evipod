<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
if ($_SESSION['user_role'] != 'admin') header("Location: ../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['landingPageEdit'])) {
  var_dump($_POST);
  var_dump($_SESSION);

  $sectionOneTitle = htmlentities(trim($_POST['sectionOneTitle']));
  $sectionOneDesc = htmlentities(trim($_POST['sectionOneDesc']));
  $sectionTwoTitle = htmlentities(trim($_POST['sectionTwoTitle']));
  $sectionTwoDesc = htmlentities(trim($_POST['sectionTwoDesc']));
  $sectionTwoIconA = htmlentities(trim($_POST['sectionTwoIconA']));
  $sectionTwoTitleA = htmlentities(trim($_POST['sectionTwoTitleA']));
  $sectionTwoDescA = htmlentities(trim($_POST['sectionTwoDescA']));
  $sectionTwoIconB = htmlentities(trim($_POST['sectionTwoIconB']));
  $sectionTwoTitleB = htmlentities(trim($_POST['sectionTwoTitleB']));
  $sectionTwoDescB = htmlentities(trim($_POST['sectionTwoDescB']));
  $sectionTwoIconC = htmlentities(trim($_POST['sectionTwoIconC']));
  $sectionTwoTitleC = htmlentities(trim($_POST['sectionTwoTitleC']));
  $sectionTwoDescC = htmlentities(trim($_POST['sectionTwoDescC']));
  $sectionTwoIconD = htmlentities(trim($_POST['sectionTwoIconD']));
  $sectionTwoTitleD = htmlentities(trim($_POST['sectionTwoTitleD']));
  $sectionTwoDescD = htmlentities(trim($_POST['sectionTwoDescD']));
  $sectionThreeName = htmlentities(trim($_POST['sectionThreeName']));
  $sectionThreeAddress = htmlentities(trim($_POST['sectionThreeAddress']));
  $sectionThreePost = htmlentities(trim($_POST['sectionThreePost']));
  $sectionThreeWebsite = htmlentities(trim($_POST['sectionThreeWebsite']));
  $sectionThreeEmail = htmlentities(trim($_POST['sectionThreeEmail']));
  $sectionThreeTel = htmlentities(trim($_POST['sectionThreeTel']));
  $sectionThreeMob = htmlentities(trim($_POST['sectionThreeMob']));
  $landingPageEdit = htmlentities(trim($_POST['landingPageEdit']));

  // $requiredFields2 = [trim($_POST['sectionOneTitle']), trim($_POST['sectionOneDesc']), trim($_POST['sectionTwoTitle']), trim($_POST['sectionTwoDesc']),
  // trim($_POST['sectionTwoIconA']), trim($_POST['sectionTwoTitleA']), trim($_POST['sectionTwoDescA']), trim($_POST['sectionTwoIconB']), trim($_POST['sectionTwoTitleB']),
  // trim($_POST['sectionTwoDescB']), trim($_POST['sectionTwoIconC']), trim($_POST['sectionTwoTitleC']), trim($_POST['sectionTwoDescC']), trim($_POST['sectionTwoIconD']),
  // trim($_POST['sectionTwoTitleD']), trim($_POST['sectionTwoDescD']), trim($_POST['sectionThreeName']), trim($_POST['sectionThreeAddress']), trim($_POST['sectionThreePost']),
  // trim($_POST['sectionThreeWebsite']), trim($_POST['sectionThreeEmail']), trim($_POST['sectionThreeTel']), trim($_POST['sectionThreeMob'])];

  $requiredFields = array_values($_POST); // Pretvorba associative array u indexed array
  $requiredFields = array_map('trim', $requiredFields); // trim() funkcija na svim vrijednostima array-a

  $requiredLength = [20,200,20,200,30,20,100,30,20,100,30,20,100,30,20,100,30,100,30,50,50,50,50,4];  // dozvoljene velicine unesenih polja
  
  // Provjera praznih vrijednosti
  foreach ($requiredFields as $field) {
    if ($field == "") {
      redirectWithToastError("warning", "Sva polja su obavezna!", "../../admin");
    }
  }

  // Provjera formata svih vrijednosti
  foreach ($requiredFields as $key => $value) {
    var_dump($value);
    if (strlen($value) > $requiredLength[$key]) {
      redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../admin");
    }
  }

} else {
  header('Location: ../../');
}
