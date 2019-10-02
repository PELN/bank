<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>BANK LEE ADMIN</title>    
<link rel="stylesheet" href="css/admin.css">
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

  nav a{
    color: white;
    text-decoration: none;
  }

  nav{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;

    position: fixed;
    top: 0px; left: 0px;
    width: 100vw;
    height: 75px;
    padding: 0px 15% 0px 15%;
    font-size: 22px;
    color: white;
    background-color:#19426F;
    border-bottom: 1px solid white;
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
  } 

  /************************************************************/
  .page{
    position: absolute;
    top: 75px; left: 0px;
    padding: 50px 15%;
    display: none;
  }
  /************************************************************/

  #chatIcon{
    width: 50px;
    position: fixed;
    bottom: 10%;
    right: 5%;
  }

  #logo{
    width: 50px;
  }
</style>
</head>

<body>

<nav>
  <div><img id="logo" src="images/bank.png"></div>
    <div class="navLink active" data-showPage="profile">PROFILE</div>
    <div class="navLink" data-showPage="accounts">ACCOUNTS</div>
    <div class="navLink" data-showPage="activity">ACTIVITY</div>
    <div class="navLink" data-showPage="logout"><a href="logout">LOGOUT</a></div>
</nav>


