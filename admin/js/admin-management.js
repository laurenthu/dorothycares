// Elements selection and variables creation
let dataText = ''; // variable for the json response
let optionsSelection; // variable for the options selection
let deleteIcons; // variable for the delete icons

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
// let implantationAddModalOpener = document.querySelector('#implantationModalButton');
// let startupAddModalOpener = document.querySelector('#startupModalButton');
// let userAddModalOpener = document.querySelector('#userModalButton');

// select buttons which add content
let addImplantationButton = document.querySelector('#addImplantation');
let addStartupButton = document.querySelector('#addStartup');
let addUserButton = document.querySelector('#addUser');

// select the divs where we display the content about to be deleted
let displayNameImplantation = document.querySelector('#displayNameImplantation');
let displayNameStartup = document.querySelector('#displayNameStartup');
let displayNameUser = document.querySelector('#displayNameUser');

// select the buttons to Confirm deletion of database
let confirmDeleteImplantation = document.querySelector('#implantationDeleteButton');
let confirmDeleteStartup = document.querySelector('#startupDeleteButton');
let confirmDeleteUser = document.querySelector('#userDeleteButton');

// AJAX requests
let feed = 'ajax.php';
let dataRequestDisplayContent = new XMLHttpRequest(); // open ajax request to display content
let dataRequestCreateContent = new XMLHttpRequest(); // open ajax request to create content
let dataRequestUpdateContent = new XMLHttpRequest(); // open ajax request to update content
let dataRequestDeleteContent = new XMLHttpRequest(); // open ajax request to delete content
let dataRequestGetCountryOptions = new XMLHttpRequest(); // open ajax request to get country options
let dataRequestGetUserTypeOptions = new XMLHttpRequest(); // open ajax request to get user types
let dataRequestGetLanguageOptions = new XMLHttpRequest(); // open ajax request to get langage options

function ajaxRequestGetCountryOptions() { // ajax request
  dataRequestGetCountryOptions.onload = whenDataLoadedGetCountryOptions; // we assign the function to excecute when the data are loaded
  dataRequestGetCountryOptions.open("GET", feed + '?optionList=country', false); // the type, the url, asynchronous true/false
  dataRequestGetCountryOptions.send(null); // we send the request
}

function whenDataLoadedGetCountryOptions() { // what happens when the AJAX request is done
  dataText = dataRequestGetCountryOptions.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  optionsSelection = dataObject; // we save the object containing the options in a variable
};

function ajaxRequestGetUserTypeOptions() { // ajax request
  dataRequestGetUserTypeOptions.onload = whenDataLoadedGetUserTypeOptions; // we assign the function to excecute when the data are loaded
  dataRequestGetUserTypeOptions.open("GET", feed + '?optionList=userType', false); // the type, the url, asynchronous true/false
  dataRequestGetUserTypeOptions.send(null); // we send the request
};

function whenDataLoadedGetUserTypeOptions() { // what happens when the AJAX request is done
  dataText = dataRequestGetUserTypeOptions.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  optionsSelection = dataObject; // we save the object containing the options in a variable
};

function ajaxRequestGetLanguageOptions() { // ajax request
  dataRequestGetLanguageOptions.onload = whenDataLoadedGetLanguageOptions; // we assign the function to excecute when the data are loaded
  dataRequestGetLanguageOptions.open("GET", feed + '?optionList=language', false); // the type, the url, asynchronous true/false
  dataRequestGetLanguageOptions.send(null); // we send the request
};

function whenDataLoadedGetLanguageOptions() { // what happens when the AJAX request is done
  dataText = dataRequestGetLanguageOptions.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
  optionsSelection = dataObject; // we save the object containing the options in a variable
};

function ajaxRequestDisplayContent(range) { // ajax request
  type = range[0].parentElement.getAttribute('data-type'); // type of data we want to display
  start = startResults(range); // define from which position the results are displayed (for example : from 11nth position)
  if (type == 'implantation') { // number of elements displayed per page depending in the type
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

function whenDataLoadedDisplayContent() { // what happens when the AJAX request is done
  dataText = dataRequestDisplayContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  let type = tabType(); // determine the type of data we want to display
  let tableContent = ''; // create a variable that will contain the contet of the table

  if (dataObject['request']['status'] != 'error') { // if no error occured

    if (type == 'implantation') { // generate implantation table
      dataObject['response'].forEach(function(el) {
        tableContent += '<tr class="tooltipped" data-tooltip="Double click to edit">';
        tableContent += '<td data-name="name" data-id="' + el['id'] + '">' + el['name'] + '</td>';
        tableContent += '<td data-name="street" data-id="' + el['id'] + '">' + el['street'] + '</td>';
        tableContent += '<td data-name="postalCode" data-id="' + el['id'] + '">' + el['postalCode'] + '</td>';
        tableContent += '<td data-name="city" data-id="' + el['id'] + '">' + el['city'] + '</td>';
        tableContent += '<td class="input-field" data-name="country" data-codeCountry="' + el['codeCountry'] + '" data-id="' + el['id'] + '">' + el['country'] + '</td>';
        tableContent += '<td data-name="delete"><a href="#implantationDeleteModal" data-item="' + el['name'] + '" data-id="' + el['id'] + '" class="modal-trigger delete"><i class="material-icons red-text">delete</i></a></td>';
        tableContent += '</tr>';
      });
      tableBodyImplantation.innerHTML = tableContent; // write the content where we want to display it
    } else if (type == 'startup') { // generate startup table
      dataObject['response'].forEach(function(el) {
        tableContent += '<tr class="tooltipped" data-tooltip="Double click to edit">';
        tableContent += '<td data-name="name" data-id="' + el['id'] + '">' + el['name'] + '</td>';
        tableContent += '<td data-name="delete"><a href="#startupDeleteModal" data-item="' + el['name'] + '" data-id="' + el['id'] + '" class="modal-trigger delete"><i class="material-icons red-text">delete</i></a></td>';
        tableContent += '</tr>';
      });
      tableBodyStartup.innerHTML = tableContent; // write the content where we want to display it
    } else if (type == 'user') { // generate user table
      dataObject['response'].forEach(function(el) {
        tableContent += '<tr class="tooltipped" data-tooltip="Double click to edit">';
        tableContent += '<td data-name="firstName" data-id="' + el['id'] + '">' + ((el['firstName'] == null)?'(empty)':el['firstName']) + '</td>';
        tableContent += '<td data-name="lastName" data-id="' + el['id'] + '">' + ((el['lastName'] == null)?'(empty)':el['lastName']) + '</td>';
        tableContent += '<td data-name="email" data-id="' + el['id'] + '">' + el['email'] + '</td>';
        tableContent += '<td class="input-field" data-name="userType" data-id="' + el['id'] + '">' + el['type'] + '</td>';
        tableContent += '<td class="input-field" data-name="mainLanguage" data-mainLanguageCode="' + el['mainLanguageCode'] + '" data-id="' + el['id'] + '">' + el['mainLanguage'] + '</td>';
        tableContent += '<td data-name="delete"><a href="#userDeleteModal" data-item="' + el['email'] + '" data-id="' + el['id'] + '" class="modal-trigger delete"><i class="material-icons red-text">delete</i></a></td>';
        tableContent += '</tr>';
      });
      tableBodyUser.innerHTML = tableContent; // write the content where we want to display it

    }

    let tableCells = document.querySelectorAll('table tbody tr td'); // select all table cells
    deleteIcons = document.querySelectorAll('a.delete'); // select all icons used to delete content
    for (i = 0; i < deleteIcons.length; i++) { // on all the delete icons
      deleteIcons[i].addEventListener('click', function () { // add an event listener on click
        if (type == 'implantation') { // check type
          displayNameImplantation.innerText = this.getAttribute("data-item"); // populate the deletion confirmation modal
          confirmDeleteImplantation.setAttribute("data-id", this.getAttribute("data-id")); // set the id of the data as a data-attribute on the deletion confirmation button
        } else if (type == 'startup') { // check type
          displayNameStartup.innerText = this.getAttribute("data-item"); // populate the deletion confirmation modal
          confirmDeleteStartup.setAttribute("data-id", this.getAttribute("data-id")); // set the id of the data as a data-attribute on the deletion confirmation button
        } else if (type == 'user') { // check type
          displayNameUser.innerText = this.getAttribute("data-item"); // populate the deletion confirmation modal
          confirmDeleteUser.setAttribute("data-id", this.getAttribute("data-id")); // set the id of the data as a data-attribute on the deletion confirmation button
        };
      });
    };
    makeContentEditableOrNot(tableCells); // call the function that handles content edition on the fly
  };
};

function ajaxRequestCreateContent(button) { // ajax request
  let addType = button.getAttribute('data-type'); // determine the type of data which is added

  dataRequestCreateContent.onload = whenDataLoadedCreateContent; // we assign the function to excecute when the data are loaded

  // determine values to add depending on the type
  if (addType == 'implantation') {
    let name = document.querySelector('#nameImplantation').value;
    let street = document.querySelector('#streetImplantation').value;
    let postalCode = document.querySelector('#postalCodeImplantation').value;
    let city = document.querySelector('#cityImplantation').value;
    let countryCode = document.querySelector('#countryImplantation').value;
    dataRequestCreateContent.open("POST", feed, true); // the type, the url, asynchronous true/false
    dataRequestCreateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form or something similar
    dataRequestCreateContent.send('type=' + addType + '&action=add&name=' + name + '&street=' + street + '&postalCode=' + postalCode + '&city=' + city + '&countryCode=' + countryCode); // the data we send through the POST ajax request
  } else if (addType == 'startup') {
    let name = document.querySelector('#nameStartup').value;
    let implantationId = document.querySelector('#linkedImplantation').value;
    let addLinkedLearners = document.querySelector('#addLinkedLearners').value;
    dataRequestCreateContent.open("POST", feed, true); // the type, the url, asynchronous true/false
    dataRequestCreateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form or something similar
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

function whenDataLoadedCreateContent() { // what happens when the AJAX request is done
  dataText = dataRequestCreateContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object

  if (dataObject['request']['status'] != 'error') { // if no error occured
    let activeTab = document.querySelector('li a.active'); // select the active tab
    let dataType = activeTab.getAttribute('data-type'); // get the type of data

    // Refresh displays
    allPaginationDisplay();
    if (dataType == 'implantation') {
      nextButtonDisableOrEnable(paginationImplantation);
      ajaxRequestDisplayContent(paginationImplantation);
    } else if (dataType == 'startup') {
      console.log('hello');
      nextButtonDisableOrEnable(paginationStartup);
      ajaxRequestDisplayContent(paginationStartup);
    } else if (dataType == 'user') {
      nextButtonDisableOrEnable(paginationUser);
      ajaxRequestDisplayContent(paginationUser);
    };
  };
};

function ajaxRequestUpdateContent(entryId, field, newValue) { // ajax request
  let activeTab = document.querySelector('li a.active'); // select the active tab
  let dataType = activeTab.getAttribute('data-type'); // get the type of data

  dataRequestUpdateContent.onload = whenDataLoadedUpdateContent; // we assign the function to excecute when the data are loaded
  dataRequestUpdateContent.open("POST", feed, false); // the type, the url, asynchronous true/false
  dataRequestUpdateContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form or something similar
  dataRequestUpdateContent.send('type=' + dataType + '&action=update&fieldName=' + field + '&newValue=' + newValue + '&id=' + entryId); // the data we send through the POST ajax request
};

function whenDataLoadedUpdateContent() { // what happens when the AJAX request is done
  dataText = dataRequestUpdateContent.responseText; // we store the text of the response
  dataObject = JSON.parse(dataText); // we convert the text into an object
};

function ajaxRequestDeleteContent(entryId) { // ajax request
  let activeTab = document.querySelector('li a.active'); // select the active tab
  let dataType = activeTab.getAttribute('data-type'); // get the type of data

  dataRequestDeleteContent.onload = whenDataLoadedDeleteContent; // we assign the function to excecute when the data are loaded
  dataRequestDeleteContent.open("POST", feed, true); // the type, the url, asynchronous true/false
  dataRequestDeleteContent.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); // determine that the data we send is data coming from a form or something similar
  dataRequestDeleteContent.send('action=delete&itemId=' + entryId + '&type=' + dataType); // the data we send through the POST ajax request
};

function whenDataLoadedDeleteContent() { // what happens when the AJAX request is done
  dataText = dataRequestDeleteContent.responseText; // we store the text of the response
  console.log(dataText);
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
  for (i = 1; i < (range.length - 1); i++) {
    range[i].addEventListener('click', function() {
      for (i = 1; i < (range.length - 1); i++) {
        resetPaginationClasses(range);
      };
      this.classList.add('active');
      this.classList.remove('waves-effect');
      previousButtonDisableOrEnable(range);
      nextButtonDisableOrEnable(range);
      ajaxRequestDisplayContent(range); // refresh display
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
    ajaxRequestDisplayContent(range); // refresh display
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
    ajaxRequestDisplayContent(range); // refresh display
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

function paginationDisplay(range) { // Global pagination of a type
  paginationNumbers(range);
  previousPage(range);
  nextPage(range);
};

function allPaginationDisplay() { // Global pagination for all types
  paginationDisplay(paginationImplantation); // Call the function with list elements (defined earlier) as parameter
  paginationDisplay(paginationStartup); // Call the function with list elements (defined earlier) as parameter
  paginationDisplay(paginationUser); // Call the function with list elements (defined earlier) as parameter
}

allPaginationDisplay(); // we call the function

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

confirmDeleteImplantation.addEventListener('click', function() {
  ajaxRequestDeleteContent(this.getAttribute("data-id"));
  ajaxRequestDisplayContent(paginationImplantation);
})

confirmDeleteStartup.addEventListener('click', function() {
  ajaxRequestDeleteContent(this.getAttribute("data-id"));
  ajaxRequestDisplayContent(paginationStartup);
})

confirmDeleteUser.addEventListener('click', function() {
  ajaxRequestDeleteContent(this.getAttribute("data-id"));
  ajaxRequestDisplayContent(paginationUser);
})

function makeContentEditableOrNot(content) { // handle the edition of values

  let editableCell; // define a variable which will contain the cell edited
  let initialValue; // define a variable which will contain the initial value of the cell
  let initialAttribute; // define a variable which will contain the initial attribute value linked to the cell
  let newValue; // define a variable which will contain the new value of the cell
  let field; // define a variable which will contain the name of the field edited
  let entryId; // define a variable which will contain the id of the entry edited
  let selectElement = null; // define a variable which will contain the select created for options related editions

  content.forEach(function(el) { // on each cell
    el.addEventListener('dblclick', function() { // make the content of the cell editable and focus it on double click
      editableCell = this; // save the cell in a variable
      initialValue = this.innerText; // save the initial value of the cell in a variable
      field = this.getAttribute('data-name'); // get the name of the field which will be updated

      // for specific fields with options
      if (field == 'country') {
        initialAttribute = this.getAttribute('data-codeCountry'); // get the initial value of the attribute
        let countrySelect = ''; // create an empty element
        ajaxRequestGetCountryOptions(); // send an ajax request to get the country options in the db

        countrySelect += '<select id="countrySelect" class="tempSelect">'; // create select
        optionsSelection['response'].forEach(function(el) { // create the options
          if (initialValue == el['name']) {
            countrySelect += '<option value="' + el['value'] + '" selected>' + el['name'] + '</option>';
          } else {
            countrySelect += '<option value="' + el['value'] + '">' + el['name'] + '</option>';
          };
        });
        countrySelect += '</select>';
        this.innerHTML = countrySelect; // put the select in the cell

        selectElement = document.querySelector('#countrySelect'); // select the select :kappa:
        selectElement.addEventListener('change', function() { // add event listener
          let newAttribute = this.value; // get the new value of the attribute
          newValue = document.querySelector("option[value=" + this.value + "]").innerText; // get the new value
          entryId = editableCell.getAttribute('data-id'); // get the id of the data
          if (newAttribute != initialAttribute) { // if the new value is different from the initial one
            ajaxRequestUpdateContent(entryId, field, newAttribute); // send an ajax request to update the db with the new value
            dataObject = JSON.parse(dataText); // we convert the text into an object

            if (dataObject['request']['status'] != 'error') { // if there's no error
              editableCell.innerText = newValue; // set the new value in the display
              editableCell.setAttribute('data-codeCountry', newAttribute); // set the new value of the attribute
              selectElement = document.querySelector('#countrySelect'); // recalculate the existence of the select
            } else { // reset the display to the initial value
              editableCell.innerText = initialValue; // reset the display to the initial value
            };
          };
        });

      } else if (field == 'userType') {
        let userTypeSelect = ''; // create an empty element
        ajaxRequestGetUserTypeOptions(); // send an ajax request to get the userType options in the db

        userTypeSelect += '<select id="userTypeSelect" class="tempSelect">'; // create select
        optionsSelection['response'].forEach(function(el) { // create the options
          if (initialValue == el['value']) {
            userTypeSelect += '<option value="' + el['value'] + '" selected>' + el['value'] + '</option>';
          } else {
            userTypeSelect += '<option value="' + el['value'] + '">' + el['value'] + '</option>';
          };
        });
        userTypeSelect += '</select>';
        this.innerHTML = userTypeSelect; // put the select in the cell

        selectElement = document.querySelector('#userTypeSelect'); // select the select :kappa:
        selectElement.addEventListener('change', function() { // add event listener
          newValue = document.querySelector("option[value=" + this.value + "]").innerText; // get the new value
          entryId = editableCell.getAttribute('data-id'); // get the id of the data
          if (newValue != initialValue) { // if the new value is different from the initial one
            ajaxRequestUpdateContent(entryId, field, newValue); // send an ajax request to update the db with the new value
            dataObject = JSON.parse(dataText); // we convert the text into an object

            if (dataObject['request']['status'] != 'error') { // if there's no error
              editableCell.innerText = newValue; // set the new value in the display
              selectElement = document.querySelector('#userTypeSelect'); // recalculate the existence of the select
            } else {
              editableCell.innerText = initialValue; // reset the display to the initial value
            };
          };
        });

      } else if (field == 'mainLanguage') {

        initialAttribute = this.getAttribute('data-mainLanguageCode'); // get the initial value of the attribute
        let languageSelect = ''; // create an empty element
        ajaxRequestGetLanguageOptions(); // send an ajax request to get the country options in the db

        languageSelect += '<select id="languageSelect" class="tempSelect">'; // create select
        optionsSelection['response'].forEach(function(el) { // create the options
          if (initialValue == el['name']) {
            languageSelect += '<option value="' + el['value'] + '" selected>' + el['name'] + '</option>';
          } else {
            languageSelect += '<option value="' + el['value'] + '">' + el['name'] + '</option>';
          };
        });
        languageSelect += '</select>';
        this.innerHTML = languageSelect; // put the select in the cell

        selectElement = document.querySelector('#languageSelect'); // select the select :kappa:
        selectElement.addEventListener('change', function() { // add event listener
          let newAttribute = this.value; // get the new value of the attribute
          newValue = document.querySelector("option[value=" + this.value + "]").innerText; // get the new value
          entryId = editableCell.getAttribute('data-id'); // get the id of the data
          if (newAttribute != initialAttribute) { // if the new value is different from the initial one
            ajaxRequestUpdateContent(entryId, field, newAttribute); // send an ajax request to update the db with the new value
            dataObject = JSON.parse(dataText); // we convert the text into an object

            if (dataObject['request']['status'] != 'error') { // if there's no error
              editableCell.innerText = newValue; // set the new value in the display
              editableCell.setAttribute('data-mainLanguageCode', newAttribute); // set the new value of the attribute
              selectElement = document.querySelector('#languageSelect'); // recalculate the existence of the select
            } else { // reset the display to the initial value
              editableCell.innerText = initialValue; // reset the display to the initial value
            };
          };
        });

      } else if (field == 'delete') {

      } else {
        this.setAttribute('contenteditable', true); // make the cell editable
        this.focus(); // focus it
      };
    });
  });

  document.addEventListener('keypress', function(e) {
    if (e.key == 'Enter' && document.activeElement == editableCell) { // if enter is pressed
      newValue = editableCell.innerText; // get the new value
      entryId = editableCell.getAttribute('data-id'); // get the id of the data
      editableCell.removeAttribute('contenteditable'); // remove the editable status of the cell
      if (newValue != initialValue) { // if the new value is different from the initial one
        ajaxRequestUpdateContent(entryId, field, newValue); // send an ajax request to update the db with the new value
        dataObject = JSON.parse(dataText);

        if (dataObject['request']['status'] != 'error') { // if there's no error
          editableCell.innerText = newValue; // set the new value in the display
        } else {
          editableCell.innerText = initialValue; // reset the display to the initial value
        };
      };
    };
  });

  document.addEventListener('click', function(e) {
    if (e.target != editableCell && editableCell != null && editableCell.hasAttribute('contenteditable')) { // if we click somewhere else than the cell which we are working on / if it exists / if it has the contenteditable attribute
      editableCell.innerText = initialValue; // restore the initial value of the cell
      editableCell.removeAttribute('contenteditable'); // remove the editable status of the cell
    } else if (field == 'delete') {

    } else if (e.target != editableCell && editableCell != null && selectElement != null) { // if we click somewhere else than the cell which we are working on / if it exists / if the select element exists
      editableCell.innerText = initialValue; // restore the initial value of the cell
    };
  });
};
