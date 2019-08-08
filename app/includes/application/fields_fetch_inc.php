<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

$userId = $_SESSION['user_id'];

if (isset($_POST['fieldsId'])) {

  $editId = $_POST['fieldsId'];

  if (filter_var($editId, FILTER_VALIDATE_INT) == false) {
    $response['status'] = 'error';
    echo json_encode($response);
    exit();
  }

  // Dohvacanje gospodarstva
  $query = $conn->prepare("SELECT field_id, field_name FROM fields INNER JOIN business ON fields.business_id = business.business_id WHERE fields.field_id = ? AND business.user_id = ? LIMIT 1");
  $query->bind_param("ii", $editId, $userId);
  $query->execute();
  $result = $query->get_result();
  if ($result->num_rows < 1) {
    $response['status'] = 'error';
    echo json_encode($response);
    exit();
  } else {
    $row = $result->fetch_assoc();
    $row = array_map('html_entity_decode', $row);
    $response['status'] = 'success';
    $response['row'] = $row;
    echo json_encode($response);
  }
} else {
  header('Location: ../../');
}
