<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importcli extends CI_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
		$this->load->model('common_model');
	}

	function import_table_data($param){

		//echo "Hi"; die;

		//fwrite($handle, $param);
		//fclose($handle);

		$param = explode('..', $param);

		$client_name = isset($param[0]) ? $param[0] : NULL;
		$analysis_name = isset($param[1]) ? $param[1] : NULL;
		$db_name = isset($param[2]) ? $param[2] : NULL;

		$handle = fopen(FCPATH.'uploads/'.$analysis_name.'.log','w');
		connect_master_db();

		fwrite($handle, date('Y-m-d H:i:s')." Master Database Connected".PHP_EOL);
		fclose($handle);

		$list_tables = $this->common_model->get_entry_by_data('rfc_read_table',false,array('1'=> '1'));
		//pr($list_tables); die;

		if(!empty($list_tables)){
			
			

			foreach ($list_tables as $key => $value) {

				connect_master_db();

				$table_name = $value['file_name'];
				$id = $value['id'];

				$list_columns = $this->common_model->get_entry_by_data('rfc_read_table_columns',false,array('table_id' => $id));

				//fwrite($handle, date('Y-m-d H:i:s')..PHP_EOL);
				//fclose($handle);
				//pr($list_columns);
				//die;

				$handle2 = fopen(FCPATH.'uploads/test_client/Indo_13_Oct/'.strtoupper($table_name.'.txt'),'r');
				
				connect_new_db($db_name);
				$list_table_data = $this->common_model->get_entry_by_data($table_name,false,array('1'=>'1'));

      	
        		if (count($list_table_data) > 0) {
          			$this->common_model->run_query('truncate table '.$table_name);
        		}

        		$resultSet = [];
        		$i = 0;

        		while (!feof($handle2)) 
        		{

		            $line = fgets($handle2); 
		            $explodeLine = strpos( $line, '|') !== false ?  explode('|',trim($line)) :  [];
		            
		            print_r($explodeLine); 


         		} // End While

         		fclose($handle2);
         		print formatBytes(memory_get_peak_usage()) . PHP_EOL;


			} // End Foreach

		} // End IF


		fclose($handle);


	} // End Function

	function import_large_text_file(){
		/*echo "Hello";
		die;*/

		connect_master_db();
		
		/*$result = $this->common_model->run_custom_query("CALL getTextTable()");
        pr($result);
        die;*/

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$this->load->view('quick-audit/import_large_text_file');
		$this->load->view('inc/footer');

		
		

	} // End Function

	// Ajax Function
	function get_import_status(){
		
		connect_master_db();

		$no_of_lines = $this->common_model->get_entry_by_data('counter',true,array('id'=>1));
		$total_number_lines = isset($no_of_lines['total_number_lines']) ? $no_of_lines['total_number_lines'] : 1;
		

		$n  = isset($no_of_lines['no_of_lines']) ? $no_of_lines['no_of_lines'] : 0;

		$per = ($n * 100 ) / $total_number_lines;

		echo round($per,2).' %'; die;

		

		/*echo $this->session->flashdata('progress');
		die;*/

		/*echo isset($_SESSION['progess']) ? $_SESSION['progess'] : "Not Started"; 
		die;*/

		/*$f = fopen(FCPATH.'uploads/counter.txt', 'a');
		flock($f, LOCK_EX);
		$txt =  fread($f, 100);
		flock($f, LOCK_UN);
		fclose($f);

		if(!empty($txt))
			echo $txt;
		die;*/

		/*$handleRead = fopen(FCPATH.'uploads/counter.txt', "r");
		echo fread($handleRead,100);
		fclose($handleRead);
		die;*/


	} // End Function

	function import_stream_text(){
		
		connect_master_db();

		$lines = [];
		$handle = fopen(FCPATH.'uploads/ADRP.TXT', "r");
    	
    	$i = 1;
		
		//$j = 0;

    	while(!feof($handle)) {
        	
        	//$lines[] = trim(fgets($handle));
        	$insert_array = [];
        	$insert_array['text_line'] = trim(fgets($handle));
        	$int_record = $this->common_model->save_entry('text_table',$insert_array);

        	if(!empty($int_record)){

        		if( $i % 2000 == 0 )
        			$upd_record = $this->common_model->update_entry('counter',array('no_of_lines' => $i),array('id' => 1));

        		

        		//$ins_record = $this->common_model->save_entry('counter',array('no_of_lines' => $i,'total_number_lines' => 1));

        			



        		/*$f = fopen(FCPATH.'uploads/counter.txt', 'a');
				flock($f, LOCK_EX);
				fwrite($f, $i);
				flock($f, LOCK_UN);
				fclose($f);*/

        		
				
				/*if($i == 10){

					$handleWrite = fopen(FCPATH.'uploads/'.$i.'.txt', "w");
					fwrite($handleWrite, $i);
					fclose($handleWrite);

				}*/

				/*if($i == 20 )
					exit(0);*/

				$i++;


        	}



        }

        fclose($handle);
    	print formatBytes(memory_get_peak_usage()) . PHP_EOL;

	}


	function import_text(){
		
		$data = [];
		
		$handle = fopen(FCPATH.'uploads/ADRP.TXT', "r");
    	$total_line = 0;
    	while(!feof($handle)) {

			trim(fgets($handle));
			$total_line++;

		}

		fclose($handle);

    	//print formatBytes(memory_get_peak_usage()) . PHP_EOL;

		connect_master_db();

		$upd_record = $this->common_model->update_entry('counter',array('total_number_lines' => $total_line),array('id' => 1));

		

		//outputProgress($current_progress,$total_statement);

		

		$command = "php ".FCPATH."index.php Importcli import_stream_text ";
		//$command = "php E:/xampp7.2/htdocs/i_audit/index.php Importcli import_stream_text";
		exec($command);

		

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
			$file_types = isset($_POST['file_types']) ? $_POST['file_types'] : NULL;

			$database = 'dynamic_dbs_'.$analysis_name.'_'.$client;
			$sql = " Create Database IF NOT EXISTS ".$database;
			$res = $this->db->query($sql);

			if($res){
				
				$data['database'] = $database;
				$data['analysis_name'] = $analysis_name;

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