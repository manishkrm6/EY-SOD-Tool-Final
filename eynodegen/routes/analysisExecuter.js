var express = require('express');
var router = express.Router();

const dblib = require('../lib/dblib');
const tbllib = require('../lib/tbllib');
const fs = require('fs');
const datelib = require('../lib/datelib');
const path = require('path');
var process = require('process');

const runAnalysis =  ( analysisId ) => {
    
  executer();
  async function executer(){
      
      const connMaster = { host: 'localhost', user: 'root', password: '', database: 'admin_iaudit' };
      const baseFilePath =  path.join(__dirname,'../../uploads/Clients');
      
      // === Fetch DB3 Info ===
      try{
          
          let sql = null;
          let statusId = null;

          // Get Analysis Detail
          sql = 'SELECT * FROM `iaudit_list_analysis` WHERE  `id` = '+analysisId; 
          const analysisInfo = await dblib.getData( connMaster, sql);
          
          //console.log(analysisInfo);
          db3 = analysisInfo[0].db_name;
          const connDB3 = { host: 'localhost', user: 'root', password: '', database: db3 };

          fk_client_id = analysisInfo[0].fk_client_id;

          // Get Client Detail
          sql = 'SELECT * FROM `iaudit_clients` WHERE  `id` = '+fk_client_id; 
          const clientInfo = await dblib.getData( connMaster, sql);
          db2 = clientInfo[0].client_database;
          
          //console.log("DB3 "+db3);

          let result = null;
          let logContent = null;
          let tms = null;

          const analysisLogFilePath = baseFilePath+'/'+db2+'/'+db3+'/'+db3+'_log.log';
          
          // Set Status Analysis Started
          statusId = await tbllib.getAnalysisStatusId("START_ANALYSIS_COMPLETED");
          sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+analysisId+" AND `fk_status_id` = "+statusId;
          result = await dblib.runQuery(connMaster,sql);
          
          // Update Process ID For Runing Analysis
          if (process.pid) {
            sql = "UPDATE `iaudit_list_analysis` SET `is_active` = 1, `process_id` = '"+process.pid+"', `process_in_time` = '"+datelib.getCurrentDateTime()+"'  WHERE `id` =  "+analysisId ;
            result = await dblib.runQuery(connMaster,sql);
          }
            
          // Copy DB2 into DB3
          sql = "select * from iaudit_sod_rule_book_table_count";
          list_db2_tables = await dblib.getData( connMaster, sql);
          
          for ( tblDetail of list_db2_tables){
            
            sql = "INSERT INTO procedure_message (id, procedure_name, message, create_datetime) VALUES (NULL, 'Copy Operation DB2 to DB3', 'copying table "+tblDetail.table_name+"', '"+datelib.getCurrentDateTime()+"')";
            result = await dblib.runQuery(connDB3,sql);
            
            // Error Handling
            if( result.executionResult === "Failure"){
                
                tms = datelib.getCurrentDateTime();
                logContent = `${tms}: Error: ${result.errorMessage} \n`;
                fs.appendFileSync(analysisLogFilePath,logContent);

            }

            sql = "INSERT INTO `"+db3+"`.`"+tblDetail.table_name+"` SELECT * FROM `"+db2+"`.`"+tblDetail.table_name+"`";
            result = await dblib.runQuery(connDB3,sql);

            // Error Handling
            if( result.executionResult === "Failure"){
                
                tms = datelib.getCurrentDateTime();
                logContent = `${tms}: Error: ${result.errorMessage} \n`;
                fs.appendFileSync(analysisLogFilePath,logContent);

            }
            

         } // End For Loop

          sql = "INSERT INTO tab_user_bkp select * from tab_user";
          result = await dblib.runQuery(connDB3,sql);
          
          // Preparation of Tab User Table
          //result = await tbllib.truncateTable(db3, "tab_user");
          //result = await tbllib.copyTable(db2, db3, "tab_user");
          
          //result = await tbllib.truncateTable(db3, "user_details");
          //result = await tbllib.copyTable(db2, db3, "user_details");

          tms = datelib.getCurrentDateTime();
          logContent = `${tms}: DB2 And DB3 Database are now ready for executing Procedures.\n`;
          fs.writeFileSync(analysisLogFilePath,logContent);

          


          // Role Build Part - 1 Execution

          tms = datelib.getCurrentDateTime();
          logContent = `${tms}: Executing Role Build Part  Procedure.\n`;
          fs.appendFileSync(analysisLogFilePath,logContent);
          
          sql = "call usp_Role_Build('"+db3+"',NULL,NULL,NULL,0,0,0)";
          result = await dblib.runQuery(connDB3,sql);
          
          // Error Handling
          if( result.executionResult === "Failure"){
              tms = datelib.getCurrentDateTime();
              logContent = `${tms}: Error: ${result.errorMessage} \n`;
              fs.appendFileSync(analysisLogFilePath,logContent);
          }

          // Set Status Analysis Prepared
          statusId = await tbllib.getAnalysisStatusId("ANALYSIS_PREPARATION_COMPLETED");
          sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+analysisId+" AND `fk_status_id` = "+statusId;
          result = await dblib.runQuery(connMaster,sql);


          // Role Analysis  Execution
          tms = datelib.getCurrentDateTime();
          logContent = `${tms}: Executing Role Analysis Procedure.\n`;
          fs.appendFileSync(analysisLogFilePath,logContent);

          sql = "call usp_role_analysis('TAS')";
          result = await dblib.runQuery(connDB3,sql);

          // Error Handling
          if( result.executionResult === "Failure"){
              tms = datelib.getCurrentDateTime();
              logContent = `${tms}: Error: ${result.errorMessage} \n`;
              fs.appendFileSync(analysisLogFilePath,logContent);
          }

          // Set Status Role Analysis Completed
          statusId = await tbllib.getAnalysisStatusId("ROLE_ANALYSIS_COMPLETED");
          sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+analysisId+" AND `fk_status_id` = "+statusId;
          result = await dblib.runQuery(connMaster,sql);

          // User Analysis Execution

          tms = datelib.getCurrentDateTime();
          logContent = `${tms}: Executing User Analysis Procedure.\n`;
          fs.appendFileSync(analysisLogFilePath,logContent);
          
          sql = "call usp_User_Analysis('TAS',0,0,'"+db3+"')";
          result = await dblib.runQuery(connDB3,sql);

          // Error Handling
          if( result.executionResult === "Failure"){
              tms = datelib.getCurrentDateTime();
              logContent = `${tms}: Error: ${result.errorMessage} \n`;
              fs.appendFileSync(analysisLogFilePath,logContent);
          }
          

          // Set Status User Analysis Completed
          statusId = await tbllib.getAnalysisStatusId("USER_ANALYSIS_COMPLETED");
          sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+analysisId+" AND `fk_status_id` = "+statusId;
          result = await dblib.runQuery(connMaster,sql);

          // Root Cause Analysis Execution

          tms = datelib.getCurrentDateTime();
          logContent = `${tms}: Executing Root Cause Analysis Procedure.\n`;
          fs.appendFileSync(analysisLogFilePath,logContent);

          sql = "call usp_Root_Cause_Analysis(1)";
          result = await dblib.runQuery(connDB3,sql);

          // Error Handling
          if( result.executionResult === "Failure"){
              tms = datelib.getCurrentDateTime();
              logContent = `${tms}: Error: ${result.errorMessage} \n`;
              fs.appendFileSync(analysisLogFilePath,logContent);
          }

          // Set Status Root Cause Analysis Completed
          statusId = await tbllib.getAnalysisStatusId("ROOT_CAUSE_ANALYSIS_COMPLETED");
          sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+analysisId+" AND `fk_status_id` = "+statusId;
          result = await dblib.runQuery(connMaster,sql);

          // General Dashboard Report
          tms = datelib.getCurrentDateTime();
          logContent = `${tms}: Executing General Dashboard Report Procedure.\n`;
          fs.appendFileSync(analysisLogFilePath,logContent);

          sql = "call Generate_report('"+db3+"')";
          result = await dblib.runQuery(connDB3,sql);

          // Error Handling
          if( result.executionResult === "Failure"){
              tms = datelib.getCurrentDateTime();
              logContent = `${tms}: Error: ${result.errorMessage} \n`;
              fs.appendFileSync(analysisLogFilePath,logContent);
          }
          

          // Set Status General Dashboard Completed
          statusId = await tbllib.getAnalysisStatusId("DASHBOARD_COMPLETED");
          sql = "UPDATE `iaudit_analysis_status_history` SET `is_completed` = 1, `create_datetime` = '"+datelib.getCurrentDateTime()+"' WHERE `fk_analysis_id` =  "+analysisId+" AND `fk_status_id` = "+statusId;
          result = await dblib.runQuery(connMaster,sql);

          // Process Finished
            sql = "UPDATE `iaudit_list_analysis` SET `is_active` = 0 , `process_out_time` = '"+datelib.getCurrentDateTime()+"' WHERE `id` =  "+analysisId ;
            result = await dblib.runQuery(connMaster,sql);
        





          return { "status":1, "msg": "The Analysis has been completed"};



      }
      catch(error){
          console.log(error);
      }
  };

}; // End Run Fn

/* GET home page. */
router.get('/', function(req, res, next) {
  
  const analysisId = req.query.fk_analysis_id;
  async function runNodeAnalysis(){
        
        runAnalysis(analysisId);
        // Set Response
        res.jsonp({ "status": 1,"msg":"Analysis is runing"});
    }

    try{
        runNodeAnalysis();
    }
    catch(error){
        res.jsonp({"message":"true","analysisInfo": analysisInfo });
    }

}); // End Middleware

module.exports = router;