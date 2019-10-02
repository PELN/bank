<?php
session_start();
$sUserId = $_SESSION['sUserId'];

$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
if( $jUser == null ){ sendResponse(0, __LINE__, "json data could not be converted"); }
$jInnerData = $jUser->data;

$sOldEmail = $_POST['old-email'] ?? '';
if( empty($sOldEmail) ){ sendResponse(0, __LINE__,"this field cant be empty");  }
if( !filter_var( $sOldEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__,"could not validate email");  }

$sNewEmail = $_POST['new-email'];
if( empty($sNewEmail) ){ fnvSendResponse(0, __LINE__,"this field cant be empty");  }
if( !filter_var( $sNewEmail, FILTER_VALIDATE_EMAIL ) ){ sendResponse(0, __LINE__,"could not validate email");  }

$sConfirmEmail= $_POST['confirm-email'];
if( empty($sConfirmEmail) ){ fnvSendResponse(0, __LINE__,"this field cant be empty");  }

if($sOldEmail == $sNewEmail){
    fnvSendResponse(0, __LINE__, "email cannot be the same as the before");
}

if($sNewEmail != $sConfirmEmail ){
    fnvSendResponse(0, __LINE__, "emails doesnt match");
}

$jInnerData->$sUserId->email = $sNewEmail;


$sData = json_encode($jUser, JSON_PRETTY_PRINT);
if( $sData == null ){ sendResponse(0, __LINE__,"json data could not be converted"); }
file_put_contents('../data/clients.json', $sData);
fnvSendResponse(1, __LINE__, "Email updated");
// header('Location: ../profile');


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}


