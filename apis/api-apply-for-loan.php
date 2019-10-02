<?php
ini_set('display_errors', 1);
session_start();
$sUserId = $_SESSION['sUserId'];

$iLoanAmount = $_POST['iLoanAmount'] ?? '';
if( empty($iLoanAmount) ){ fnvSendResponse(0,__LINE__, 'Amount cant be empty'); }
if( !ctype_digit($iLoanAmount)  ){ fnvSendResponse(0, __LINE__, 'Can only contain digits'); }

$sLoanComment = $_POST['sLoanComment'] ?? '';
if( empty($sLoanComment) ){ fnvSendResponse(0,__LINE__, "Comment cant be empty"); }
if( strlen($sLoanComment) < 2 ) { fnvSendResponse(0,__LINE__, "Comment has to be at least 2 characters "); }
if( strlen($sLoanComment) > 20 ) { fnvSendResponse(0,__LINE__, "Comment cant be longer than 20 characters "); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null){ fnvSendResponse(0,__LINE__, "json file corrupt"); }
$jInnerData = $jData->data;

$jLoan = new stdClass();
$jLoan->amount = $iLoanAmount;
$jLoan->comment = $sLoanComment;
$jLoan->active = 0;
$sLoanId = uniqid();
$jInnerData->$sUserId->loans->$sLoanId = $jLoan;

$sData = json_encode($jData, JSON_PRETTY_PRINT);
if($sData == null){ fnvSendResponse(0,__LINE__, "json could not be converted");}
file_put_contents('../data/clients.json', $sData);

fnvSendResponse(1,__LINE__, "Applied for loan {$sLoanId}");


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{ "status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'" }';
    exit;
}