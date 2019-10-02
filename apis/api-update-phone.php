<?php

// DOES NOT WORK PROPERLY

session_start();
//user from seession, hard coded
$sUserId = $_SESSION['sUserId'];

$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
if( $jUser == null ){ sendResponse(0, __LINE__, "json data could not be converted"); }
$jInnerData = $jUser->data;

$sOldPhone = $_POST['old-phone'] ?? '';
if( empty($sOldPhone) ){ sendResponse(0, __LINE__, "this field cant be empty"); }
if( strlen($sOldPhone) != 8 ){ sendResponse(0, __LINE__,"must be at least 8 characters"); }
if( intval($sOldPhone) < 10000000 ){ sendResponse(0, __LINE__, "no decimals"); }
if( intval($sOldPhone) > 99999999 ){ sendResponse(0, __LINE__,"no decimals"); }

$sNewPhone = $_POST['new-phone'] ?? '';
if( empty($sNewPhone) ){ sendResponse(0, __LINE__, "this field cant be empty"); }
if( strlen($sNewPhone) != 8 ){ sendResponse(0, __LINE__,"must be at least 8 characters"); }
if( intval($sNewPhone) < 10000000 ){ sendResponse(0, __LINE__, "no decimals"); }
if( intval($sNewPhone) > 99999999 ){ sendResponse(0, __LINE__,"no decimals"); }

$sConfirmPhone = $_POST['confirm-phone'] ?? '';
if( empty($sConfirmPhone) ){ fnvSendResponse(0, __LINE__,"this field cant be empty");  }


if($sOldPhone == $sNewPhone){
    fnvSendResponse(0, __LINE__, "phone cannot be the same as the before");
}

if($sNewPhone != $sConfirmPhone ){
    fnvSendResponse(0, __LINE__, "phones doesnt match");
}

if($sUserId != $sOldPhone){
    fnvSendResponse(0, __LINE__, "Sorry, your phone is incorrect");
}

//set new phone in id, save it in session? update on screen 
//bliver ved med at overskrive hele objectet , og ændrer heller ikke telefonnummer
foreach($jInnerData->$sUserId as $sClientId => $jClient){
    
    $sData = json_encode($jUser, JSON_PRETTY_PRINT);
    if( $sData == null ){ sendResponse(0, __LINE__,"json data could not be converted"); }
    file_put_contents('../data/clients.json', $sData);
    fnvSendResponse(1, __LINE__, "Phone updated");
}


// $sData = json_encode($jUser);
// if( $sData == null ){ sendResponse(0, __LINE__,"json data could not be converted"); }
// file_put_contents('../data/clients.json', $sData);
// fnvSendResponse(1, __LINE__, "Phone updated");

// header('Location: ../profile');


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}


