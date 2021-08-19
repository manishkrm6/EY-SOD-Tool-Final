<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}

	function users_list(){
		$data = [];
		connect_master_db();
		$data['list_users'] = $this->common_model->get_entry_by_data('users',false,[ 'fk_user_status_id' => 1 ]);
		$this->layout->render('users/list_users',$data);

	} // End Function

	public function update_user_detail($fk_user_id = ''){

	} // End Function
	
	public function add_new_user(){
		
		$data = [];
		
		if($this->form_validation->run('add_new_user') == TRUE ){

			$first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : NULL;
			$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : NULL;
			$email = isset($_POST['email']) ? trim($_POST['email']) : NULL;
			$fk_user_type = isset($_POST['fk_user_type']) ? trim($_POST['fk_user_type']) : NULL;
			$username = isset($_POST['username']) ? trim($_POST['username']) : NULL;
			$password = isset($_POST['password']) ? trim($_POST['password']) : NULL;

			connect_master_db();

			$insert_array = [];

			$insert_array['first_name'] = $first_name;
			$insert_array['last_name'] = $last_name;
			$insert_array['email'] = $email;
			$insert_array['fk_user_type'] = $fk_user_type;
			$insert_array['user_name'] = $username;
			$insert_array['password'] = MD5($password);
			$insert_array['api_key'] = "testapikey111";
			$insert_array['create_datetime'] = date('Y-m-d H:i:s');
			$insert_array['create_by'] = $this->session->userdata('uid');
			$insert_array['fk_user_status_id'] = 1;

			

			$int_record = $this->common_model->save_entry('users',$insert_array);

			if($int_record){
				$this->session->set_flashdata('succ', "User Created Successfully.");

				echo json_encode(array("success" => 1,"message" => "User Created Successfully")); 
				die;
			}
			else{
				echo json_encode(array("success" => 0,"message" => "User Could Not be Created.")); 
				die;
			}
			
		}	
		else{
			echo json_encode(array("success" => 0,"message" =>  str_replace('</p>','',str_replace('<p>','',validation_errors()))   )); die;
		}

	} // End Function


}