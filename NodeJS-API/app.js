// 1.1 Importing all the needed modules.
const express = require("express");
const app = express();
const path = require("path");
const morgan = require("morgan");
const bodyParser = require("body-parser");
const cors = require('cors');
const passport = require('passport');
const mongoose = require("mongoose");

// 1.2 Importing the routes that will be used.
const ressourcesRoutes = require("./api/routes/ressources");
const toolboxRoutes = require("./api/routes/toolbox");

// 2. Connecting to MongoDB on mLab
mongoose.Promise = global.Promise;
const DBName = 'dorothycares';
mongoose.connect(`mongodb://DorothyCares:TheN!neSold!ers@ds239309.mlab.com:39309/${DBName}`)
        .then(() => console.log(`Connected to MongoDB on DB ${DBName}`))
        .catch((err) => console.log(`Database error: ${err}`));


// 3. Initializing the needed middlewares.
app.use(morgan("dev"));

app.use(express.static(path.join(__dirname, 'public')));
app.use('/uploads', express.static('uploads'));

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// 3.1 Setting up the CORS parameters that allows you to configure the web API's security.
app.use(cors());
app.use((req, res, next) => {
  res.header("Access-Control-Allow-Origin", "*");
  res.header(
    "Access-Control-Allow-Headers",
    "Origin, X-Requested-With, Content-Type, Accept, Authorization"
  );
  if (req.method === "OPTIONS") {
    res.header("Access-Control-Allow-Methods", "PUT, POST, PATCH, DELETE, GET");
    return res.status(200).json({});
  }
  next();
});

// 4. Declaring the routes that should handle requests
app.use("/ressources", ressourcesRoutes);
app.use("/toolbox", toolboxRoutes);

// 5. Index Route
app.get('/', (req, res) => {
  res.send('Invalid Endpoint');
});

// 6. Non-existing routes
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'public/html'));
});

// 6. Error Handling
app.use((req, res, next) => {
  const error = new Error("Not found");
  error.status = 404;
  next(error);
});

app.use((error, req, res, next) => {
  res.status(error.status || 500);
  res.json({
    error: {
      message: error.message
    }
  });
});

// 7. Exporting the app module that will be imported in the server.js file
module.exports = app;
