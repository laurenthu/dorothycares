const express = require("express");
const router = express.Router();
// const checkAuth = require("../middleware/check-auth");

const CategoryController = require ('../controllers/category');

// Handle incoming GET requests to /category
router.get("/", CategoryController.get_all_category);
// Handle incoming GET requests to /category/:categoryId
// router.get("/:categoryId", CategoryController.get_category);

// Handle incoming GET requests to /category/:categoryName
router.get("/:categoryName", CategoryController.get_categoryName);
// Handle POST requests to /category
router.post("/", CategoryController.create_category);

// Handle PATCH requests to /category/:categoryName
router.patch("/:categoryName", CategoryController.update_category);

// Handle DELETE requests to /category/:categoryName
router.delete("/:categoryName", CategoryController.delete_category);

module.exports = router;
