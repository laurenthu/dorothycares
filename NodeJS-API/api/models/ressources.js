const mongoose = require('mongoose');

const ressourcesSchema = mongoose.Schema({
    _id: mongoose.Schema.Types.ObjectId,
    name: {type: String},
    intro: {type: String},
    installation: {type: Array},
    documentation: {type: Array},
    tutorials : {type: Array}
});

module.exports = mongoose.model('Ressources', ressourcesSchema);
