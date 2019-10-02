<?php
//check variable in php with isset
//if it is not set, redirect customers back
if(!isset($_GET['id'])){
    header('Location: admin');
    fnvSendResponse(0, __LINE__, 'no id found');
}//implicit 'else' - everything is executed, if the ID it not set

$sAccountId = $_GET['id'];


$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if( $jData == null){fnvSendResponse(0,__LINE__, "json not valid");}

$jInnerdata = $jData->data;

if( !$jInnerdata->$sAccountId ){
    fnvSendResponse(0, __LINE__, "ID not found");
}

$jInnerdata->$sAccountId->active = !$jInnerdata->$sAccountId->active;


$sData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents('data/clients.json', $sData);
header('Location: admin');
fnvSendResponse(1, __LINE__, 'blocked or unblocked');

// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{ "status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'" }';
    exit;
}

