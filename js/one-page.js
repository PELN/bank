$('.page').hide();
$('#home').show()

if(window.location.href.indexOf("index#activation") > 0){
    console.log('show activation')
    $('.page').hide();
    $('#activation').show()
    console.log('show activation')
}


if(window.location.href.indexOf("profile") > 0) {
    $('.page').hide();
    $('#profile').show()
    console.log('show profile')
}


$('.navLink').click( function(){
    $('.navLink').removeClass('active') // remove the active
    $('.page').hide() // hide all pages
    $(this).addClass('active')
    let sPageToShow = $(this).attr('data-showPage') // get name of page to show
    $('#'+sPageToShow).show() // show page by # ID
  });


