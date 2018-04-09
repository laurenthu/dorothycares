const express = require("express");
const router = express.Router();
// const checkAuth = require("../middleware/check-auth");

const RessourcesController = require ('../controllers/ressources');

// Handle incoming GET requests to /ressources
router.get("/", RessourcesController.get_all_ressources);
router.get("/:ressourcesId", RessourcesController.get_ressource);

module.exports = router;
