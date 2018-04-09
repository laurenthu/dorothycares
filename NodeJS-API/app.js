const express = require("express");
const app = express();
const path = require("path")
const morgan = require("morgan");
const bodyParser = require("body-parser");
const cors = require('cors');
const passport = require('passport');
const mongoose = require("mongoose");

const ressourcesRoutes = require("./api/routes/ressources");

mongoose.Promise = global.Promise;
const DBName = 'dorothycares'
mongoose.connect(`mongodb://${process.env.MONGO_LAB_DB}:${process.env.MONGO_LAB_PW}@ds239309.mlab.com:39309/${DBName}`)
        .then(() => console.log(`Connected to MongoDB on DB ${DBName}`))
        .catch((err) => console.log(`Database error: ${err}`));

app.use(morgan("dev"));

app.use(express.static(path.join(__dirname, 'public')));
app.use('/uploads', express.static('uploads'));

app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());


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

// Routes which should handle requests
app.use("/ressources", ressourcesRoutes)

// Index Route
app.get('/', (req, res) => {
  res.send('Invalid Endpoint');
});

app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'public/html'));
})

//Error Handling
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

module.exports = app;
