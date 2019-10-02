$('#frmAdminTransfer').submit( function(){
    console.log('transfering...')
  $.ajax({
    method : "POST",
    url : 'apis/api-admin-transfer.php',
    data :  $('#frmAdminTransfer').serialize(),
    dataType: "JSON"
  }).
  done( function(jData){

    if(jData.status == 1){
      console.log('*************')
      swal({
        title:"TRANSFER", text:"You have sent this amount: "+$('#txtTransferAmount').val()+" to this phone: "+$('#txtTransferToPhone').val(), icon: "success",
        });
    }

    if(jData.status == 0){
        swal({
            title:"Ooops! Something went wrong", text:jData.message, icon: "warning",
        });
    }

    }).
  fail( function(){
    console.log('FATAL ERROR')
  })
  
  return false
  })