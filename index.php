<?php
require_once 'loggedout-top.php';
?>


<div id="home" class="page">

<div id="welcomeBox">
  <h1>Welcome to Lee Bank</h1>
  
  <div id="knowBoxes">
    <div class="knowBox">
      <h4>What should you know before applying for a loan?</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc interdum lorem faucibus, pharetra ex lobortis, posuere leo.  </p>
      <button>READ MORE</button>
    </div>

    <div class="knowBox">
      <h4>What can we do for you as a client?</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc interdum lorem faucibus, pharetra ex lobortis, posuere leo. </p>
      <button>READ MORE</button>
    </div>
  </div>

</div> 

<div id="sellingPoints">
    <div class="pointBox">
      <div class="iconBox">
        <i class="fas fa-money-check"></i>
        <h3>REGISTER CARD</h3>
      </div>
    </div>

    <div class="pointBox">
      <div class="iconBox">
        <i class="fas fa-exchange-alt"></i>
        <h3>TRANSFER MONEY</h3>
      </div>
    </div>

    <div class="pointBox">
      <div class="iconBox">
        <i class="fas fa-piggy-bank"></i>
        <h3>CREATE ACCOUNTS</h3>
      </div>
    </div>

    <div class="pointBox">
      <div class="iconBox">
        <i class="fas fa-hand-holding-usd"></i>
        <h3>APPLY FOR LOAN</h3>
      </div>
    </div>
  </div>
  


  <!-- <div>
    <i class="fab fa-cc-mastercard"></i>
    <i class="fab fa-cc-visa"></i>
  <div>
 -->



</div>

<div id="signup" class="page">

<div class="formContainer">
   <h1>SIGNUP</h1>
   <form id="frmSignup" action="apis/api-signup" method="POST">
        <input name="txtSignupName" id="txtSignupName" type="text" placeholder="Name*"value="">
        <input name="txtSignupLastName" id="txtSignupLastName" type="text" placeholder="Last name*" value="">
        <input name="txtSignupEmail" id="txtSignupEmail" type="email" placeholder="Email*" value="">
        <input name="txtSignupCpr" id="txtSignupCpr" type="text" placeholder="CPR number*" value="">
        <input name="txtSignupPhone" id="txtSignupPhone" type="text" placeholder="Phone number*" value="" maxlength="8">
        <input name="txtSignupPassword" id="txtSignupPassword" type="text" placeholder="Password*" value="">
        <input name="txtSignupConfirmPassword" id="txtSignupConfirmPassword" type="text" placeholder="Type Password again*" value="">
        <button class="frmButtons">SIGNUP</button>
    </form>
  </div>
</div>

<div id="login" class="page">
  <div class="formContainer">
   <h1>LOGIN</h1>

   <div id="loginAttemptsLeft"></div>

   <form id="frmLogin" action="apis/api-login.php" method="POST">
        <input name="txtLoginPhone" id="txtLoginPhone" type="text" placeholder="Phone number*">
        <input name="txtLoginPassword" id="txtLoginPassword" type="text" placeholder="Password*">
        <button class="frmButtons">LOGIN</button>
      </form>
    </div>
    
    <div id="forgotPassword">
      <p>Forgot your password?</p>
        <form id="frmForgotPassword" action="apis/api-forgot-password.php" method="GET">
          <input name="txtForgotPhone" id="txtForgotPhone" type="text" placeholder="Phone number*">
          <button id="forgotBtn" class="frmButtons">RESET PASSWORD</button>
        </form>
    </div>
</div>


<div id="activation" class="page">
  <div class="formContainer">
    <h1>Your account has been activated, go to login</h1>
  </div>
</div>



<?php 
  // $sLinkToScript = '<script src="js/one-page.js"></script>';
  $sLinkToScript = '<script src="js/signup-and-login.js"></script>';
  // $sLinkToScript = '<script src="js/login.js"></script>';
  require_once 'loggedout-bottom.php';
?>

