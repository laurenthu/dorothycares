'use strict';

process.env.DEBUG = 'actions-on-google:*';
const App = require('actions-on-google').DialogflowApp;
const functions = require('firebase-functions');
const https = require('https');

/* DOROTHY'S FUNCTIONS*/

/* RESSOURCES */
const RESSOURCES_ACTION = 'coding.technologies.ressources';
const TECH_ARGUMENT = 'codingTechnology';

const RELATIONAL_ACTION = 'user.becode.getCoach';
const EMAIL_AGRGUMENT = 'email';
const TOKEN_AGRGUMENT = 'token';

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
    // let siteName = app.getArgument(SITE_NAME_ARGUMENT);
    // Keeping track of the version of the function that will be deployed
    console.log('give give ressources v1.5');
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
        body = JSON.stringify(body);
        console.log('on res body stringify', body);

        app.ask('Hello from give ressource' + body);

      });
      // Handling erros
    }).on('error', (e) => {
      console.error(e);
    });
  }

  function giveCoaches(app) {
    // let siteName = app.getArgument(SITE_NAME_ARGUMENT);
    // Keeping track of the version of the function that will be deployed
    console.log('give give coaches v3.5');
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
  // 3.X Declaring the endConversation function just to link the DialogFlow agent to the Google Assistant
  // function endConversation(app) {}

  // 4. build an action map, which maps intent names to functions
  let actionMap = new Map();
  actionMap.set(RESSOURCES_ACTION, giveRessources);
  actionMap.set(RELATIONAL_ACTION, giveCoaches);
  // actionMap.set(END_ACTION, endConversation);

  app.handleRequest(actionMap);

});