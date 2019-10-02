<?php
  session_start();
  $sUserId = $_SESSION['sUserId'];
  // echo $sUserId;
  // $sUserId = $_GET['user'];
  // echo $sUserId;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>CHAT</title>
  <style>
    body{ 
      display: grid; 
      justify-items: center; 
      align-items: center;  
      width: 100vw; 
      height: 100vh; 
      overflow: hidden;
      font-size: 16px;
      color: white;
    }
    body > div{
        position: relative;
        width: 500px;
        height: 500px;
        /* border: 2px solid blue; */
        padding: 20px;
        background-color:#19426F;
        box-shadow: 10px 10px 53px -6px rgba(0,0,0,0.75);
        border-radius: 15px;
    }
    form{
      position: absolute;
      bottom: 20px;
    }

    button {
        border-radius: 15px;
        height: 30px;
        width: 250px;
        border: none;
        padding: 10px 10px 10px 10px;
        margin-top: 20px;
    }

    textarea, input { outline: none; }

    input[type=text]{
        border-radius: 15px;
        height: 30px;
        width: 250px;
        border: none;
        padding: 10px 10px 10px 10px;
    }

    input[name=txt-user-id]{
        /* border: 2px solid red !important; */
        width: 100px;
    }


  </style>
</head>
<body>

  <div>
    <div id="lblMessages">
    </div>

    <form>
      <input id="txt-user-id" name="txt-user-id" type="text" placeholder="Username" value="<?= $sUserId; ?>">
      <input name="txt-message" type="text" placeholder="Type your message..">
      <button>Send message</button>
    </form>
  </div>
  

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  
  <script>

    let sUserId = '<?= $sUserId; ?>'

    $('form').submit( function(){
      $.ajax({
        method: "POST",
        url: "apis/api-chat-set-messages",
        data: $('form').serialize(),
        cache: false
      }).
      done(function( sMessages ){
        console.log('done')
      }).
      fail(function(){

      })
      return false;
    })

    setInterval( function(){

      $.ajax({
        method: "GET",
        url: "apis/api-chat-get-messages?sUserId="+sUserId,
        cache: false
      }).
      done(function( sMessages ){
        $('#lblMessages').append('<div>'+sMessages+'</div>')
        

      }).
      fail(function(){
      })

    } , 1000 )

  

  </script>


</body>
</html>