// Elements selection and variables creation
let dataText = ''; // variable for the json response
let jwt = ''; // variable for the json web token
let i = 0; //variable for the GET request
let contentCard = ''; //variable for the GET request

// Select the content tabs
let resourcesTab = document.querySelector('#resources');
let toolboxTab = document.querySelector('#toolbox');
let resourcesIcons = document.querySelector('#resourcesIcons');
let resourcesInfo = document.querySelector('#resourcesInfo');
let resourcesCardName = document.querySelector('#resourcesCardName');
let resourcesCardInfos = document.querySelector('#resourcesCardInfos');

// Select card-content
let cardName = document.querySelector('#cardName');
let cardDisplayName = document.querySelector('#cardDisplayName');
let cardIntro = document.querySelector('#cardIntro');
let cardInstallation = document.querySelector('#cardInstallation');
let cardDocumentation = document.querySelector('#cardDocumentation');
let cardTutorials = document.querySelector('#cardTutorials');
let cardExercices = document.querySelector('#cardExercices');
let cardExamples = document.querySelector('#cardExamples');
let cardNews = document.querySelector('#cardNews');

// Select buttons for pagination
let pagination = document.querySelector('#pagination');
let addPageNumber = document.querySelector('#addPageNumber');
let type;
let start;
let itemPerPage;
let resourcesCount;
let resourcesNbrResults;
let resourcesPageCount;
let resourcePage = '';


// Initialize writing function
function setDefaultCard(object, card) { //Initialize function to write inside HTML
  dataObject['ressources'][0][object].forEach(function(el) { //loop through the first object in the ressources json 
    for (const key in el) { //loop though elements inside the first object to get the key and the value
      if (el[key] == '') { //check if the value of the key element is empty
        contentCard += '<b>' + key + '</b> : <br>Empty<br><br>'; //write empty
      } else { //otherwise
        contentCard += '<b>' + key + '</b> : <br>' + el[key] + '<br><br>'; //add a string which contains the key and value inside a variable
      }
    }
    
  })
  card.innerHTML = contentCard; //write all keys and values inside the html
  contentCard = ''; //empty the variable for the next use
}

function writeEmptyCard(object, card, message) { //Initialize function to write inside HTML
  if (dataObject['ressources'][i][object] < 1) { //check if the object is empty
    card.innerHTML = '<p>' + message + '</p>'; //write empty
  }
}

function writeInfoCard(object, card) { //Initialize function to write inside HTML
  dataObject['ressources'][i][object].forEach(function(el) { //loop through all the object in the ressources json 
    for (const key in el) { //loop though elements inside the first object to get the key and the value
      if (el[key] == '') { //check if the value of the key element is empty
        contentCard += '<b>' + key + '</b> : <br>Empty<br><br>'; //write empty
      } else { //otherwise
        contentCard += '<b>' + key + '</b> : <br>' + el[key] + '<br><br>'; //add a string which contains the key and value inside a variable
      }
    }
    card.innerHTML = contentCard; //write all keys and values inside the html
    contentCard = ''; //empty the variable for the next use
  })
}

//Pagination function
function getResourcePage () {
  resourcePage = document.querySelectorAll('.resourcePage li');
  return resourcePage;
}

function previousButtonDisableOrEnable(range) { // handle previous button usability
  if (range[1].classList.contains('active')) {
    range[0].classList.add('disabled');
    range[0].classList.remove('waves-effect');
  } else {
    range[0].classList.remove('disabled');
    range[0].classList.add('waves-effect');
  };
};

function nextButtonDisableOrEnable(range) { // handle next button usability
  if (range[range.length - 2].classList.contains('active')) {
    range[range.length - 1].classList.add('disabled');
    range[range.length - 1].classList.remove('waves-effect');
  } else {
    range[range.length - 1].classList.remove('disabled');
    range[range.length - 1].classList.add('waves-effect');
  };
};

function resetPaginationClasses(range) { // reset classes attributions before switching page
  range[i].classList.remove('active');
  range[i].classList.add('waves-effect');
};

function paginationNumbers(range) { // handle the pagination when you click on page numbers
  console.log(range);
  for (i = 1; i < (range.length - 1); i++) {
    range[i].addEventListener('click', function() {
      for (i = 1; i < (range.length - 1); i++) {
        resetPaginationClasses(range);
      };
      this.classList.add('active');
      this.classList.remove('waves-effect');
      previousButtonDisableOrEnable(range);
      nextButtonDisableOrEnable(range);
      ajaxRequestDisplayResources(range); // refresh display
    });
  };
};

function previousPage(range) { // handle what happens when you use the "previous" button
  range[0].addEventListener('click', function() {
    for (i = 1; i < (range.length - 1); i++) {
      if (range[i].classList.contains('active') && !range[0].classList.contains('disabled')) {
        resetPaginationClasses(range);
        range[i - 1].classList.add('active');
        range[i - 1].classList.remove('waves-effect');
      };
      previousButtonDisableOrEnable(range);
      nextButtonDisableOrEnable(range);
    };
    ajaxRequestDisplayResources(range); // refresh display
  });
};

function nextPage(range) { // // handle what happens when you use the "next" button
  range[range.length - 1].addEventListener('click', function() {
    for (i = (range.length - 1); i > 0; i--) {
      if (range[i].classList.contains('active') && !range[range.length - 1].classList.contains('disabled')) {
        resetPaginationClasses(range);
        range[i + 1].classList.add('active');
        range[i + 1].classList.remove('waves-effect');
      };
      nextButtonDisableOrEnable(range);
      previousButtonDisableOrEnable(range);
    };
    ajaxRequestDisplayResources(range); // refresh display
  });
};

function startResults(range) { // Define from which position the results are dislayed
  for (i = 1; i < (range.length - 1); i++) {
    if (range[i].classList.contains('active')) {
      return range[i].getAttribute('data-start');
    };
  };
};

function paginationDisplay(range) { // Global pagination of a type
  paginationNumbers(range);
  previousPage(range);
  nextPage(range);
};


// AJAX requests
let feedphp = 'ajax.php';
let feednode = 'https://dorothycares.herokuapp.com/ressources/';
let dataRequestGetJWT = new XMLHttpRequest(); // open ajax request to get the json web token
let dataRequestDisplayResources = new XMLHttpRequest(); // open ajax request to display resources
let dataRequestCreateResources = new XMLHttpRequest();

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

  if (dataObject['message'] != 'undefined') { //check if the ressources is defined or not

    dataObject['ressources'].forEach(function(el) { //loop through the ressources json to get all elements
      resourcesCardName.innerHTML = dataObject['ressources'][0]['displayName']; //write the ressources displayName inside HTML 
      cardName.innerHTML = dataObject['ressources'][0]['name']; //write the ressources name inside HTML 
      cardDisplayName.innerHTML = dataObject['ressources'][0]['displayName']; //write the ressources displayName inside HTML 
      cardIntro.innerHTML = dataObject['ressources'][0]['intro']; //write the ressources introduction inside HTML 
      setDefaultCard('installation', cardInstallation); //call function to write the installation object from the first json element
      setDefaultCard('documentation', cardDocumentation); //call function to write the documentation object from the first json element
      setDefaultCard('tutorials', cardTutorials); //call function to write the tutorials object from the first json element
      setDefaultCard('exercices', cardExercices); //call function to write the exercices object from the first json element
      setDefaultCard('examples', cardExamples); //call function to write the examples object from the first json element
      setDefaultCard('news', cardNews); //call function to write the news object from the first json element

    });

  } else {
    console.log('hello');
  };

};


function ajaxRequestCreateResources() { // ajax request
  dataRequestCreateResources.onload = whenDataLoadedCreateResources; // we assign the function to excecute when the data are loaded
  dataRequestCreateResources.open("GET", feednode, true); // the type, the url, asynchronous true/false
  dataRequestCreateResources.setRequestHeader('Authorization', 'Bearer ' + jwt);
  dataRequestCreateResources.send(null); // we send the request
};

function whenDataLoadedCreateResources() {
  dataText = dataRequestCreateResources.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  console.log(dataObject);

  if (dataObject['message'] != 'undefined') { //check if the ressources is defined or not
    
    resourcesCount = dataObject['count'];
    resourcesNbrResults = 10;
    resourcesPageCount = Math.ceil(resourcesCount/resourcesNbrResults);


    createPage();
    resourcePage = document.querySelectorAll('.resourcePage li');
    start = startResults(resourcePage); // define from which position the results are displayed (for example : from 11nth position)
    createBtns(resourcePage);
    console.log(resourcePage);
    paginationDisplay(resourcePage);

    let btns = document.querySelectorAll('.btn'); //Select all buttons created in resourcesIcons

    btns.forEach(function(btn, key) { //loop through all these buttons

      btn.addEventListener('click', function(event) { //on click, do the following process 
        let btnID = event.target.getAttribute('data-id'); //get the data-id of the button clicked

        for (i = 0; i < dataObject['ressources'].length; i++) { //loop through the ressources json
  
          if (dataObject['ressources'][i]['_id'] == btnID) { //check which resources id was called when the button was clicked
            resourcesCardName.innerHTML = dataObject['ressources'][i]['displayName']; //write the ressources displayName inside HTML 
            cardName.innerHTML = dataObject['ressources'][i]['name'];//write the ressources name inside HTML 
            cardDisplayName.innerHTML = dataObject['ressources'][i]['displayName'];//write the ressources displayName inside HTML 
            cardIntro.innerHTML = dataObject['ressources'][i]['intro'];//write the ressources introduction inside HTML 
            
            writeEmptyCard('installation', cardInstallation, 'No installation needed.'); //call function to write a message when the json object is empty
            writeEmptyCard('documentation', cardDocumentation, 'No documentation added.'); //call function to write a message when the json object is empty
            writeEmptyCard('tutorials', cardTutorials, 'No tutorials added.'); //call function to write a message when the json object is empty
            writeEmptyCard('exercices', cardExercices, 'No exercices added.'); //call function to write a message when the json object is empty
            writeEmptyCard('examples', cardExamples, 'No examples added.'); //call function to write a message when the json object is empty
            writeEmptyCard('news', cardNews, 'No news added.'); //call function to write a message when the json object is empty


            writeInfoCard('installation', cardInstallation); //call function to write the installation object from the clicked element
            writeInfoCard('documentation', cardDocumentation); //call function to write the documentation object from the clicked element
            writeInfoCard('tutorials', cardTutorials); //call function to write the tutorials object from the clicked element
            writeInfoCard('exercices', cardExercices); //call function to write the exercices object from the clicked element
            writeInfoCard('examples', cardExamples); //call function to write the examples object from the clicked element
            writeInfoCard('news', cardNews); //call function to write the news object from the clicked element

            console.log(dataObject['ressources'][i]['installation']);
            
          }
          
        }
    
      })
    })
  }
};

//pagination

function createBtns(range) {
  // resourcePage.forEach(function(range) {
  //   if (range.classList.contains('active')) {
      // let dataStart = document.querySelectorAll('.resourcePage li').getAttribute('data-start');
      // switch (range) {
      //   case 0:
      //     i = 0;
      //     break;
      //   case 10:
      //     i = 10;
      //     break;
      //   case 0:
      //     i = 20;
      //     break;
      //   default:
      //     i = 0;
      //     break;
      // }
  //   }
  //   console.log(this)
  // })

  
  // i = 0;
  let allIcons ='';
  // start = startResults(resourcePage);
    dataObject['ressources'].forEach(function(el) { //loop through the ressources json to get all elements
      if (i < (startResults(range)+resourcesNbrResults)) {
        allIcons += '<a data-id ="' + el._id + '" data-start="' + i + '" class="resourcesIcons waves-effect waves-light btn red lighten-1">' + el.displayName + '</a>'; //display all resources names inside buttons with data-id of the ressources json
        i++;
      }
    });
  // }
  console.log('hello' + startResults(resourcePage));
  resourcesIcons.innerHTML = allIcons;
}

function createPage() {
  let numberPage = '';
  if (resourcesPageCount > 1) {
    for (i = 2, start = resourcesNbrResults; i <= resourcesPageCount; i++, start += resourcesNbrResults) {
      numberPage +=  '<li class="waves-effect" data-start="' + start + '"><a href="#!">' + i + '</a></li>';
    };
    addPageNumber.innerHTML = numberPage;
    numberPage = '';
  }
}


// Event Listeners
window.addEventListener('load', function() { // implantations displayed on load
  jwt = ajaxRequestGetJWT(); // save the json web token in the variable we created for it
  ajaxRequestDisplayResources();
  ajaxRequestCreateResources();
});



// Materialize
let tabs = document.querySelectorAll('.tabs'); // select tabs
var instanceTabs = M.Tabs.init(tabs); // Materialize tabs
