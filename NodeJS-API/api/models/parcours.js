const mongoose = require('mongoose');

const parcoursSchema = mongoose.Schema({
    _id: mongoose.Schema.Types.ObjectId,
    url: {type: String},
    description : {type: String},
    volume : {type: String},
    stops : {type: Array}
});

module.exports = mongoose.model('Parcours', parcoursSchema);
