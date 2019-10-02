<?php 
// ini_set('display_errors', 1);

// validate name
$sName = $_POST['txtSignupName'] ?? '';
if( empty($sName) ){ fnvSendResponse(0, __LINE__,'Name field cant be empty');  }
if( strlen($sName) < 2 ){ fnvSendResponse(0, __LINE__,'Name has to be at least 2 characters'); }
if( strlen($sName) > 20 ){ fnvSendResponse(0, __LINE__,'Name cant be longer than 20 characters'); }

// validate last name
$sLastName = $_POST['txtSignupLastName'] ?? '';
if( empty($sLastName) ){ fnvSendResponse(0, __LINE__,'Last name field cant be empty');  }
if( strlen($sLastName) < 2 ){ fnvSendResponse(0, __LINE__,'Last name has to be at least 2 characters'); }
if( strlen($sLastName) > 20 ){ fnvSendResponse(0, __LINE__,'Last name cant be longer than 20 characters'); }

// validate email
$sEmail = $_POST['txtSignupEmail'] ?? '';
if( empty($sEmail) ){ fnvSendResponse(0, __LINE__,'Email field cant be empty'); }
if( !filter_var( $sEmail, FILTER_VALIDATE_EMAIL ) ){ fnvSendResponse(0, __LINE__,'Not a valid email'); }

// validate CPR
$sCpr = $_POST['txtSignupCpr'] ?? '';
if( empty($sCpr) ){ fnvSendResponse(0, __LINE__,'CPR field cant be empty');  }
if( strlen($sCpr) != 10 ){ fnvSendResponse(0, __LINE__,'CPR has to be at least 10 numbers'); }
if( !ctype_digit($sCpr)  ){ fnvSendResponse(0, __LINE__,'CPR can only contain digits');  }

//validate phone
$sPhone = $_POST['txtSignupPhone'] ?? '';
if( empty($sPhone) ){ fnvSendResponse(0, __LINE__, 'Phone field cant be empty'); }
if( strlen($sPhone) != 8 ){ fnvSendResponse(0, __LINE__, 'Phone should be at least 8 numbers'); }
if( intval($sPhone) < 10000000 ){ fnvSendResponse(0, __LINE__, 'Phone can only contain 8 numbers'); }
if( intval($sPhone) > 99999999 ){ fnvSendResponse(0, __LINE__,'Phone can only contain 8 numbers'); }

// validate password
$sPassword = $_POST['txtSignupPassword'] ?? '';
if( empty($sPassword) ){ fnvSendResponse(0, __LINE__,'Password field cant be empty');  }
if( strlen($sPassword) < 4 ){ fnvSendResponse(0, __LINE__,'Password has to be at least 4 characters'); }
if( strlen($sPassword) > 50 ){ fnvSendResponse(0, __LINE__,'Password cant be longer than 50 characters'); }

// validate confirm password
$sConfirmPassword = $_POST['txtSignupConfirmPassword'] ?? '';
if( empty($sConfirmPassword) ){ fnvSendResponse(0, __LINE__,'Confirm password field cant be empty');  }
if( $sPassword != $sConfirmPassword ){ fnvSendResponse(0, __LINE__,'Passwords doesnt match');  }


//when all is validated, open the file and check it for corruption
$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ fnvSendResponse(0, __LINE__,'json data corrupt'); }

$jInnerData = $jData->data; //from the data obj. - point to the obj. inside = the id/phone

$jClient = new stdClass(); // json empty obj.
$jClient->name = $sName;
$jClient->lastName = $sLastName;
$jClient->email = $sEmail;
$jClient->password = password_hash( $sPassword, PASSWORD_DEFAULT );
$jClient->cpr = $sCpr;
$jClient->balance = 0;
$jClient->active = 0;
$jClient->iLoginAttemptsLeft = 3;
$jClient->iLastLoginAttempt = 0;
$sActivationKey = $jClient->activationKey = $sEmail.uniqid();

$jClient->accounts = new stdClass(); // make json obj. {}

//make json obj., so it can contain more than one
$jClient->transactions = new stdClass();
$jClient->transactionsNotRead = new stdClass();

$jClient->loans = new stdClass();

$jClient->creditcard = new stdClass();
$jCard = new stdClass();
$jCard->creditcardNumber = NULL;
$jCard->cvv = NULL;
$jCard->expirationMonth = NULL;
$jCard->expirationYear = NULL;
$jCard->cardType = NULL;
$jClient->creditcard = $jCard;
$jClient->creditcardActive = 0;

$jClient->admin = 0;

$jInnerData->$sPhone = $jClient; // put the jClient ID/phone inside the jInnerData

//convert the obj. back to text and check the file 
$sData = json_encode( $jData, JSON_PRETTY_PRINT );
if( $sData == null   ){ fnvSendResponse(0, __LINE__,'json data corrupt'); }
//put it back in the file
file_put_contents( '../data/clients.json', $sData );

mail($sEmail, 'Activation Key', "www.pennylee.dk/bank/activation-page?phone=$sPhone&activation-key=$sActivationKey");


// SUCCESS
fnvSendResponse(1,__LINE__, 'You have succesfully signed up. Activate your account in email');

// **************************************************
function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
    echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
    exit;
  }
