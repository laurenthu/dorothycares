let buttonFullScreen = document.querySelector('.maximize');
let buttonClose = document.querySelector('.close');
let buttonMicro = document.querySelector('.os-bar__micro');
let buttonVolume = document.querySelector('.os-bar__volume');
let buttonLanguages = document.querySelector('.os-bar__language');
let sliderContainer = document.querySelector('.slider-container');
let sliderVolumeIcon = document.querySelector('.slider-container .volume-icon');
let audioslider = document.getElementById("audioRange");
let audioLevelDisplay = document.getElementById("volume-level");
let audioLevelBeforeMute = 0;
let languagesContainer = document.querySelector('.languages-container');
let languagesItems = document.querySelectorAll('.languages-container div');
let languagesItemsIcon = document.querySelectorAll('.languages-container div i');
const accessToken = 'c3fb78b0042f42cda2d1d28c9f682aae';
const baseUrl = 'https://api.dialogflow.com/v1/';
const version = '20170712';

buttonFullScreen.addEventListener('click', function () {
    let body = document.querySelector('body');
    if (!document.mozFullScreen && !document.webkitFullScreen) {
        if (body.requestFullScreen) {
            body.requestFullScreen();
        } else if (body.mozRequestFullScreen) {
            body.mozRequestFullScreen();
        } else if (body.webkitRequestFullScreen) {
            body.webkitRequestFullScreen();
        }
    }
}, false);

buttonClose.addEventListener('click', function () {
    location.reload();
}, false);

function nl2br(str) {
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + '<br>' + '$2');
}

function addFirstZero(i) {
    if (i < 10) {
        i = '0' + i;
    }
    return i;
}

buttonMicro.addEventListener('click', function () {
    if (buttonMicro.querySelector('.fa').classList.contains('fa-microphone-slash')) {
        buttonMicro.querySelector('.fa').classList.remove('fa-microphone-slash');
        buttonMicro.querySelector('.fa').classList.add('fa-microphone');
    } else {
        buttonMicro.querySelector('.fa').classList.remove('fa-microphone');
        buttonMicro.querySelector('.fa').classList.add('fa-microphone-slash');
    };
});

buttonVolume.addEventListener('click', function () {
    if (sliderContainer.style.visibility == "hidden") {
        sliderContainer.style.visibility = "visible";
    } else {
        sliderContainer.style.visibility = "hidden";
    };
});

$('body').click(function (evt) {
    if (!$(evt.target).is('.slider-container') && !$(evt.target).is('.slider-container *') && !$(evt.target).is('.os-bar__volume i') && !$(evt.target).is('.os-bar__volume')) {
        if (sliderContainer.style.visibility == "visible") {
            sliderContainer.style.visibility = "hidden";
        };
    };
});

audioLevelDisplay.innerHTML = audioslider.value;

function updateVolumeIcon() {
    if (audioslider.value > 50) {
        buttonVolume.querySelector('.fa').classList.remove('fa-volume-off', 'fa-volume-down');
        buttonVolume.querySelector('.fa').classList.add('fa-volume-up');
        sliderVolumeIcon.querySelector('.fa').classList.remove('fa-volume-off', 'fa-volume-down');
        sliderVolumeIcon.querySelector('.fa').classList.add('fa-volume-up');
    } else if (audioslider.value > 0) {
        buttonVolume.querySelector('.fa').classList.remove('fa-volume-off', 'fa-volume-up');
        buttonVolume.querySelector('.fa').classList.add('fa-volume-down');
        sliderVolumeIcon.querySelector('.fa').classList.remove('fa-volume-off', 'fa-volume-up');
        sliderVolumeIcon.querySelector('.fa').classList.add('fa-volume-down');
    } else {
        buttonVolume.querySelector('.fa').classList.remove('fa-volume-down', 'fa-volume-up');
        buttonVolume.querySelector('.fa').classList.add('fa-volume-off');
        sliderVolumeIcon.querySelector('.fa').classList.remove('fa-volume-down', 'fa-volume-up');
        sliderVolumeIcon.querySelector('.fa').classList.add('fa-volume-off');
    };
};

audioslider.oninput = function () {
    audioLevelDisplay.innerHTML = this.value;
    updateVolumeIcon();
};

sliderVolumeIcon.addEventListener('click', function () {
    if (audioslider.value != 0) {
        audioLevelBeforeMute = audioslider.value;
        audioslider.value = 0;
    } else {
        audioslider.value = audioLevelBeforeMute;
    };
    audioLevelDisplay.innerHTML = audioslider.value;
    updateVolumeIcon();
});

buttonLanguages.addEventListener('click', function () {
    if (languagesContainer.style.visibility == "hidden") {
        languagesContainer.style.visibility = "visible";
    } else {
        languagesContainer.style.visibility = "hidden";
    };
});

$('body').click(function (evt) {
    if (!$(evt.target).is('.languages-container') && !$(evt.target).is('.languages-container *') && !$(evt.target).is('.os-bar__language')) {
        if (languagesContainer.style.visibility == "visible") {
            languagesContainer.style.visibility = "hidden";
        };
    };
});

for (i = 0; i < languagesItems.length; i++) {
    languagesItems[i].addEventListener('click', function () {
        languagesItemsIcon.forEach(function (icon) {
            icon.classList.remove('fa-check-circle');
            icon.classList.add('fa-circle');
        });
        this.querySelector('i').classList.remove('fa-circle');
        this.querySelector('i').classList.add('fa-check-circle');
        buttonLanguages.innerHTML = this.querySelector('span').innerHTML;
    });
}

function date_time(selector) {
    let date = new Date;
    let year = date.getFullYear();
    let month = date.getMonth();
    let d = date.getDate();
    let h = date.getHours();
    let m = date.getMinutes();
    let s = date.getSeconds();
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
            let randomNumber = Math.floor(Math.random() * 35000);
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
                    sessionId: randomNumber
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
                    $('.terminal-control').remove();
                    $('<span class="request">' + userInstruction + '</span>').appendTo($('.user-request').last());
                    $('<div class="answer">' + answer + '</span>').appendTo($('.user-request').last());
                    $('<div class="instruction"></div>').appendTo($('.terminal-content'));
                    $('<div class="user-request"></div>').appendTo($('.instruction').last());
                    $('<span class="user">dorothAI@becode</span><span class="symbol">:~$</span>').appendTo($('.instruction .user-request').last());
                    $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo($('.instruction .user-request').last());
                },
                error: function (result, status, error) {
                    $('.terminal-control').remove();
                    $('<span class="request">' + userInstruction + '</span>').appendTo($('.user-request').last());
                    $('<div class="answer">Sorry. There is a bug in my brai. Please try again!</span>').appendTo($('.user-request').last());
                    $('<div class="instruction"></div>').appendTo($('.terminal-content'));
                    $('<div class="user-request"></div>').appendTo($('.instruction').last());
                    $('<span class="user">dorothAI@becode</span><span class="symbol">:~$</span>').appendTo($('.instruction .user-request').last());
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

particlesJS("particles-js", {
    "particles": {
        "number": {
            "value": 200,
            "density": {
                "enable": true,
                "value_area": 800
            }
        },
        "color": {
            "value": "#1e5799"
        },
        "shape": {
            "type": "circle",
            "stroke": {
                "width": 0,
                "color": "#000000"
            },
            "polygon": {
                "nb_sides": 5
            },
            "image": {
                "src": "img/github.svg",
                "width": 100,
                "height": 100
            }
        },
        "opacity": {
            "value": 1,
            "random": true,
            "anim": {
                "enable": true,
                "speed": 1,
                "opacity_min": 0,
                "sync": false
            }
        },
        "size": {
            "value": 3,
            "random": true,
            "anim": {
                "enable": false,
                "speed": 4,
                "size_min": 0.3,
                "sync": false
            }
        },
        "line_linked": {
            "enable": false,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 1,
            "direction": "none",
            "random": true,
            "straight": false,
            "out_mode": "out",
            "bounce": false,
            "attract": {
                "enable": false,
                "rotateX": 600,
                "rotateY": 600
            }
        }
    },
    "interactivity": {
        "detect_on": "canvas",
        "events": {
            "onhover": {
                "enable": false,
                "mode": "bubble"
            },
            "onclick": {
                "enable": true,
                "mode": "push"
            },
            "resize": true
        },
        "modes": {
            "grab": {
                "distance": 400,
                "line_linked": {
                    "opacity": 1
                }
            },
            "bubble": {
                "distance": 250,
                "size": 0,
                "duration": 2,
                "opacity": 0,
                "speed": 3
            },
            "repulse": {
                "distance": 400,
                "duration": 0.4
            },
            "push": {
                "particles_nb": 4
            },
            "remove": {
                "particles_nb": 2
            }
        }
    },
    "retina_detect": true
});
