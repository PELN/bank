//************************************************** 
//talk to the server and get the balance of the logged user
//check the balance every second with playing a function (setInterval)
function fnvGetBalance(){
  var money = new Audio('money.mp3')
  setInterval(function(){
    $.ajax({
      method: "GET",
      url: 'apis/api-get-balance',
      cache: false
    })//get a string, not json
    .done(function( sBalance ){
      // console.log(sBalance)
      // console.log($('#lblBalance').text() )
      //play sound if the balance changes
      if( sBalance != $('#lblBalance').text() ){
          $('#lblBalance').text(sBalance)
          money.play()
      }
    }).fail(function(){})

    $.ajax({
      method : "GET",
      url : 'apis/api-get-transactions-not-read',
      cache : false,
      dataType : "JSON"
    }).done(function( jTransactions ){
      // if there is a transaction not read, show it in html?
      for( let jTransactionKey in jTransactions ){
        console.log(jTransactionKey)
        let jTransaction = jTransactions[jTransactionKey] // get object from key
        let date = jTransaction.date
        let amount = jTransaction.amount
        let name = jTransaction.name
        let lastName = jTransaction.lastName
        let fromPhone = jTransaction.fromPhone
        let message = jTransaction.message
        
        // string literals
        let sTransactionTr = `
          <tr>
            <td>${jTransactionKey}</td>
            <td>${date}</td>
            <td>${amount}</td>
            <td>${name}</td>
            <td>${lastName}</td>
            <td>${fromPhone}</td>
            <td>${message}</td>
          </tr>
        ` 
        $('#lblTransactions').prepend(sTransactionTr)
        // Maybe display them slower
        swal({
          title:"TRANSFER", text:"You have received "+amount+ ' from: ' +name+' '+lastName+ ' ' +' with phone number: ' +fromPhone+ ' and message: ' +message, icon: "success",
        });
      }

    }).fail(function(){})
  }, 10000 )
}

fnvGetBalance()



$('#frmTransfer').submit( function(){
  console.log('transfering...')
$.ajax({
  method : "GET",
  url : 'apis/api-transfer',
  data :  {
            "phone": $('#txtTransferToPhone').val(),
            "amount": $('#txtTransferAmount').val(),
            "message": $('#txtTransferMessage').val()
          },
  cache: false,
  dataType:"JSON"
}).
done( function(jData){
  if(jData.status == -1){
    console.log(jData.message)
    swal({
      title:"Ooops! Something went wrong", text:jData.message, icon: "warning",
    });
  }
  //if the phone does not exit in my systemm, but still is valid - get list of banks 
  if(jData.status == 0){
    console.log('*************')
  } // end of 0 case
  if(jData.status == 1){
    console.log('*************')
    console.log(jData)
    // TODO: Continue with a local transfer
    swal({
      title:"TRANSFER", text:"You have sent this amount: "+$('#txtTransferAmount').val()+" to this phone: "+$('#txtTransferToPhone').val(), icon: "success",
    });
  }
  }).
fail( function(){
  console.log('FATAL ERROR')
})

return false
})


$('#frmUpdatePassword').submit(function(){
  console.log('updating password')
  $.ajax({
    method: "POST",
    url: 'apis/api-update-password',
    data: $('#frmUpdatePassword').serialize(),
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      // console.log(jData.responseText)
      swal({
          title:"PASSWORD", text:"HAS BEEN UPDATED", icon: "success",
        });
    }else{
      swal({
          // title:"SYSTEM UPDATE", text:"System is under maintenance", icon: "error",
          title:"Oops! Something went wrong", text:jData.message, icon: "warning",
        });
    }
    return
  }).
  fail(function(jData){
    console.log(jData)
  })
  return false
})


$('#frmUpdatePhone').submit(function(){
  console.log('updating phone')
  $.ajax({
    method: "POST",
    url: 'apis/api-update-phone',
    data: $('#frmUpdatePhone').serialize(),
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      // console.log(jData.responseText)
      swal({
          title:"PHONE", text:"HAS BEEN UPDATED", icon: "success",
        });
    }else{
      swal({
          // title:"SYSTEM UPDATE", text:"System is under maintenance", icon: "error",
          title:"Oops! Something went wrong", text:jData.message, icon: "warning",
        });
    }
    return
  }).
  fail(function(jData){
    console.log(jData)
  })
  return false
})


$('#frmUpdateEmail').submit(function(){
  console.log('updating email')

  $.ajax({
    method: "POST",
    url: 'apis/api-update-email',
    data: $('#frmUpdateEmail').serialize(),
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      // console.log(jData.responseText)
      swal({
          title:"EMAIL", text:"HAS BEEN UPDATED", icon: "success",
        });
      
        fnvGetEmail();

      }else{
      swal({
          // title:"SYSTEM UPDATE", text:"System is under maintenance", icon: "error",
          title:"Oops! Something went wrong", text:jData.message, icon: "warning",
        });
    }
    return
  }).
  fail(function(jData){
    console.log(jData)
  })
  return false
})

function fnvGetEmail(){
  setInterval(function(){
    $.ajax({
      method: "GET",
      url: 'apis/api-get-email',
      cache: false
    })//get a string, not json
    .done(function( sEmail ){
      // console.log(sEmail)
      if( sEmail != $('#lblEmail').text() ){
          $('#lblEmail').text(sEmail)
      }
      if( sEmail != $('#lblEmailProfile').text() ){
          $('#lblEmailProfile').text(sEmail)
      }
    }).fail(function(){})
  }, 1000 )
}


$('#frmRegisterCreditcard').submit(function(){
  console.log('registering creditcard')

  $.ajax({
    method: "POST",
    url: 'apis/api-register-creditcard',
    data: $('#frmRegisterCreditcard').serialize(),
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      console.log(jData.message)
      swal({
          title:"Creditcard registered", text:"You have succesfully registered your creditcard", icon: "success",
        });

    }else{
      swal({
          title:"Oops! Something went wrong", text:jData.message, icon: "warning",
        });
    }
    return
  }).
  fail(function(jData){
    console.log(jData)
  })
  return false
})


$('#frmBlockCard').submit(function(){
  console.log('blocking creditcard')
  $.ajax({
    method: "POST",
    url: 'apis/api-block-creditcard',
    data: $('#frmBlockCard').serialize(),
    cache: false,
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      swal({
        title:"BLOCKED CARD", text:jData.message, icon: "success",
      });
    }

    if(jData.status == 0){
      swal({
        title:"Oops! something went wrong", text:jData.message, icon: "warning",
      });
    }

  }).
  fail(function(jData){
    console.log(jData.responseText)
  })
  return false;
})



$('#frmCreateAccount').submit(function(){
  console.log('creating account...')

  $.ajax({
    method: "POST",
    url: 'apis/api-create-account',
    data: $('#frmCreateAccount').serialize(),
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      console.log(jData.message)
      swal({
          title:"Account created", text:"You have succesfully created an account", icon: "success",
        });
          
    }else{
      swal({
          // title:"SYSTEM UPDATE", text:"System is under maintenance", icon: "error",
          title:"Oops! Something went wrong", text:jData.message, icon: "warning",
        });
    }
    return
  }).
  fail(function(jData){
    console.log(jData)
  })
  return false
})


$('#frmApplyForLoan').submit(function(){
  console.log('applying for loan...')

  $.ajax({
    method: "POST",
    url: 'apis/api-apply-for-loan',
    data: $('#frmApplyForLoan').serialize(),
    dataType: "JSON"
  }).
  done(function(jData){
    if(jData.status == 1){
      console.log(jData.message)
      swal({
          title:"Account created", text:"You have succesfully applied for a loan", icon: "success",
        });
    }
      
    if(jData.status == 0){
      swal({
          // title:"SYSTEM UPDATE", text:"System is under maintenance", icon: "error",
          title:"Oops! Something went wrong", text:jData.message, icon: "warning",
        });
    }
  
  }).
  fail(function(jData){
    console.log(jData)
    
    swal({
      // title:"SYSTEM UPDATE", text:"System is under maintenance", icon: "error",
      title:"Oops! Something went wrong", text:jData.message, icon: "warning",
    });

  })
  return false
})


