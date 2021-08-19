<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Saptxtfileread extends REST_Controller{

  function __construct()
  {
    // Construct the parent class
    parent::__construct();

    // Configure limits on our controller methods
    // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
    $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
    $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
    $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    //Test API Key: 21232f297a57a5a743894a0e4a801fc3

  }
  
  function validateFilePath(){
    return true;
  }

  function validateDatabase(){
    return true;
  }

  function validateFile(){
   return true; 
  }


  function get_txt_file_content_post(){
    
    if($this->form_validation->run('api_get_txt_file_content')){

        // Text
        connect_master_db();
        $list_columns = $this->common_model->get_entry_by_data('rfc_read_table_columns',false,array('table_id' => 1));

        pr($list_columns); die;


        //pr($_POST); die;
        $file_path = isset($_POST['file_path']) ? $_POST['file_path'] : NULL;
        $database = isset($_POST['database']) ? $_POST['database'] : NULL;
        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : NULL;
        
        $table_name = strtolower(explode('.',$file_name)[0]);
        
        connect_new_db($database);
        $num_row = $this->common_model->count_results($table_name,false,array('1'=>'1'));
      
        if ($num_row > 0) {
          $this->common_model->run_query('truncate table '.$table_name);
        }
        
        $open = fopen(FCPATH.$file_path,'r');
        
        $resultSet = [];
        $i = 0;

        while (!feof($open)) 
        {
        
            $line = fgets($open); 
            $explodeLine = strpos( $line, '|') !== false ?  explode('|',trim($line)) :  [];
            //pr($explodeLine); die;

            if(!empty($explodeLine)){
              $resultSet[$i++] = $explodeLine;
              pr($resultSet[$i]);
            }


         } // End While

         fclose($open);

          //pr($resultSet); die;

          if(!empty($resultSet)){
            
            $data['status_code'] = 1;
            $data['response'] = "Success";
            $data['message'] = count($resultSet)." Rows Extracted";
            $data['data']['resultSet'] = $resultSet;

          }

        $this->response($data,REST_Controller::HTTP_OK);


    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['user'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }

  } // End Function

} // End Class

