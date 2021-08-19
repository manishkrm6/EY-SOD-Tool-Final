var express = require('express');
var router = express.Router();

const datelib = require('../lib/datelib');
const dblib = require('../lib/dblib');

const fs = require('fs');
const path = require('path');

const connMaster = { host: 'localhost', user: 'root', password: '', database: 'admin_iaudit' };
const baseFilePath =  path.join(__dirname,'../../uploads/sql');

router.get('/getStatus',(req,res,next) => {
    
    const fk_analysis_id = req.query.fk_analysis_id;

    // -- Fn Create New Analysis --
    async function getStatus(){

        let sql = '';
        let dbResponse = [];
        let progress = '';
        let message = '';
        
        try{
            
            sql = 'SELECT * FROM `iaudit_db3_creation_message` WHERE  `fk_analysis_id` = '+fk_analysis_id+" ORDER BY id desc limit 0,1"; 
            dbResponse = await dblib.getData( connMaster, sql);
            progress = dbResponse[0].progress;
            message = dbResponse[0].message;

        }
        catch(error){
            //console.log(error);
        }
        
        res.jsonp({"progress":progress,"message":message});

    } // End getStatus Fn
    
    getStatus();

}); // End Middle-Ware

// Create New Analysis Middleware
router.get('/', function(req, res, next) {
    
    const fk_analysis_id =  req.query.fk_analysis_id;
    
    

    // -- Fn Create New Analysis --
    async function createNewAnalysis(){
        
        let sql = '';
        let dbResponse = [];

        let db3 = null;
        let fk_client_id = '';
        let db2= null;
        let list_db2_tables = [];
        let connDB3 = null;
        
        try{
            sql = 'SELECT * FROM `iaudit_list_analysis` WHERE  `id` = '+fk_analysis_id; 
            dbResponse = await dblib.getData( connMaster, sql);
            db3 = dbResponse[0].db_name;
            connDB3 = { host: 'localhost', user: 'root', password: '', database: db3 };

            fk_client_id = dbResponse[0].fk_client_id;
            sql = 'SELECT * FROM `iaudit_clients` WHERE  `id` = '+fk_client_id; 
            dbResponse = await dblib.getData( connMaster, sql);
            db2 = dbResponse[0].client_database;
            
            //sql = "select * from iaudit_sod_rule_book_table_count";
            //list_db2_tables = await dblib.getData( connMaster, sql);
            
        }
        catch(error){
            //console.log(error);
        }
        
        try{
            
            allSqlsArr = [];
            
            let db3SchemaSql = fs.readFileSync(baseFilePath+'/DB3_Schema.sql').toString();
            let db3AdditionTempTablesSql = fs.readFileSync(baseFilePath+'/DB3_Schema_Additional_Temp_Tables.sql').toString();
            
            let tmp = db3SchemaSql+db3AdditionTempTablesSql;
            allSqlsArr = tmp.split(';');

            let roleBuildSql = fs.readFileSync(baseFilePath+'/proc/Role_Build.sql').toString();
            let roleAnalysisSql = fs.readFileSync(baseFilePath+'/proc/Role_Analysis.sql').toString();
            let userAnalysisSql = fs.readFileSync(baseFilePath+'/proc/User_Analysis.sql').toString();
            let rootCauseAnalysisSql = fs.readFileSync(baseFilePath+'/proc/Root_Cause_Analysis.sql').toString();
            let generalReportSql = fs.readFileSync(baseFilePath+'/proc/Generate_Report.sql').toString();

            allSqlsArr.push(roleBuildSql);
            allSqlsArr.push(roleAnalysisSql);
            allSqlsArr.push(userAnalysisSql);
            allSqlsArr.push(rootCauseAnalysisSql);
            allSqlsArr.push(generalReportSql); 

            /* for ( tblDetail of list_db2_tables){
                let tmpQuery = "INSERT INTO `"+db3+"`.`"+tblDetail.table_name+"` SELECT * FROM `"+db2+"`.`"+tblDetail.table_name+"`";
                allSqlsArr.push(tmpQuery);
            } */

            //return false;
            totalQueries = allSqlsArr.length;
            
            let result = null;
            let i = 1;
            for ( let query of allSqlsArr){
                
                result = await dblib.runQuery(connDB3,query);
                
                if( result.executionResult === "Failure"){
                    
                    let logFilePath = path.join(__dirname,'../logs/dberror.log');
                    tms = datelib.getCurrentDateTime();
                    logContent = `${tms}: Error: ${result.errorMessage} \n`;
                    fs.appendFileSync(logFilePath,logContent); 

                }

                progress = parseInt( (i * 100)/totalQueries );  
                sql = "INSERT into `iaudit_db3_creation_message` set `fk_analysis_id` = "+fk_analysis_id+", `progress` = "+progress+", `message` = '"+i+"/"+totalQueries+" Completed.'";
                result = await dblib.runQuery(connMaster,sql);

                i++;


            } // End For Loop

            if( (i - 1) == totalQueries ){
                
                sql = "UPDATE `iaudit_analysis_status_history` set `is_completed` = 1 WHERE `fk_analysis_id` = "+fk_analysis_id+" AND `fk_status_id` = 1 ";
                result = await dblib.runQuery(connMaster,sql);
                
            }

            

        }
        catch(error){
            console.log(error);
        }


    } // End Fn Create New Analysis

    createNewAnalysis();

}); // End Middleware

module.exports = router;
