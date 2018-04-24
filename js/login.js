/*
TEXT SCRAMBLE
_______________________________
*/

class TextScramble {
  constructor(el) {
    this.el = el
    this.chars = '!<>-_\\/[]{}—=+*^?#________'
    this.update = this.update.bind(this)
  }
  setText(newText) {
    const oldText = this.el.innerText
    const length = Math.max(oldText.length, newText.length)
    const promise = new Promise((resolve) => this.resolve = resolve)
    this.queue = []
    for (let i = 0; i < length; i++) {
      const from = oldText[i] || ''
      const to = newText[i] || ''
      const start = Math.floor(Math.random() * 40)
      const end = start + Math.floor(Math.random() * 40)
      this.queue.push({
        from,
        to,
        start,
        end
      })
    }
    cancelAnimationFrame(this.frameRequest)
    this.frame = 0
    this.update()
    return promise
  }
  update() {
    let output = ''
    let complete = 0
    for (let i = 0, n = this.queue.length; i < n; i++) {
      let {
        from,
        to,
        start,
        end,
        char
      } = this.queue[i]
      if (this.frame >= end) {
        complete++
        output += to
      } else if (this.frame >= start) {
        if (!char || Math.random() < 0.28) {
          char = this.randomChar()
          this.queue[i].char = char
        }
        output += `<span class="dud">${char}</span>`
      } else {
        output += from
      }
    }
    this.el.innerHTML = output
    if (complete === this.queue.length) {
      this.resolve()
    } else {
      this.frameRequest = requestAnimationFrame(this.update)
      this.frame++
    }
  }
  randomChar() {
    return this.chars[Math.floor(Math.random() * this.chars.length)]
  }
}

const phrases = [
  'Hello!',
  'My name is Dorothy.',
  'Who are you?'
]

const el = document.querySelector('.welcome')
const fx = new TextScramble(el)

let counter = 0
const next = () => {
  fx.setText(phrases[counter]).then(() => {
    setTimeout(next, 800)
  })
  counter = (counter + 1) % phrases.length
}

next();

/*
GOOGLE SIGN IN
_______________________________
*/
let googleButton = document.querySelector(".google-button");
let relocation = googleButton.getAttribute("data-location");
//console.log(relocation);

googleButton.addEventListener('click', function () {
  window.location = relocation;
});

/*
BUTTON HOVER EFFECT
_______________________________
*/

document.querySelector('.call-to-action').onmousemove = function (e) {

  var x = e.pageX - e.target.offsetLeft;
  var y = e.pageY - e.target.offsetTop;

  e.target.style.setProperty('--x', x + 'px');
  e.target.style.setProperty('--y', y + 'px');
};

/*
EMPTY REQUEST TO WAKE UP HEROKU
_______________________________
*/
let wakeUpRequest = new XMLHttpRequest();

function wakeUpRequestFunction() { // what happens when the AJAX request is done
  console.log('Hello Heroku, it\'s time to wake up!')
};

wakeUpRequest.onload = wakeUpRequestFunction; // we assign the function to excecute when the data are loading
wakeUpRequest.open("GET", 'https://dorothycares.herokuapp.com/ressources/nodejs', true); // the type, the url, asynchronous true/false
wakeUpRequest.send(null); // we send the request
