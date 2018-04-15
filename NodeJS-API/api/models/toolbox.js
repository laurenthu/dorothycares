const mongoose = require('mongoose');

const toolboxSchema = mongoose.Schema({
    _id: mongoose.Schema.Types.ObjectId,
    name: {type: String},
    desc: {type: String},
    category: {type: String},    
    usecase: {type: Array},
    urls: {type: Array}
});

module.exports = mongoose.model('Toolbox', toolboxSchema);
