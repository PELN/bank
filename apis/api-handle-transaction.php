<?php

ini_set('display_errors', 0);

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );
if( $jData == null ){ fnvSendResponse(-1, __LINE__, 'Cannot convert the data file to json'); }
$jInnerData = $jData->data;

$sPhoneFromOtherServer = $_GET['phone'];
$iAmountFromOtherServer = $_GET['amount'];
$sMessageFromOtherServer = $_GET['message'];

// if phone is not registered
if( !$jInnerData->$sPhoneFromOtherServer ){
    fnvSendResponse(0, __LINE__, 'Phone not registered in Lee Bank');
}

// give the amount to the registered phone
$jInnerData->$sPhoneFromOtherServer->balance += $iAmountFromOtherServer;

//give the message to the transactions, build/create the obj. with date, amount,...
$iTransactionDate = time();
$jTransaction->date = date('D-d-M-Y', $iTransactionDate);
$jTransaction->amount = $iAmountFromOtherServer;
$jTransaction->name = 'AA';
$jTransaction->lastName = 'AAA';
$jTransaction->fromPhone = $sPhoneFromOtherServer;
$jTransaction->message = $sMessageFromOtherServer;
//assign a uniq id to the transactions obj.
$sTransactionUniqueId = uniqid();
//set the id to the transaction obj.
$jInnerData->$sPhoneFromOtherServer->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
$jInnerData->$sPhoneFromOtherServer->transactions->$sTransactionUniqueId = $jTransaction;

$sData = json_encode($jData, JSON_PRETTY_PRINT);
if( $sData == null ){ fnvSendResponse(-1, __LINE__, 'Cannot convert the data file to json'); }
file_put_contents('../data/clients.json', $sData);
fnvSendResponse(1, __LINE__, 'Transaction success from Lee Bank');

// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}





