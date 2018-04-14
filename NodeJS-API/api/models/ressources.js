const mongoose = require('mongoose');

const ressourcesSchema = mongoose.Schema({
    _id: mongoose.Schema.Types.ObjectId,
    name: {type: String},
    intro: {type: String},
    category: {type: String},    
    installation: {type: Array},
    documentation: {type: Array},
    tutorials: {type: Array},
    exercices: {type: Array},
    examples: {type: Array},
    news: {type: Array}
});

module.exports = mongoose.model('Ressources', ressourcesSchema);
