// Elements selection and variables creation
let dataText = ''; // variable for the json response
let optionsSelection; // variable for the options selection

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
let dataRequestUpdateContent = new XMLHttpRequest();
let dataRequestGetCountryOptions = new XMLHttpRequest();

function ajaxRequestGetCountryOptions() { // ajax request
  dataRequestGetCountryOptions.onload = whenDataLoadedGetCountryOptions; // we assign the function to excecute when the data are loaded
  dataRequestGetCountryOptions.open("GET", feed + '?optionList=country', false); // the type, the url, asynchronous true/false
  dataRequestGetCountryOptions.send(null); // we send the request
}

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
  dataRequestDisplayContent.onload = whenDataLoadedDisplayContent; // we assign the function to excecute when the data are loaded
  dataRequestDisplayContent.open("GET", feed + '?start=' + start + '&itemPerPage=' + itemPerPage + '&type=' + type, true); // the type, the url, asynchronous true/false
  dataRequestDisplayContent.send(null); // we send the request
}

function ajaxRequestCreateContent(button) { // ajax request
  let addType = button.getAttribute('data-type');

  dataRequestCreateContent.onload = whenDataLoadedCreateContent; // we assign the function to excecute when the data are loaded

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
    let linkedStartupId = document.querySelector('#linkedStartup').value;
    dataRequestCreateContent.open("POST", feed, true); // the type, the url, asynchronous true/false
    dataRequestCreateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form or something similar
    dataRequestCreateContent.send('type=' + addType + '&action=add&addUsers=' + addUsers + '&typeOfUser=' + typeOfUser + '&linkedStartupId=' + linkedStartupId); // the data we send through the POST ajax request
  }

};

function ajaxRequestUpdateContent(entryId, field, newValue) {
  let activeTab = document.querySelector('li a.active'); // select the active tab
  let dataType = activeTab.getAttribute('data-type'); // get the type of data

  dataRequestUpdateContent.onload = whenDataLoadedUpdateContent; // we assign the function to excecute when the data are loaded
  dataRequestUpdateContent.open("POST", feed, false); // the type, the url, asynchronous true/false
  dataRequestUpdateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form or something similar
  dataRequestUpdateContent.send('type=' + dataType + '&action=update&fieldName=' + field + '&newValue=' + newValue + '&id=' + entryId); // the data we send through the POST ajax request
};

function whenDataLoadedGetCountryOptions() { // what happens when the AJAX request is done
  dataText = dataRequestGetCountryOptions.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  optionsSelection = dataObject;
};

function whenDataLoadedDisplayContent() { // what happens when the AJAX request is done
  dataText = dataRequestDisplayContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  let type = tabType();
  let tableContent = '';

  if (type == 'implantation') { // generate implantation table
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-name="name" data-id="' + el['id'] + '">' + el['name'] + '</td>';
      tableContent += '<td data-name="street" data-id="' + el['id'] + '">' + el['street'] + '</td>';
      tableContent += '<td data-name="postalCode" data-id="' + el['id'] + '">' + el['postalCode'] + '</td>';
      tableContent += '<td data-name="city" data-id="' + el['id'] + '">' + el['city'] + '</td>';
      tableContent += '<td class="input-field" data-name="country" data-codeCountry="' + el['codeCountry'] + '" data-id="' + el['id'] + '">' + el['country'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyImplantation.innerHTML = tableContent;
  } else if (type == 'startup') { // generate startup table
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-name="name" data-id="' + el['id'] + '">' + el['name'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyStartup.innerHTML = tableContent;
  } else if (type == 'user') { // generate user table
    dataObject['response'].forEach(function(el) {
      tableContent += '<tr>';
      tableContent += '<td data-name="firstName" data-id="' + el['id'] + '">' + el['firstName'] + '</td>';
      tableContent += '<td data-name="lastName" data-id="' + el['id'] + '">' + el['lastName'] + '</td>';
      tableContent += '<td data-name="email" data-id="' + el['id'] + '">' + el['email'] + '</td>';
      tableContent += '<td data-name="type" data-id="' + el['id'] + '">' + el['type'] + '</td>';
      tableContent += '<td data-name="mainLanguage" data-id="' + el['id'] + '">' + el['mainLanguage'] + '</td>';
      tableContent += '</tr>';
    });
    tableBodyUser.innerHTML = tableContent;
  }

  let tableCells = document.querySelectorAll('table tbody tr td'); // select all table cells
  makeContentEditableOrNot(tableCells); // call the function that handles content edition on the fly
};

function whenDataLoadedCreateContent() { // what happens when the AJAX request is done
  dataText = dataRequestCreateContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  if (dataObject['request']['status'] != 'error') { // if an error occured
    let activeTab = document.querySelector('li a.active'); // select the active tab
    let dataType = activeTab.getAttribute('data-type'); // get the type of data

    // Refresh displays
    allPaginationDisplay();
    if (dataType == 'implantation') {
      nextButtonDisableOrEnable(paginationImplantation);
      ajaxRequestDisplayContent(paginationImplantation);
    } else if (dataType == 'startup') {
      nextButtonDisableOrEnable(paginationStartup);
      ajaxRequestDisplayContent(paginationStartup);
    } else if (dataType == 'user') {
      nextButtonDisableOrEnable(paginationUser);
      ajaxRequestDisplayContent(paginationUser);
    };
  };
};

function whenDataLoadedUpdateContent() { // what happens when the AJAX request is done
  dataText = dataRequestUpdateContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  if (dataObject['request']['status'] != 'error') { // if an error occured
    let activeTab = document.querySelector('li a.active'); // select the active tab
    let dataType = activeTab.getAttribute('data-type'); // get the type of data

    // Refresh displays
    allPaginationDisplay();
    if (dataType == 'implantation') {
      nextButtonDisableOrEnable(paginationImplantation);
      ajaxRequestDisplayContent(paginationImplantation);
    } else if (dataType == 'startup') {
      nextButtonDisableOrEnable(paginationStartup);
      ajaxRequestDisplayContent(paginationStartup);
    } else if (dataType == 'user') {
      nextButtonDisableOrEnable(paginationUser);
      ajaxRequestDisplayContent(paginationUser);
    };
  };
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

function previousButtonDisableOrEnable(range) { // handles previous button usability
  if (range[1].classList.contains('active')) {
    range[0].classList.add('disabled');
    range[0].classList.remove('waves-effect');
  } else {
    range[0].classList.remove('disabled');
    range[0].classList.add('waves-effect');
  };
};

function nextButtonDisableOrEnable(range) { // handles next button usability
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

function tabType() { // determine the type of content
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

function allPaginationDisplay() {
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

addImplantationButton.addEventListener('click', function() { // Add an implantation
  ajaxRequestCreateContent(addImplantationButton);
});

addStartupButton.addEventListener('click', function() { // Add a startup
  ajaxRequestCreateContent(addStartupButton);
});

addUserButton.addEventListener('click', function() { // Add an User
  ajaxRequestCreateContent(addUserButton);
});

function makeContentEditableOrNot(content) { // handle the edition of values

  let editableCell;
  let initialValue;
  let initialAttribute;
  let newValue;
  let field;
  let entryId;

  content.forEach(function(el) {
    el.addEventListener('dblclick', function() { // make the content of the cell editable and focus it
      editableCell = this; // save the cell in a variable
      initialValue = this.innerText; // save the initial value of the cell in a variable
      field = this.getAttribute('data-name'); // get the name of the field updated

      if (field == 'country') {
        initialAttribute = this.getAttribute('data-codeCountry');
        let countrySelect = '';
        ajaxRequestGetCountryOptions(); // send an ajax request to get the country options in the db

        countrySelect += '<select id="countrySelect">'; // create select
        optionsSelection['response'].forEach(function(el) {
          if (initialValue == el['name']) {
            countrySelect += '<option value="' + el['value'] + '" selected>' + el['name'] + '</option>';
          } else {
            countrySelect += '<option value="' + el['value'] + '">' + el['name'] + '</option>';
          };
        });
        countrySelect += '</select>';
        this.innerHTML = countrySelect;

        let selectElement = document.querySelector('#countrySelect'); // select the select :kappa:
        selectElement.addEventListener('change', function() { // add event listener
          let newAttribute = this.value; // get the new value
          newValue = document.querySelector("option[value=" + this.value + "]").innerText;
          entryId = editableCell.getAttribute('data-id');
          if (newAttribute != initialAttribute) { // if the new value is different from the initial one
            ajaxRequestUpdateContent(entryId, field, newAttribute); // send an ajax request with the new value
            dataObject = JSON.parse(dataText);

            if (dataObject['request']['status'] != 'error') {
              editableCell.innerText = newValue;
              editableCell.setAttribute('data-codeCountry', newAttribute);
            } else {
              editableCell.innerText = initialValue;
            };
          };
        });

      } else {
        this.setAttribute('contenteditable', true); // make the cell editable
        this.focus(); // focus it
      };
    });
  });

  document.addEventListener('keypress', function(e) {
    if (e.key == 'Enter' && document.activeElement == editableCell) { // if enter is pressed
      newValue = editableCell.innerText; // get the new value
      entryId = editableCell.getAttribute('data-id');
      editableCell.removeAttribute('contenteditable'); // remove the editable status of the cell
      if (newValue != initialValue) { // if the new value is different from the initial one
        ajaxRequestUpdateContent(entryId, field, newValue); // send an ajax request with the new value
        dataObject = JSON.parse(dataText);

        if (dataObject['request']['status'] != 'error') {
          editableCell.innerText = newValue;
        } else {
          editableCell.innerText = initialValue;
        };
      };
    };
  });

  document.addEventListener('click', function(e) {
    if (e.target != editableCell && editableCell != undefined) { // if we click somewhere else
      if (editableCell.hasAttribute('contenteditable')) {
        editableCell.innerText = initialValue; // restore the initial value of the cell
        editableCell.removeAttribute('contenteditable'); // remove the editable status of the cell
      } else {
        editableCell.innerText = initialValue;
        editableCell.setAttribute('data-countryCode', initialAttribute);
      };
    };
  });
};
