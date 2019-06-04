<?php
/**
 * Funkcija za definiranje poruke i njezinog Bootstrap tipa (success, danger, warning, info...), te preusmjeravanje korisnika.
 */
function redirectWithMsg(string $type, string $message, string $location){
  $_SESSION['msg'] = "<div class='alert alert-{$type} text-center alertFadeout'>
                        <strong>{$message}</strong>
                          <div class='progress' id='customAlertBar'>
                            <div class='progress-bar bg-info' role='progressbar' style='width:100%' id='customBar'></div>
                          </div> 
                      </div>";
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

/**
 * Funkcija za definiranje toast poruke i njezinog tipa (success, danger, warning, info...), te preusmjeravanje korisnika.
 */
function redirectWithToast(string $type, string $message, string $location)
{
  $_SESSION['msg'] = "
  <div class='toast position-absolute' data-delay='3000'>
    <div class='toast-header'>
      <i class='fas fa-exclamation-circle fa-lg mr-2 text-{$type}'></i>
      <strong class='mr-auto text-{$type}'>Upozorenje</strong>
      <button type='button' class='close text-dark' data-dismiss='toast' aria-label='Close'>
        <span aria-hidden='true'><i class='fas fa-times fa-sm'></i></span>
      </button>
    </div>
    <div class='toast-body bg-white text-center'>
      {$message}
    </div>
  </div>  
  ";
  header("Location: {$location}");
  exit();
}
?>