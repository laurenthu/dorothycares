// 1. Importing the needed modules.
const http = require('http');
const app = require('./app');

// 2. Declaring the port that will be used.
const port = process.env.PORT || 3000;

// 3. Initializing the server
const server = http.createServer(app);

// 4. Launch the server
server.listen(port);
console.log(`Server running on port ${port}`);
