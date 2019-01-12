<?php
session_start();
//poništavanje svih varijabli
$_SESSION = array();
//uništavanje cookia
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 36000, '/');
}
//uništavanje sesije
session_destroy();

//redirekcija
header("Location: ../../");

?>