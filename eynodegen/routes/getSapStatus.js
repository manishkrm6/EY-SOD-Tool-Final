var express = require('express');
var router = express.Router();
const path = require('path');
const dblib = require('../lib/dblib');
const fh = require('../lib/fileHandler');

// Get Status For SAP Table Download
router.get('/', function(req, res, next) {
  
  const connMaster = { host: 'localhost', user: 'root', password: '', database: 'admin_iaudit' };
  const analysis_id = req.query.analysis_id;

  let sql = '';
  let dbResponse = [];
  
  if( parseInt(analysis_id) > 0 ) {
    checkStatus();
  }
  else{
      
    let resObj = {
        "message": "Failed",
        "error": "",
        "total_downloaded_files": 0,
        "current_downloading_file":0
    };
    res.jsonp(resObj);
  }
  
  async function  checkStatus(){
     
    let resObj = null;
    // DB3 ===
        let db3 = null;
        let db2 = null;
        let fk_client_id = null;

        try{
            
            sql = 'SELECT * FROM `iaudit_list_analysis` WHERE  `id` = '+analysis_id; 
            dbResponse = await dblib.getData( connMaster, sql);

            db3 = dbResponse[0].db_name;
            fk_client_id = dbResponse[0].fk_client_id;

            sql = 'SELECT * FROM `iaudit_clients` WHERE  `id` = '+fk_client_id; 
            dbResponse = await dblib.getData( connMaster, sql);
            db2 = dbResponse[0].client_database;

            const baseFilePath =  path.join(__dirname,'../../uploads/Clients/'+db2+'/'+db3+'/');
            sql = 'SELECT * FROM `iaudit_sap_file_import` WHERE  `fk_analysis_id` = '+analysis_id+' ORDER BY id desc limit 0,1';
            dbResponse = await dblib.getData( connMaster, sql);
            
            let message = null;
            let currentFile = null;
            let progress = null;
            if(dbResponse.length > 0){
                message = dbResponse[0].message;
                currentFile = baseFilePath+'/'+dbResponse[0].table_file+'.TXT';
                progress = dbResponse[0].progress;
            }
            
            let numLines = await fh.getNumberOfLines(currentFile);

            res.jsonp({
                "success": true,
                "progress":progress,
                "message": message+' Lines '+numLines+'...'
            });


        } // End Try Block
        catch(error){
            console.log(error);
            
            res.jsonp({
                "success": false,
                "progress": 0,
                "message": error
            });
        }


} // End of Function


  
  
}); // End Middleware

module.exports = router;