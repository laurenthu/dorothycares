'use strict';

process.env.DEBUG = 'actions-on-google:*';
const App = require('actions-on-google').DialogflowApp;
const functions = require('firebase-functions');
const https = require('https');

// https://developers.google.com/actions/assistant/responses#basic_card
/* DOROTHY'S FUNCTIONS*/

/* NO_REL RESSOURCES */
const RESSOURCES_ACTION = 'coding.technologies.ressources';
const TECH_ARGUMENT = 'codingTechnology';

const TOOLBOX_ACTION = 'coding.technologies.toolbox';
const SIDE_TECH_ARGUMENT = 'codingToolbox';

/* REL RESSOURCES */
const RELATIONAL_ACTION = 'user.becode.getCoach';

const IMPLANTATION_ACTION = 'user.becode.getImplantation';

const STARTUP_ACTION = 'user.becode.getStartup';

const STARTUP_MEMBERS_ACTION = 'user.becode.getStartupMember';

const RELATIONAL_URL = 'https://dev.dorothycares.io/api';


exports.dorothyCares = functions.https.onRequest((request, response) => {
  // 1. declaring our app so that we can make requests
  const app = new App({
    request,
    response
  });
  // 2. Logging the request
  console.log('Request headers: ' + JSON.stringify(request.headers));
  console.log('Request body: ' + JSON.stringify(request.body));

  function giveRessources(app) {
    // Keeping track of the version of the function that will be deployed
    console.log('give ressources v1.5');
    let technology = app.getArgument(TECH_ARGUMENT);
    // make the request to our api to have the informations
    console.log('https://dorothycares.herokuapp.com/ressources/' + technology);
    https.get('https://dorothycares.herokuapp.com/ressources/' + technology, (res) => {
      // declaring the body
      let body = '';
      // checking the status of the request
      console.log('statusCode:', res.statusCode);
      // On response, fill the data inside the body
      res.on('data', (data) => {
        body += data;
      });
      // Once the body is filled with the informations
      res.on('end', () => {
        // parse the body
        body = JSON.parse(body);
        console.log('on res body', body);
        body.modal = true;
        body.api = 'no-rel';
        body.type = 'ressources';
        body = JSON.stringify(body);
        console.log('on res body stringify', body);

        app.ask(body);

      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }

  function giveToolbox(app) {
    // Keeping track of the version of the function that will be deployed
    console.log('give toolbox v1.3');
    let codingToolbox = app.getArgument(SIDE_TECH_ARGUMENT);
    // make the request to our api to have the informations
    console.log('https://dorothycares.herokuapp.com/toolbox/'+codingToolbox);
    https.get('https://dorothycares.herokuapp.com/toolbox/'+codingToolbox, (res) => {
      // declaring the body
      let body = '';
      // checking the status of the request
      console.log('statusCode:', res.statusCode);
      // On response, fill the data inside the body
      res.on('data', (data) => {
        body += data;
      });
      // Once the body is filled with the informations
      res.on('end', () => {
        // parse the body
        body = JSON.parse(body);
        console.log('on res body', body);
        body.modal = true;
        body.api = 'no-rel';
        body.type = 'toolbox';
        body = JSON.stringify(body);
        console.log('on res body stringify', body);

        app.ask(body);

      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }

  function giveCoaches(app) {
    // Keeping track of the version of the function that will be deployed
    console.log('give coaches v3.5');
    let email;
    let token;
    let myResArr = [];
    // make the request to our api to have the informations
    let sessionId = request.body.sessionId;
    console.log('sessionId:', sessionId);
    https.get(RELATIONAL_URL + '/session/' + sessionId + '/', (res) => {
      // declaring the body
      let body = '';
      // checking the status of the request
      console.log('statusCode:', res.statusCode);
      // On response, fill the data inside the body
      res.on('data', (data) => {
        body += data;
      });
      // Once the body is filled with the informations
      res.on('end', () => {
        // parse the body
        body = JSON.parse(body);
        console.log('on res body', body);

        email = body.response.email;
        token = body.response.token;
        console.log('response email', email);
        console.log('response token', token);
        https.get(RELATIONAL_URL + '/user/' + token + '/' + email + '/coach/', (res) => {
          let body = '';
          console.log('statusCode:', res.statusCode);
          res.on('data', (data) => {
            body += data;
          });
          res.on('end', () => {
            body = JSON.parse(body);
            body.api = 'rel';
            body.type = 'text';
            console.log('on res body second', body);
            for (let i = 0; i < body.response.length; i++) {
              myResArr[i] = body.response[i].firstName + ' <' + body.response[i].email + '>';
              console.log('my res arr', myResArr[i]);
            }
            app.ask('Your coaches are ' + myResArr.join(" and ") + '.');

          });
        });
      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }

  function giveImplantation(app) {
    // Keeping track of the version of the function that will be deployed
    console.log('give implantation v2.2');
    let email;
    let token;
    let implantation;  
    let street;  
    let postalCode;
    let city;
    let country;
    // make the request to our api to have the informations
    let sessionId = request.body.sessionId;
    console.log('sessionId:', sessionId);
    https.get(RELATIONAL_URL + '/session/' + sessionId + '/', (res) => {
      // declaring the body
      let body = '';
      // checking the status of the request
      console.log('statusCode:', res.statusCode);
      // On response, fill the data inside the body
      res.on('data', (data) => {
        body += data;
      });
      // Once the body is filled with the informations
      res.on('end', () => {
        // parse the body
        body = JSON.parse(body);
        console.log('on res body', body);

        email = body.response.email;
        token = body.response.token;
        console.log('response email', email);
        console.log('response token', token);
        https.get(RELATIONAL_URL + '/user/' + token + '/' + email + '/implantation/', (res) => {
          let body = '';
          console.log('statusCode:', res.statusCode);
          res.on('data', (data) => {
            body += data;
          });
          res.on('end', () => {
            body = JSON.parse(body);
            body.api = 'rel';
            body.type = 'text';
            implantation = body.response.name;
            street = body.response.street;
            postalCode = body.response.postalCode;
            city = body.response.city;
            country = body.response.country;
            console.log('on res body second', body);
            app.ask('Your are at ' + implantation + '. Here is the address: ' + street + ', ' + postalCode + ' ' + city + ', ' + country +'.');

          });
        });
      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }

  function giveStartUp(app) {
    // Keeping track of the version of the function that will be deployed
    console.log('give startup v1');
    let email;
    let token;
    let startUp;
    let startUpGit;
    // make the request to our api to have the informations
    let sessionId = request.body.sessionId;
    console.log('sessionId:', sessionId);
    https.get(RELATIONAL_URL + '/session/' + sessionId + '/', (res) => {
      // declaring the body
      let body = '';
      // checking the status of the request
      console.log('statusCode:', res.statusCode);
      // On response, fill the data inside the body
      res.on('data', (data) => {
        body += data;
      });
      // Once the body is filled with the informations
      res.on('end', () => {
        // parse the body
        body = JSON.parse(body);
        console.log('on res body', body);

        email = body.response.email;
        token = body.response.token;
        console.log('response email', email);
        console.log('response token', token);
        https.get(RELATIONAL_URL + '/user/' + token + '/' + email + '/startup/', (res) => {
          let body = '';
          console.log('statusCode:', res.statusCode);
          res.on('data', (data) => {
            body += data;
          });
          res.on('end', () => {
            body = JSON.parse(body);
            body.api = 'rel';
            body.type = 'text';
            startUp = body.response.nameStartup;
            startUpGit = body.response.meta[0].value;
            console.log('on res body second', body);
            app.ask('Your are in ' + startUp + '. Here is the GitHub: ' + startUpGit + '.');

          });
        });
      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }

  function giveStartUpMembers(app) {
    // Keeping track of the version of the function that will be deployed
    console.log('give startup members v1.2');
    let email;
    let token;
    let startUpId;
    // make the request to our api to have the informations
    let sessionId = request.body.sessionId;
    console.log('sessionId:', sessionId);
    https.get(RELATIONAL_URL + '/session/' + sessionId + '/', (res) => {
      // declaring the body
      let body = '';
      // checking the status of the request
      console.log('statusCode:', res.statusCode);
      // On response, fill the data inside the body
      res.on('data', (data) => {
        body += data;
      });
      // Once the body is filled with the informations
      res.on('end', () => {
        // parse the body
        body = JSON.parse(body);
        console.log('on res body', body);

        email = body.response.email;
        token = body.response.token;
        console.log('response email', email);
        console.log('response token', token);
        https.get(RELATIONAL_URL + '/user/' + token + '/' + email + '/startup/', (res) => {
          let body = '';
          console.log('statusCode:', res.statusCode);
          res.on('data', (data) => {
            body += data;
          });
          res.on('end', () => {
            body = JSON.parse(body);
            body.api = 'rel';
            startUpId = body.response.idStartup;
            console.log('on res body second', body);
            console.log('startup Id', startUpId);
            https.get(RELATIONAL_URL + '/startup/' + token + '/' + email + '/members/' + startUpId + '/learner/', (res) => {
              let body = '';
              console.log('statusCode:', res.statusCode);
              res.on('data', (data) => {
                body += data;
              });
              res.on('end', () => {
                body = JSON.parse(body);
                body.api = 'rel';
                body.modal = 'true';
                body.type = 'list';
                body = JSON.stringify(body);
                console.log('on res body third', body);
                app.ask(body);
              });
            });
          });
        })
      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }
  // 3.X Declaring the endConversation function just to link the DialogFlow agent to the Google Assistant
  // function endConversation(app) {}

  // 4. build an action map, which maps intent names to functions
  let actionMap = new Map();
  actionMap.set(RESSOURCES_ACTION, giveRessources);
  actionMap.set(TOOLBOX_ACTION, giveToolbox);
  actionMap.set(RELATIONAL_ACTION, giveCoaches);
  actionMap.set(IMPLANTATION_ACTION, giveImplantation);
  actionMap.set(STARTUP_ACTION, giveStartUp);
  actionMap.set(STARTUP_MEMBERS_ACTION, giveStartUpMembers);
  // actionMap.set(END_ACTION, endConversation);

  app.handleRequest(actionMap);

});