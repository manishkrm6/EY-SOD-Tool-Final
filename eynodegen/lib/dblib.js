const mysql = require('mysql2');

exports.runQuery = async ( connObject, sql ) => {
    
    let pool = null;
    let errorMsg = '';
    let result = { "executionResult": "", errorMessage: ""} ;
    

    try{
        pool = mysql.createPool(connObject);
        // now get a Promise wrapped instance of that pool
        const promisePool = pool.promise();
        // query database using promises
        result = { "executionResult": await promisePool.query(sql), errorMessage: ""} ;
        
        pool.end();
        //return result;
    }
    catch(error){
         errorMsg = JSON.stringify(error);
         result = { "executionResult": "Failure", errorMessage: errorMsg} ;
    }
    finally{
        pool.end();
    }

   return result;


};

exports.getData = async ( connObject,  sql ) => {
    
    let pool = null
    try{

        pool = mysql.createPool(connObject);
        // now get a Promise wrapped instance of that pool
        const promisePool = pool.promise();
        // query database using promises
        const [rows,fields] = await promisePool.query(sql);
        
        pool.end();
        return rows;
    }
    catch(error){
        //console.log(error);
    }
    finally{
        pool.end();
    } 
};
 



