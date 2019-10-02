<?php

session_start();
$sUserId = $_SESSION['sUserId'];

//open the file to get the keys inside json obj.
$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if($jData == null){ echo 'system update'; }

//make a variable jInnerData, which contains the 'data' obj.
$jInnerData = $jData->data;

// foreach( $jInnerData as $sUserId => $jClient ){
//     echo $sUserId;
// }

require_once 'admin-loggedin-top.php';
?>

<div id="profile" class="page">

    <div id="infoContainer">
        <h1>Profile</h1>
        <p>Logged in as Admin</p>
  
        <div id="balance">
            <div><h3>BALANCE<h3></div>
            <span id="lblBalance"><?= $jInnerData->$sUserId->balance; ?></span>
        </div>
  
    </div>
        

    <div id="transferContainer">
        <h1>Transfer</h1>
        <form id="frmAdminTransfer">
            <input name="txtTransferToPhone" id="txtTransferToPhone" type="text" placeholder="transfer to phone">
            <input name="txtTransferAmount" id="txtTransferAmount" type="text" placeholder="transfer amount">
            <input name="txtTransferMessage" id="txtTransferMessage" type="text" placeholder="transfer message">
            <button class="frmButtons">TRANSFER</button>
        </form>
    </div>

    <div id="chat">
        <a href="chat?user=30000000"><img id="chatIcon" src="images/bubble.png"></a>
    </div>
</div>


<div id="accounts" class="page">

    <h1>View all customers</h1>
    <div id="view-customers">
        <?php
            foreach( $jInnerData as $sAccountId => $jAccount ){
                $sWord = ($jAccount->active == 0) ? 'UNBLOCK' : 'BLOCK';

                echo "
                    <div>
                        <div>Phone: $sAccountId</div>
                        <div>Name: $jAccount->name</div>
                        <div>Last name: $jAccount->lastName</div>
                        <div>Email: $jAccount->email</div>
                        <div>Balance: $jAccount->balance</div>
                        <div>CPR: $jAccount->cpr</div>
                        <div>Active: $jAccount->active</div> <a href='admin-block-or-unblock-customer?id=$sAccountId'>$sWord</a>
                    </div>
                ";
            }
        ?>
    </div>

    <div id="chat">
        <a href="chat?user=30000000"><img id="chatIcon" src="images/bubble.png"></a>
    </div>

</div>

<div id="activity" class="page">

    <h1>Loans activity</h1>
    <div id="loansHistory">
        <?php
            foreach( $jInnerData as $sUserId => $jAccount ){
                // $jLoans = json_encode($jAccount->loans);

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

                    echo "
                        <div>
                            <div>Phone: $sUserId</div>
                            <div>ID: $sLoanId </div>
                            <div>Comment: $jLoan->comment </div>
                            <div>Amount: $jLoan->amount</div>
                            <div>Status: $sWord</div>
                            <div><a href='apis/api-admin-approve-loan?id=$sLoanId&user=$sUserId'>APPROVE</a></div>
                            <div><a href='apis/api-admin-decline-loan?id=$sLoanId&user=$sUserId'>DECLINE</a></div>
                        </div>
                    ";
                }
            }
        ?>
    </div>


    <div id="chat">
        <a href="chat?user=30000000"><img id="chatIcon" src="images/bubble.png"></a>
    </div>

</div>



<?php 
  
    require_once 'loggedin-bottom.php';
?>

