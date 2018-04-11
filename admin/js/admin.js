// Elements selection and variables creation
let tableBodyImplantation = document.querySelector('#implantationTable'); // Implantations table
let tableBodyStartup = document.querySelector('#startupTable'); // Startups table
let tableBodyUser = document.querySelector('#userTable'); // Users table
let start; // the result from which we begin displaying
let itemPerPage; // the numbe of results displayed
let itemPerPageImplantation = document.querySelector('.implantationPage').getAttribute('data-itemPerPage');
let itemPerPageStartup = document.querySelector('.startupPage').getAttribute('data-itemPerPage');
let itemPerPageUser = document.querySelector('.userPage').getAttribute('data-itemPerPage');
let implantationTab = document.querySelector('#implantationTab');
let startupTab = document.querySelector('#startupTab');
let userTab = document.querySelector('#userTab');
let tabLinks = document.querySelectorAll('.tabs li a');

// AJAXrequest
let feed = 'ajax.php';
let dataRequest = new XMLHttpRequest();

function whenDataLoaded() { // what happens when the AJAX request is done
  let dataText = dataRequest.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  console.log(dataObject);

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
  } else if (type == 'startup') {
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-id="' + el['id'] + '">'+ el['name'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyStartup.innerHTML = tableContent;
  } else if (type == 'user') {
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

// Materialize
let tabs = document.querySelectorAll('.tabs'); // select tabs
var instance = M.Tabs.init(tabs); // Materialize tabs

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
      ajaxRequest(range);
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
    ajaxRequest(range);
  });
};

function nextPage(range) { // next page button JS
  range[range.length - 1].addEventListener('click', function() {
    for (i = 1; i < (range.length - 1); i++) {
      if (range[i].classList.contains('active') && !range[range.length - 1].classList.contains('disabled')) {
        resetPaginationClasses(range);
        range[i + 1].classList.add('active');
        range[i + 1].classList.remove('waves-effect');
      };
      nextButtonDisableOrEnable(range);
      previousButtonDisableOrEnable(range);
    };
    ajaxRequest(range);
  });
};


function paginationDisplay(range) { // Global JS for the pagination
  paginationNumbers(range);
  previousPage(range);
  nextPage(range);
};

paginationDisplay(paginationImplantation); // Call the function with list elements (defined earlier) as parameter
paginationDisplay(paginationStartup); // Call the function with list elements (defined earlier) as parameter
paginationDisplay(paginationUser); // Call the function with list elements (defined earlier) as parameter

function startResults(range) { // Define from which position the results are dislayed
  for (i = 1; i < (range.length - 1); i++) {
    if (range[i].classList.contains('active')) {
      return range[i].getAttribute('data-start');
    };
  };
};

function tabType () {
  for (i = 0; i < tabLinks.length; i++) {
    if (tabLinks[i].classList.contains('active')) {
      return tabLinks[i].getAttribute('data-type');
    };
  };
};

function ajaxRequest(range) {
  type = range[0].parentElement.getAttribute('data-type');
  start = startResults(range);
  if (type == 'implantation') {
    itemPerPage = itemPerPageImplantation;
  } else if (type == 'startup') {
    itemPerPage = itemPerPageStartup;
  } else if (type == 'user') {
    itemPerPage = itemPerPageUser;
  }
  dataRequest.onload = whenDataLoaded; // we assign the function to excecute when the data are loading
  dataRequest.open("GET", feed + '?start=' + start + '&itemPerPage=' + itemPerPage + '&type=' + type, true); // the type, the url, asynchronous true/false
  dataRequest.send(null); // we send the request
}

// Event Listeners
window.addEventListener('load', function() {
  nextButtonDisableOrEnable(paginationImplantation);
  ajaxRequest(paginationImplantation);
});

implantationTab.addEventListener('click', function() {
  nextButtonDisableOrEnable(paginationImplantation);
  ajaxRequest(paginationImplantation);
});

startupTab.addEventListener('click', function() {
  nextButtonDisableOrEnable(paginationStartup);
  ajaxRequest(paginationStartup);
});

userTab.addEventListener('click', function() {
  nextButtonDisableOrEnable(paginationUser);
  ajaxRequest(paginationUser);
});
