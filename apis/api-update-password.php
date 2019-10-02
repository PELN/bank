<?php
session_start();
$sUserId = $_SESSION['sUserId'];

$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
if( $jUser == null ){ sendResponse(0, __LINE__); }
$jInnerData = $jUser->data;

$sOldPassword = $_POST['old-password'] ?? '';
if( empty($sOldPassword) ){ fnvSendResponse(0, __LINE__, "this field cant be empty");  }
if( strlen($sOldPassword) < 4 ){ fnvSendResponse(0, __LINE__,"must be at least 4 characters"); }
if( strlen($sOldPassword) > 50 ){ fnvSendResponse(0, __LINE__,"cant be over 50 characters"); }

$sNewPassword = $_POST['new-password'];
if( empty($sNewPassword) ){ fnvSendResponse(0, __LINE__,"this field cant be empty");  }
if( strlen($sNewPassword) < 4 ){ fnvSendResponse(0, __LINE__,"must be at least 4 characters"); }
if( strlen($sNewPassword) > 50 ){ fnvSendResponse(0, __LINE__,"cant be over 50 characters"); }

$sConfirmPassword = $_POST['confirm-password'];
if( empty($sConfirmPassword) ){ fnvSendResponse(0, __LINE__,"this field cant be empty");  }

//validate all of them with length, char 
if($sOldPassword == $sNewPassword){
    fnvSendResponse(0, __LINE__, "Password cannot be the same as the before");
}

if($sNewPassword != $sConfirmPassword ){
    fnvSendResponse(0, __LINE__, "Passwords doesnt match");
}

// check hashed password 
if(!password_verify( $sOldPassword, $jInnerData->$sUserId->password)){
    fnvSendResponse(0, __LINE__, "Sorry, your password is incorrect");
}

//hash new password
$jInnerData->$sUserId->password = password_hash($sNewPassword, PASSWORD_DEFAULT);


$sData = json_encode($jUser, JSON_PRETTY_PRINT);
if( $sData == null ){ sendResponse(0, __LINE__); }
file_put_contents('../data/clients.json', $sData);
fnvSendResponse(1, __LINE__, "Password updated");


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}


