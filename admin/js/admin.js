// Elements selection and variables creation

let tableBodyImplantation = document.querySelector('#implantationTable'); // Implantations table
let tableBodyStartup = document.querySelector('#startupTable'); // Startups table
let tableBodyUser = document.querySelector('#userTable'); // Users table

let start; // the result from which we begin displaying
let itemPerPage; // Init of the variable for the number of results displayed

// Determine the number of items displayed per page for each type of content
let itemPerPageImplantation = document.querySelector('.implantationPage').getAttribute('data-itemPerPage');
let itemPerPageStartup = document.querySelector('.startupPage').getAttribute('data-itemPerPage');
let itemPerPageUser = document.querySelector('.userPage').getAttribute('data-itemPerPage');

// select the content tabs
let implantationTab = document.querySelector('#implantationTab');
let startupTab = document.querySelector('#startupTab');
let userTab = document.querySelector('#userTab');
let tabLinks = document.querySelectorAll('.tabs li a');

// select buttons that open content creation modals
let implantationAddModalOpener = document.querySelector('#implantationModalButton');
let startupAddModalOpener = document.querySelector('#startupModalButton');
let userAddModalOpener = document.querySelector('#userModalButton');

// select buttons which add content
let addImplantationButton = document.querySelector('#addImplantation');
let addStartupButton = document.querySelector('#addStartup');
let addUserButton = document.querySelector('#addUser');

// AJAX requests
let feed = 'ajax.php';
let dataRequestDisplayContent = new XMLHttpRequest();
let dataRequestCreateContent = new XMLHttpRequest();

function ajaxRequestDisplayContent(range) { // ajax request
  type = range[0].parentElement.getAttribute('data-type');
  start = startResults(range);
  if (type == 'implantation') {
    itemPerPage = itemPerPageImplantation;
  } else if (type == 'startup') {
    itemPerPage = itemPerPageStartup;
  } else if (type == 'user') {
    itemPerPage = itemPerPageUser;
  }
  dataRequestDisplayContent.onload = whenDataLoadedDisplayContent; // we assign the function to excecute when the data are loading
  dataRequestDisplayContent.open("GET", feed + '?start=' + start + '&itemPerPage=' + itemPerPage + '&type=' + type, true); // the type, the url, asynchronous true/false
  dataRequestDisplayContent.send(null); // we send the request
}

function ajaxRequestCreateContent(button) { // ajax request
  let addType = button.getAttribute('data-type');

  dataRequestCreateContent.onload = whenDataLoadedCreateContent; // we assign the function to excecute when the data are loading

  if (addType == 'implantation') {
    let name = document.querySelector('#nameImplantation').value;
    let street = document.querySelector('#streetImplantation').value;
    let postalCode = document.querySelector('#postalCodeImplantation').value;
    let city = document.querySelector('#cityImplantation').value;
    let countryCode = document.querySelector('#countryImplantation').value;
    dataRequestCreateContent.open("POST", feed, true); // the type, the url, asynchronous true/false
    dataRequestCreateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form
    dataRequestCreateContent.send('type=' + addType + '&action=add&name=' + name + '&street=' + street + '&postalCode=' + postalCode + '&city=' + city + '&countryCode=' + countryCode);
  } else if (addType == 'startup') {
    let name = document.querySelector('#nameStartup').value;
    let implantationId = document.querySelector('#linkedImplantation').value;
    let addLinkedLearners = document.querySelector('#addLinkedLearners').value;
    dataRequestCreateContent.open("POST", feed, true); // the type, the url, asynchronous true/false
    dataRequestCreateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form
    dataRequestCreateContent.send('type=' + addType + '&action=add&name=' + name + '&implantationId=' + implantationId + '&addLinkedLearners=' + addLinkedLearners); // the data we send through the POST ajax request
  } else if (addType == 'user') {
    let addUsers = document.querySelector('#addUsers').value;
    let typeOfUser = document.querySelector('#userType').value;
    dataRequestCreateContent.open("POST", feed, true); // the type, the url, asynchronous true/false
    dataRequestCreateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form
    dataRequestCreateContent.send('type=' + addType + '&action=add&addUsers=' + addUsers + '&typeOfUser=' typeOfUser); // the data we send through the POST ajax request
  }

};

function whenDataLoadedDisplayContent() { // what happens when the AJAX request is done
  let dataText = dataRequestDisplayContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  let type = tabType();
  let tableContent = '';

  if (type == 'implantation') { // generate implantation table
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['name'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['street'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['postalCode'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['city'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['country'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['codeCountry'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyImplantation.innerHTML = tableContent;
  } else if (type == 'startup') { // generate startup table
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['name'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyStartup.innerHTML = tableContent;
  } else if (type == 'user') { // generate user table
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['firstName'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['lastName'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['email'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['type'] + '</td>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['mainLanguage'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyUser.innerHTML = tableContent;
  }
};

function whenDataLoadedCreateContent() { // what happens when the AJAX request is done
  let dataText = dataRequestCreateContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
};

// Materialize
let tabs = document.querySelectorAll('.tabs'); // select tabs
var instanceTabs = M.Tabs.init(tabs); // Materialize tabs

let modals = document.querySelectorAll('.modal'); // select modals
var instanceModals = M.Modal.init(modals); // Materialize modals

let selects = document.querySelectorAll('select'); // select selects
var instanceSelects = M.FormSelect.init(selects); // Materialize selects

// Pagination
let paginationImplantation = document.querySelectorAll('.implantationPage li'); // select implantation pagination elements
let paginationStartup = document.querySelectorAll('.startupPage li'); // select startup pagination elements
let paginationUser = document.querySelectorAll('.userPage li'); // select user pagination elements

function previousButtonDisableOrEnable (range) { // handles previous button usability
  if (range[1].classList.contains('active')) {
    range[0].classList.add('disabled');
    range[0].classList.remove('waves-effect');
  } else {
    range[0].classList.remove('disabled');
    range[0].classList.add('waves-effect');
  };
};

function nextButtonDisableOrEnable (range) { // handles next button usability
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


function paginationNumbers(range) { // page numbers JS
  for (i = 1; i < (range.length - 1); i++) {
    range[i].addEventListener('click', function() {
      for (i = 1; i < (range.length - 1); i++) {
        resetPaginationClasses(range);
      };
      this.classList.add('active');
      this.classList.remove('waves-effect');
      previousButtonDisableOrEnable(range);
      nextButtonDisableOrEnable(range);
      ajaxRequestDisplayContent(range);
    });
  };
};

function previousPage(range) { // previous page button JS
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
    ajaxRequestDisplayContent(range);
  });
};

function nextPage(range) { // next page button JS
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
    ajaxRequestDisplayContent(range);
  });
};

function startResults(range) { // Define from which position the results are dislayed
  for (i = 1; i < (range.length - 1); i++) {
    if (range[i].classList.contains('active')) {
      return range[i].getAttribute('data-start');
    };
  };
};

function tabType () { // determine the type of content
  for (i = 0; i < tabLinks.length; i++) {
    if (tabLinks[i].classList.contains('active')) {
      return tabLinks[i].getAttribute('data-type');
    };
  };
};

function paginationDisplay(range) { // Global JS for the pagination
  paginationNumbers(range);
  previousPage(range);
  nextPage(range);
};

function allPaginationDisplay () {
  paginationDisplay(paginationImplantation); // Call the function with list elements (defined earlier) as parameter
  paginationDisplay(paginationStartup); // Call the function with list elements (defined earlier) as parameter
  paginationDisplay(paginationUser); // Call the function with list elements (defined earlier) as parameter
}

allPaginationDisplay();



// Event Listeners
window.addEventListener('load', function() { // implantations displayed on load
  nextButtonDisableOrEnable(paginationImplantation);
  ajaxRequestDisplayContent(paginationImplantation);
});

implantationTab.addEventListener('click', function() { // display implantations on tab click
  nextButtonDisableOrEnable(paginationImplantation);
  ajaxRequestDisplayContent(paginationImplantation);
});

startupTab.addEventListener('click', function() { // display startups on tab click
  nextButtonDisableOrEnable(paginationStartup);
  ajaxRequestDisplayContent(paginationStartup);
});

userTab.addEventListener('click', function() { // display users on tab click
  nextButtonDisableOrEnable(paginationUser);
  ajaxRequestDisplayContent(paginationUser);
});

addImplantationButton.addEventListener('click', function () { // Add an implantation
  ajaxRequestCreateContent(addImplantationButton);

  // Refresh displays
  allPaginationDisplay();
  nextButtonDisableOrEnable(paginationImplantation);
  ajaxRequestDisplayContent(paginationImplantation);
});

addStartupButton.addEventListener('click', function () { // Add a startup
  ajaxRequestCreateContent(addStartupButton);

  // Refresh displays
  allPaginationDisplay();
  nextButtonDisableOrEnable(paginationStartup);
  ajaxRequestDisplayContent(paginationStartup);
});

addUserButton.addEventListener('click', function () { // Add an User
  ajaxRequestCreateContent(addUserButton);

  // Refresh displays
  allPaginationDisplay();
  nextButtonDisableOrEnable(paginationUser);
  ajaxRequestDisplayContent(paginationUser);
});
