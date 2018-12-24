<?php
/**
 * Funkcija za definiranje poruke i njezinog Bootstrap tipa (success, danger, warning, info...), te preusmjeravanje korisnika.
 */
function redirectWithMsg(string $type, string $message, string $location){
  $_SESSION['msg'] = "<div class='alert alert-{$type} text-center alertFadeout'><strong>{$message}</strong></div>";
  header("Location: {$location}");
  exit();
}
?>