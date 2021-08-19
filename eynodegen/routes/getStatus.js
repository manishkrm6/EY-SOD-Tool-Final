var express = require('express');
var router = express.Router();

const datelib = require('../lib/datelib');
const dblib = require('../lib/dblib');
const progressLib = require('../lib/progressPercentageCalculation');
//var process = require('process');

/* GET home page. */
router.get('/', function(req, res, next) {
  /* console.log("I am in getStatus.js")
    if (process.pid) {
        console.log('This process is your pid ' + process.pid);
  } */

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
        "total_role_build": 0,
        "total_estimated_role_build":0,
        "total_rcompleted": 0,
        "total_rconflicts": 0,
        "total_ucompleted": 0,
        "total_uconflicts": 0,
        "sap_report": "",
        "elapsed_time": "",
        "proc_message": "",
        "progress_summary":{},
        "shouldRequestForProgress": false,

    };

    res.jsonp(resObj);

  }

  // Handle Status

  // Handle Status Report
    
  async function  checkStatus(){
  
    try{
        
        // DB3 ===
        let db3 = null;
        let shouldRequestForProgress = true;
        let create_datetime = null;
        let process_out_time = null;

        // Get Estimated Role Build
        let total_estimated_role_build = 0;
        let total_estimated_rcompleted = 0;
        let total_estimated_ucompleted = 0;

        try{
            
            sql = 'SELECT * FROM `iaudit_list_analysis` WHERE  `id` = '+analysis_id; 
            dbResponse = await dblib.getData( connMaster, sql);
            db3 = dbResponse[0].db_name;

            create_datetime = dbResponse.length > 0 ? dbResponse[0].process_in_time : null;
            process_out_time = dbResponse.length > 0 && dbResponse[0].process_out_time != null ? dbResponse[0].process_out_time : null;
            total_estimated_ucompleted = dbResponse.length > 0 && dbResponse[0].total_users_for_analysis != null ? dbResponse[0].total_users_for_analysis : 0;

            if(create_datetime == null)
                shouldRequestForProgress = false;



            // Check If Analysis is active or not
            let is_active = dbResponse[0].is_active;
            //console.log("Hello");

            //console.log("Is active ",is_active);

            if(is_active == 0)
                shouldRequestForProgress = false;

        }
        catch(error){
            ////console.log(error);
        }

        ////console.log(db3);
        const connDB3 = { host: 'localhost', user: 'root', password: '', database: db3 };

        

        try{
            
            sql = 'SELECT count(*) as total_estimated_role_build FROM `TMP_ROLE_BUILD`';  
            dbResponse = await dblib.getData( connDB3, sql);
            total_estimated_role_build = dbResponse[0].total_estimated_role_build;
        }
        catch(error){
            //console.log(error);
        }

        // Get Total Role Build 
        let total_role_build = 0;
        try{
            sql = 'SELECT count(*) as total_role_build FROM `role_build`'; 
            dbResponse = await dblib.getData( connDB3, sql);
            total_role_build = dbResponse[0].total_role_build;
        }
        catch(error){
            //console.log(error);
        }

        // Get Total Roles To be analyzed 
        if( total_estimated_rcompleted == 0 ){
            
            try{
                sql = "select distinct u.agr_name from agr_users u  inner join tab_user_bkp t on u.uname = t.uname where  date(u.to_dat)>=curdate() and u.agr_name not like 'PROFILE:%SAP%ALL%' and u.agr_name not like 'PROFILE:%SAP%NEW%'";
                console.log(sql);
                dbResponse = await dblib.getData( connDB3, sql);
                total_estimated_rcompleted = dbResponse.length;
                console.log("Total Estimated R Completed ",total_estimated_rcompleted);
            }
            catch(error){

            }
        }

        // Get Total Role Analyzed
        let total_rcompleted = 0;
        try{
            sql = 'SELECT count(*) as total_rcompleted FROM `rcompleted`'; 
            dbResponse = await dblib.getData( connDB3, sql);
            total_rcompleted = dbResponse[0].total_rcompleted;
        }
        catch(error){
            //console.log(error);
        }

        // Get Total RConflicts
        let total_rconflicts = 0;
        try{
            
            sql = 'SELECT count(*) as total_rconflicts FROM `rconflicts`'; 
            dbResponse = await dblib.getData( connDB3, sql);
            total_rconflicts = dbResponse[0].total_rconflicts;
        }
        catch(error){
            //console.log(error);
        }

        // Get Total U Completed
        let total_ucompleted = 0;
        try{
            sql = 'SELECT count(*) as total_ucompleted FROM `ucompleted`'; 
            dbResponse = await dblib.getData( connDB3, sql);
            total_ucompleted = dbResponse[0].total_ucompleted;
        }
        catch(error){
            //console.log(error);
        }

        // Get Total UConflicts
        let total_uconflicts = 0;
        try{
            sql = 'SELECT count(*) as total_uconflicts FROM `uconflicts`'; 
            dbResponse = await dblib.getData( connDB3, sql);
            total_uconflicts = dbResponse[0].total_uconflicts;
        }
        catch(error){
            //console.log(error);
        }

        let sap_report = null;
        // Get SAP Report
        try{
            sql = 'SELECT *  FROM `sap_report`'; 
            dbResponse = await dblib.getData( connDB3, sql);
            sap_report = dbResponse;
        }
        catch(error){
            //console.log(error);
        }
        
        // Progress Summary
        let progressSummary = null;
        

        try{
            
            sql = 'SELECT * FROM `iaudit_analysis_status_history` where `fk_analysis_id` = '+analysis_id+" ORDER BY ID ASC";
            //console.log(sql);

            dbResponse = await dblib.getData( connMaster, sql);
            
            //console.log(dbResponse);

            progressSummary = progressLib.getProgressSummary(dbResponse);
            
            //console.log(progressSummary);

        }
        catch(error){
            //console.log(error);  
        }
        
        // Get Procedure Message

        let  curr_proc = '';
        let curr_proc_msg = '';
        let proc_message = '';
        
        try{

            sql = 'SELECT *  FROM `procedure_message` order by `id` DESC limit 0,1'; 
            dbResponse = await dblib.getData( connDB3, sql);
        
            curr_proc =  dbResponse[0].procedure_name;
            curr_proc_msg = dbResponse[0].message;
            proc_message = '('+curr_proc+')'+' '+curr_proc_msg ;

        }
        catch(error){
            //console.log(error);  
        }

    
        let time_diff = null;
        if(process_out_time)
            time_diff = create_datetime !== null ? datelib.getTimeDifference(create_datetime, process_out_time) : null;
        else
        time_diff = create_datetime !== null ? datelib.getTimeDifference(create_datetime, datelib.getCurrentDateTime()) : null;
        
        
        let elapsedTime = time_diff !== null ? time_diff.hours+" Hour "+time_diff.minutes+" Minute "+time_diff.seconds+" Seconds " : "Not Started Yet";

        let resObj = {

            "message": "Connection Successful",
            "total_role_build": `${total_role_build}/${total_estimated_role_build}`,
            "total_estimated_role_build":total_estimated_role_build,
            "total_rcompleted": `${total_rcompleted}/${total_estimated_rcompleted}`,
            "total_rconflicts": total_rconflicts,
            "total_ucompleted": `${total_ucompleted}/${total_estimated_ucompleted}`,
            "total_uconflicts": total_uconflicts,
            "sap_report": sap_report,
            "elapsed_time": elapsedTime,
            "proc_message": proc_message,
            "progress_summary": progressSummary,
            "shouldRequestForProgress": shouldRequestForProgress,
            
        };


        //console.log(resObj);
        res.jsonp(resObj);

    } // End Try
    catch(error){
       
        //console.log(error);
       
        let resObj = {

            "message": "Failed",
            "error": error,
            "total_role_build": 0,
            "total_estimated_role_build":0,
            "total_rcompleted": 0,
            "total_rconflicts": 0,
            "total_ucompleted": 0,
            "total_uconflicts": 0,
            "sap_report": "",
            "elapsed_time": "",
            "proc_message": "",
            "progress_summary":{},
            "shouldRequestForProgress": true,
            
            
        };
        
        res.jsonp(resObj);

    } // End Catch 

} // End of Function


  
  
}); // End Middleware

module.exports = router;