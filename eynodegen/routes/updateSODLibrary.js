var express = require('express');
var router = express.Router();
const fileUpload =  require('express-fileupload');
router.use(fileUpload());
var Excel = require('exceljs');

const dblib = require('../lib/dblib');
const exec = require('await-exec');
const fs = require('fs');

const tbllib = require('../lib/tbllib');
const datelib = require('../lib/datelib');
const fileHandler = require('../lib/fileHandler');

const path = require('path');
const connMaster = { host: 'localhost', user: 'root', password: '', database: 'admin_iaudit' };
//const baseFilePath =  path.join(__dirname,'./tmp/');
const baseFilePath =  path.join(__dirname,'../../uploads/temp');

router.post('/',(req,res,next) => {


    let sql = '';
    let dbResponse = [];

    let db3 = null;
    let fk_client_id = '';
    let db2= null;
    
    let connDB3 = null;
    var workbook = new Excel.Workbook();
    const fk_analysis_id =  req.body.fk_analysis_id;
    
    if(req.files === null){
        res.status(400).json({"msg":'No Files Uploaded'});
    }

    updateSODLibrary();

    async function updateSODLibrary(){
		      
          //res.json({"fk_analysis_id":req.body.fk_analysis_id, post:req.files});

		      // Get Analysis Detail
          sql = 'SELECT * FROM `iaudit_list_analysis` WHERE  `id` = '+fk_analysis_id; 
          const analysisInfo = await dblib.getData( connMaster, sql);
          
          //console.log(analysisInfo);
          db3 = analysisInfo[0].db_name;
          const connDB3 = { host: 'localhost', user: 'root', password: '', database: db3 };
          fk_client_id = analysisInfo[0].fk_client_id;

          // Get Client Detail
          sql = 'SELECT * FROM `iaudit_clients` WHERE  `id` = '+fk_client_id; 
          const clientInfo = await dblib.getData( connMaster, sql);
          db2 = clientInfo[0].client_database;
		      const connDB2 = { host: 'localhost', user: 'root', password: '', database: "sap_cli0008" };

       
          result = await tbllib.truncateTable("sap_cli0008", "actcode");
          result = await tbllib.truncateTable("sap_cli0008", "sod_risk");
          result = await tbllib.truncateTable("sap_cli0008", "bus_proc");

          
          
	 
          const file = req.files.file;
          const newFileName = Date.now()+file.name;

          let returnedQueryList = await new Promise ( (resolve, reject) => {

            let listQueries = [];

            file.mv(`${baseFilePath}/${newFileName}`, (err) => {
              
              workbook.xlsx.readFile(`${baseFilePath}/${newFileName}`)
              .then(function() {

                workbook.eachSheet(function(sheet, sheetId) {
                  
                  let worksheet = workbook.getWorksheet(sheet.name);

                  worksheet.eachRow(function(row, rowNumber) {
                    
                    let rowDetail = row.values;
                    len = rowDetail.length;
                    
                    if(worksheet.name === 'actcode')
                    {
                      var activity = row.getCell(1).text;
                      var tcode = row.getCell(2).text;
                    
                      if(activity!='activity' && tcode!='tcode'){
                        
                        sql = "INSERT into "+db2+".`actcode` set `activity` = '"+activity+"', `tcode` = '"+tcode+"'";	
                        listQueries.push(sql);

                      }



                        

                    } // End IF



                  }); // End Work Book



                });

                if(listQueries.length > 0)
                  resolve(listQueries)
                else
                  reject('Oops Something Went Wrong');


  
              }); // End Then Block
  
  
            }); // End File MV

          }); // End Promise Block

          console.log(returnedQueryList);

          if( returnedQueryList.length > 0 ){

            for ( let i = 0; i <  returnedQueryList.length; i++){

              result = await dblib.runQuery(connDB2, returnedQueryList[i]);
              if( result.executionResult === "Failure"){
                console.log(result.errorMessage);
              }

            }

          } // IF

          


          //res.json({"fk_analysis_id":req.body.fk_analysis_id});

    } // End updateSODLibrary Fn

}); //


module.exports = router;
