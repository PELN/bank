<?php
session_start();

// in new browser, it redirects to login page, if session isn't logged in
if(!isset($_SESSION['sUserId']) ){
    header('Location: index');
}

// get the user id that is stored in the session
$sUserId = $_SESSION['sUserId'];

//open the file to get the keys inside json obj.
$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if($jData == null){ echo 'system update'; }

//make a variable jInnerData, which contains the 'data' obj.
$jInnerData = $jData->data;
// echo json_encode($jInnerData);

//if admin is 1, redirect to admin.php
if($jInnerData->$sUserId->admin == 1){
    header('Location: admin');
}

//make it more readable - put it in a jClient
$jClient = $jInnerData->$sUserId;
$jAccount = $jInnerData->$sUserId->accounts;

$sUserPhone = $sUserId;

require_once 'loggedin-top.php';
?>

<div id="profile" class="page">

<div id="infoContainer">
    <h1>Profile</h1>
    <div>Phone: <span id="lblUserId"><?= $sUserId; ?></span> </div>
    <div>Name: <?= $jClient->name; ?> </div>
    <div>Last Name: <?= $jClient->lastName; ?> </div>
    <div>Email: <span id="lblEmailProfile"><?= $jClient->email; ?></span></div>
  

    <div id="creditcardInformation">
        <h4>Creditcard registered:</h4>
        <div>Card Type: <?= $jClient->creditcard->cardType; ?></div>
        <div>Card Number: <?= $jClient->creditcard->creditcardNumber; ?></div>
        <div>Expiration Month: <?= $jClient->creditcard->expirationMonth; ?> </div>
        <div>Expiration Year: <?= $jClient->creditcard->expirationYear; ?> </div>
        <h4>Register or block card in Settings</h4>
    </div>

  </div>



<div id="transferContainer">
      
    <div id="balance">
        <div><h3>BALANCE<h3></div>
        <span id="lblBalance"><?= $jClient->balance; ?></span>    
    </div>
    
    <h1>Transfer</h1>
    <form id="frmTransfer">
        <input name="txtTransferToPhone" id="txtTransferToPhone" type="text" placeholder="transfer to phone">
        <input name="txtTransferAmount" id="txtTransferAmount" type="text" placeholder="transfer amount">
        <input name="txtTransferMessage" id="txtTransferMessage" type="text" placeholder="transfer message">
        <button class="frmButtons">TRANSFER</button>
    </form>
</div>

<div id="transactionsContainer">
    <h1>Transactions</h1>
        <table>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>DATE</td>
                    <td>AMOUNT</td>
                    <td>NAME</td>
                    <td>LASTNAME</td>
                    <td>PHONE</td>
                    <td>MESSAGE</td>
                </tr>
            </thead>

            <tbody id="lblTransactions">

            <?php
            //you already save the innerdata in a jClient
            //get the key (transaction ID) and the value as (one json object transaction)
            foreach( $jClient->transactions as $sTransactionId => $jTransaction ){
                echo "
                    <tr>
                        <td>$sTransactionId</td>
                        <td>$jTransaction->date</td>
                        <td>$jTransaction->amount</td>
                        <td>$jTransaction->name</td>
                        <td>$jTransaction->lastName</td>
                        <td>$jTransaction->fromPhone</td>
                        <td>$jTransaction->message</td>
                    </tr>
                ";
            }
        ?>
            </tbody>
        </table>

        <div id="chat">
            <a href="chat?user=<?=$sUserId?>"><img id="chatIcon" src="images/bubble.png"></a>
        </div>
    </div>
</div>



<div id="accounts" class="page">

    <div id="createAccount">
        <h3>Create a new account</h3>
        <form id="frmCreateAccount" action="">
            <input name="account-name" type="text" placeholder="Name of account">
            <input name="account-type" type="text" placeholder="Account type (e.g: savings)">
            <label for="currency">Choose currency</label>            
                <select name="currency" id="currency">
                    <option name="dkk" value="dkk">DKK</option>
                    <option name="usd" value="usd">$ USD</option>
                    <option name="euro" value="euro">€ EURO</option>
                    <option name="pound" value="pound">£ POUND</option>
                </select>
            <button class="frmButtons">Create account</button>
        </form>
    </div>

    <div id="applyForLoan">
        <h3>Apply for a loan</h3>
        <form id="frmApplyForLoan" action="apis/api-apply-for-loan" method="POST">
            <input name="iLoanAmount" type="text" placeholder="Desired loan amount">
            <input name="sLoanComment" type="text" placeholder="Comment">
            <button class="frmButtons">Apply</button>
        </form>
    </div>

    <div id="loansContainer">
        <h1>LOANS</h1>
        <?php
            foreach($jInnerData->$sUserId->loans as $sLoanId => $jLoan){
                if($jLoan->active == 1){
                    $sWord = 'Loan Approved';
                }
                if($jLoan->active == 0){
                    $sWord = 'Loan waiting to be approved';
                }
                if($jLoan->active == -1){
                    $sWord = 'Loan not approved';
                }

                echo "<div>
                    <div>ID: $sLoanId </div>
                    <div>Amount: $jLoan->amount </div>
                    <div>Comment: $jLoan->comment </div>
                    <div>Status: $sWord</div>
                </div>
                ";
            }
        ?>
    </div>


    <div id="accountsContainer">
        <h1>ACCOUNTS</h1>
        <table>
                <thead>
                    <tr>
                        <!-- <td>ID</td> -->
                        <td>ACCOUNT NAME</td>
                        <td>TYPE</td>
                        <td>BALANCE</td>
                        <td>CURRENCY</td>
                    </tr>
                </thead>

                <tbody id="displayAccounts">
                <?php
                //get the key (transaction ID) and the value as (one json object transaction)
                foreach( $jClient->accounts as $sAccountId => $jAccount ){
                    echo "
                        <tr>
                            <td>$jAccount->accountName</td>
                            <td>$jAccount->accountType</td>
                            <td>$jAccount->balance</td>
                            <td>$jAccount->currency</td>
                        </tr>
                    ";
                }
            ?>
                </tbody>
        </table>
    </div>

    <div id="chat">
        <a href="chat?user=<?=$sUserId?>"><img id="chatIcon" src="images/bubble.png"></a>
    </div>
</div>


<div id="settings" class="page">

    <div id="infoContainer">
        <h3>Profile details</h3> 
        <div>Phone: <?= $sUserId; ?></div>
        <div>Name: <?= $jClient->name; ?> </div>
        <div>Last Name: <?= $jClient->lastName; ?> </div>
        <div>Email: <span id="lblEmail"><?= $jClient->email; ?></span></div>

        <div id="creditcardInformation">
            <h3>Credit card registered</h3> 
            <div>Card Type: <?= $jClient->creditcard->cardType; ?></div>
            <div>Card Number: <?= $jClient->creditcard->creditcardNumber; ?></div>
            <div>Expiration Month: <?= $jClient->creditcard->expirationMonth; ?> </div>
            <div>Expiration Year: <?= $jClient->creditcard->expirationYear; ?> </div>
        </div>

        <div id="cardIsBlocked"></div>
    </div>


    <div id="updateEmail">
        <h3>Change Email</h3>
        <form id="frmUpdateEmail" method="POST">
            <input name="old-email" type="text" placeholder="old email">            
            <input name="new-email" type="text" placeholder="new email">            
            <input name="confirm-email" type="text" placeholder="confirm new email">
            <button class="frmButtons">Change email</button>
        </form>
    </div>
    

    <div id="updatePhone">
        <h3>Change phone number</h3>
        <form id="frmUpdatePhone" action="apis/api-update-phone" method="POST">
            <input name="old-phone" type="text" placeholder="old phone">            
            <input name="new-phone" type="text" placeholder="new phone">            
            <input name="confirm-phone" type="text" placeholder="confirm new phone">
            <button class="frmButtons">Change phone</button>
        </form>
    </div>
    
    <div id="updatePassword">
        <h3>Change password</h3>
        <div id="lblPassword"></div>
        <form id="frmUpdatePassword" method="POST">
            <input name="old-password" type="text" placeholder="old password">            
            <input name="new-password" type="text" placeholder="new password">            
            <input name="confirm-password" type="text" placeholder="confirm new password">
            <button class="frmButtons">Change password</button>
        </form>
    </div>


    <div id="creditcardContainer">
        <h3>Register card</h3>
        <form id="frmRegisterCreditcard">
            <div><img class="creditcard" src="images/visa.png"><img class="creditcard" src="images/mastercard.png"></div>
            <select name="cardType" id="cardType">
                <option name="mastercard" value="mastercard">Mastercard</option>
                <option name="visa" value="visa">VISA</option>
            </select>
            <input name="iCreditCardNumber" type="text" placeholder="Credit Card Number">
            <input name="iCVV" type="text" placeholder="CVV number">
            <div><select name="expiryMonth" id="expiryMonth">
                <option name="march">March</option>
                <option name="april">April</option>
            </select>
            <select name="expiryYear" id="expiryYear">
                <option name="2019">2019</option>
                <option name="2020">2020</option>
            </select></div>
            <button class="frmButtons">Register Creditcard</button>
        </form>
    </div>


    <div id="blockCard">
        <h3>Cancel / Block Card </h3>
        <form id="frmBlockCard" action="">
            <input name="password" type="text" placeholder="Your password">
            <input name="confirm-password" type="text" placeholder="Confirm password">
            <button class="frmButtons">Block card</button>
        </form>
    </div>


    <div id="chat">
        <a href="chat?user=<?=$sUserId?>"><img id="chatIcon" src="images/bubble.png"></a>
    </div>

</div>



<?php 
    // $sLinkToScript = '<script src="js/one-page.js"></script>';
    $sLinkToScript = '<script src="js/profile.js"></script>';
    require_once 'loggedin-bottom.php';
?>

