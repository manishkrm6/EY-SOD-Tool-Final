<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// Connect DB 1
if( !function_exists('connect_master_db') ){

    function connect_master_db(){
        
        $CI = & get_instance();
        $config_app = switch_db(DATABASE_USERNAME,DATABASE_PASSWORD,MASTER_DATABASE,MASTER_DATABASE_PREFIX);
        $CI->common_model->app_db = $CI->load->database($config_app,TRUE);
        
        //print_r($CI->common_model->app_db);
        //die;
    }
}

if( !function_exists('connect_new_db') ){

    function connect_new_db($database){
        
        $CI = & get_instance();

        $config_app = switch_db(DATABASE_USERNAME,DATABASE_PASSWORD,$database);
        $CI->common_model->app_db = $CI->load->database($config_app,TRUE);
    }
}

if( !function_exists('switch_db') ){
    
    function switch_db( $user_name, $password, $name_db , $db_prefix = '')
    {
        
        $config_app['hostname'] = 'localhost';
        $config_app['username'] = $user_name;
        $config_app['password'] = $password;
        $config_app['database'] = $name_db;
        $config_app['dbdriver'] = 'mysqli';
        $config_app['dbprefix'] = $db_prefix;
        $config_app['pconnect'] = FALSE;
        $config_app['db_debug'] = (ENVIRONMENT !== 'production');
        
        return $config_app;
    }
}


