var express = require('express');
var router = express.Router();

// Get Server Runing Status
router.get('/', function(req, res, next) {
    res.jsonp({"status":"1","message":"Server is runing"});
}); 

module.exports = router;