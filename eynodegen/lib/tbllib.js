const dblib = require('./dblib');

exports.getAnalysisStatusId = async ( statusCode ) => {
    
    let sql = "";
    let statusId = null;

    try{
        
        const connMaster= { host: 'localhost', user: 'root', password: '', database: "admin_iaudit" };
        sql = "SELECT `id` FROM iaudit_master_analysis_status where `status` = '"+statusCode+"'";
        let result  = await dblib.getData(connMaster,sql);
        statusId = result[0].id;

        return statusId;
    }
    catch(error){
        //console.log(error);
    }
    finally{
        statusId = null;
    }
    
    return statusId;

};

exports.copyTable = async ( sourceDB, destinationDB, tableName ) => {
    
    const connSourceDB = { host: 'localhost', user: 'root', password: '', database: sourceDB };
    const connDestinationDB = { host: 'localhost', user: 'root', password: '', database: destinationDB };

    let tf = await this.isTableExists(sourceDB,tableName);
    let sql = '';

    if( tf == 1 ){

        // Drop Table in Destination DB
        sql = " Drop Table IF Exists "+tableName;
        let result  = await dblib.runQuery(connDestinationDB,sql);

        sql = " create table "+destinationDB+"."+tableName+" select * from "+sourceDB+"."+tableName;
        console.log(sql);
        result  = await dblib.runQuery(connDestinationDB,sql);

        return result;
    }

    return 0;

};

exports.truncateTable = async ( database, tableName ) => {
    const connDB = { host: 'localhost', user: 'root', password: '', database: database };
    let tf = await this.isTableExists(database, tableName);
    if( tf == 1 ){        
        let sql = "TRUNCATE TABLE `"+tableName+"`";
        let result = await dblib.runQuery( connDB, sql);        
        return result;
    }

    return 0;

};

exports.isTableExists = async ( database, tableName ) => {
    
    const connDB = { host: 'localhost', user: 'root', password: '', database: database };
    const sql = "SELECT count(table_name) as total_table FROM information_schema.tables WHERE table_schema = '"+database+"' AND table_name = '"+tableName+"'";
    //console.log(sql);

    const dbResponse = await dblib.getData( connDB, sql);
    const totalTable = dbResponse[0].total_table;
    return totalTable;

};


