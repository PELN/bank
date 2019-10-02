<?php
ini_set('display_errors', 1);
session_start();
$sUserId = $_SESSION['sUserId'];

$sAccountName = $_POST['account-name'] ?? '';
if( empty($sAccountName) ){ fnvSendResponse(0,__LINE__, "name cant be empty");}
if( strlen($sAccountName) < 3 ){ fnvSendResponse(0,__LINE__, "name has to be at least 3 characters");}
if( strlen($sAccountName) > 15 ){ fnvSendResponse(0,__LINE__, "name cant be longer than 15 characters");}

$sAccountType = $_POST['account-type'] ?? '';
if( empty($sAccountType) ){ fnvSendResponse(0,__LINE__, "type cant be empty");}
if( strlen($sAccountType) < 3 ){ fnvSendResponse(0,__LINE__, "name has to be at least 3 characters");}
if( strlen($sAccountType) > 10 ){ fnvSendResponse(0,__LINE__, "name cant be longer than 10 characters");}

$iCurrency = $_POST['currency'] ?? '';

$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
if($jUser == null){ fnvSendResponse(0, __LINE__, "json cant be converted"); }
$jInnerData = $jUser->data;


$jAccount = new stdClass();
$jAccount->accountName = $sAccountName;
$jAccount->accountType = $sAccountType;
$jAccount->balance = 0;
$jAccount->currency = $iCurrency;
$sAccountUniqueId = uniqid();
$jInnerData->$sUserId->accounts->$sAccountUniqueId = $jAccount;


$sData = json_encode($jUser, JSON_PRETTY_PRINT);
if($sData == null){ fnvSendResponse(0,__LINE__, "json could not be converted");}
file_put_contents('../data/clients.json', $sData);

fnvSendResponse(1,__LINE__, "account created");


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{ "status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'" }';
    exit;
}