<?php
session_start();
$sUserId = $_SESSION['sUserId'];

$sCardType = $_POST['cardType'];
$iCreditcardNumber = $_POST['iCreditCardNumber'];
if(empty($iCreditcardNumber)){ fnvSendResponse(0, __LINE__, "creditcard number field can not be empty");}

$iCVV = $_POST['iCVV'];
if(empty($iCVV)){ fnvSendResponse(0, __LINE__, "CVV field can not be empty");}
if(!preg_match("/^[0-9]{3,4}$/", $iCVV)){ fnvSendResponse(0, __LINE__, "cvv not correct"); }

$iExpiryMonth = $_POST['expiryMonth'];
$iExpiryYear = $_POST['expiryYear'];


switch($sCardType){
    case "mastercard": 
        if(!preg_match("(5[1-5]\d{14})", $iCreditcardNumber)){
            fnvSendResponse(0, __LINE__, "mastercard number not correct");
        }
    break;
    
    case "visa": 
        if(!preg_match("(4\d{12}(?:\d{3})?)", $iCreditcardNumber)){
            fnvSendResponse(0, __LINE__, "visa number not correct");
        }
    break;

    default:
        echo "You have to choose an option";
}


$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
if($jUser == null){ fnvSendResponse(0, __LINE__, "json cant be converted"); }
$jInnerData = $jUser->data;

$jInnerData->$sUserId->creditcard->creditcardNumber = $iCreditcardNumber;
$jInnerData->$sUserId->creditcard->cvv = $iCVV;
$jInnerData->$sUserId->creditcard->expirationMonth = $iExpiryMonth;
$jInnerData->$sUserId->creditcard->expirationYear = $iExpiryYear;
$jInnerData->$sUserId->creditcard->cardType = $sCardType;
$jInnerData->$sUserId->creditcardActive = 1;


$sData = json_encode($jUser, JSON_PRETTY_PRINT);
if($sData == null){ fnvSendResponse(0,__LINE__, "json could not be converted");}
file_put_contents('../data/clients.json', $sData);

//function MUST be after saving to the file, or no changes will happen
fnvSendResponse(1,__LINE__, "creditcard registered");

// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }
