<?php

// ini_set('display_errors', 1);

$sPhone = $_POST['txtLoginPhone'] ?? '';
if( empty($sPhone) ){ sendResponse(0, __LINE__, "you have to fill out the field");  }
if( strlen($sPhone) != 8 ){ sendResponse(0, __LINE__, "has to be at least 8 numbers"); }
if( !ctype_digit($sPhone)  ){ sendResponse(0, __LINE__,"the number can only contain digits");  }

$sPassword = $_POST['txtLoginPassword'] ?? '';
if( empty($sPassword) ){ sendResponse(0, __LINE__,"you have to fill out the field");  }
if( strlen($sPassword) < 4 ){ sendResponse(0, __LINE__,"has to be at least 4 characters"); }
if( strlen($sPassword) > 50 ){ sendResponse(0, __LINE__,"can not be longer than 50 characters"); }

//when all is valid, open the file and check it
$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__,"system update"); }
$jInnerData = $jData->data;

if(!$jInnerData->$sPhone){
    sendResponse(0, __LINE__,"Phone is not in the database"); 
}

//check attempts left
if( $jInnerData->$sPhone->iLoginAttemptsLeft <= 0 ){
    //if there are 0 attempts left, wait 60 seconds
    $iSecondsElapsedSinceLastLoginAttempt = $jInnerData->$sPhone->iLastLoginAttempt + 10 - time();
    //if you reached 0 seconds, check password again
    if($iSecondsElapsedSinceLastLoginAttempt <= 0){

        if( !password_verify( $sPassword, $jInnerData->$sPhone->password) ){
            
            if($jInnerData->$sPhone->iLoginAttemptsLeft <= 0){
                $jInnerData->$sPhone->iLoginAttemptsLeft = 3;
                $jInnerData->$sPhone->iLastLoginAttempt = 0;
                file_put_contents("../data/clients.json", json_encode($jData, JSON_PRETTY_PRINT));
            }
            
            sendResponse(-1, __LINE__,"password wrong, try again");
        }
        //else if the passwords match - set 3 new attempts
        $jInnerData->$sPhone->iLoginAttemptsLeft = 3;
        $jInnerData->$sPhone->iLastLoginAttempt = 0;
        file_put_contents("../data/clients.json", json_encode($jData, JSON_PRETTY_PRINT));
        sendResponse(1, __LINE__,"SUCCESS, you are logged in");
    }
    sendResponse(-1, __LINE__,"please wait {$iSecondsElapsedSinceLastLoginAttempt} seconds to login again ");
}

// if user has login attempts, check the password, if it is wrong, take one attempt away
if( !password_verify( $sPassword, $jInnerData->$sPhone->password)  ){
    $jInnerData->$sPhone->iLoginAttemptsLeft --;
    $jInnerData->$sPhone->iLastLoginAttempt = time();
    file_put_contents( "../data/clients.json", json_encode( $jData, JSON_PRETTY_PRINT ) );
    sendResponse(-1, __LINE__, "Wrong password. You have {$jInnerData->$sPhone->iLoginAttemptsLeft} attempts left");
}


// check if user is active /activated
if( $jInnerData->$sPhone->active != 1 ){
    sendResponse(0, __LINE__,"you must activate your account in email"); 
}



// SUCCESS
session_start();
$_SESSION['sUserId'] = $sPhone;
sendResponse(1, __LINE__,"SUCCESS");
header('Location: profile');


// **************************************************
function sendResponse($bStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}






