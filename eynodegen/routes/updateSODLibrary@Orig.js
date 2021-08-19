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
const baseFilePath =  path.join(__dirname,'../tmp/');

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
        
    const file = req.files.file;
    const newFileName = Date.now()+file.name;
    await file.mv( `${baseFilePath}/${newFileName}`, (err) => {

        workbook.xlsx.readFile(`${baseFilePath}/${newFileName}`)
        .then(function() {
            
            workbook.eachSheet(function(sheet, sheetId) {
                var worksheet = workbook.getWorksheet(sheet.name);
                    worksheet.eachRow({ includeEmpty: true, }, function(row, rowNumber) {
                    //console.log("Row " + rowNumber + " = " + JSON.stringify(row.values));
                    let rowDetail = row.values;
                    len = rowDetail.length;
                    
                    console.log(rowDetail);

                    /* for ( let i = 1; i < len; i++){
                        
                        
                        
                    } */


                });
            });

            fs.unlinkSync(`${baseFilePath}/${newFileName}`);

            res.json({fileName:newFileName,filePath:`${baseFilePath}/${newFileName}`})

        });
        if(err){
            console.error(err);
            return res.status(500).send(err);
        }  
        // End of Reading Excel File
        
    });  // End File Upload

        

    } // End updateSODLibrary Fn

}); //

router.get('/getUpdateSODStatus',(req,res,next) => {
    
    let sql = '';
    let dbResponse = [];
    let db3 = null;
    const fk_analysis_id =  req.query.fk_analysis_id;
    
    getUpdateSODStatus();
    
    async function getUpdateSODStatus(){
        //res.jsonp({"success":1, "message":message, "progress":progress });
    } // End Function

});

module.exports = router;
