<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

if (isset($_POST['protectionAdd'])) {
  var_dump($_POST);
  exit();

} else {
  header('Location: ../../');
}
