var express = require('express');
var router = express.Router();

const host = 'localhost';
const user = 'root';
const password = '';
const database = 'sap_cli0005_a10004';

const Importer = require('mysql-import');
const importer = new Importer({host, user, password, database});

router.get('/', function(req, res, next) {

    // New onProgress method, added in version 5.0!
    importer.onProgress(progress=>{
    var percent = Math.floor(progress.bytes_processed / progress.total_bytes * 10000) / 100;
    console.log(`${percent}% Completed`);
    });

    importer.import('C:/Users/User/Downloads/admin_iaudit.sql').then(()=>{
        var files_imported = importer.getImported();
        console.log(`${files_imported.length} SQL file(s) imported.`);
    }).catch(err=>{
        console.error(err);
    });

});

module.exports = router;