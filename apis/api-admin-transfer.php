<?php
ini_set('user_agent', 'any');
ini_set('display_errors', 0);

session_start();
$sUserId = $_SESSION['sUserId'];

// Validate phone
$sPhone = $_POST['txtTransferToPhone'] ?? '';
if( empty( $_POST['txtTransferToPhone'] ) ){ sendResponse(0, __LINE__, 'Phone missing'); }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__, 'Phone must be 8 characters in length'); }
if( !ctype_digit($sPhone)  ){ sendResponse(0, __LINE__, 'Phone can only contain numbers'); }

// Validate amount
$iAmount = $_POST['txtTransferAmount'] ?? '';
if( empty( $_POST['txtTransferAmount'] ) ){ sendResponse(0, __LINE__, 'Amount is missing'); }
if( !ctype_digit($iAmount)  ){ sendResponse(0, __LINE__, 'Amount can only contain numbers'); }

// Validate message
$sMessage = $_POST['txtTransferMessage'] ?? '';
if( empty( $_POST['txtTransferMessage'] ) ){ sendResponse(0, __LINE__, 'Message is missing'); }
if( strlen($sMessage) >= 30 ){ sendResponse(0, __LINE__, 'message can only be 30 characters long'); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );
if( $jData == null){ sendResponse(0, __LINE__, 'Cannot convert data to JSON'); }
$jInnerData = $jData->data;

if(!$jInnerData->$sPhone){
    sendResponse(0, __LINE__, 'could not find phone');
}

// if what you transfer in iamount, is not the amount on your account
if($iAmount >= $jInnerData->$sUserId->balance){
  sendResponse( 0, __LINE__ , 'You dont have enough money' );
}

// Take money from admin, 
$jInnerData->$sUserId->balance -= $iAmount;
//Give it to corresponding phone from GET
$jInnerData->$sPhone->balance += $iAmount;


$sData = json_encode($jData, JSON_PRETTY_PRINT);
if( $sData == null ){ sendResponse(0, __LINE__,"file could not be converted"); }
file_put_contents('../data/clients.json', $sData);
sendResponse( 1, __LINE__ , 'Phone registered locally' );

// **************************************************
function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}




