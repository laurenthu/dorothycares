const mongoose = require("mongoose");

const Category = require("../models/category");

exports.get_all_category = (req, res, next) => {
  Category.find()
    .select("_id name ressources toolbox")
    .exec()
    .then(docs => {
      res.status(200).json({
        count: docs.length,
        category: docs.map(doc => {
          return {
            _id: doc._id,
            name: doc.name,
            ressources: doc.ressources,
            toolbox: doc.toolbox
            // request: {
            //   type: "GET",
            //   url: "https://dorothycares.herokuapp.com/category/" + doc._id
            // }
          };
        })
      });
    })
    .catch(err => {
      res.status(500).json({
        error: err
      });
    });
}

// exports.get_category = (req, res, next) => {
//   Category.findById(req.params.categoryId)
//     .exec()
//     .then(category => {
//       if (!category) {
//         return res.status(404).json({
//           message: "category not found"
//         });
//       }
//       res.status(200).json({
//         category: category
//         // request: {
//         //   type: "GET",
//         //   url: "https://dorothycares.herokuapp.com/category/"
//         // }
//       });
//     })
//     .catch(err => {
//       res.status(500).json({
//         error: err
//       });
//     });
// }
exports.get_categoryName = (req, res, next) => {
  const reqName = req.params.categoryName
  Category.findOne({
      name: reqName
    })
    .select('_id name ressources toolbox')
    .populate('ressources', 'displayName intro')
    .populate('toolbox', 'displayName desc')
    .exec()
    .then(category => {
      if (!category) {
        return res.status(404).json({
          message: "Toolb not found"
        });
      }
      res.status(200).json({
        category: category
        // request: {
        //   type: "GET",
        //   url: "https://dorothycares.herokuapp.com/category/"
        // }
      });
    })
    .catch(err => {
      res.status(500).json({
        error: err
      });
    });
}

exports.create_category = (req, res, next) => {
  const newCategory = new Category({
    _id: new mongoose.Types.ObjectId(),
    name: req.body.name,
    ressources: req.body.ressources,
    toolbox: req.body.toolbox
  });
  newCategory
    .save()
    .then(result => {
      console.log(result);
      res.status(201).json({
        message: "Created category successfully",
        createdCategory: {
          _id: result._id,
          name: result.name,
          ressources: result.ressources,
          toolbox: result.toolbox
          // request: {
          //   type: 'GET',
          //   url: "https://dorothycares.herokuapp.com/category/" + result._id
          // }
        }
      });
    })
    .catch(err => {
      console.log(err);
      res.status(500).json({
        error: err
      });
    });
}

exports.update_category = (req, res, next) => {

  const reqName = req.params.categoryName;

  Category.findOneAndUpdate({
      name: reqName
    }, req.body, {
      new: false
    })
    .exec()
    .then(result => {
      res.status(200).json({
        message: 'Category updated'
        // request: {
        //   type: 'GET',
        //   url: 'https://dorothycares.herokuapp.com/category/' + id
        // }
      });
    })
    .catch(err => {
      console.log(err);
      res.status(500).json({
        error: err
      });
    });
}

exports.delete_category = (req, res, next) => {
  const reqName = req.params.categoryName;

  Category.remove({
      name: reqName
    })
    .exec()
    .then(result => {
      res.status(200).json({
        message: 'Category deleted'
        // request: {
        //   type: 'POST',
        //   url: 'https://dorothycares.herokuapp.com/category/',
        //   body: {
        //     name: 'String',
        //     price: 'Number'
        //   }
        // }
      });
    })
    .catch(err => {
      console.log(err);
      res.status(500).json({
        error: err
      });
    });
}