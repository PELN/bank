<?php

$sPhone = $_GET['phone'];
$sActivationKey = $_GET['activation-key'];
//VALIDATE THE ELEMENTS

$sUser = file_get_contents('data/clients.json');
$jUser = json_decode($sUser);
//check if the conversion is well done
$jInnerData = $jUser->data;


//if there is no activation key
if( $jInnerData->$sPhone != $sPhone && $sActivationKey != $jInnerData->$sPhone->activationKey){
    echo 'cannot activate';
    exit;
}

//flip from 0 to one
$jInnerData->$sPhone->active = 1;

$sData = json_encode($jUser, JSON_PRETTY_PRINT);
file_put_contents('data/clients.json', $sData);
header('Location: index#activation');

// echo 'User activated, <a href="../login">click here to login</a>';