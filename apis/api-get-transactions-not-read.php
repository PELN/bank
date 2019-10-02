<?php

//DOES NOT WORK PROPERLY

session_start();
$sUserId = $_SESSION['sUserId'];

if( !isset($_SESSION['sUserId'] ) ){fnvSendResponse(0, __LINE__, 'You must login to use this api'); }

//fetch all data that hasnt been read
$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null ){fnvSendResponse(0, __LINE__, 'cant fetch json data'); }
$jInnerData = $jData->data;

$jTransactionsNotRead = $jInnerData->$sUserId->transactionsNotRead;
// $jTransactionsRead = $jInnerData->$sUserId->transactions;


echo json_encode($jTransactionsNotRead);


fnvSendResponse(1, __LINE__, 'Transaction received');

// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}
