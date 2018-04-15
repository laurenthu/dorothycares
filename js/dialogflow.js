/*
----------------------------------------------------------------------
Laurent
----------------------------------------------------------------------
*/

function asciiToHex(str) {
  let arr1 = [];
  for (let n = 0, l = str.length; n < l; n ++) {
    let hex = Number(str.charCodeAt(n)).toString(16);
    arr1.push(hex);
  }
  return arr1.join('');
}

function hexToAscii(hexa) {
  hexa = hexa.toString();//force conversion
  let str = '';
  for (let i = 0; (i < hexa.length && hexa.substr(i, 2) !== '00'); i += 2)
    str += String.fromCharCode(parseInt(hexa.substr(i, 2), 16));
  return str;
}


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
    let date = new Date();
    result = addFirstZero(date.getHours()) + ':' + addFirstZero(date.getMinutes()) + ':' + addFirstZero(date.getSeconds()) + '<br>';
    result += addFirstZero(date.getDate()) + '/' + addFirstZero(date.getMonth() + 1) + '/' + date.getFullYear();
    document.querySelector(selector).innerHTML = result;
    setTimeout('date_time("' + selector + '");', '1000');
    return true;
}


document.addEventListener('DOMContentLoaded', function() {
    let userInstruction; // variable temporaire
    //const accessToken = '20070064bedf4ee7b077ef1ae9ea64c0'; // agent v1 - DorothyAngular
    const accessToken = 'c3fb78b0042f42cda2d1d28c9f682aae'; // agent v2 - DorothyCares
    const baseUrl = 'https://api.dialogflow.com/v1/';
    const version = '20170712';
    let emailUser = document.querySelector('body').getAttribute('data-email');
    let tokenUser = document.querySelector('body').getAttribute('data-token');
    let sessionId = document.querySelector('body').getAttribute('data-dialogflow-session');
    console.log(sessionId);

    date_time('.os-bar__date-time');
    document.querySelector('.user-input').setAttribute('contentEditable', true);
    document.querySelector('.user-input').focus();
    document.querySelector('.terminal-symbol').addEventListener('click', function () {
      document.querySelector('.user-input').focus();
    });

    document.addEventListener('keydown', function (e) { // we detect keyboard entry

        document.querySelector('.user-input').focus();
        userInstruction = document.querySelector('.user-input').textContent; // we save the current value

        if (e.key == 'Enter' && userInstruction != '') {
            e.preventDefault();
            document.querySelector('.user-input').setAttribute('contentEditable', false);
            document.querySelector('.terminal-control').parentNode.removeChild(document.querySelector('.terminal-control'));

            let span = document.createElement("span");
            span.classList.add("request");
            document.querySelectorAll('.user-request')[document.querySelectorAll('.user-request').length - 1].appendChild(span);
            span.innerHTML = '<span class="request">' + userInstruction + '</span>';

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
                emailUser: emailUser,
                tokenUser: tokenUser,
                sessionId: sessionId
              }),

              success: function (data, status) { // answer include the answer return by the script
                console.log(data);
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

                $('<div class="answer">' + answer + '</span>').appendTo($('.user-request').last());
                $('<div class="instruction"></div>').appendTo($('.terminal-content'));
                $('<div class="user-request"></div>').appendTo($('.instruction').last());
                $('<span class="user"></span><span class="symbol"></span>').appendTo($('.instruction .user-request').last());
                $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo($('.instruction .user-request').last());
              },
              error: function (result, status, error) {
                $('<div class="answer">Sorry. There is a bug in my brain. Please try again!</span>').appendTo($('.user-request').last());
                $('<div class="instruction"></div>').appendTo($('.terminal-content'));
                $('<div class="user-request"></div>').appendTo($('.instruction').last());
                $('<span class="user"></span><span class="symbol"></span>').appendTo($('.instruction .user-request').last());
                $('<span class="terminal-control"><div class="user-input"></div><span class="terminal-symbol">_</span></span>').appendTo($('.instruction .user-request').last());
              },
              complete: function (result, status) {
                window.scrollTo(0, document.body.scrollHeight);
                document.querySelector('.user-input').setAttribute('contentEditable', true);
                document.querySelector('.terminal-symbol').addEventListener('click', function () {
                  document.querySelector('.user-input').focus();
                });
              },
            });

        } else if (e.key == 'Enter' && userInstruction == '') {
          e.preventDefault();
        }
    })

});
