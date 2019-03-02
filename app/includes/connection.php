<?php 

$conn = new mysqli("localhost", "root", "", "evipod");
if ($conn->connect_error) {
  echo '<div class="alert alert-danger">
        <strong>Nije se moguće spojiti na bazu podataka</strong></div>';
  exit();
}
$conn->set_charset("utf8mb4");

// $host = 'localhost';
// $db = 'evipod';
// $user = 'root';
// $pass = '';
// $charset = 'utf8mb4';

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// try {
//   $conn = new mysqli($host, $user, $pass, $db);
//   $conn->set_charset($charset);
// } catch (mysqli_sql_exception $e) {
//   throw new mysqli_sql_exception($e->getMessage(), $e->getCode());
// }

?>