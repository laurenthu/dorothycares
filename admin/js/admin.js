let tableBody = document.querySelector('#displayTable');

// AJAXrequest
let implantationFeed = 'ajax.php';
let dataRequestImplantation = new XMLHttpRequest();

document.addEventListener('load', function() {
  dataRequestMovie.onload = whenDataLoadedImplantations; // we assign the function to excecute when the data are loading
});
dataRequestMovie.open("GET", implantationFeed, true); // the type, the url, asynchronous true/false
dataRequestMovie.send(null); // we send the request

function whenDataLoadedImplantations() { // what happens when the AJAX request is done
  let dataText = dataRequestImplantation.responseText; // we store the text of the response
  implantationObject = JSON.parse(dataText); // we convert the text into an object

  let tableContent;
  implantationObject.forEach(function(el) {
    tableContent += '<tr>
            <td>'+
              el['name']
            + '</td>
            <td>'+
              el['street']
            + '</td>
            <td>'+
              el['postalCode']
            + '</td>
            <td>'+
              el['city']
            + '</td>
            <td>'+
              el['country']
            + '</td>
            <td>'+
              el['codeCountry']
            + '</td>
          </tr>';
  });
  tableBody.innerHTML = tableContent;
};

// Materialize
let tabs = document.querySelectorAll('.tabs'); // select tabs
var instance = M.Tabs.init(tabs); // Materialize tabs

// Pagination
let paginationImplantation = document.querySelectorAll('.implantationPage li'); // select implantation pagination elements
let paginationClasse = document.querySelectorAll('.classePage li'); // select classe pagination elements
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
  });
}

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
  });
}

function paginationDisplay(range) { // Global JS for the pagination
  paginationNumbers(range);
  previousPage(range);
  nextPage(range);
};

paginationDisplay(paginationImplantation); // Call the function with list elements (defined earlier) as parameter
paginationDisplay(paginationClasse); // Call the function with list elements (defined earlier) as parameter
paginationDisplay(paginationUser); // Call the function with list elements (defined earlier) as parameter
