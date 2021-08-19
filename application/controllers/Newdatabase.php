<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newdatabase extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}

	
	function import_stream_text(){
		
		connect_master_db();

		$lines = [];
    	$handle = fopen(FCPATH.'uploads/ADRP.TXT', "r");

    	while(!feof($handle)) {
        	
        	//$lines[] = trim(fgets($handle));

        	$insert_array = [];

        	$insert_array['text_line'] = trim(fgets($handle));
        	$int_record = $this->common_model->saveEntry('text_table',$insert_array);

        }

        fclose($handle);
    	
    	print formatBytes(memory_get_peak_usage()) . PHP_EOL;


	}


	function import_text(){
		
		$data = [];

		$command = "php ".FCPATH."index.php Newdatabase import_stream_text  > /dev/null &";
		
		exec($command);

		connect_master_db();
		$data['list_databases'] = $this->common_model->get_entry_by_data('list_analysis',false,array('1'=>'1'));

		


		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('newdatabases/create_new_database',$data);
		$this->load->view('inc/footer');


	} // End Function

	// While Creating Database
	// No Special Character, only text, number * underscore
	// Should be of fixed length

	function create_new_database(){
		
		$data = [];

		if($this->form_validation->run('create_new_database') == TRUE){

			$uname = isset($_SESSION['name']) ? explode(' ',$_SESSION['name'])[0] : NULL;


			$analysis_name = isset($_POST['analysis_name']) ? $_POST['analysis_name'] : NULL;
			$client = isset($_POST['client']) ? $_POST['client'] : NULL;
			$file_type = isset($_POST['file_type']) ? $_POST['file_type'] : NULL;
			$system_type = isset($_POST['system_type']) ? $_POST['system_type'] : NULL;

			$database = 'dynamic_dbs_'.$analysis_name.'_'.$client;

			$sql = " Create Database IF NOT EXISTS ".$database;
			$res = $this->db->query($sql);

			if($res){


				$data['database'] = $database;
				$data['analysis_name'] = $analysis_name;
				$data['client'] = $client;
				$data['system_type'] = $system_type;
				
				



			} // End IF Res

		} // End IF Form Validation
		else{
			$this->session->set_flashdata('err',validation_errors());
		}
        
        connect_master_db();
		$data['list_databases'] = $this->common_model->get_entry_by_data('list_analysis',false,array('1'=>'1'));

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('newdatabases/create_new_database',$data);
		$this->load->view('inc/footer');

	} // End Function


} // End Class


