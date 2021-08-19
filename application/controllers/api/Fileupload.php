<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Fileupload extends REST_Controller{

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

  public function validateFile(){
    
    if(!empty($_FILES['userfiles'])){

          $i = 0;
          foreach ($_FILES['userfiles'] as $key => $value) {

              $size = isset($_FILES['userfiles']['size'][$i]) ? $_FILES['userfiles']['size'][$i] : NULL;
              $fileName = isset($_FILES['userfiles']['name'][$i]) ? $_FILES['userfiles']['name'][$i] : NULL;

              $fileNameCmps = explode(".", $fileName);
              $fileExtension = strtolower(end($fileNameCmps));

              if( NULL != $fileName && !in_array($fileExtension, unserialize(ALLOWED_FILE_TYPES) ) ){
                  
                  $this->form_validation->set_message("validateFile","($fileName) .$fileExtension File Type  is not allowed."); 
                  return false;   
              }

              if(NULL != $size && $size > ALLOWED_FILE_SIZE){
                
                $this->form_validation->set_message("validateFile"," ($fileName) File Size Must be less than ".(ALLOWED_FILE_SIZE/1024/1024)." MB  "); 
                return false;
              }

              $i++;

          } // End Foreach

      } // End IF Not Empty Files
      else{

          $this->form_validation->set_message("validateFile","At least One File must be Selected."); 
          return false; 
      }

      return true;


  } // End Function

  public function upload_new_files_post(){
    
    $data = [];
    
    $uploaded_files = [];
    $invalid_files = [];

    $upload_path = isset($_POST['upload_path']) ? trim($_POST['upload_path']) : NULL;

    if ( $this->form_validation->run('api_upload_new_files') == TRUE ){
        
        $uploadResult = $this->lib_common->uploadFiles($_FILES['userfiles'],$upload_path);
        if(!empty($uploadResult)) {

            foreach ($uploadResult as $key => $value) {

                if($value['is_uploaded'] == 'YES')
                  array_push($uploaded_files,$value['filename']);
                else if($value['is_uploaded'] == 'NO')
                  array_push($invalid_files,$value['filename']);
                
            } // End Foreach

        } // End IF

        if(!empty($uploaded_files)){

            $data['response'] = "Success";
            $data['message'] = count($uploaded_files)." Files Uploaded Successfully.";
            $data['data']['uploaded_files'] = $uploaded_files;
            $data['data']['invalid_files'] = $invalid_files;

            $this->response($data,REST_Controller::HTTP_OK);
        }
        else{
            
            $data['response'] = "Failed";
            $data['message'] = count($invalid_files)." Files could not be uploaded";
            $data['data']['uploaded_files'] = $uploaded_files;
            $data['data']['invalid_files'] = $invalid_files;
            $this->response($data,REST_Controller::HTTP_OK);
        }

    }
    else{
        
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        
        $data['data']['uploaded_files'] = NULL;
        $data['data']['invalid_files'] = NULL;

        $this->response($data,REST_Controller::HTTP_OK);
    }

  } // End Function

  

  

} // End Class

