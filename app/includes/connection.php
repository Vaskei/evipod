<?php 

$conn = new MySQLi("localhost", "root", "", "evipod");
if ($conn->connect_error) {
  echo '<div class="alert alert-danger">
        <strong>Nije se moguće spojiti na bazu podataka</strong></div>';
  exit();
}
$conn->set_charset("utf8mb4");

?>