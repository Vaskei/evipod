<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

$userID = $_SESSION['user_id'];

// var_dump($_POST);

if (isset($_POST['opgID'])) {
  // var_dump($_POST);
  $opgID = $_POST['opgID'];
  // var_dump($opgID);

  // Provjera da li je prosljedeni ID OPG-a krivog formata
  if (filter_var($opgID, FILTER_VALIDATE_INT) === false) {
    $response['status'] = 'error';
    toastNoRedirect("danger", "Greška kod promjene gospodarstva.");
    echo json_encode($response);
    exit();
  } else {
    // Provjera da li postoji korisnik sa OPG-om
    $query = $conn->prepare("SELECT * FROM business WHERE business_id = ? AND user_id = ? LIMIT 1");
    $query->bind_param("ii", $opgID, $userID);
    $query->execute();
    $result = $query->get_result();
    // var_dump($result);
    // Zaustavljanje skripte ukoliko nema valjanog rezultata
    if ($result->num_rows < 1) {
      $response['status'] = 'error';
      toastNoRedirect("danger", "Greška kod promjene gospodarstva.");
      echo json_encode($response);
      exit();
    } else {
      // Azuriranje users tabele i sesije
      $query = $conn->prepare("UPDATE users SET last_business_id = ? WHERE user_id = ?");
      $query->bind_param("ii", $opgID, $userID);
      if ($query->execute()) {
        $_SESSION['last_business_id'] = intval($opgID);
        $response['status'] = 'success';
        toastNoRedirect("success", "Gospodarstvo promijenjeno.");
        echo json_encode($response);
      } else {
        $response['status'] = 'error';
        toastNoRedirect("danger", "Greška kod promjene gospodarstva.");
        echo json_encode($response);
        exit();
      } 
    }
  }
} else {
  header('Location: ../../');
}
