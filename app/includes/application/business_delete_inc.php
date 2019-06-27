<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['businessDelete'])) {
  var_dump($_POST);
  $userID = intval($_SESSION['user_id']);
  $businessId = $_POST['businessDelete'];
} else {
  header('Location: ../../');
}



?>