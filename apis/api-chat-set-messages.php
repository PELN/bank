<?php

session_start();
$sUserId = $_SESSION['sUserId'];

$sUserId = $_POST['txt-user-id'];
$sMessage = $_POST['txt-message'];

//user skal sende til den der ikke er dig og omvendt
$sUserId = $sUserId == '30000000' ? '30111111' : '30000000';

file_put_contents( "../data/to-$sUserId.txt", $sMessage );