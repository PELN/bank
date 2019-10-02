<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>BANK LEE</title>    
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="css/forms.css">
<link rel="stylesheet" href="css/home.css">


<style>
*{
    margin: 0px;
    padding: 0px;
    box-sizing: border-box;
  }
  body{
    width: 100vw;
    height: 100vh;
    font-size: 16px;
    overflow: hidden;
    overflow-y: scroll;
    background-color: white;
    font-family: "Avenir";
  }
  nav{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;

    position: fixed;
    top: 0px; left: 0px;
    width: 100vw;
    height: 75px;
    padding: 0px 15% 0px 15%;
    font-size: 22px;
    color: white;
    /* background-image: linear-gradient(#027AC9, #19426F); */
    background-color:#19426F;
    z-index: 1;
  }
  nav div.active{
    background-color: rgba(0,0,0,.1);
  }
  nav > div{
    display: grid;
    justify-content: center;
    align-content: center;
    cursor: pointer;
    /* background-color: rgba(0,0,0,.7); */
  } 
  /************************************************************/
  .page{
    position: absolute;
    top: 75px; left: 0px;
    padding: 20px 15%;
    display: none;
  }
  /************************************************************/


  #loginAttemptsLeft{
    padding: 20px 20px 20px 20px;
  }

  #logo {
    width: 50px;
  }

  h1{
    color:#19426F;
    font-weight: 300;
    padding-top: 30px;
    padding-bottom: 20px;
  }

</style>
</head>

<body>

<nav>
    <div><img id="logo" src="images/bank.png"></div>
    <div class="navLink active" data-showPage="home">HOME</div>
    <div class="navLink " data-showPage="signup">SIGNUP</div>
    <div class="navLink" data-showPage="login">LOGIN</div>
  </nav>

