<?php

//get logged in user
session_start();

$sUserId = $_SESSION['sUserId'];

// get balance form user
$sData = file_get_contents('../data/clients.json');
// once data is fetched, convert to obj
$jData = json_decode($sData);
//its a complex file with innerData
$jInnerData = $jData->data;

//get the the email of the user
echo $jInnerData->$sUserId->email;


