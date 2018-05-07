// Elements selection and variables creation
let dataText = ''; // variable for the json response
let jwt = ''; // variable for the json web token


//Select the content tabs
let resourcesTab = document.querySelector('#resources');
let toolboxTab = document.querySelector('#toolbox');
let resourcesIcons = document.querySelector('#resourcesIcons');
let resourcesInfo = document.querySelector('#resourcesInfo');
let resourcesCardName = document.querySelector('#resourcesCardName');
let resourcesCardInfos = document.querySelector('#resourcesCardInfos');


//Select card-content
let cardName = document.querySelector('#cardName');
let cardDisplayName = document.querySelector('#cardDisplayName');
let cardIntro = document.querySelector('#cardIntro');
let cardInstallation = document.querySelector('#cardInstallation');
let cardDocumentation = document.querySelector('#cardDocumentation');
let cardTutorials = document.querySelector('#cardTutorials');
let cardExercices = document.querySelector('#cardExercices');
let cardExamples = document.querySelector('#cardExamples');
let cardNews = document.querySelector('#cardNews');



// AJAX requests
let feedphp = 'ajax.php';
let feednode = 'https://dorothycares.herokuapp.com/ressources/';
let dataRequestGetJWT = new XMLHttpRequest(); // open ajax request to get the json web token
let dataRequestDisplayResources = new XMLHttpRequest(); // open ajax request to display resources

function ajaxRequestGetJWT() { // ajax request
  dataRequestGetJWT.onload = whenDataLoadedGetJWT; // we assign the function to excecute when the data are loaded
  dataRequestGetJWT.open("GET", feedphp + '?dataToGet=JWT', false); // the type, the url, asynchronous true/false
  dataRequestGetJWT.send(null); // we send the request
};

function whenDataLoadedGetJWT() { // what happens when the AJAX request is done
  dataText = dataRequestGetJWT.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  return dataObject['response']['jwt']; // return the json web token
};

function ajaxRequestDisplayResources() { // ajax request
  dataRequestDisplayResources.onload = whenDataLoadedDisplayResources; // we assign the function to excecute when the data are loaded
  dataRequestDisplayResources.open("GET", feednode, true); // the type, the url, asynchronous true/false
  dataRequestDisplayResources.setRequestHeader('Authorization', 'Bearer ' + jwt);
  dataRequestDisplayResources.send(null); // we send the request
};

function whenDataLoadedDisplayResources() { // what happens when the AJAX request is done
  dataText = dataRequestDisplayResources.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  console.log(dataObject);

  let cardContent = '';

  if (dataObject['message'] != 'undefined') {
    dataObject['ressources'].forEach(function(el) {
      resourcesIcons.innerHTML += '<a data-id ="' + el._id + '" class="waves-effect waves-light btn red lighten-1">' + el.displayName + '</a>'; //display all resources names
      

      // if (resourcesCardName.innerHTML == '' && resourcesCardInfos.innerHTML == '') {
      //   resourcesCardName.innerHTML = '<b>' + el.displayName + '</b>';
  
      //   if (el.name != '' && el.displayName != '' && el.intro != '') {
      //     cardContent += '<div class="card-content"><span><b>Name : </b></span><p>' + el.name + '</p></div>';
      //     cardContent += '<div class="card-content"><span><b>Name displayed : </b></span><p>' + el.displayName + '</p></div>';
      //     cardContent += '<div class="card-content"><span><b>Introduction : </b></span><p>' + el.intro + '</p></div>';
      //   } else if (el.name == '') {
      //     cardContent += '<span><b>Name : </b></span><p>Empty</p>';
      //   } else if (el.displayName == '') {
      //     cardContent += '<span><b>Name displayed : </b></span><p>Empty</p>';
      //   } else if (el.intro == '') {
      //     cardContent += '<span><b>Introduction : </b></span><p>Empty</p>';
      //   }

      //   if (el.installation && el.documentation && el.tutorials && el.exercices && el.examples && el.news) {
          
      //   }

      // }
      
      // resourcesCardInfos.innerHTML = cardContent;
      // console.log(el['displayName']);
    });
    let btns = document.querySelectorAll('.btn');

    btns.forEach(function(btn, key) {

      btn.addEventListener('click', function(event) {
        let btnID = event.target.getAttribute('data-id');
        let contentCard = '';
        console.log(btnID);
        if (dataObject['message'] != 'undefined') {
          for (let i = 0; i < dataObject['ressources'].length; i++) {
    
            if (dataObject['ressources'][i]['_id'] == btnID) {
              resourcesCardName.innerHTML = dataObject['ressources'][i]['displayName'];
              cardName.innerHTML = dataObject['ressources'][i]['name'];
              cardDisplayName.innerHTML = dataObject['ressources'][i]['displayName'];
              cardIntro.innerHTML = dataObject['ressources'][i]['intro'];

              if (dataObject['ressources'][i]['installation'].length < 1) {
                cardInstallation.innerHTML = 'No installation needed.';
              }
              

              dataObject['ressources'][i]['installation'].forEach(function(el) {
                console.log('hello');

                for (const key in el) {
                  console.log(el[key].length);
                  if (el[key].length > 1) {
                    contentCard += key + ' : ' + el[key] + '<br>';
                  }
                }
                cardInstallation.innerHTML = contentCard;
                
              })
              console.log(dataObject['ressources'][i]['installation']);
    
            }
            
          }
        };
    
      })
    })




  } else {
    console.log('hello');
  };


};

// Event Listeners
window.addEventListener('load', function() { // implantations displayed on load
  jwt = ajaxRequestGetJWT(); // save the json web token in the variable we created for it
  ajaxRequestDisplayResources();
});


// Materialize
let tabs = document.querySelectorAll('.tabs'); // select tabs
var instanceTabs = M.Tabs.init(tabs); // Materialize tabs
