<?php
$sUser = file_get_contents('../data/clients.json');
$jUser = json_decode($sUser);
//check if the conversion is well done
$jInnerData = $jUser->data;

$sPhone = $_GET['txtForgotPhone'];

if( !$jInnerData->$sPhone ){
    fnvSendResponse(0, __LINE__, "phone not found");
}

$sEmail = $jInnerData->$sPhone->email;
$sActivationKey = $jInnerData->$sPhone->activationKey;

mail($sEmail, 'Reset Password', "www.pennylee.dk/bank/apis/api-reset-password?phone=$sPhone&activation-key=$sActivationKey your temporary password is password123");


header('Location: ../index#login');
fnvSendResponse(1, __LINE__, "email sent");


// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}
