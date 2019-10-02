<?php

ini_set('display_errors', 1);

if(!isset($_GET['id'])){
    header('Location: admin');
    fnvSendResponse(0, __LINE__, 'no id found');
}//implicit 'else' - everything is executed, if the ID it not set

$sGetLoanId = $_GET['id'];
$sUserId = $_GET['user'];

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null){fnvSendResponse(0, __LINE__, 'json corrupt'); }
$jInnerData = $jData->data;

//switch approve to 0 - meaning approved?
foreach($jInnerData->$sUserId->loans as $sLoanId => $jLoan){
    // check if id is in database
    if( $sLoanId == $sGetLoanId){
        $jLoan->active = -1;

        $sData = json_encode($jData, JSON_PRETTY_PRINT);
        file_put_contents('../data/clients.json', $sData);
        header('Location: ../admin');
        fnvSendResponse(1, __LINE__, "Loan declined {$sLoanId}");
    }
}

if( !$jInnerdata->$sUserId ){
    fnvSendResponse(0, __LINE__, "ID not found, loan fail");
}

// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{ "status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'" }';
    exit;
}

