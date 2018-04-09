const mongoose = require("mongoose");

const Ressources = require ("../models/ressources");

exports.get_all_ressources = (req, res, next) => {
  Ressources.find()
    .select("_id name intro installation documentation tutorials")
    .exec()
    .then(docs => {
      res.status(200).json({
        count: docs.length,
        ressources: docs.map(doc => {
          return {
            _id: doc._id,
            name: doc.name,
            intro: doc.intro,
            installation: doc.installation,
            documentation: doc.documentation,
            tutorials: doc.volume,
            request: {
              type: "GET",
              url: "http://localhost:3000/ressources/" + doc._id
            }
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

exports.get_ressource = (req, res, next) => {
  Ressources.findById(req.params.ressourcesId)
    .exec()
    .then(ressources => {
      if (!ressources) {
        return res.status(404).json({
          message: "Ressources not found"
        });
      }
      res.status(200).json({
        ressources: ressources,
        request: {
          type: "GET",
          url: "http://localhost:3000/ressources/"
        }
      });
    })
    .catch(err => {
      res.status(500).json({
        error: err
      });
    });
}