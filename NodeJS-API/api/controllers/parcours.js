const mongoose = require("mongoose");

const Parcours = require ("../models/parcours");

exports.get_all_parcours = (req, res, next) => {
  Parcours.find()
    .select("_id description url stops volume")
    .exec()
    .then(docs => {
      res.status(200).json({
        count: docs.length,
        parcours: docs.map(doc => {
          return {
            _id: doc._id,
            description: doc.description,
            url: doc.url,
            stops: doc.stops,
            volume: doc.volume,
            request: {
              type: "GET",
              url: "http://localhost:3000/parcours/" + doc._id
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

exports.get_parcours = (req, res, next) => {
  Parcours.findById(req.params.parcoursId)
    .exec()
    .then(parcours => {
      if (!parcours) {
        return res.status(404).json({
          message: "Parcours not found"
        });
      }
      res.status(200).json({
        parcours: parcours,
        request: {
          type: "GET",
          url: "http://localhost:3000/parcours/"
        }
      });
    })
    .catch(err => {
      res.status(500).json({
        error: err
      });
    });
}