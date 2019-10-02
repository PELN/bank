<?php
ini_set('display_errors', 1);

session_start();
$sUserId = $_SESSION['sUserId'];

$sPassword = $_POST['password'] ?? '';
if( empty($sPassword) ){ fnvSendResponse(0, __LINE__,"you have to fill out the field");  }
if( strlen($sPassword) < 4 ){ fnvSendResponse(0, __LINE__,"has to be at least 4 characters"); }
if( strlen($sPassword) > 50 ){ fnvSendResponse(0, __LINE__,"can not be longer than 50 characters"); }

$sConfirmPassword = $_POST['confirm-password'] ?? '';
if( empty($sConfirmPassword) ){ fnvSendResponse(0, __LINE__,"this field cant be empty");  }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null){ fnvSendResponse(0, __LINE__, "json cant be converted"); }
$jInnerData = $jData->data;


if( !password_verify($sPassword, $jInnerData->$sUserId->password) ) {
    fnvSendResponse(0, __LINE__,"wrong password, try again");
}

if($sPassword != $sConfirmPassword){fnvSendResponse(0, __LINE__, "Passwords doesnt match");}

if($jInnerData->$sUserId->creditcardActive == 1){
    //flip the status to 0, meanin inactive
    $jInnerData->$sUserId->creditcardActive = 0;
    // set creditcard values to null, meaning it is deleted
    $jInnerData->$sUserId->creditcard->creditcardNumber = NULL;
    $jInnerData->$sUserId->creditcard->cvv = NULL;
    $jInnerData->$sUserId->creditcard->expirationMonth = NULL;
    $jInnerData->$sUserId->creditcard->expirationYear = NULL;
    $jInnerData->$sUserId->creditcard->cardType = NULL;
}

$sData = json_encode($jData, JSON_PRETTY_PRINT);
if($sData == null){ fnvSendResponse(0,__LINE__, "json could not be converted");}
file_put_contents('../data/clients.json', $sData);

fnvSendResponse(1,__LINE__, "Your card is not active anymore");


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{ "status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'" }';
    exit;
}