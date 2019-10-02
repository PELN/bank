<?php

$sPhone = $_GET['phone'];
$sActivationKey = $_GET['activation-key'];

$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
//check if the conversion is well done
if($jUser == null){fnvSendResponse(0, __LINE__, "json wrong");}
$jInnerData = $jUser->data;

if( $jInnerData->$sPhone != $sPhone && $jInnerData->$sPhone->activationKey != $sActivationKey ){
    fnvSendResponse(0, __LINE__, "not found in users");
}

$temporaryPassword = "password123";
$jInnerData->$sPhone->password = password_hash($temporaryPassword, PASSWORD_DEFAULT);

//get the phone and validation key , check if it is in the data, if not, set pass to a temporary pass
// set a temporary password in data clients
// log in with temporary key

$sUser = json_encode($jUser, JSON_PRETTY_PRINT);
if($sUser == null){ fnvSendResponse(0,__LINE__, "json could not be converted");}
file_put_contents('../data/clients.json', $sUser);

header('Location: ../index#login');
fnvSendResponse(1, __LINE__, "temp password set");


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }
  
  