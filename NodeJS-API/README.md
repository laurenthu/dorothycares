# DorothyCare's ressource API.

## A RESTful API made with : 

- NodeJS
- Express
- MongoDB(mLab) & Mongoose
- JWT & Passport
- Hosted on Heroku

### Folder structure :

#### - Root level : 
- app.js (initializing & setting up the server)
- server.js (launching the server)
#### - Sub level : 
  ##### The api folder:
  - /config : contains the config files whatever for the DB or for passport.
  - /routes : contains all the routes that will be handled with their relative methods.
  - /controllers : contains the callback functions of our routes.
  - /models : defines the schemas of our data structure and is used on our controllers.

### Local usage :

```
1. npm install
2. npm start
3. check localhost:3000 server should be running
```

### Heroku deployment :

https://devcenter.heroku.com/articles/getting-started-with-nodejs#introduction

```
1. Install the heroku CLI
2. Create a new heroku project : heroku create [name of your project without brackets]
3. Add the code of your project to the created folder.
4. git add .
5. git commit -m "deploying on heroku"
6. git push heroku master
7. Your API should be up and running
```