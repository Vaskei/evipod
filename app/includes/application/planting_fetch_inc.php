<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../../../");
require_once '../connection.php';
require_once '../functions.php';

$userId = $_SESSION['user_id'];

if (isset($_POST['plantingId'])) {

  $editId = $_POST['plantingId'];

  if (filter_var($editId, FILTER_VALIDATE_INT) == false) {
    $response['status'] = 'error';
    echo json_encode($response);
    exit();
  }

  // Dohvacanje sjetve/sadnje
  $query = $conn->prepare("SELECT * FROM users WHERE user_id = ? LIMIT 1");
  $query->bind_param("i", $userId);
  $query->execute();
  $result = $query->get_result()->fetch_assoc();
  $currentBusinessId = $result['current_business_id'];
  if ($currentBusinessId != NULL) {
    $query = $conn->prepare("SELECT fields.field_name, fields.field_arkod, planting.* FROM planting INNER JOIN fields ON planting.field_id = fields.field_id WHERE planting.planting_id = ? AND fields.business_id = ? LIMIT 1");
    $query->bind_param("ii", $editId, $currentBusinessId);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows < 1) {
      $response['status'] = 'error';
      echo json_encode($response);
      exit();
    } else {
      $row = $result->fetch_assoc();
      // $row = array_map('html_entity_decode', $row);
      $response['status'] = 'success';
      $response['row'] = $row;
      echo json_encode($response);
    }
  } else {
    $response['status'] = 'error';
    echo json_encode($response);
    exit();
  }
} else {
  header('Location: ../../');
}
