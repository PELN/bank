<?php

ini_set('user_agent', 'any');
ini_set('display_errors', 0);

session_start();
if( !isset($_SESSION['sUserId'] ) ){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sUserId = $_SESSION['sUserId'];

if( empty( $_GET['phone'] ) ){ sendResponse(-1, __LINE__, 'Phone missing'); }
if( empty( $_GET['amount'] ) ){ sendResponse(-1, __LINE__, 'Amount is missing'); }
if( empty( $_GET['message'] ) ){ sendResponse(-1, __LINE__, 'Message is missing'); }

// Validate phone
$sPhone = $_GET['phone'] ?? '';
if( strlen($sPhone) != 8 ){ sendResponse(-1, __LINE__, 'Phone must be 8 characters in length'); }
if( !ctype_digit($sPhone)  ){ sendResponse(-1, __LINE__, 'Phone can only contain numbers'); }

// Validate amount
$iAmount = $_GET['amount'] ?? '';
if( !ctype_digit($iAmount)  ){ sendResponse(-1, __LINE__, 'Amount can only contain numbers'); }

// Validate message
$sMessage = $_GET['message'] ?? '';
if( strlen($sMessage) >= 30 ){ sendResponse(-1, __LINE__, 'message can only be 30 characters long'); }


$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );
if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON'); }
$jInnerData = $jData->data;

//if the phone is not in my bank, get list from central bank
if( !$jInnerData->$sPhone ){
  $jListOfBanks = fnjGetListOfBanksFromCentralBank();
  // loop through the list, connect to each bank
  foreach( $jListOfBanks as $sKey => $jBank ){
    $sUrl = $jBank->url.'/apis/api-handle-transaction?phone='.$sPhone.'&amount='.$iAmount.'&message='.$sMessage;

    //talk to the other bank
    $sBankResponse =  file_get_contents($sUrl);
    $jBankResponse = json_decode($sBankResponse);

    if( $jBankResponse->status == 1 && 
        $jBankResponse->code && 
        $jBankResponse->message ){
        sendResponse( 1, __LINE__ , $jBankResponse->message);
    }
  }
  sendResponse( 2, __LINE__ , 'Phone does not exist' );
}


//if what you transfer in iamount, is not the amount on your account
if($iAmount >= $jInnerData->$sUserId->balance){
  sendResponse( -1, __LINE__ , 'You dont have enough money' );
}

// Take money from the logged user, 
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

// **************************************************
function fnjGetListOfBanksFromCentralBank(){
  // get the list of banks
  $sData = file_get_contents('https://ecuaguia.com/central-bank/api-get-list-of-banks.php?key=1111-2222-3333');
  return json_decode($sData);
}



