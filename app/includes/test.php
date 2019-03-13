<?php

session_start();
require_once './functions.php';
sleep(2);
redirectWithMsg("info", "Back from TEST.PHP", "../membership");

?>