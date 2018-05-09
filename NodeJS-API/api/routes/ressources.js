const express = require("express");
const router = express.Router();
const checkAuth = require("../middleware/check-auth");

const RessourcesController = require ('../controllers/ressources');

// Handle incoming GET requests to /ressources
router.get("/", checkAuth, RessourcesController.get_all_ressources);
// Handle incoming GET requests to /ressources/:ressourceId
// router.get("/:ressourceId", RessourcesController.get_ressource);

router.get("/:ressourceName", checkAuth, RessourcesController.get_ressourceName);
// Handle POST requests to /ressources
router.post("/", checkAuth, RessourcesController.create_ressource);

// Handle PATCH requests to /ressources/:ressourcesId
router.patch("/:ressourceName", checkAuth, RessourcesController.update_ressource);

// Handle DELETE requests to /ressources/:ressourcesId
router.delete("/:ressourceName", checkAuth, RessourcesController.delete_ressource);

module.exports = router;
