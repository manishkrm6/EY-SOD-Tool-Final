var express = require('express');
var router = express.Router();
const dblib = require('../lib/dblib');
const exec = require('await-exec');
const fs = require('fs');
const tbllib = require('../lib/tbllib');
const datelib = require('../lib/datelib');
const fileHandler = require('../lib/fileHandler');


const path = require('path');
const connMaster = { host: 'localhost', user: 'root', password: '', database: 'admin_iaudit' };
const baseFilePath =  path.join(__dirname,'../../uploads/Clients');
const sqlBaseFilePath = path.join(__dirname,'../../uploads/sql');

router.get('/',(req,res,next) => {
    
    let sql = '';
    let dbResponse = [];

    let db3 = null;
    let fk_client_id = '';
    let db2= null;
    
    let connDB3 = null;

    const fk_analysis_id =  req.query.fk_analysis_id;

    importToMySql();

    async function importToMySql(){
        
        try{
            
            sql = 'SELECT * FROM `iaudit_list_analysis` WHERE  `id` = '+fk_analysis_id; 
            dbResponse = await dblib.getData( connMaster, sql);
            db3 = dbResponse[0].db_name;
            
            connDB3 = { host: 'localhost', user: 'root', password: '', database: db3 };
    
            fk_client_id = dbResponse[0].fk_client_id;
            sql = 'SELECT * FROM `iaudit_clients` WHERE  `id` = '+fk_client_id; 
            dbResponse = await dblib.getData( connMaster, sql);
            db2 = dbResponse[0].client_database;

            //sql = "SELECT file_name FROM iaudit_rfc_read_table WHERE  status = 1"; 
            //dbResponse = await dblib.getData( connMaster, sql);
            //console.log(dbResponse);

        }
        catch(error){
            //console.log(error);
        }

        const dirPath = (baseFilePath+'/'+db2+'/'+db3).replace(/\\/g, "/");
        const analysisLogFilePath = baseFilePath+'/'+db2+'/'+db3+'/'+db3+'_log.log';
        const userDetailsSql = fs.readFileSync(sqlBaseFilePath+'/DB3_User_Details_Script.sql').toString();
        const zCodeSql = fs.readFileSync(sqlBaseFilePath+'/DB3_ZCodes_Script.sql').toString();

        const userDetailsSqlArr = userDetailsSql.split(";");
        const zCodeSqlArr = zCodeSql.split(";");

        //console.log(userDetailsSqlArr);
        //console.log(zCodeSqlArr);

        

        const totalTxtFiles = await fileHandler.getNumberOfFilesInDir(dirPath,".txt")
                             .then( total => total )
                             .catch( error => console.log(error));

        

        await fs.readdir(dirPath, (err, files) => {
            
            // Create a New Directory For Chunk Files
            if (!fs.existsSync(dirPath+"/sql_chunks")){
                fs.mkdirSync(dirPath+"/sql_chunks");
            }

            let txtFileDoneCounter = 1;

            files.forEach( async (file) => {

                // Get File Extension 
                fileExt = path.extname(dirPath+'/'+file);
                //console.log(fileExt);

                if(fileExt === '.sql'){
                    
                    listQueries = fs.readFileSync(dirPath+"/"+file).toString();
                    listQueriesArr = listQueries.split(";\r");
                    
                    // Preparing Batch Of 50 Queries

                    const n = 50;
                    const batches = new Array(Math.ceil(listQueriesArr.length / n))
                    .fill()
                    .map(_ => listQueriesArr.splice(0, n))

                    let x = 0;
                    let totalBatch = batches.length;

                    for (queryBatch of batches){
                        
                        let batchString = queryBatch.join(';\r\n');
                        fs.writeFileSync(dirPath+"/sql_chunks/chunk_"+x+".sql",batchString);

                        let cmd = "mysql -u root  "+db3+" < "+dirPath+"/sql_chunks/chunk_"+x+".sql";

                        await exec(cmd, (error, stdout, stderr) => {
                            
                            if (error) {
                                //console.log(`error: ${error.message}`);
                                fs.appendFileSync(dirPath+"/chunk_error.log",error.message);
                                return;
                            }
                            if (stderr) {
                                console.log(`stderr: ${stderr}`);
                                fs.appendFileSync(dirPath+"/chunk_error.log",stderr);
                                return;
                            }
                            console.log(`stdout: ${stdout}`);
                        });
                        
                        let progress =  ( (x*100)/totalBatch ).toFixed(2);
                        sql = `INSERT into iaudit_import_db3_message set fk_analysis_id = ${fk_analysis_id}, message="${progress} % completed", progress=${progress}`;
                        dbResponse = await dblib.runQuery(connMaster,sql);
                        x++;

                    } // End For Loop

                    // Remaining Percentage Progress Update
                    let progress =  ( (x*100)/totalBatch ).toFixed(2);
                    sql = `INSERT into iaudit_import_db3_message set fk_analysis_id = ${fk_analysis_id}, message="${progress} % completed", progress=${progress}`;
                    dbResponse = await dblib.runQuery(connMaster,sql);

                     // Clean Up after 100 % work done execute after 5 Second
                     if( parseInt(progress) == 100 ){
                        
                        let statusId = await tbllib.getAnalysisStatusId("UPLOAD_COMPLETED");
                        sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+fk_analysis_id+" AND `fk_status_id` = "+statusId;
                        result = await dblib.runQuery(connMaster,sql);

                        setTimeout( async () => {
                            sql = `delete from iaudit_import_db3_message where fk_analysis_id = ${fk_analysis_id}`;
                            dbResponse = await dblib.runQuery(connMaster,sql);

                        },5000);
                     }

                } // End IF Check File Ext Sql
                else if ( fileExt === '.txt'){
                    
                    //const tempDirPath = dirPath.replace(/\\/g, "/");
                    

                    // Truncate all Tables in DB3
                    let fileNameWtExt = file.split(".")[0];

                    try{
                        result = await tbllib.truncateTable(db3, fileNameWtExt);
                        sql = " LOAD DATA INFILE '"+dirPath+"/"+file+"' INTO TABLE "+fileNameWtExt+" FIELDS TERMINATED BY  '|' LINES STARTING BY  '|'; "; 
                        //console.log(sql);

                        result = await dblib.runQuery(connDB3,sql);

                        if( result.executionResult === "Failure"){

                            tms = datelib.getCurrentDateTime();
                            let logContent = `${tms}: Error: ${result.errorMessage} \n`;
                            fs.appendFileSync(analysisLogFilePath,logContent);
                        }
                        else{

                            let progress =  ( (txtFileDoneCounter*100)/totalTxtFiles ).toFixed(2);
                            sql = `INSERT into iaudit_import_db3_message set fk_analysis_id = ${fk_analysis_id}, message="${progress} % completed", progress=${progress}`;
                            dbResponse = await dblib.runQuery(connMaster,sql);

                            // Clean Up after 100 % work done execute after 5 Second
                            if( parseInt(progress) == 100 ){
                                
                                //console.log(userDetailsSqlArr);
                                //console.log(zCodeSqlArr);
                                for (sql of userDetailsSqlArr){
                                    
                                    result = await dblib.runQuery(connDB3,sql);
                                }
                                
                                for (sql of zCodeSqlArr){
                                    result = await dblib.runQuery(connDB3,sql);
                                }


                                let statusId = await tbllib.getAnalysisStatusId("UPLOAD_COMPLETED");
                                sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+fk_analysis_id+" AND `fk_status_id` = "+statusId;
                                result = await dblib.runQuery(connMaster,sql);

                                setTimeout( async () => {
                                    sql = `delete from iaudit_import_db3_message where fk_analysis_id = ${fk_analysis_id}`;
                                    dbResponse = await dblib.runQuery(connMaster,sql);

                                },5000);


                            }


                            
                        }   
                        
                    }   
                    catch(error){
                        console.log(error);
                    }  

                    if(txtFileDoneCounter <= totalTxtFiles){
                        txtFileDoneCounter++;
                    }
                     

                } // End IF Check File Ext Txt

            }); // Foreach Loop


        }); // End Block Read dir

        res.jsonp({"is_completed":1,"message": "Request has been Received by Server" });

    } // End importToSql Fn

}); //

router.get('/getImportStatus',(req,res,next) => {
    
    let sql = '';
    let dbResponse = [];
    let db3 = null;
    const fk_analysis_id =  req.query.fk_analysis_id;
    
    getImportStatus();
    
    async function getImportStatus(){

        sql = `SELECT * FROM iaudit_import_db3_message where fk_analysis_id = ${fk_analysis_id} ORDER BY id DESC limit 0,1`;
        dbResponse = await dblib.getData( connMaster, sql);
        
        
        let progress = dbResponse.length == 1 ? parseInt(dbResponse[0].progress) : 0;
        let message = dbResponse.length == 1 ? dbResponse[0].message : null;
        
        res.jsonp({"success":1, "message":message, "progress":progress });

    } // End Function

});

module.exports = router;
