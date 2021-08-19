<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SOD extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}


	function view_tables_list($client_id=1){
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$data['client_id'] = $client_id;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);

		connect_new_db($client['client_database']);

		$data['tables'] = $this->common_model->run_custom_query("SELECT TABLE_NAME AS table_name
		FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".$client['client_database']."'");

		$this->load->view('sod/view-tables-list',$data);
		$this->load->view('inc/footer');
	}

	function add_new_entry($client_id=1,$table_name){
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$data['client_id'] = $client_id;
		$data['table_name'] = $table_name;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);

		connect_new_db($client['client_database']);

		$columns = $data['columns']=$this->common_model->run_custom_query("SHOW COLUMNS FROM `".$table_name."`");
		
		if ($this->input->post()) {
			$insert_array = $this->input->post();
			array_pop($insert_array);
			$int_record = $this->common_model->save_entry($table_name,$insert_array,$columns[0]['Field']);
			if ($int_record) {
				$this->session->set_flashdata('succ', 'New entry successfully added');
			} else{
				$this->session->set_flashdata('err', 'New entry could not be added. Please try again.');
			}

			redirect('sod/add-new-entry/'.$client_id.'/'.$table_name);
		}

		$this->load->view('sod/add-new-entry',$data);
		$this->load->view('inc/footer');
	}

	function view_table_entries($client_id=1,$table_name){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$data['client_id'] = $client_id;
		$data['table_name'] = $table_name;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);

		connect_new_db($client['client_database']);

		$data['columns']=$this->common_model->run_custom_query("SHOW COLUMNS FROM `".$table_name."`");

		$data['table_data'] = $this->common_model->get_entry_by_data($table_name,false,['1'=>1],'','','',50);

		#pr($this->common_model->get_last_query()); die();

		$this->load->view('sod/view-table-entries',$data);
		$this->load->view('inc/footer');
	}

	function edit_entries($client_id=1,$table_name){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$data['client_id'] = $client_id;
		$data['table_name'] = $table_name;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);

		connect_new_db($client['client_database']);
		$data['columns']=$this->common_model->run_custom_query("SHOW COLUMNS FROM `".$table_name."`");
		$data['table_data'] = $this->common_model->get_entry_by_data($table_name,false,['1'=>1],'','','',5);

		if ($this->input->post('update_entries')) {
			$columns = array_keys($this->input->post());
			$entries = $this->input->post();
			array_pop($entries);

			$update_array = [];
			$counter = 0;
			$successAr = $errorAr = [];
			foreach ($entries as $column => $entry) {
				if (empty($entries['uname'][$counter])) {
					continue;
				}
			    $update_entries['uname'] =	$uname	= 	$entries['uname'][$counter];
			    $update_entries['user_name'] 		= 	$entries['user_name'][$counter];
			    $update_entries['valid_from'] 		= 	$entries['valid_from'][$counter];
			    $update_entries['valid_to'] 		= 	$entries['valid_to'][$counter];
			    $update_entries['lockstatus'] 		= 	$entries['lockstatus'][$counter];
			    $update_entries['user_type'] 		= 	$entries['user_type'][$counter];
			    $update_entries['user_group'] 		= 	$entries['user_group'][$counter];
			    $update_entries['department'] 		= 	$entries['department'][$counter];
			    $update_entries['manager'] 			= 	$entries['manager'][$counter];
			    $update_entries['suser'] 			= 	$entries['suser'][$counter];
			    $update_entries['shared_id'] 		= 	$entries['shared_id'][$counter];
			    $update_entries['generic_id'] 		= 	$entries['generic_id'][$counter];
			    $update_entries['company'] 			= 	$entries['company'][$counter];
			    $update_entries['location'] 		= 	$entries['location'][$counter];
			    $update_entries['enabled'] 			= 	$entries['enabled'][$counter];
			    $update_entries['PASSWORD'] 		= 	$entries['PASSWORD'][$counter];
			    $update_entries['level2'] 			= 	$entries['level2'][$counter];
			    $update_entries['level3'] 			= 	$entries['level3'][$counter];
				$counter++;

				$upd_record = $this->common_model->update_entry( $table_name, $update_entries, array( 'uname' => $uname) );

				if ($upd_record) {
					array_push($successAr,$uname);
				} else{
					array_push($errorAr,$uname);
				}
			} 
			
			if ($upd_record) {
				$this->session->set_flashdata('succ', count($successAr).' entries successfully updated');
			} else{
				$this->session->set_flashdata('err', 'Entries could not be updated. Please try again.');
			}

			redirect('sod/edit-entries/'.$client_id.'/'.$table_name);
		}

		$this->load->view('sod/edit-entries',$data);
		$this->load->view('inc/footer');
	}
}