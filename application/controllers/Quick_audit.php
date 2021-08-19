<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quick_audit extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}

	

	function validate_files($analysis_id){

		connect_master_db();

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>id_decode($analysis_id)],'db_name,analysis_name,client_name');

		$client_name = trim($analysis_data['client_name']);
		$analysis_name = trim($analysis_data['analysis_name']);

		$data['client_name'] = $client_name;
		$data['analysis_name'] = $analysis_name;
		$data['analysis_id'] = $analysis_id;

		if (!is_dir('uploads/'.$client_name.'/'.$analysis_name)) {
			$message = 'Files\' folder not found.' ;
			$this->session->set_flashdata('err',$message);
			redirect(base_url('import-files/'.$analysis_id));
		}

		$db_files = $this->common_model->get_entry_by_data('rfc_read_table',false,['status'=>1],'file_name');

		foreach ($db_files as $key => $value) {
			$file=fopen('./uploads/'.$client_name.'/'.$analysis_name.'/'.strtolower($value['file_name']).'.txt','r');
			$file_data = fgets($file);
			$explodeLine = explode("|",$file_data);
			pr($explodeLine);
		}

		$this->load->view('quick-audit/validate-files',$data);
		$this->load->view('inc/footer');
	}

	function import_data($analysis_id = ''){
		

		connect_master_db();
		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>id_decode($analysis_id)],'db_name,analysis_name,client_name');

		$client_name   = trim($analysis_data['client_name']);
		$analysis_name = trim($analysis_data['analysis_name']);
		$db_name = trim($analysis_data['db_name']);


		$param = $client_name.'..'.$analysis_name.'..'.$db_name;

		//echo $param; die;

		$command = "php ".FCPATH."index.php Importcli import_table_data ".$param;

		echo $command; die;
		
		//$command = "php E:/xampp7.2/htdocs/i_audit/index.php Importcli import_stream_text";
		exec($command);

		echo $command; die;




	} // End Function

	function import_data_old($analysis_id = ''){

		connect_master_db();

		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>id_decode($analysis_id)],'db_name,analysis_name,client_name');
		
		//pr($analysis_data); die;

		$client_name   = trim($analysis_data['client_name']);
		$analysis_name = trim($analysis_data['analysis_name']);
		
		$db_name = $analysis_data['db_name'];

		connect_new_db($db_name);

		$check_data = $this->common_model->count_results('agr_1016',false,[1=>1],'id');
		
		if ($check_data>0) {
			$this->common_model->run_query('truncate table agr_1016');
		}

		$open = fopen('uploads/AGR_1016.TXT','r');
			$successAr = $failAr = [];
		while (!feof($open)) 
		{
		 
		 $explodeLine = strpos( fgets($open), '|') !== false ?  explode('|',trim(fgets($open))) :  [];
		 pr($explodeLine); die;


		 if (empty($explodeLine[0]) || empty($explodeLine[7])) {
			 unset($explodeLine[0]);
			 unset($explodeLine[7]);
		 }

		$explodeLine = array_values($explodeLine);

		if (empty($explodeLine[0]) || $explodeLine[1]=='AGR_NAME') {
			continue;
		}

		$fieldsAr = array('agr_name', 'counter', 'profile', 'variant', 'generated', 'gstate');
		$insert_array = array_combine($fieldsAr, $explodeLine);

		//pr($insert_array); die;

		$data_save = $this->common_model->save_entry('agr_1016',$insert_array);

		pr($data_save); die;

		if ($data_save) {
			echo json_encode("One row saved.");
			array_push($successAr, $data_save);
		} else {
			echo json_encode("One row not saved.");
			array_push($failAr, $data_save);
			}
		}
		 
		fclose($open);

		if (count($successAr)>0) {
			echo "Total <b>".count($successAr)."</b> rows successfully saved.";
		} 

		if (count($failAr)>0) {
			echo "Total <b>".count($failAr)."</b> rows could not be saved, please try again.";
		}

	} // End Function

	function get_import_status(){
		$check_data = $this->common_model->count_results('agr_1016',false,[1=>1],'id');
		return $check_data;
	}

	function update_user(){
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['title'] = 'Update User';
		$this->load->view('users/update-user',$data);
		$this->load->view('inc/footer');
	}

	function my_profile(){
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['title'] = 'My Profile';
		$user_data = $this->get_user_data();
		if ($this->input->post('submit')) {
			$this->update_user_data();
			redirect(base_url('my-profile'));
		}
		$data['user'] = $user_data['user_data'];
		$data['states'] = $user_data['states_list'];
		$data['cities'] = $user_data['cities_list'];
		$data['occupations'] = $user_data['occupations_list'];
		$this->load->view('users/update-user',$data);
		$this->load->view('inc/footer');
	}

	function get_user_data($user_id=''){
		$posted_array = [
			'api_key' 	=> $_SESSION['api_key'],
			'create_by' => $_SESSION['uid'],
			'user_id'   => ($user_id)?$user_id:$_SESSION['uid']
		];

		$data = $this->lib_common->callAPI('POST',base_url('/api/users/get_user_data'),$posted_array);
		$response = (array)json_decode($data);
		//pr($response['user_data']);
		$return_data['user_data'] = $response['user_data'];

		$data = $this->lib_common->callAPI('POST',base_url('/api/master/states/get_states_list'),$posted_array);
		$response = (array)json_decode($data);
		$return_data['states_list'] = $response['states_list'];

		$data = $this->lib_common->callAPI('POST',base_url('/api/master/cities/get_cities_list'),$posted_array);
		$response = (array)json_decode($data);
		$return_data['cities_list'] = $response['cities_list'];

		$data = $this->lib_common->callAPI('POST',base_url('/api/master/occupations/get_occupations_list'),$posted_array);
		$response = (array)json_decode($data);
		$return_data['occupations_list'] = $response['occupations_list'];
		//die();
		return $return_data;
	}

	function update_user_data(){
		$posted_array['create_by']	=	$_SESSION['uid'];
		$posted_array['api_key']	=	$_SESSION['api_key'];
		$posted_array['user_id']		=	id_decode($this->input->post('uid'));
		$posted_array['first_name']	=	$this->input->post('first_name');
		$posted_array['last_name']	=	$this->input->post('last_name');
		$posted_array['contact']	=	$this->input->post('contact');
		$posted_array['email']		=	$this->input->post('email');
		$posted_array['blood_group']=	$this->input->post('blood_group');
		$posted_array['birth_date']	=	$this->input->post('birth_date');
		$posted_array['profile_picture']			=	$this->input->post('profile_picture');
		$posted_array['permanent_address_line1']	=	$this->input->post('permanent_address_line1');
		$posted_array['permanent_address_line2']	=	$this->input->post('permanent_address_line2');
		$posted_array['permanent_address_line3']	=	$this->input->post('permanent_address_line3');
		$posted_array['state_id']	=	$this->input->post('state_id');
		$posted_array['city_id']	=	$this->input->post('city_id');
		$posted_array['pin_code']	=	$this->input->post('pin_code');
		$posted_array['occupation_id']	=	$this->input->post('occupation_id');
		$update = $this->lib_common->callAPI('POST',base_url('/api/users/update_user_data'),$posted_array);
		$response = (array)json_decode($update);
		if ($response['status_code']==1) {
			$message = $response['message'];
			$this->session->set_flashdata('succ',$message);
		} else {
			$message = $response['message'];
			$this->session->set_flashdata('err',$message);
		}

		return $response['status_code'];
	}
}