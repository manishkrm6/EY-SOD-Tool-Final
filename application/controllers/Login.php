<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	function __construct()
    {	
		// Construct the parent class
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('inc/header');

		if (isset($_SESSION['uid'])) {
			redirect(base_url('/dashboard'));
		}

		//pr($_POST); die;

		if ($this->input->post('username')) {

			$data['user_name'] = $this->input->post('username');
			$data['password'] = str_rot13($this->input->post('password'));
			$response = json_decode($this->lib_common->callAPI('POST',base_url('/api/login/login'),$data));

			$info = [];
			$session = [];

			if(isset($response->response) && $response->response == "Success"){
				if( isset($response->data->user) && !empty($response->data->user) ){
					
					$info = (array) $response->data->user;
					$session = $this->lib_common->generateSessionInfo($info);
					$this->session->set_userdata($session);

					/* -------- Library Call to save username and password in cookie ----------- */
					if($this->input->post('remember'))
						$this->lib_common->remember_admin($this->input->post('username'), $this->input->post('password'));
					else if(!$this->input->post('remember'))
						$this->lib_common->delete_cookie();
						
				/* -------- End Block Library Call to save username and password in cookie --- */

					redirect(base_url('dashboard'));
				}
			}

			$this->session->set_flashdata('err',"Invalid Username Or Password.");
			redirect(base_url());

		}
		

		
		$this->load->view('login');

		//$this->load->view('inc/footer');

	}
	
	public function logout(){
		
		$data = [];
		
		if( !empty($this->session->all_userdata()) ){

			foreach ($this->session->all_userdata() as $key => $value) {
				$this->session->unset_userdata($key);
			}


			$this->session->set_flashdata('succ',"You have been Logout.");
			redirect(base_url());
		}

		redirect(base_url('dashboard'));
		
	} // End Function

	public function validateValidUser(){
		
		connect_master_db();
		$email = isset($_POST['email']) ? trim($_POST['email']) : NULL;
		$info = $this->common_model->get_entry_by_data('users',true,array('email' => $email),'id');

		if(empty($info)){
			$this->form_validation->set_message("validateValidUser","Email Doesn't exist in the system."); 
        	return false; 
		}
		return true;

	} // End Function

	public function validateConfirmPassword(){
		
		$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : NULL;
		$confirm_password =  isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : NULL;
		
		if( $new_password !== $confirm_password ){
			$this->form_validation->set_message("validateConfirmPassword"," Both Password must be same."); 
        	return false;
		}

		return true;
		
	} // End Function

	public function forgot_password(){
		
		$data = [];

		if($this->form_validation->run('forgot_password') == TRUE ){
			
			connect_master_db();

			$email = isset($_POST['email']) ? trim($_POST['email']) : NULL;
			$info = $this->common_model->get_entry_by_data('users',true,array('email' => $email));

			$uid = isset($info['id']) ? id_encode(trim($info['id'])) : NULL;
			$name = ucfirst(strtolower($info['first_name'])).' '.ucfirst(strtolower($info['last_name']));
			
			//echo $uid; die;

			$subject = "Password Reset Link - EY SOD Tool";
			$email_data = [];
			$message_body = " <a target = '_blank' href = '".base_url()."password-reset-ey-sod-tool/".$uid."'>Click on Password Reset Link</a>";
			$email_data['recipient_name'] = $name;
           	$email_data['message_body'] = $message_body;

			//pr($email_data); die;

           		$message = $this->load->view('email_notification/forgot_password',$email_data,true);
			     


           	if( send_mail($email, $subject, $message,$cc_recipients='', $from='') ){

				$this->session->set_flashdata('succ','Reset Link Sent to Email.');
				echo json_encode(array("success" => 1, "message" => "Password Reset Email Sent Successfully."));
				die;
				
           	}
           	else{
				
				echo json_encode( array("success" => 0, "message" => "Password Reset Email Could Not Sent.") );
				die;
           		//$this->session->set_flashdata('err','Email Could not be sent to Your Registered Email Address');	
           	}
			
			
           	//redirect(base_url());

		} // End IF
		else{

			echo json_encode(array("success" => 0, "message" => validation_errors()));
			die;

			//$this->session->set_flashdata('err',validation_errors());
			//redirect(base_url());
		}

	} // End Function

	public function password_reset($uid = ''){
		
		$data = [];
		if($this->form_validation->run('password_reset') == TRUE){
			
			connect_master_db();

			$uid = isset($_POST['uid']) ? id_decode(trim($_POST['uid'])) : NULL;
			$new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : NULL;

			$update_array = [];

			$update_array['password'] = MD5($new_password);
			$update_array['update_datetime'] = date('Y-m-d H:i:s');
			$update_array['update_by'] = $uid;

			$upd_record = $this->common_model->update_entry('users',$update_array,array('id' => $uid));
			
			if($upd_record){
				$this->session->set_flashdata('succ',"Password Changed Successfully.");
			}
			else{
				$this->session->set_flashdata('succ',"Password Could not be changed,Please Retry.");	
			}

			redirect(base_url());

		} // End IF
		else{
			$this->session->set_flashdata('err',validation_errors());
		}

		$uid = ($uid != '') ? trim($uid) : NULL;
		$data['uid'] = $uid;

		$this->layout->render_password_reset('password_reset',$data);
		
	} // End Function


}
