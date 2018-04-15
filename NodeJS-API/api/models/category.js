const mongoose = require('mongoose');

const toolboxSchema = mongoose.Schema({
    _id: mongoose.Schema.Types.ObjectId,
    name: {type: String},
    ressources: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Ressources'}],
    toolbox: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Toolbox'}]
});

module.exports = mongoose.model('Toolbox', toolboxSchema);