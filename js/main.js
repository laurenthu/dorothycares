let buttonFullScreen = document.querySelector('.maximize');
let buttonClose = document.querySelector('.close');

buttonFullScreen.addEventListener('click', function () {
  let body = document.querySelector('body');
  if (!document.mozFullScreen && !document.webkitFullScreen) {
    if(body.requestFullScreen) {
      body.requestFullScreen();
    } else if(body.mozRequestFullScreen) {
      body.mozRequestFullScreen();
    } else if(body.webkitRequestFullScreen) {
      body.webkitRequestFullScreen();
    }
  }
}, false);

buttonClose.addEventListener('click', function() {
  location.reload();
}, false);


$(function() { // = $(document).ready(function(){})
  let userInstruction; // variable temporaire

  $(document).ready(function(){
    $('.user-input').attr('contentEditable',true);
    $('.terminal-symbol').on('click',function(){
      $('.user-input').focus();
    });
  });

  $(document).on('keydown',function(e){ // we detect keyboard entry

    $('.user-input').focus();

    if (e.key == 'Enter' && userInstruction != '') {

      userInstruction = $('.user-input').text(); // we save the current value
      console.log(userInstruction);

      $.ajax({
        url: './srv/ajax.php',
        type: 'POST',
        data: 'instruction=' + userInstruction,
        dataType : 'html',
        success: function(answer, status) { // answer include the answer return by the script
          $('.terminal-control').remove();
          $('<span class="request">' + userInstruction + '</span>').appendTo( $('.user-request').last() );
          $('<div class="answer">' + answer + '</span>').appendTo( $('.user-request').last() );
          $('<div class="instruction"></div>').appendTo( $('.terminal-content') );
          $('<div class="user-request"></div>').appendTo( $('.instruction').last() );
          $('<span class="user">dorothAI@becode</span><span class="symbol">:~$</span>').appendTo( $('.instruction .user-request').last() );
          $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo( $('.instruction .user-request').last() );
        },
        error: function(result, status, error) {
          $('.terminal-control').remove();
          $('<span class="request">' + userInstruction + '</span>').appendTo( $('.user-request').last() );
          $('<div class="answer">Sorry. There is a bug during the connection with me. Please try again!</span>').appendTo( $('.user-request').last() );
          $('<div class="instruction"></div>').appendTo( $('.terminal-content') );
          $('<div class="user-request"></div>').appendTo( $('.instruction').last() );
          $('<span class="user">dorothAI@becode</span><span class="symbol">:~$</span>').appendTo( $('.instruction .user-request').last() );
          $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo( $('.instruction .user-request').last() );
        },
        complete : function(result, status){
          console.log('Request complete ['+ status +']');
          window.scrollTo(0,document.body.scrollHeight);
          $('.user-input').attr('contentEditable',true);
          $('.terminal-symbol').on('click',function(){
            $('.user-input').focus();
          });
        },
      });

    }
  })



});
