const express = require("express");
const router = express.Router();
// const checkAuth = require("../middleware/check-auth");

const ParcoursController = require ('../controllers/parcours');

// Handle incoming GET requests to /orders
router.get("/", ParcoursController.get_all_parcours);
router.get("/:parcoursId", ParcoursController.get_parcours);

module.exports = router;
