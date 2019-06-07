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

  if (filter_var($opgID, FILTER_VALIDATE_INT) === false) {
    $response_array['status'] = 'error';
    exit();
  } else {
    $response_array['status'] = 'success';
  }
  echo json_encode($response_array);

} else {
  header('Location: ../../');
}


?>