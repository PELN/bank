$('#frmLogin').submit( function(){
    console.log('logging in...')
      $.ajax({
        method:"POST",
        url:'apis/api-login',
        data:$('#frmLogin').serialize(),
        dataType:"JSON"
      }).
      done(function(jData){
        if(jData.status == 0){
          console.log(jData)
          swal({
            title:"Something went wrong", text:jData.message, icon: "warning",
          });
          return
        }
        
        if(jData.status == -1){
          console.log(jData.message)
          $('#loginAttemptsLeft').text(jData.message)
          return
        }
  
        // SUCCESS
        location.href = 'profile'
      }).
      fail(function(jData){
        // console.log(jData.responseText)
  
        swal({
          title:"Sorry, try again", text:jData.message, icon: "warning",
        });
  
      })
  
      return false
  
    });
  
  
    $('#frmSignup').submit(function(){
      console.log('signing up...')
      $.ajax({
          method: "POST",
          url: 'apis/api-signup',
          //key: whatever is in the form - convert the form to code that php will understand
          data: $('#frmSignup').serialize(),
          //return what? as json
          dataType: "JSON"
      }).
      done(function(jData){
          console.log(jData)
          if(jData.status == 1){
              swal({
                  title:"CONGRATS", text:"You have signed up", icon: "success",
                });
              return
          }
    
          if(jData.status == 0){
              swal({
                  title:"Oops something went wrong", text:jData.message, icon: "warning",
                });
              return
          }
      }).
      fail(function(jData){
          console.log('error')
          swal({
              title:"SYSTEM UPDATE", text:"System is under maintenance" +jData.code, icon: "warning",
            });
      })
      return false
    });
    