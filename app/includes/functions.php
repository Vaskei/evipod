<?php
/**
 * Funkcija za definiranje poruke i njezinog Bootstrap tipa (success, danger, warning, info...), te preusmjeravanje korisnika.
 */
function redirectWithMsg(string $type, string $message, string $location){
  $_SESSION['msg'] = "<div class='alert alert-{$type} text-center alertFadeout'><strong>{$message}</strong></div>";
  header("Location: {$location}");
  exit();
}

/**
 * Funkcija za definiranje poruke i njezinog Bootstrap tipa (success, danger, warning, info...), te preusmjeravanje korisnika. Bez Fadeout effekta, sa gumbicem za zatvaranje.
 */
function redirectWithMsgNoFadeout(string $type, string $message, string $location)
{
  $_SESSION['msg'] = "<div class='alert alert-{$type} text-center alert-dismissible fade show'><strong>{$message}</strong><button type='button' class='close' data-dismiss='alert'><span>&times;</span></button></div>";
  header("Location: {$location}");
  exit();
}
?>