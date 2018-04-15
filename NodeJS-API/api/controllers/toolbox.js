const mongoose = require("mongoose");

const Toolbox = require("../models/toolbox");

exports.get_all_toolbox = (req, res, next) => {
  Toolbox.find()
    .select("_id name desc category usecase tools")
    .exec()
    .then(docs => {
      res.status(200).json({
        count: docs.length,
        toolbox: docs.map(doc => {
          return {
            _id: doc._id,
            name: doc.name,
            displayName: doc.displayName,
            desc: doc.desc,
            category: doc.category,            
            usecase: doc.usecase,
            tools: doc.tools
            // request: {
            //   type: "GET",
            //   url: "https://dorothycares.herokuapp.com/toolbox/" + doc._id
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

// exports.get_toolbox = (req, res, next) => {
//   Toolbox.findById(req.params.toolboxId)
//     .exec()
//     .then(toolbox => {
//       if (!toolbox) {
//         return res.status(404).json({
//           message: "Toolbox not found"
//         });
//       }
//       res.status(200).json({
//         toolbox: toolbox
//         // request: {
//         //   type: "GET",
//         //   url: "https://dorothycares.herokuapp.com/toolbox/"
//         // }
//       });
//     })
//     .catch(err => {
//       res.status(500).json({
//         error: err
//       });
//     });
// }
exports.get_toolboxName = (req, res, next) => {
  const reqName = req.params.toolboxName
  Toolbox.findOne({ name: reqName })
    .exec()
    .then(toolbox => {
      if (!toolbox) {
        return res.status(404).json({
          message: "Toolbox not found"
        });
      }
      res.status(200).json({
        toolbox: toolbox
        // request: {
        //   type: "GET",
        //   url: "https://dorothycares.herokuapp.com/toolbox/"
        // }
      });
    })
    .catch(err => {
      res.status(500).json({
        error: err
      });
    });
}

exports.create_toolbox = (req, res, next) => {
  const newToolbox = new Toolbox({
    _id: new mongoose.Types.ObjectId(),
    name: req.body.name,
    displayName: req.body.displayName,
    desc: req.body.desc,
    category: req.body.category,    
    usecase: req.body.usecase,
    tools: req.body.tools
  });
  newToolbox
    .save()
    .then(result => {
      console.log(result);
      res.status(201).json({
        message: "Created toolbox successfully",
        createdToolbox: {
          _id: result._id,
          name: result.name,
          displayName: result.displayName,
          desc: result.desc,
          category: result.category,
          usecase: result.usecase,
          tools: result.tools
          // request: {
          //   type: 'GET',
          //   url: "https://dorothycares.herokuapp.com/toolbox/" + result._id
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

exports.update_toolbox = (req, res, next) => {

  const reqName = req.params.toolboxName;

  Toolbox.findOneAndUpdate({
      name: reqName
    }, req.body, {
      new: false
    })
    .exec()
    .then(result => {
      res.status(200).json({
        message: 'Toolbox updated'
        // request: {
        //   type: 'GET',
        //   url: 'https://dorothycares.herokuapp.com/toolbox/' + id
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

exports.delete_toolbox = (req, res, next) => {
  const reqName = req.params.toolboxName;

  Toolbox.remove({
      name: reqName
    })
    .exec()
    .then(result => {
      res.status(200).json({
        message: 'Toolbox deleted'
        // request: {
        //   type: 'POST',
        //   url: 'https://dorothycares.herokuapp.com/toolbox/',
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