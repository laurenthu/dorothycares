/*
----------------------------------------------------------------------
BERTRAND
----------------------------------------------------------------------
*/


/*
INTRO ANIMATIONS (ball & menu)
_______________________________
*/


// Hide ball on page load
$('.ball-menu-item').hide();

let dorothyBall = $('.dorothy-ball');
let menuOpen = false; // used to tell whether menu was clicked or not (acts as switch)
let message = document.querySelector('.welcome-message-style');
let welcomeMessageContainer = document.getElementById('welcomeMessageContainer');
let messageFirstTimeOpen = true;

// intro animation [Anime JS], "breathing" ball effect
let breathingBall = anime({
  targets: '.dorothy-ball',
  delay: 1500,
  translateX: ['-50%', '-50%'],
  translateY: ['50%', '50%'],
  scale: [1, 1.05],
  direction: 'alternate',
  easing: 'easeInOutQuad',
  duration: 1600,
  loop: true,
  autoplay: false
});


// $( window ).on( "load", function() {
  // on page load first make ball appear [Anime JS]
  anime({
    targets: '.dorothy-ball',
    translateX: '-50%',
    translateY: '50%',
    opacity: 1,
    scale: [0, 1],
    duration: 1000,
    easing: 'easeInOutBack',
    complete: breathingBall.play()
  });

  // When ball is clicked
  dorothyBall.click(function() {
    // pause the breathing animation to avoid problems with its loop property [Anime JS]
    breathingBall.pause();
    // then move ball to the bottom [Anime JS]
    anime({
      targets: '.dorothy-ball',
      bottom: '-130px',
      translateX: '-50%',
      translateY: '0%',
      duration: 1200,
      easing: 'easeOutElastic'
    });
    // create a timeline [Anime JS] to chain more animations
    let myTimeline = anime.timeline();

    // if menu isn't open do following:
    if (menuOpen === false) {
      welcomeMessageContainer.style.opacity = 0;
      menuOpen = true;
      // 'display block' (show) the menu (tiny balls)
      $('.ball-menu-item').show();
      // lay out the timeline [Anime JS]
      myTimeline
        .add({
          targets: '.menu-terminal',
          scale: [0, 1],
          offset: '+=500'
        })
        .add({
          targets: '.menu-profile',
          scale: [0, 1],
          offset: '-=950'
        })
        .add({
          targets: '.menu-info',
          scale: [0, 1],
          offset: '-=950'
        })
        .add({
          targets: '.menu-calendar',
          scale: [0, 1],
          offset: '-=950',
          complete: function(){
            if (messageFirstTimeOpen == true) {
              displayMessage();
              welcomeMessageContainer.style.opacity = 1;
              messageFirstTimeOpen = false;
            } else {
              displayMessage();
              welcomeMessageContainer.style.opacity = 1;
            }
          }
        });

    // if menu is open do following:
    } else {
      menuOpen = false;
      // lay out the timeline [Anime JS]
      myTimeline
        .add({
          targets: '.menu-terminal',
          scale: 0.4
        })
        .add({
          targets: '.menu-profile',
          scale: 0.4,
          offset: '-=850'
        })
        .add({
          targets: '.menu-info',
          scale: 0.4,
          offset: '-=850'
        })
        .add({
          targets: '.menu-calendar',
          scale: 0.4,
          offset: '-=850'
        })
        .add({
          targets: '.menu-terminal',
          scale: 0.4,
          translateX: '150%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack'
        })
        .add({
          targets: '.menu-profile',
          scale: 0.4,
          translateX: '100%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack'
        })
        .add({
          targets: '.menu-info',
          scale: 0.4,
          translateX: '-100%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack'
        })
        .add({
          targets: '.menu-calendar',
          scale: 0.4,
          translateX: '-150%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack',
          complete: function(){ // once all of these animations are completed run the following:
            $('.ball-menu-item').hide();
            $('.menu-terminal').css({transform: 'translateX(0%) translateY(0%)'});
            $('.menu-profile').css({transform: 'translateX(0%) translateY(0%)'});
            $('.menu-info').css({transform: 'translateX(0%) translateY(0%)'});
            $('.menu-calendar').css({transform: 'translateX(0%) translateY(0%)'});
          }
        })
    }
  });

  welcomeMessageContainer.addEventListener('click', function(){
    let myTimeline2 = anime.timeline();
    welcomeMessageContainer.style.opacity = 0;
    anime({
      targets: '.terminal',
      bottom: 0,
      duration: 2000,
      complete: function(){
        myTimeline2
        .add({
          targets: '.menu-terminal',
          scale: 0.4
        })
        .add({
          targets: '.menu-profile',
          scale: 0.4,
          offset: '-=850'
        })
        .add({
          targets: '.menu-info',
          scale: 0.4,
          offset: '-=850'
        })
        .add({
          targets: '.menu-calendar',
          scale: 0.4,
          offset: '-=850'
        })
        .add({
          targets: '.menu-terminal',
          scale: 0.4,
          translateX: '150%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack'
        })
        .add({
          targets: '.menu-profile',
          scale: 0.4,
          translateX: '100%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack'
        })
        .add({
          targets: '.menu-info',
          scale: 0.4,
          translateX: '-100%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack'
        })
        .add({
          targets: '.menu-calendar',
          scale: 0.4,
          translateX: '-150%',
          translateY: '400%',
          duration: 300,
          offset: '-=800',
          easing: 'easeInBack',
          complete: function(){ // once all of these animations are completed run the following:
            $('.ball-menu-item').hide();
            $('.menu-terminal').css({transform: 'translateX(0%) translateY(0%)'});
            $('.menu-profile').css({transform: 'translateX(0%) translateY(0%)'});
            $('.menu-info').css({transform: 'translateX(0%) translateY(0%)'});
            $('.menu-calendar').css({transform: 'translateX(0%) translateY(0%)'});
          }
        })
      }
      // translateY: [
      //   { value: -500, duration: 2000}, // Value is the position in pixel, duration in milliseconds
      // ],
    });
  });

// });


/*
MOUSE TRACKING ANIMATION [OPTIONAL]
_______________________________
*/



/*
WELCOME MESSAGE CENTRE PAGE
_______________________________
*/
function displayMessage () {
  let welcomeMessageSpan = document.querySelector('#welcomeMessageContainer h1 span');
  // array of different messages
  let messageArray = ["wanna talk?", "ask me anything.", "wanna chat?", "can I help you with anything?", "what's up?", "how's it going?"];
  // fetch message from messageArray at random
  let randomMessage = messageArray[Math.floor(Math.random() * messageArray.length)];
  // what will be displayed once user updated their profile
  // let messageGeneral = 'Hey fellow becoder,' + ' ' + randomMessage;
  // what will be displayed if user hasn't updated their profile
  let messageNoName = 'Hello stranger, I would love to know your name! You can do this by updating your profile page in the menu below.';
  // let messageWithName = 'Hello <span>FETCH NAME IN DB</span>, wanna talk?'; // Use this with DB (check with backend guys) and associate with this an array of more messages like 'it's good to see you again' or 'long time no see'

  // add random message as content in the h1
  welcomeMessageSpan.innerHTML = randomMessage;


  /* TO IMPLEMENT LATER:

  if (USER HAS UPDATED PROFILE) {
    welcomeMessageH1.innerHTML = messageGeneral;
  } else if(USER HAS NOT UPDATED PROFILE) {
    welcomeMessageH1.innerHTML = messageNoName;
  }
  */
}


/*
IDLE MESSAGE CENTRE PAGE [OPTIONAL]
_______________________________
*/

// When user is idle for too long, launch function below:
/*let inactivityTime = function () {
    let t;
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer; // catches touchscreen presses
    window.onclick = resetTimer; // catches touchpad clicks
    window.onscroll = resetTimer; // catches scrolling with arrow keys
    window.onkeypress = resetTimer;

    function display() {

    }

    function resetTimer() {
        clearTimeout(t);
        t = setTimeout(displayMessage, 3000);
    }
};*/






/*
----------------------------------------------------------------------
MIKEY
----------------------------------------------------------------------
*/

/*
Terminal animation (lighter version)
_______________________________
*/

// document.getElementById('terminal').onclick = function(){   // Select element button "close" onclick
//   // Anime.js change the value of the Y axis to create an animation
//   anime({
//     targets: 'main, terminal',              // The target to animate (only works with ID)
//     translateY: [                   // Affect the Y axis
//       { value: -500, duration: 2000},         // Value is the position in pixel, duration is the time the animation will take in millisecond
//     ],
//   });
// }


/*
Close button Function
_______________________________
*/

document.getElementById('close').onclick = function(){  // Select element button "close" onclick
  // Anime.js change the value of the Y axis to create an animation
  anime({
    targets: 'main, terminal',
    // The target to animate (only works with ID)
    translateY: [
    // Affect the Y axis
      { value: 700, duration: 2000},
      // Value is the position in pixel, duration is the time the animation will take in millisecond
    ],
  });
};

/*
Resize State Button Function
_______________________________
*/


let terminal = document.querySelector('#terminal');   // Variable terminal initialisation
let resizeBtn = document.querySelector('#maximize');  // Variable maximize initialisation
let resizeState = false;                // State variable

resizeBtn.addEventListener('click', function (){    // Function start on click on maximize button
  if (resizeState == false) {             // Condition to create toggle
    terminal.style.margin = "0 2.5vw";        // Change to new margin value
    terminal.style.width = "95%";         // Change to new width value
    terminal.style.top = "550px";         // Change to new top value
    resizeState = true;               // Change the state to true
  } else if (resizeState == true) {         // In other case if resizeState is = to true
    terminal.style.margin = "0 22.5vw";       // Change to margin default value
    terminal.style.width = "55%";         // Change to width default value
    terminal.style.top = "700px";         // Change to top pixel default value
    resizeState = false;              // Change the state to false
  };
})


/*
Particles animation
_______________________________
*/

let resizeReset = function() {
  w = canvasBody.width = window.innerWidth;
  h = canvasBody.height = window.innerHeight;
}

const opts = {
  particleColor: "rgb(255,255,255,1)",
  lineColor: "rgb(150,150,150,1)",
  particleAmount: 30,
  defaultSpeed: 0.01,
  variantSpeed: 0.3,
  defaultRadius: 0.5,
  variantRadius: 0.5,
  linkRadius: 200,
};

window.addEventListener("resize", function(){
  deBouncer();
});

let deBouncer = function() {
    clearTimeout(tid);
    tid = setTimeout(function() {
        resizeReset();
    }, delay);
};

let checkDistance = function(x1, y1, x2, y2){
  return Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
};

Particle = function(xPos, yPos){
  this.x = Math.random() * w;
  this.y = Math.random() * h;
  this.speed = opts.defaultSpeed + Math.random() * opts.variantSpeed;
  this.directionAngle = Math.floor(Math.random() * 360);
  this.color = opts.particleColor;
  this.radius = opts.defaultRadius + Math.random() * opts. variantRadius;
  this.vector = {
    x: Math.cos(this.directionAngle) * this.speed,
    y: Math.sin(this.directionAngle) * this.speed
  };
  this.update = function(){
    this.border();
    this.x += this.vector.x;
    this.y += this.vector.y;
  };
  this.border = function(){
    if (this.x >= w || this.x <= 0) {
      this.vector.x *= -1;
    }
    if (this.y >= h || this.y <= 0) {
      this.vector.y *= -1;
    }
    if (this.x > w) this.x = w;
    if (this.y > h) this.y = h;
    if (this.x < 0) this.x = 0;
    if (this.y < 0) this.y = 0;
  };
  this.draw = function(){
    drawArea.beginPath();
    drawArea.arc(this.x, this.y, this.radius, 0, Math.PI*2);
    drawArea.closePath();
    drawArea.fillStyle = this.color;
    drawArea.fill();
  };
};

function setup(){
  particles = [];
  resizeReset();
  for (let i = 0; i < opts.particleAmount; i++){
    particles.push( new Particle() );
  }
  window.requestAnimationFrame(loop);
}

function loop(){
  window.requestAnimationFrame(loop);
  drawArea.clearRect(0,0,w,h);
  for (let i = 0; i < particles.length; i++){
    particles[i].update();
    particles[i].draw();
  }
}

const canvasBody = document.getElementById("canvas"),
drawArea = canvasBody.getContext("2d");
let delay = 200, tid;
resizeReset();
setup();




/***********
* OLD MAIN *
***********/

let sessionId = Math.floor(Math.random() * Math.random() * 350000); // we generate a sessionId for dialogflow
const accessToken = '20070064bedf4ee7b077ef1ae9ea64c0'; // agent v1 - DorothyAngular
//const accessToken = 'c3fb78b0042f42cda2d1d28c9f682aae'; // agent v2 - DorothyCares
const baseUrl = 'https://api.dialogflow.com/v1/';
const version = '20170712';

function nl2br(str) {
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>' + '$2');
}

function addFirstZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

function date_time(selector) {
    let date = new Date;
    result = addFirstZero(date.getHours()) + ':' + addFirstZero(date.getMinutes()) + ':' + addFirstZero(date.getSeconds()) + '<br>';
    result += addFirstZero(date.getDate()) + '/' + addFirstZero(date.getMonth() + 1) + '/' + date.getFullYear();
    $(selector).html(result);
    setTimeout('date_time("' + selector + '");', '1000');
    return true;
}


$(function () { // = $(document).ready(function(){})
    let userInstruction; // variable temporaire

    $(document).ready(function () {
        date_time('.os-bar__date-time');
        $('.answer').first().hide();
        $('.instruction').last().hide();
        $('.answer').first().delay(1000).fadeIn();
        $('.instruction').last().delay(1050).fadeIn(100);
        $('.user-input').attr('contentEditable', true);
        $('.terminal-symbol').on('click', function () {
            $('.user-input').focus();
        });
    });

    $('.terminal-content').on('click', function (e) {
        $('.user-input').focus();
    });
    $(document).on('keydown', function (e) { // we detect keyboard entry

        $('.user-input').focus();
        userInstruction = $('.user-input').text(); // we save the current value

        if (e.key == 'Enter' && userInstruction != '') {
            e.preventDefault();
            $('.user-input').attr('contentEditable', false);
            //console.log(userInstruction);

            $.ajax({
                type: 'POST',
                url: baseUrl + 'query?v=' + version,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                headers: {
                    'Authorization': 'Bearer ' + accessToken
                },
                data: JSON.stringify({
                    query: userInstruction,
                    lang: "en",
                    sessionId: sessionId
                }),

                success: function (data, status) { // answer include the answer return by the script
                    answer = data.result.fulfillment.messages[0].speech;
                    answer = anchorme(nl2br(answer), {
                        attributes: [{
                            name: "target",
                            value: "_blank"
                        }],
                        files: false,
                        ips: false
                    });
                    if (typeof data.sessionId !== 'undefined') {
                      sessionId = data.sessionId;
                    }
                    //console.log(data);
                    $('.terminal-control').remove();
                    $('<span class="request">' + userInstruction + '</span>').appendTo($('.user-request').last());
                    $('<div class="answer">' + answer + '</span>').appendTo($('.user-request').last());
                    $('<div class="instruction"></div>').appendTo($('.terminal-content'));
                    $('<div class="user-request"></div>').appendTo($('.instruction').last());
                    $('<span class="user"></span><span class="symbol"></span>').appendTo($('.instruction .user-request').last());
                    $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo($('.instruction .user-request').last());
                },
                error: function (result, status, error) {
                    $('.terminal-control').remove();
                    $('<span class="request">' + userInstruction + '</span>').appendTo($('.user-request').last());
                    $('<div class="answer">Sorry. There is a bug in my brai. Please try again!</span>').appendTo($('.user-request').last());
                    $('<div class="instruction"></div>').appendTo($('.terminal-content'));
                    $('<div class="user-request"></div>').appendTo($('.instruction').last());
                    $('<span class="user"></span><span class="symbol"></span>').appendTo($('.instruction .user-request').last());
                    $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo($('.instruction .user-request').last());
                },
                complete: function (result, status) {
                    //console.log('Request complete [' + status + ']');
                    window.scrollTo(0, document.body.scrollHeight);
                    $('.user-input').attr('contentEditable', true);
                    $('.terminal-symbol').on('click', function () {
                        $('.user-input').focus();
                    });
                },
            });

        } else if (e.key == 'Enter' && userInstruction == '') {
          e.preventDefault();
        }
    })

});
