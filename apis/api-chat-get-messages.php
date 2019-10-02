<?php
  session_start();
  $sUserId = $_SESSION['sUserId'];

$sMessages = file_get_contents("../data/to-$sUserId.txt");
file_put_contents("../data/to-$sUserId.txt", '');

echo $sMessages;