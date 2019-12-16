<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
if ($_SESSION['user_role'] != 'admin') header("Location: ../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['landingPageEdit'])) {
  // var_dump($_POST);
  // var_dump($_SESSION);

  $sectionOneTitle = trim($_POST['sectionOneTitle']);
  $sectionOneDesc = trim($_POST['sectionOneDesc']);
  $sectionTwoTitle = trim($_POST['sectionTwoTitle']);
  $sectionTwoDesc = trim($_POST['sectionTwoDesc']);
  $sectionTwoIconA = trim($_POST['sectionTwoIconA']);
  $sectionTwoTitleA = trim($_POST['sectionTwoTitleA']);
  $sectionTwoDescA = trim($_POST['sectionTwoDescA']);
  $sectionTwoIconB = trim($_POST['sectionTwoIconB']);
  $sectionTwoTitleB = trim($_POST['sectionTwoTitleB']);
  $sectionTwoDescB = trim($_POST['sectionTwoDescB']);
  $sectionTwoIconC = trim($_POST['sectionTwoIconC']);
  $sectionTwoTitleC = trim($_POST['sectionTwoTitleC']);
  $sectionTwoDescC = trim($_POST['sectionTwoDescC']);
  $sectionTwoIconD = trim($_POST['sectionTwoIconD']);
  $sectionTwoTitleD = trim($_POST['sectionTwoTitleD']);
  $sectionTwoDescD = trim($_POST['sectionTwoDescD']);
  $sectionThreeName = trim($_POST['sectionThreeName']);
  $sectionThreeAddress = trim($_POST['sectionThreeAddress']);
  $sectionThreePost = trim($_POST['sectionThreePost']);
  $sectionThreeWebsite = trim($_POST['sectionThreeWebsite']);
  $sectionThreeEmail = trim($_POST['sectionThreeEmail']);
  $sectionThreeTel = trim($_POST['sectionThreeTel']);
  $sectionThreeMob = trim($_POST['sectionThreeMob']);

  // $requiredFields2 = [trim($_POST['sectionOneTitle']), trim($_POST['sectionOneDesc']), trim($_POST['sectionTwoTitle']), trim($_POST['sectionTwoDesc']),
  // trim($_POST['sectionTwoIconA']), trim($_POST['sectionTwoTitleA']), trim($_POST['sectionTwoDescA']), trim($_POST['sectionTwoIconB']), trim($_POST['sectionTwoTitleB']),
  // trim($_POST['sectionTwoDescB']), trim($_POST['sectionTwoIconC']), trim($_POST['sectionTwoTitleC']), trim($_POST['sectionTwoDescC']), trim($_POST['sectionTwoIconD']),
  // trim($_POST['sectionTwoTitleD']), trim($_POST['sectionTwoDescD']), trim($_POST['sectionThreeName']), trim($_POST['sectionThreeAddress']), trim($_POST['sectionThreePost']),
  // trim($_POST['sectionThreeWebsite']), trim($_POST['sectionThreeEmail']), trim($_POST['sectionThreeTel']), trim($_POST['sectionThreeMob'])];

  $requiredFields = array_values($_POST); // Pretvorba associative array u indexed array
  $requiredFields = array_map('trim', $requiredFields); // trim() funkcija na svim vrijednostima array-a

  $requiredLength = [20, 200, 20, 200, 30, 20, 100, 30, 20, 100, 30, 20, 100, 30, 20, 100, 50, 100, 30, 50, 50, 50, 50, 4];  // dozvoljene velicine unesenih polja

  // Provjera praznih vrijednosti
  foreach ($requiredFields as $field) {
    if ($field == "") {
      redirectWithToastError("warning", "Sva polja su obavezna!", "../../admin");
    }
  }

  // Provjera formata svih vrijednosti
  foreach ($requiredFields as $key => $value) {
    if (mb_strlen($value) > $requiredLength[$key]) {
      redirectWithToastError("warning", "Unesen neispravan format podatka!", "../../admin");
    }
  }

  // Dohvacanje podataka odredisne stranice
  $result = $conn->query("SELECT * FROM landing_page");
  if ($result->num_rows < 1) {
    $query = $conn->prepare("INSERT INTO landing_page(section_1_title, section_1_desc, section_2_title, section_2_desc, section_2_icon_1, section_2_title_1, section_2_desc_1, section_2_icon_2, section_2_title_2, section_2_desc_2, section_2_icon_3, section_2_title_3, section_2_desc_3, 
      section_2_icon_4, section_2_title_4, section_2_desc_4, section_3_name, section_3_address, section_3_post, section_3_website, section_3_email, section_3_tel, section_3_mob) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $query->bind_param(
      "sssssssssssssssssssssss",
      $sectionOneTitle,
      $sectionOneDesc,
      $sectionTwoTitle,
      $sectionTwoDesc,
      $sectionTwoIconA,
      $sectionTwoTitleA,
      $sectionTwoDescA,
      $sectionTwoIconB,
      $sectionTwoTitleB,
      $sectionTwoDescB,
      $sectionTwoIconC,
      $sectionTwoTitleC,
      $sectionTwoDescC,
      $sectionTwoIconD,
      $sectionTwoTitleD,
      $sectionTwoDescD,
      $sectionThreeName,
      $sectionThreeAddress,
      $sectionThreePost,
      $sectionThreeWebsite,
      $sectionThreeEmail,
      $sectionThreeTel,
      $sectionThreeMob
    );
    $query->execute();
    if ($query->affected_rows > 0) {
      redirectWithToastSuccess("success", "Uspjeh.", "Odredišna stranica ažurirana.", "../../admin");
    } else {
      redirectWithToastError("warning", "Odredišna stranica nije ažurirana.", "../../admin");
    }
  } elseif ($result->num_rows > 0) {
    $rowId = 1;
    $query = $conn->prepare("UPDATE landing_page SET section_1_title=?, section_1_desc=?, section_2_title=?, section_2_desc=?, section_2_icon_1=?, section_2_title_1=?, section_2_desc_1=?, section_2_icon_2=?, section_2_title_2=?, section_2_desc_2=?, section_2_icon_3=?, section_2_title_3=?, section_2_desc_3=?, 
    section_2_icon_4=?, section_2_title_4=?, section_2_desc_4=?, section_3_name=?, section_3_address=?, section_3_post=?, section_3_website=?, section_3_email=?, section_3_tel=?, section_3_mob=? WHERE id=?");
    $query->bind_param(
      "sssssssssssssssssssssssi",
      $sectionOneTitle,
      $sectionOneDesc,
      $sectionTwoTitle,
      $sectionTwoDesc,
      $sectionTwoIconA,
      $sectionTwoTitleA,
      $sectionTwoDescA,
      $sectionTwoIconB,
      $sectionTwoTitleB,
      $sectionTwoDescB,
      $sectionTwoIconC,
      $sectionTwoTitleC,
      $sectionTwoDescC,
      $sectionTwoIconD,
      $sectionTwoTitleD,
      $sectionTwoDescD,
      $sectionThreeName,
      $sectionThreeAddress,
      $sectionThreePost,
      $sectionThreeWebsite,
      $sectionThreeEmail,
      $sectionThreeTel,
      $sectionThreeMob,
      $rowId
    );
    $query->execute();
    if ($query->affected_rows > 0) {
      redirectWithToastSuccess("success", "Uspjeh.", "Odredišna stranica ažurirana.", "../../admin");
    } else {
      redirectWithToastError("warning", "Odredišna stranica nije ažurirana.", "../../admin");
    }
  } else {
    redirectWithToastError("warning", "Greška. Pokušajte ponovno.", "../../admin");
  }
} else {
  header('Location: ../../');
}
