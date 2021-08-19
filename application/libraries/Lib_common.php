<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_common extends CI_Controller {
    
    private $CI;


 	  function __construct()
    {
      $this->CI = get_instance();
    }
    
    /*
      Returns an Array of Percentage against Status 
    */

    function get_analysis_completion_summary( $analysis_id = '' ){


      $data = [];

      if($analysis_id == ''){

        // Card 1
        $data['status_analysis_detail'] = 0;
        $data['status_upload'] = 0;

        $data['extract_status'] = 0;

        // Card 2
        $data['status_select_users'] = 0;
        $data['status_finalize_rules'] = 0;
        $data['status_start_analysis'] = 0;

        $data['configure_status'] = 0;

        // Card 3
        
        $data['status_analysis_preparation'] = 0;
        $data['status_role_analysis'] = 0;
        $data['status_user_analysis'] = 0;
        $data['status_enforce_org_check'] = 0;

        $data['analysis_status'] = 0;

        // Card 4

        $data['status_dashboard'] = 0;
        //$data['status_reports'] = 0;

        $data['status_all_reports'] = 0;

        $data['overall_status'] = 0;

        return $data;

      }

      $data['status_analysis_detail'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('ANALYSIS_DETAIL_COMPLETED'));
      $data['status_upload'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('UPLOAD_COMPLETED'));

      $sum = $data['status_analysis_detail'] + $data['status_upload'];
      $percentage = round( (($sum * 100)/2) , 2 );

      $data['extract_status'] = $percentage;

      // Card 2
      $data['status_select_users'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('SELECT_USERS_COMPLETED'));
      $data['status_finalize_rules'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('FINALIZE_RULES_COMPLETED'));
      $data['status_start_analysis'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('START_ANALYSIS_COMPLETED'));

      $sum = $data['status_select_users'] + $data['status_finalize_rules'] + $data['status_start_analysis'];
      $percentage = round( (($sum * 100)/3) , 2 );
      $data['configure_status'] = $percentage;


      
      // Card 3
      $data['status_analysis_preparation'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('ANALYSIS_PREPARATION_COMPLETED'));
      $data['status_role_analysis'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('ROLE_ANALYSIS_COMPLETED'));
      $data['status_user_analysis'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('USER_ANALYSIS_COMPLETED'));
      $data['status_enforce_org_check'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('ROOT_CAUSE_ANALYSIS_COMPLETED'));

      $sum = $data['status_analysis_preparation'] + $data['status_role_analysis'] + $data['status_user_analysis'] + $data['status_enforce_org_check'];
      $percentage = round( (($sum * 100)/4) , 2 );
      $data['analysis_status'] = $percentage;


      // Card 4
      $data['status_dashboard'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('DASHBOARD_COMPLETED'));
      //$data['status_reports'] = $this->is_analysis_stage_completed( $analysis_id, $this->get_analysis_status_id('REPORTS_COMPLETED'));
      
      //$sum = $data['status_dashboard'] + $data['status_reports'] ;
      $sum = $data['status_dashboard'];
      $percentage = round( (($sum * 100)/1) , 2 );
      $data['status_all_reports'] = $percentage;

      // Compute Overall Status
      
      $sum = ($data['extract_status'] + $data['configure_status'] + $data['analysis_status'] + $data['status_all_reports']);
      $percentage = round( (($sum * 100)/400),2);

      $data['overall_status'] = $percentage;
      

      return $data;

    } // End Function

    /*
      Return 0 or 1
    */
    function is_analysis_stage_completed( $fk_analysis_id, $fk_status_id ){

      $info = $this->CI->common_model->get_entry_by_data('analysis_status_history',true,array('fk_status_id' => $fk_status_id, 'fk_analysis_id' => $fk_analysis_id));
      if(!empty($info) && isset($info['is_completed'])){
        return $info['is_completed'];
      }

      return 0;
      
    } // End Function

    function create_analysis_status($fk_analysis_id){
      
      $effective_date = date('Y-m-d H:i:s');

      // ANALYSIS_DETAIL_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('ANALYSIS_DETAIL_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "Analysis Details Created";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // UPLOAD_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('UPLOAD_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // SELECT_USERS_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('SELECT_USERS_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);


      // FINALIZE_USERS_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('FINALIZE_RULES_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);
      
      // START_ANALYSIS_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('START_ANALYSIS_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // ANALYSIS_PREPARATION_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('ANALYSIS_PREPARATION_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // ROLE_ANALYSIS_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('ROLE_ANALYSIS_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // USER_ANALYSIS_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('USER_ANALYSIS_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // ROOT_CAUSE_ANALYSIS_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('ROOT_CAUSE_ANALYSIS_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // DASHBOARD_COMPLETED

      $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('DASHBOARD_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array);

      // REPORTS_COMPLETED

      /* $insert_array = [];
      
      $insert_array['fk_analysis_id'] = $fk_analysis_id;
      $insert_array['fk_status_id']  = $this->get_analysis_status_id('REPORTS_COMPLETED');
      $insert_array['is_completed']  = 0;
      $insert_array['remarks'] = "";
      $insert_array['create_datetime'] = $effective_date;
      $insert_array['create_by'] = $_SESSION['uid'];

      $int_record = $this->CI->common_model->save_entry('analysis_status_history',$insert_array); */

      return 1;


    } // End Function

    function get_analysis_status_code($id){
      
      connect_master_db();
      $info = $this->CI->common_model->get_entry_by_data( 'master_analysis_status', true, array( 'id' => $id ) );

      if( !empty($info) && isset($info['status']) ){
        return $info['status'];
      }

      return NULL;

    } // End Function
    
    function get_analysis_status_id($code){

      connect_master_db();
      $info = $this->CI->common_model->get_entry_by_data( 'master_analysis_status', true, array( 'status' => $code ) );

      if( !empty($info) && isset($info['id']) ){
        return $info['id'];
      }

      return NULL;

    } // End Function

    function get_total_line_count_file($file_path){
      
      $linecount = 0;
      $handle = fopen($file_path, "r");
      while(!feof($handle)){
        $line = fgets($handle);
        $linecount++;
      }

      fclose($handle);
      
      return $linecount;

    } // End Function

    function backup_db_table($db_name,$path,$table_name = ''){

      if(DATABASE_PASSWORD == ''){
          $cmd = "mysqldump -u ".DATABASE_USERNAME."  ".$db_name." ".$table_name." > ".$path;
          //echo $cmd;
      }
      else {
         $cmd = "mysqldump -u ".DATABASE_USERNAME." -p ".DATABASE_PASSWORD." ".$db_name." ".$table_name." > ".$path;
        //echo $cmd;
      }

      return exec($cmd);
      
    } // End Function

    

    function copy_table( $source_db, $destination_db, $table){

      if( $this->is_table_exists($source_db,$table) ){

        // Drop Table IF Exists
        connect_new_db($destination_db);  
        $sql = " Drop Table IF Exists ".$table;
        $result = $this->CI->common_model->run_query($sql);

        // Create & Copy Table

        if( ! $this->is_table_exists($destination_db, $table) ){
            $sql = " create table ".$destination_db.".$table select * from ".$source_db.".$table ";
            $this->CI->common_model->run_query($sql); 
        }


      }
      
      
    } // End Function

    function truncate_table($database,$table){
      
      connect_new_db($database);
      
      if( $this->is_table_exists($database, $table) ){
        
        $sql = " TRUNCATE Table ".$table;
        $result = $this->CI->common_model->run_query($sql);

        if($result)
        return true;

      } // End IF

      return false;

    } // End Function

    function drop_table($database,$table){
      
      connect_new_db($database);

      $sql = " DROP TABLE IF EXISTS `".$table."`";
      $result = $this->CI->common_model->run_query($sql);

      if($result)
        return true;

      return false;

    }

    function truncate_list_tables($database,$list_table){

      if(!empty($list_table)){
        foreach ($list_table as $table) {
          $sql = " TRUNCATE `".$database."`.`".$table."`";
          $result = $this->CI->common_model->run_query($sql);
        } // End Foreach
      } // End IF

      return true;

    } // End Function

    // Empty every table in database but will not delete schemas of tables
    function truncate_database($database){

          $sql = "SELECT count(table_name) as total_table
          FROM information_schema.tables
          WHERE table_schema = '".$database."'
          AND table_name = '".$table_name."'";

      return true;

    } // End Function

    
    function is_table_exists($database, $table_name){
      
      $sql = "SELECT count(table_name) as total_table
      FROM information_schema.tables
      WHERE table_schema = '".$database."'
      AND table_name = '".$table_name."'";
      
      //echo $sql; die;
      $result = $this->CI->common_model->run_custom_query($sql);
      $total_table = isset($result[0]['total_table']) ? $result[0]['total_table'] : 0;

      if($total_table == 1)
        return true;

      return false;

    } // End Function

    function create_db3_procedures($database){

      connect_new_db($database);

      $list_sql_files = [];
      $list_sql_files = getProceduresListFiles();

      
      //pr($list_sql_files); die;
      if(!empty($list_sql_files)){
        
        foreach ($list_sql_files as $key => $sql_file) {

            $file_path = FCPATH."uploads/sql/Proc/".trim($sql_file);

            $sql = trim(file_get_contents($file_path));
            $this->CI->common_model->run_query($sql);
            

        } // End Foreach Loop

      } // End IF

    } // End Function

    function create_db3_schema($database,$analysis_name){

      connect_new_db($database);
      $list_sql_files = [];
      $list_sql_files = getTableLines();

      if(!empty($list_sql_files)){
          foreach ($list_sql_files as $key => $sql_file) {
              
              $file_path = FCPATH."uploads/sql/".trim($sql_file);
              $sql = file_get_contents($file_path);
              $sqls = explode(';', $sql);
              array_pop($sqls);
              $total_statement = count($sqls);
              $current_progress = 0;
              foreach($sqls as $statement){
                  $statement = $statement . ";";
                  $this->CI->common_model->run_query($statement);
                  $current_progress++;
                  outputProgress($current_progress,$total_statement);
              }
          }
      } // End IF

    } // End Function

    function import_tab_user_from_db3_to_db2($analysis_id){

        connect_master_db();
        $analysis_id =  $analysis_id;

        $analysisInfo = $this->CI->common_model->get_entry_by_data('list_analysis',true,array('id' => $analysis_id));
        $clientInfo = $this->CI->common_model->get_entry_by_data('clients',true,array('id' => $analysisInfo['fk_client_id']));
        
        //pr($analysisInfo);
        //pr($clientInfo); die;

        $db2 = $clientInfo['client_database'];
        $db3 = $analysisInfo['db_name'];

        /*echo "DB 2 ".$db2;
        echo "DB 3 ".$db3;
        die;*/


        if( ! $this->is_table_exists($db2, "tab_user") ){
          $sql = " create table ".$db2.".tab_user select * from ".$db3.".tab_user ";
          $this->CI->common_model->run_query($sql); 
        }

        return true;

    } // End Function

    function import_user_details_from_db3_to_db2($analysis_id){

        connect_master_db();
        $analysis_id =  $analysis_id;

        $analysisInfo = $this->CI->common_model->get_entry_by_data('list_analysis',true,array('id' => $analysis_id));
        $clientInfo = $this->CI->common_model->get_entry_by_data('clients',true,array('id' => $analysisInfo['fk_client_id']));
        
        //pr($analysisInfo);
        //pr($clientInfo); die;

        $db2 = $clientInfo['client_database'];
        $db3 = $analysisInfo['db_name'];

        /*echo "DB 2 ".$db2;
        echo "DB 3 ".$db3;
        die;*/


        if( ! $this->is_table_exists($db2, "user_details") ){

          $sql = " create table ".$db2.".user_details select * from ".$db3.".user_details ";
          $this->CI->common_model->run_query($sql);  
        }
        
        return true;

    } // End Function

    function import_db2_into_db3($analysis_id){

      connect_master_db();
      $analysis_id =  $analysis_id;

      $analysisInfo = $this->CI->common_model->get_entry_by_data('list_analysis',true,array('id' => $analysis_id));
      $clientInfo = $this->CI->common_model->get_entry_by_data('clients',true,array('id' => $analysisInfo['fk_client_id']));

      //pr($analysisInfo);
      //pr($clientInfo); die;

      $db2 = $clientInfo['client_database'];
      $db3 = $analysisInfo['db_name'];


      $list_db_std_tables = $this->CI->common_model->get_entry_by_data('sod_rule_book_table_count',false,array('1' => '1'));

      //pr($list_db_std_tables); die;

      $sql = [];
      $i = 0;

      if(!empty($list_db_std_tables)){

        $total_statement = count($list_db_std_tables);
        $current_progress = 0;
        echo "Importing SOD Library...";
        foreach ($list_db_std_tables as $key => $value) {
        
          $sql = " insert into ".$db3.'.'.$value['table_name']." select * from ".$db2.'.'.$value['table_name'];
          $this->CI->common_model->run_query($sql);  
          $current_progress++;
          outputProgress($current_progress,$total_statement);

        } // End Foreach

      } // End IF 

    } // End Function

    function isValidUser($create_by){
      
      $info = $this->CI->common_model->get_entry_by_data('users',true,array('id' => $create_by ),'id');
      if(!empty($info))
        return true;

      return false;
    } // End Function

    function isValidAPIKey($create_by, $api_key){
      
      $info = $this->CI->common_model->get_entry_by_data('users',true,array( 'id' => $create_by, 'api_key' => $api_key ),'id');
      
      if(!empty($info))
        return true;

      return false;
      
    } // End Function

    function generateSessionInfo($uDetail){

            $data = [];

            $data['uid'] = isset($uDetail['id']) ? trim($uDetail['id']) : NULL;
            $first_name = isset($uDetail['first_name']) ? ucfirst(strtolower($uDetail['first_name'])) : NULL;
            $last_name = isset($uDetail['last_name']) ? ucfirst(strtolower($uDetail['last_name'])) : NULL;

            $data['name'] = $first_name.' '.$last_name;
            $data['fk_user_type'] = isset($uDetail['fk_user_type']) ? $uDetail['fk_user_type'] : NULL;
            $data['api_key'] = isset($uDetail['api_key']) ? $uDetail['api_key'] : NULL;
            $data['ugroup'] = isset($uDetail['ugroup']) ? $uDetail['ugroup'] : NULL;
            $data['email'] = isset($uDetail['email']) ? $uDetail['email'] : NULL;
            $data['contact'] = isset($uDetail['contact']) ? $uDetail['contact'] : NULL;
            $data['fk_status_id'] = isset($uDetail['fk_status_id']) ? $uDetail['fk_status_id'] : NULL;
            
            return $data;

    } // End Function

    public function remember_admin($user_name, $password)
	  {	
        $cookie=array(
              'name'=>'el_rem_user_name',
              'domain' => '',
              'path'   => '/',
              'expire'=>2592000 + time(),
              'value'=> $user_name
        );
        $cookie1=array(
              'name'=>'el_rem_password',
              'expire'=>2592000 + time(),
              'value'=>$password 
        );
        set_cookie($cookie);
        set_cookie($cookie1);
	  } 
	
    public function delete_cookie()
    {
      
      $del_cookie = array(
                    'name'   => 'el_rem_user_name',
              );
      delete_cookie($del_cookie);
      $del_cookie1 = array(
                    'name'   => 'el_rem_password',
                              );
      delete_cookie($del_cookie1);
    }
    
    function renameFile($userfiles,$user_id){
        
        if(!empty($userfiles['name'])){
          $len = count($userfiles['name']);
          for($i = 0; $i < $len; $i++){
              $ext = pathinfo($userfiles['name'][$i], PATHINFO_EXTENSION);
              $userfiles['name'][$i] = $user_id.'-'.date('d-m-Y-H-i-s').'-'.rand().'.'.$ext;
          }

        } // End IF
        return $userfiles;

    } // End Function  

    function uploadFiles($userfiles,$path){

          $len = count($userfiles['name']);
          $allowedfileExtensions = unserialize(ALLOWED_FILE_TYPES);

          $message = [];

          for($i = 0; $i < $len; $i++){

            $fileTmpPath = $userfiles['tmp_name'][$i] ? $userfiles['tmp_name'][$i] : NULL;
            $fileName = $userfiles['name'][$i] ? $userfiles['name'][$i] : NULL;
            $fileSize = $userfiles['size'][$i] ? $userfiles['size'][$i] : NULL;
            $fileType = $userfiles['type'][$i] ? $userfiles['type'][$i] : NULL;

            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $message[$i]['filename'] =    $fileName;

            if (in_array($fileExtension, $allowedfileExtensions)) {

                  
                  $uploadFileDir = $path;
                  $dest_path = FCPATH.$uploadFileDir.$fileName;
                  
                  if(move_uploaded_file($fileTmpPath, $dest_path))
                  {
                      $message[$i]['is_uploaded'] = "YES";
                  }
                  else
                  {
                      $message[$i]['is_uploaded'] = "NO";
                      
                  }

            } // End IF Check File Extension
            else{
              $message[$i]['is_uploaded'] = "NO";
            }

            $message[$i]['error'] = isset($userfiles['error'][$i]) ? $userfiles['error'][$i] : NULL;
          } // End For Loop


          return $message;
             
    } // End Function

    function callAPIBasicAuth(){

      $login = 'tlc0nn3ctf0rt3wdl';
      $password = 'telesonic##0098';
      $url = 'https://ltesd.telesonic.in:8443/tmsapp_api/v1/connected_device';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      
      curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
      
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, '{"serial": "T5D7S18320913971"}');
      curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json','key: 64df95454c3f4f0896647a2d01cbef15')); 


      $result = curl_exec($ch);
      curl_close($ch);  

      pr(json_decode($result));

  } // End Function

  function callAPI($method, $url, $data){
              
      $curl = curl_init();

       switch ($method){

      //case "GET":
      //curl_setopt($curl, CURLOPT_GET, 1);
      //break;
        
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
      }

       // OPTIONS:
       curl_setopt($curl, CURLOPT_URL, $url);
       // curl_setopt($curl, CURLOPT_HTTPHEADER, array(
       //    'Content-Type: application/json',
       // ));

       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

       // EXECUTE:
       $result = curl_exec($curl);
       
       //pr($result); die;

       if(!$result){ die("Connection Failure"); }
       curl_close($curl);
       return $result;

  } // End Function

} // End Class