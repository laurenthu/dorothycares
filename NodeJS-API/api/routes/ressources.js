const express = require("express");
const router = express.Router();
// const checkAuth = require("../middleware/check-auth");

const RessourcesController = require ('../controllers/ressources');

// Handle incoming GET requests to /ressources
router.get("/", RessourcesController.get_all_ressources);
// Handle incoming GET requests to /ressources/:ressourceId
// router.get("/:ressourceId", RessourcesController.get_ressource);

router.get("/:ressourceName", RessourcesController.get_ressourceName);
// Handle POST requests to /ressources
router.post("/", RessourcesController.create_ressource);

// Handle PATCH requests to /ressources/:ressourcesId
router.patch("/:ressourceName", RessourcesController.update_ressource);

// Handle DELETE requests to /ressources/:ressourcesId
router.delete("/:ressourceName", RessourcesController.delete_ressource);

module.exports = router;
