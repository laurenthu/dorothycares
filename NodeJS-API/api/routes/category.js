const express = require("express");
const router = express.Router();
// const checkAuth = require("../middleware/check-auth");

const CategoryController = require ('../controllers/category');

// Handle incoming GET requests to /category
router.get("/", checkAuth,  CategoryController.get_all_category);
// Handle incoming GET requests to /category/:categoryId
// router.get("/:categoryId", CategoryController.get_category);

// Handle incoming GET requests to /category/:categoryName
router.get("/:categoryName", checkAuth, CategoryController.get_categoryName);
// Handle POST requests to /category
router.post("/", checkAuth, CategoryController.create_category);

// Handle PATCH requests to /category/:categoryName
router.patch("/:categoryName", checkAuth, CategoryController.update_category);

// Handle DELETE requests to /category/:categoryName
router.delete("/:categoryName", checkAuth, CategoryController.delete_category);

module.exports = router;
