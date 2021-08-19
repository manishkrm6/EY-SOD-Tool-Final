<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// use namespace
use Restserver\Libraries\REST_Controller;

class Login extends REST_Controller{

  function __construct()
  {
      // Construct the parent class
      parent::__construct();
      // Configure limits on our controller methods
      // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
      $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
      $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
      $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
      
  }

  public function login_post(){

    $user_name = isset($_POST['user_name']) ?  trim($_POST['user_name']) : NULL;
    $password = isset($_POST['password']) ?  str_rot13(trim($_POST['password'])) : NULL;
    
    // Status Code 1 => Successful login, 0 => Failed Login, -1 => Form Validation Error 

    if( $this->form_validation->run('api_login') == TRUE ){
      
      connect_master_db();
      
      $res = $this->common_model->get_entry_by_data('users',true,array('fk_user_status_id' => 1, 'user_name' => $user_name, 'password' => MD5($password)));
      
      if(!empty($res)){

          $user = [];
          
          $user['id'] = isset($res['id']) ? $res['id'] : NULL;
          $user['first_name'] = isset($res['first_name']) ? $res['first_name'] : NULL;
          $user['last_name'] = isset($res['last_name']) ? $res['last_name'] : NULL;
          $user['fk_user_type'] = isset($res['fk_user_type']) ? $res['fk_user_type'] : NULL;
          $user['api_key'] = isset($res['api_key']) ? $res['api_key'] : NULL;
          $user['email'] = isset($res['email']) ? $res['email'] : NULL;
          $user['contact'] = isset($res['contact']) ? $res['contact'] : NULL;
          $user['fk_user_status_id'] = isset($res['fk_status_id']) ? $res['fk_status_id'] : NULL;
          


          $data['status_code'] = 1;
          $data['response'] = "Success";
          $data['message'] = "Login Successful.";
          $data['data']['user'] = $user;
          $this->response($data,REST_Controller::HTTP_OK);


        }
        else{

            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "Invalid Username Or Password ";
            $data['data']['user'] = NULL;
            $this->response($data,REST_Controller::HTTP_OK);
        }

    } // End IF Form Validation
    else{

        $data['status_code'] = -1;
        $data['response'] = "Failed";
        $data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
        $data['data']['user'] = NULL;
        $this->response($data,REST_Controller::HTTP_OK);
    }

  } // End Function

  public function forgot_password_post(){
    $contact_number = $this->input->post('contact_number');
    if (!empty($contact_number)) {
      $check_contact_number = $this->common_model->get_entry_by_data('users',true,array('contact' => $contact_number),'id');
      if (!empty($check_contact_number)) {
        $otp = rand(1000,9999);
        $insert_array = [
          'fk_user_id'    =>  $check_contact_number['id'],
          'contact_number'=>  $contact_number,
          'otp'           =>  $otp,
          'create_datetime' => CURRENT_DATETIME,
          'status'     => 'Pending'
        ];

        $data_saved = $this->common_model->save_entry('otp_verification',$insert_array);
        
        if ($data_saved) {
            $data['status_code'] = 1;
            $data['response'] = "Success";
            $data['message'] = "Housing Society password OTP ".$otp.' For password reset. This is valid only for 5 minutes';
        } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "OTP couldn't be generated, please try again.";
        }

      } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "This contact number is not available in your database.";
      }
            $this->response($data,REST_Controller::HTTP_OK);
    }
  }

  public function otp_verification_post(){
    $contact_number = $this->input->post('contact_number');
    $otp_number     = $this->input->post('otp_number');

    if (!empty($contact_number) && !empty($otp_number)) {

      $check_otp = $this->common_model->get_entry_by_data('otp_verification',true,array('contact_number' => $contact_number,'otp'=>$otp_number,'status'=>'Pending'),'fk_user_id,create_datetime');
      if (!empty($check_otp)) {
        $fk_user_id = $check_otp['fk_user_id'];
        $otp_create_time = $check_otp['create_datetime'];
        $create_time = new DateTime($otp_create_time);
        $current_time   = new DateTime(CURRENT_DATETIME);
        $interval   = $create_time->diff($current_time);

        $time_difference = $interval->i;

        if ($time_difference>5) {
          $update_data_array['status'] =  'Expired';
          $update_data = $this->common_model->update_entry('otp_verification',$update_data_array,array('contact_number'=>$contact_number,'otp'=>$otp_number,'status'=>'Pending'));
          if ($update_data) {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "OTP expired. Please try again.";
          } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "OTP status couldn't be updated. Please try again.";
          }
        } else {
          $update_data_array['verification_datetime'] = CURRENT_DATETIME;
          $update_data_array['status']                =  'Verified';
  $update_data = $this->common_model->update_entry('otp_verification',$update_data_array,array('contact_number'=>$contact_number,'otp'=>$otp_number,'status'=>'Pending'));
  if($update_data){
        $data['status_code'] = 1;
            $data['response'] = "Success";
            $data['message'] = "OTP verified successfully.";
            $data['user_id'] = $fk_user_id;
        } else{
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "OTP status couldn't be updated. Please try again.";
            $data['user_id'] = NULL;
            }
        }

      } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "Invalid OTP number.";
            $data['user_id'] = NULL;
      }
    } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "Contact number & OTP is required.";
            $data['user_id'] = NULL;
    }
    $this->response($data,REST_Controller::HTTP_OK);
  }

  public function change_password_post(){
    $user_id      = $this->input->post('user_id');
    $new_password = $this->input->post('new_password');
    if (!empty($user_id) && !empty($new_password)) {
        $update_data_array['password'] = md5($new_password);
        $update_data_array['update_datetime'] =  CURRENT_DATETIME;
        $update_data_array['update_by'] =  $user_id;
  $update_data = $this->common_model->update_entry('users',$update_data_array,array('id'=>$user_id));
  if($update_data){
        $data['status_code'] = 1;
            $data['response'] = "Success";
            $data['message'] = "Password successfully changed.";
          } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "Password couldn't be changed. Please try again.";
            }
    } else {
            $data['status_code'] = 0;
            $data['response'] = "Failed";
            $data['message'] = "User Id & New Password is required.";
    }
    $this->response($data,REST_Controller::HTTP_OK);
  }

} // End Class

       