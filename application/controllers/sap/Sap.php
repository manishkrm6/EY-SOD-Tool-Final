<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('saprfc.php');
require_once('SAP-tables-list.php');

class Sap extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();	

	} // End Function

	function connections_list(){
		
		$data = [];

		connect_master_db();
		$data['connections'] = $this->common_model->get_entry_by_data('sap_connections',false,['status'=>1]);
		$data['clients'] = $this->common_model->get_entry_by_data('clients',false,['status'=>1],'','ASC','client_name');
		
		// pr($data); die;
		
		/*$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('sap/list',$data);
		$this->load->view('inc/footer');*/
		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
		
		$this->layout->render('sap/list_sap_connection',$data);


		if ($this->input->post()) {

			$connection_id	=	implode(',',$this->input->post('connection_id'));
			$status = $this->input->post('update_status');

			$where = " id in (".$connection_id.") ";
			$upd_record = $this->common_model->update_entry('sap_connections', ['active_inactive'=>$status,'update_datetime'=>CURRENT_DATETIME,'update_by'=>$_SESSION['uid']],$where);
			//pr($this->common_model->get_last_query()); die();
			if ($upd_record) {
				$this->session->set_flashdata('succ', 'Data successfully updated.');
			} else {
				$this->session->set_flashdata('err', 'Data could not be updated. Please try again.');
			}

			redirect('sap/connections-list/');
		}

		

	} // End Function


	function connections_list_old(){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		connect_master_db();
		$data['connections'] = $this->common_model->get_entry_by_data('sap_connections',false,['status'=>1]);
		$this->load->view('sap/list',$data);

		if ($this->input->post()) {

			$connection_id	=	implode(',',$this->input->post('connection_id'));
			$status = $this->input->post('update_status');

			$where = " id in (".$connection_id.") ";
			$upd_record = $this->common_model->update_entry('sap_connections', ['active_inactive'=>$status,'update_datetime'=>CURRENT_DATETIME,'update_by'=>$_SESSION['uid']],$where);
			//pr($this->common_model->get_last_query()); die();
			if ($upd_record) {
				$this->session->set_flashdata('succ', 'Data successfully updated.');
			} else {
				$this->session->set_flashdata('err', 'Data could not be updated. Please try again.');
			}

			redirect('sap/connections-list/');
		}

		$this->load->view('inc/footer');

	} // End Function

	function save_new_connection_ajax(){
		
		$data = [];
		
		$data['success'] = 0;
		$data['message'] = '';
		
		//pr($_POST); die;
		
		
		if ($this->input->post()) {
			
			connect_master_db();
			
			$insert_data['fk_client_id']		=	isset($_POST['client_id']) ? $_POST['client_id'] : NULL;
			$insert_data['connection_name']		=	isset($_POST['connection_name']) ? $_POST['connection_name'] : NULL;
			$insert_data['ashost']				=	isset($_POST['ashost']) ? $_POST['ashost'] : NULL;
			$insert_data['sysnr']				=	isset($_POST['sysnr']) ? $_POST['sysnr'] : NULL;
			$insert_data['client']				=	isset($_POST['client']) ? $_POST['client'] : NULL;
			$insert_data['user']				=	isset($_POST['user']) ? $_POST['user'] : NULL;
			$insert_data['passwd']				=	isset($_POST['password']) ? $_POST['password'] : NULL;
			
			$insert_data['gwhost']				=	isset($_POST['gwhost']) ? $_POST['gwhost'] : NULL;
			$insert_data['gwserv']				=	isset($_POST['gwserv']) ? $_POST['gwserv'] : NULL;
			$insert_data['mshost']				=	isset($_POST['mshost']) ? $_POST['mshost'] : NULL;
			$insert_data['r3name']				=	isset($_POST['r3name']) ? $_POST['r3name'] : NULL;
			$insert_data['group']				=	isset($_POST['group']) ? $_POST['group'] : NULL;
			$insert_data['lang']				=	isset($_POST['lang']) ? $_POST['lang'] : NULL;
			$insert_data['tsfile']				=	isset($_POST['tsfile']) ? $_POST['tsfile'] : NULL;
			$insert_data['active_inactive']		=	"Active";
			
			$insert_data['status']		=	1;
			$insert_data['create_datetime']		=	CURRENT_DATETIME;
			$insert_data['create_by']			=	$_SESSION['uid'];

			$save = $this->common_model->save_entry('sap_connections',$insert_data);

			if ($save) {
				
				$data['success'] = 1;
				$data['message'] = 'New entry successfully added';
				
				//$this->session->set_flashdata('succ', 'New entry successfully added');
			} else {
				
				$data['success'] = 0;
				$data['message'] = 'New entry could not be added. Please try again.';
				
				//$this->session->set_flashdata('err', 'New entry could not be added. Please try again.');
			}
			
		}
		
		echo json_encode($data); die;
		
		
	} // End Function
	
	function create_new_connection(){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		connect_master_db();
		$data['clients'] = $this->common_model->get_entry_by_data('clients',false,['status'=>1],'id,serial_no,client_name');
		$this->load->view('sap/add-new',$data);

		if ($this->input->post()) {
			
			$insert_data['fk_client_id']		=	$this->input->post('client_id');
			$insert_data['connection_name']		=	$this->input->post('connection_name');
			$insert_data['ashost']				=	$this->input->post('ashost');
			$insert_data['sysnr']				=	$this->input->post('sysnr');
			$insert_data['client']				=	$this->input->post('client');
			$insert_data['user']				=	$this->input->post('user');
			$insert_data['passwd']				=	$this->input->post('password');
			$insert_data['gwhost']				=	$this->input->post('gwhost');
			$insert_data['gwserv']				=	$this->input->post('gwserv');
			$insert_data['mshost']				=	$this->input->post('mshost');
			$insert_data['r3name']				=	$this->input->post('r3name');
			$insert_data['group']				=	$this->input->post('group');
			$insert_data['lang']				=	$this->input->post('lang');
			$insert_data['tsfile']				=	$this->input->post('tsfile');
			$insert_data['active_inactive']		=	$this->input->post('active_inactive');
			$insert_data['status']		=	1;
			$insert_data['create_datetime']		=	CURRENT_DATETIME;
			$insert_data['create_by']			=	$_SESSION['uid'];

			$save = $this->common_model->save_entry('sap_connections',$insert_data);

			if ($save) {
				$this->session->set_flashdata('succ', 'New entry successfully added');
			} else {
				$this->session->set_flashdata('err', 'New entry could not be added. Please try again.');
			}

			redirect('sap/connections-list/');
		}

		$this->load->view('inc/footer');

	}

	function view_connection_details($connection_id){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		connect_master_db();
		$connection_id = id_decode($connection_id);

		$data['connection'] = $this->common_model->get_entry_by_data('sap_connections',true,['id'=>$connection_id]);
		$this->load->view('sap/view-connection',$data);
	}

	function edit_connection_details($connection_id){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		connect_master_db();
		$connection_id = id_decode($connection_id);

		$data['clients'] = $this->common_model->get_entry_by_data('clients',false,['status'=>1],'id,serial_no,client_name');
		$data['connection'] = $this->common_model->get_entry_by_data('sap_connections',true,['id'=>$connection_id]);

		if ($this->input->post()) {
			
			$update_data['fk_client_id']		=	$this->input->post('client_id');
			$update_data['connection_name']		=	$this->input->post('connection_name');
			$update_data['ashost']				=	$this->input->post('ashost');
			$update_data['sysnr']				=	$this->input->post('sysnr');
			$update_data['client']				=	$this->input->post('client');
			$update_data['user']				=	$this->input->post('user');
			$update_data['passwd']				=	$this->input->post('password');
			$update_data['gwhost']				=	$this->input->post('gwhost');
			$update_data['gwserv']				=	$this->input->post('gwserv');
			$update_data['mshost']				=	$this->input->post('mshost');
			$update_data['r3name']				=	$this->input->post('r3name');
			$update_data['group']				=	$this->input->post('group');
			$update_data['lang']				=	$this->input->post('lang');
			$update_data['tsfile']				=	$this->input->post('tsfile');
			$update_data['active_inactive']		=	$this->input->post('active_inactive');
			$update_data['status']				=	1;
			$update_data['create_datetime']		=	CURRENT_DATETIME;
			$update_data['create_by']			=	$_SESSION['uid'];

			$save = $this->common_model->update_entry('sap_connections',$update_data,['id'=>$connection_id]);

			if ($save) {
				$this->session->set_flashdata('succ', 'Entry successfully updated');
			} else {
				$this->session->set_flashdata('err', 'Entry could not be updated. Please try again.');
			}

			redirect('sap/connections-list/');
		}

		$this->load->view('sap/edit-connection',$data);
	}

	function delete_connection($connection_id){
		
			$connection_id = id_decode($connection_id);
			connect_master_db();
			$upd_record = $this->common_model->update_entry('sap_connections', ['status'=>0,'update_datetime'=>CURRENT_DATETIME,'update_by'=>$_SESSION['uid']],['id'=>$connection_id]);

			if ($upd_record) {
				$this->session->set_flashdata('succ', 'Data successfully deleted.');
			} else {
				$this->session->set_flashdata('err', 'Data could not be deleted. Please try again.');
			}

			redirect('sap/connections-list/');
	}
	
	function create_connection_ajax($client_id){
		
		$data = [];
		
		$data['success'] = 0;
		$data['message'] = '';
		
		//pr($_POST); die;


		
		
		if ($this->input->post('sap_import')) {
			
			//echo "Am I here"; die;
			
			$connection_id = $this->input->post('connection_id');
			$analysis_id = $this->input->post('analysis_id');
			$client_id = $this->input->post('client_id');
			
			 $connection    = $this->create_sap_connection($connection_id);
			
			if ( $connection  ) {
				
				$data['success'] = 1;
				$data['message'] = 'Sap connection successfully done.';
				
			} else {
				
				$data['success'] = 0;
				$data['message'] = 'SAP Server not reachable, please try again.';
			}
			
		}
		
		echo json_encode($data); die;
		
		
	} // End Funcation
	
	function create_connection($client_id){
			
			$this->load->view('inc/header');
			$this->load->view('inc/left-sidebar');

			$data = [];

			if ($this->input->post('sap_import')) {
				
				$connection_id = $this->input->post('connection_id');
				$analysis_id = $this->input->post('analysis_id');
				$client_id = $this->input->post('client_id');

				$connection    = $this->create_sap_connection($connection_id);

				if ($connection) {
						$this->session->set_flashdata('succ', 'Sap connection successfully done.');
			        redirect(base_url('import-files/'.$client_id.'?cid='.id_encode($connection_id).'&analysis_id='.$analysis_id));
			        } else {
						$this->session->set_flashdata('err', "SAP Server not reachable, please try again.");
						redirect(base_url('import-files/'.$client_id));
			        }
			}
			
				
			$this->load->view('sap/import',$data);
	}

	function create_sap_connection($connection_id) { # sapconnectionokornot

	   $login_sap = $this->sapconfig($connection_id);
	    $criteria = $options = '';

	    $rfc = saprfc_open($login_sap);
	    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");
	    
	    saprfc_function_free($fce);
	    saprfc_close($rfc);

	    if (!$fce) {
			return false;
        }else 
        {
			return true;
        }
	}


	function sapconfig($connection_id) {
	        // return ['ASHOST' => '192.168.1.29', 'SYSNR' => '00', 'CLIENT' => '800', 'USER' => 'sapuser', 'PASSWD' => 'india123', 'LANG' => 'EN'];
			connect_master_db();
	        $connection = $this->common_model->get_entry_by_data('sap_connections',true,['id'=>$connection_id],'ashost,sysnr,client,user,passwd');
	        return $connection;
	}

	
	
	function import_data_ajax(){
			
		connect_master_db();
		
		$data = [];
		
		$data['success'] = 0;
		$data['message'] = '';
		
		
		
		$client_id 		= isset($_POST['client_id']) ? $_POST['client_id'] : NULL;
		$analysis_id 	= isset($_POST['analysis_id']) ? $_POST['analysis_id'] : NULL;
		$connection_id 	= isset($_POST['connection_id']) ? $_POST['connection_id'] : NULL;
		
		//pr($_POST); die;
		

		$this->load->library('Lib_txtuploadrule');

		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $client_id),'client_database');
		$client_database = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>$analysis_id],'db_name');

		$analysis_database 			= trim($analysis_data['db_name']);
		$data['analysis_database'] 	= $analysis_database;

		$path = 'uploads/Clients/'.$client_database.'/'.$analysis_database.'/';
		
		if (!is_dir($path)) {
			mkdir($path);
		}

		$chunck_block = 10000;
		$errorlogfile = fopen($path."errorlog.txt", 'a');
		$downloaderror = fopen($path."downloaderror.txt", 'w');
		$login_sap = $this->sapconfig($connection_id);
		$tables_file = fopen("uploads/import-tables.txt",'r') or die("Unable to open file!");
		$tables_not_found = [];
		$tables_imported = [];
		
	    while(!feof($tables_file)) {
	    $table = trim(fgets($tables_file));
	    if (empty($table)) {
	    	continue;
	    }

	    $columns = $this->lib_txtuploadrule->get_columns_rule($table);
	    $columnsAr = isset($columns['target_columns'])?$columns['target_columns']:[''];
	    $this->copy_SAP_table($table,$columnsAr,$connection_id,$path);
	    array_push($tables_imported,$table);
	    continue;
		}

		if (count($tables_imported)>0) {
			
			$data['success'] = 1;
			$data['message'] = 'SAP '.count($tables_imported).' tables successfully imported at location : '.$path;
		
			//$this->session->set_flashdata('succ', 'SAP '.count($tables_imported).' tables successfully imported at location : '.$path);
        } else {
			
			$data['success'] = 0;
			$data['message'] = 'Unable to import SAP tables data, please try again.';
			
			//$this->session->set_flashdata('err',"Unable to import SAP tables data, please try again.");
        }
		
		
		echo json_encode($data); die;
		

        //redirect(base_url('import-files/'.id_encode($analysis_id) ));
		
		
			
	} // End Function
	
	function import_data($client_id,$analysis_id,$connection_id){
		
		connect_master_db();
		$client_id 		= id_decode($client_id);
		$analysis_id 	= id_decode($analysis_id);
		$connection_id 	= id_decode($connection_id);

		$this->load->library('Lib_txtuploadrule');

		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $client_id),'client_database');
		$client_database = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>$analysis_id],'db_name');

		$analysis_database 			= trim($analysis_data['db_name']);
		$data['analysis_database'] 	= $analysis_database;

		$path = 'uploads/Clients/'.$client_database.'/'.$analysis_database.'/';
		
		if (!is_dir($path)) {
			mkdir($path);
		}

		$chunck_block = 10000;
		$errorlogfile = fopen($path."errorlog.txt", 'a');
		$downloaderror = fopen($path."downloaderror.txt", 'w');
		$login_sap = $this->sapconfig($connection_id);
		$tables_file = fopen("uploads/import-tables.txt",'r') or die("Unable to open file!");
		$tables_not_found = [];
		$tables_imported = [];
		
	    while(!feof($tables_file)) {
	    $table = trim(fgets($tables_file));
	    if (empty($table)) {
	    	continue;
	    }

	    $columns = $this->lib_txtuploadrule->get_columns_rule($table);
	    $columnsAr = isset($columns['target_columns'])?$columns['target_columns']:[''];
	    $this->copy_SAP_table($table,$columnsAr,$connection_id,$path);
	    array_push($tables_imported,$table);
	    continue;
		}

		if (count($tables_imported)>0) {
			$this->session->set_flashdata('succ', 'SAP '.count($tables_imported).' tables successfully imported at location : '.$path);
        } else {
			$this->session->set_flashdata('err',"Unable to import SAP tables data, please try again.");
        }

        redirect(base_url('import-files/'.id_encode($analysis_id) ));
		
	}
	
	

	function import_data_notinuse($client_id,$analysis_id,$connection_id){ ######## NOT IN USE
		connect_master_db();
		$client_id 		= id_decode($client_id);
		$analysis_id 	= id_decode($analysis_id);
		$connection_id 	= id_decode($connection_id);

		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $client_id),'client_database');
		$client_database = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>$analysis_id],'db_name');

		$analysis_database 			= trim($analysis_data['db_name']);
		$data['analysis_database'] 	= $analysis_database;

		$path = 'uploads/Clients/'.$client_database.'/'.$analysis_database.'/';

		$chunck_block = 10000;
		$errorlogfile = fopen($path."errorlog.txt", 'a');
		$downloaderror = fopen($path."downloaderror.txt", 'w');
		$login_sap = $this->sapconfig($connection_id);
		$tables_file = fopen("uploads/import-tables.txt",'r') or die("Unable to open file!");
		$tables_not_found = [];
		$tables_imported = [];
		
	    while(!feof($tables_file)) {
	    $table = trim(fgets($tables_file));
	    $this->copy_SAP_table($table,['MANDT','AGR_NAME','COUNTER','PROFILE','VARIANT','GENERATED','PSTATE'],$connection_id,$path);

	    continue;

	    if (empty($table)) {
	        continue;
	    }
	 	echo 'table name is : '.$table;
	 	echo PHP_EOL;
	 	ob_flush();
	 	//ob_implicit_flush(1);
	    $tbl_columns = get_columns_rule($table);
    	$options="";
	    $rfc = saprfc_open($login_sap);
	    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");
    	
	    if (!$fce) {
	        echo "SAP Server not reachable";
	        exit();
	    }

	    saprfc_import ($fce,"DELIMITER","*");
	    saprfc_import ($fce,"NO_DATA","");
	    saprfc_import ($fce,"QUERY_TABLE",$table);
	    saprfc_import ($fce,"ROWCOUNT","");
	    saprfc_import ($fce,"ROWSKIPS","");
	    saprfc_table_init ($fce,"FIELDS");
	    //saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>"TABNAME")); 
	    //saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>"FIELDNAME")); 
	    saprfc_table_init ($fce,"OPTIONS");
	    saprfc_table_append($fce,"OPTIONS", $options);
	    saprfc_table_init ($fce,"DATA");

	   $rc = @saprfc_call_and_receive ($fce);
	    if ($rc != SAPRFC_OK)
	    {
	        if ($rfc == SAPRFC_EXCEPTION )
	        {
	            echo $messages[] = "Exception raised: ".saprfc_exception($fce);
	            echo PHP_EOL;
	            //ob_flush();
	           
	            fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Exception :".saprfc_exception($fce));
	            fwrite($downloaderror, "\n".$table);

	        }
	        else
	        {
	            echo $messages[] = "Call error: ".saprfc_error($fce);
	            echo PHP_EOL;
	            //ob_flush();
	           
	             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Error :".saprfc_exception($fce));
	             fwrite($downloaderror, "\n".$table);
	        }
	        
	    }

	    $data_row = saprfc_table_rows ($fce,"DATA");
	    $field_row = saprfc_table_rows ($fce,"FIELDS"); 

	    $table_file = $table.'.TXT'; #"table_structure.txt";

	    if (file_exists($path.$table_file)) {
	        unlink($path.$table_file);
	    }

	    $tbl_file = fopen($path.$table_file, 'a');
	    echo $messages[] = $data_row.' No of rows available in '.$table_file.'  and File created in 
	    folder.';
	    echo PHP_EOL;
	    //ob_flush();
	   

###################### CODE FOR TABLE FILEDS #########################
    
    $fields = NULL;
    
    for($i=1; $i<=$field_row;$i++)
    {
        $field = saprfc_table_read ($fce,"FIELDS",$i);
        $fields .= $field['FIELDNAME'].'|'; 
    }

    fwrite($tbl_file,$fields);
    echo $messages[] = 'In '.$table.'.TXT File table headings saved. ';
    echo PHP_EOL;
    //ob_flush();
   

###################### CODE FOR TABLE DATA ###########################

    saprfc_function_free($fce);
    saprfc_close($rfc);

    $chunk = round($data_row /$chunck_block);
    echo $messages[] = 'total chunks are : '.$chunk;
    echo PHP_EOL;
    //ob_flush();
   
    $rem_chunk = fmod($data_row, $chunck_block);
    echo $messages[] = ' rows : '.$data_row.' chunck_block '. $chunck_block;
    echo PHP_EOL;
    //ob_flush();
   
   	echo $messages[] = 'remaining chunks : '.$rem_chunk;
   	echo PHP_EOL;
   	//ob_flush();
   	flush();
    $counter = 1;
      
   if ($chunk>0) {
    for ($c=1; $c <=$chunk ; $c++) {
        echo $messages[] = "Chunk - ".$c;
        echo PHP_EOL;
        //ob_flush();
       

    //ob_start();
    $rfc = saprfc_open($login_sap);
    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");

    // set import parameters 
    saprfc_import ($fce,"DELIMITER","*");
    saprfc_import ($fce,"NO_DATA","");
    saprfc_import ($fce,"QUERY_TABLE",$table);
    saprfc_import ($fce,"ROWCOUNT","");
    saprfc_import ($fce,"ROWSKIPS","");
    
    saprfc_table_init ($fce,"OPTIONS");
    saprfc_table_append($fce,"OPTIONS", $options);
    saprfc_table_init ($fce,"FIELDS");
    //saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>"TABNAME")); 
     //saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>"FIELDNAME")); 
    saprfc_table_init ($fce,"DATA");

    $rc = @saprfc_call_and_receive ($fce);

    if ($rc != SAPRFC_OK)
    {
        if ($rfc == SAPRFC_EXCEPTION )
        {
            echo $messages[] = "Exception raised: ".$table;
            echo PHP_EOL;
            //ob_flush();
           
           // fwrite($errorlogfile, "\n".$table."-".date('d-M-Y H:i:s'));
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Exception :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        else
        {
            echo $messages[] = "Call error: <br>".$table;
            echo PHP_EOL;
            //ob_flush();
           
           // fwrite($errorlogfile, "\n".$table."-".date('d-M-Y H:i:s'));
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Error :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        exit;
    }
    $data_row = saprfc_table_rows ($fce,"DATA");
    $field_row = saprfc_table_rows ($fce,"FIELDS");

    for($i=(($c-1)* $chunck_block)+1; $i<=$c* $chunck_block;$i++)
    {
        $DATA[$i] = $a = saprfc_table_read ($fce,"DATA",$i);
        $string = NULL;
        $ex = explode("*",$DATA[$i]["WA"]);
        $string = '|';
        foreach ($ex as $key => $value) {
            $string .=trim($value).'|';
        }
        
        fwrite($tbl_file, "\n". $string);
        $counter++;
    }

    saprfc_function_free($fce);
    saprfc_close($rfc);
    } ####  END OF CHUNK LOOP #######
} ####  END OF CHUNK IF CONDITION #######

if ($rem_chunk>0) {
    $rfc = saprfc_open($login_sap);
    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");

    // set import parameters 
    saprfc_import ($fce,"DELIMITER","*");
    saprfc_import ($fce,"NO_DATA","");
    saprfc_import ($fce,"QUERY_TABLE",$table);
    saprfc_import ($fce,"ROWCOUNT","");
    saprfc_import ($fce,"ROWSKIPS","");
    saprfc_table_init ($fce,"FIELDS");
    saprfc_table_init ($fce,"OPTIONS");
    saprfc_table_init ($fce,"DATA");
     saprfc_table_append($fce,"OPTIONS", $options); 
    //saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>"TABNAME")); 
     //saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>"FIELDNAME")); 
    $rc = @saprfc_call_and_receive ($fce);
    
    if ($rc != SAPRFC_OK)
    {
        if ($rfc == SAPRFC_EXCEPTION )
        {
            echo $messages[] = "Exception raised: <br>".$table;
            echo PHP_EOL;
            //ob_flush();
           
           // fwrite($errorlogfile, "\n".$table."-".date('d-M-Y H:i:s'));
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Exception :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        else
        {
            
            echo $messages[] = "Call error: <br>".$table;
            echo PHP_EOL;
            //ob_flush();
           
          //  fwrite($errorlogfile, "\n".$table."-".date('d-M-Y H:i:s'));
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Error :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        exit;
    }

    $data_row = saprfc_table_rows ($fce,"DATA");
    $field_row = saprfc_table_rows ($fce,"FIELDS");
   
    for($i=($chunk* $chunck_block)+1; $i<=$data_row;$i++)
    {
        $DATA[$i] = $a = saprfc_table_read ($fce,"DATA",$i);

        $string = NULL;

        $ex = explode("*",$DATA[$i]["WA"]);
        $string = '|';
        foreach ($ex as $key => $value) {
            //$string .=$value.'|' ; 
             $string .=trim($value).'|';
        }
        
        fwrite($tbl_file, "\n". $string);
        $counter++;
    }

    saprfc_function_free($fce);
    saprfc_close($rfc);
}
    echo $messages[] = 'In '.$table.'.TXT File '.$data_row.' rows saved. <br>'; 
    echo PHP_EOL;
    //ob_flush();
   
    fclose($tbl_file);
    echo $messages[] = $table.'.TXT File closed.<br>';
    echo PHP_EOL;
    //ob_flush();
   
    echo $messages[] = 'Total line itmes in file : '.count(file($path.$table_file));
    echo PHP_EOL;
    //ob_flush();
   

    //saprfc_function_debug_info($fce);
    // saprfc_function_free($fce);
    // saprfc_close($rfc);
    array_push($tables_imported,$table_file);
    sleep(5);
} ############# END OF WHILE LOOP ##############

fclose($errorlogfile);
fclose($downloaderror);
$data['messages'] = $messages;	
	if (count($tables_imported)>0) {
			$this->session->set_flashdata('succ', 'SAP '.count($tables_imported).' tables successfully imported at location : '.$path);
        } else {
		$this->session->set_flashdata('err', "Unable to import SAP tables data, please try again.");
        }

        //redirect(base_url('import-files/'.id_encode($analysis_id) ));
        //$data['redirect_url'] = base_url('import-files/'.id_encode($analysis_id));
        //$this->load->view('inc/header');
        //$this->load->view('inc/left-sidebar');
       // $this->load->view('sap/import',$data);
	}

	// use this function to download files which dont downlaod otherwise and bind with RFP 

function copy_SAP_table($tablename, $field_col=[],$connection_id,$path){
    
    if(empty($field_col)){
    	return "no field in Table ".$tablename;
    }

	$chunck_block 	= 10000;
	$criteria 		= "";
	$errorlogfile 	= fopen($path."/errorlog.txt", 'a');
	$downloaderror 	= fopen($path."/downloaderror.txt", 'w');
	
	$login_sap 		= $this->sapconfig($connection_id);

	$table = $tables_file = $tablename;
	echo "inside exception for obj ".$table;
	
    $options = "";

    $rfc = saprfc_open($login_sap);
    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");
    
    if (!$fce) {
        echo "SAP Server not reachable";
        exit();
    }

    saprfc_import ($fce,"DELIMITER","*");
    saprfc_import ($fce,"NO_DATA","");
    saprfc_import ($fce,"QUERY_TABLE",$table);
    saprfc_import ($fce,"ROWCOUNT","");
    saprfc_import ($fce,"ROWSKIPS","");
    saprfc_table_init ($fce,"FIELDS");

    foreach ($field_col as $key => $value) {
        print $value;
       saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>trim($value))); 
    }

    saprfc_table_init ($fce,"OPTIONS");
    saprfc_table_append($fce,"OPTIONS", $options);
    saprfc_table_init ($fce,"DATA");
    
   $rc = @saprfc_call_and_receive ($fce);

    if ($rc != SAPRFC_OK)
    {
        if ($rfc == SAPRFC_EXCEPTION )
        {
            echo ("Exception raised: ".saprfc_exception($fce));
            fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Exception :".saprfc_exception($fce));
            fwrite($downloaderror, "\n".$table);

        }
        else
        {
            echo ("Call error: ".saprfc_error($fce));
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Error :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }     
    }

    $data_row = saprfc_table_rows ($fce,"DATA");
    $field_row = saprfc_table_rows ($fce,"FIELDS"); 
    $table_file = $table.'.TXT';
    $table_file = str_replace("/","$$",$table_file);
    $tbl_file = fopen($path.$table_file, 'a');

    echo $data_row.' No of rows available in '.$table_file.'  and File created in folder. <br>';

###################### CODE FOR TABLE FILEDS #########################
    
    $fields = NULL;
    $fields = '|';
    for($i=1; $i<=$field_row;$i++)
    {
        $field = saprfc_table_read ($fce,"FIELDS",$i);
        $fields .= $field['FIELDNAME'].'|'; 
    }

    fwrite($tbl_file,$fields);
    echo 'In '.$table.'.TXT File table headings saved. <br>';

###################### CODE FOR TABLE DATA ###########################

    saprfc_function_free($fce);
    saprfc_close($rfc);

    $chunk = round($data_row /$chunck_block);
    $rem_chunk = fmod($data_row, $chunck_block);
    $counter = 1;

   if ($chunk>0) {
    for ($c=1; $c <=$chunk ; $c++) {
        echo "Chunk - ".$c.'<br>';

    $rfc = saprfc_open($login_sap);
    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");

    saprfc_import ($fce,"DELIMITER","*");
    saprfc_import ($fce,"NO_DATA","");
    saprfc_import ($fce,"QUERY_TABLE",$table);
    saprfc_import ($fce,"ROWCOUNT","");
    saprfc_import ($fce,"ROWSKIPS","");
    saprfc_table_init ($fce,"FIELDS");

    foreach ($field_col as $key => $value) {
        print $value ;
       saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>trim($value))); 
    }

    saprfc_table_init ($fce,"OPTIONS");
    saprfc_table_append($fce,"OPTIONS", $options);
    saprfc_table_init ($fce,"DATA");
    
    $rc = @saprfc_call_and_receive ($fce);

    if ($rc != SAPRFC_OK)
    {
        if ($rfc == SAPRFC_EXCEPTION )
        {
            echo ("Exception raised: <br>".$table);
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Exception :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        else
        {
            echo ("Call error: <br>".$table);
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Error :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        exit;
    }

    $data_row = saprfc_table_rows ($fce,"DATA");
    $field_row = saprfc_table_rows ($fce,"FIELDS");

    for($i=(($c-1)* $chunck_block)+1; $i<=$c* $chunck_block;$i++)
    {
        $DATA[$i] = $a = saprfc_table_read ($fce,"DATA",$i);
        $string = NULL;
        $ex = explode("*",$DATA[$i]["WA"]);
        $string = '|';
        foreach ($ex as $key => $value) {
            $string .=trim($value).'|';
        }
        
        fwrite($tbl_file, "\n". $string);
        $counter++;
    }

    saprfc_function_free($fce);
    saprfc_close($rfc);
        ob_flush();
    } ####  END OF CHUNK LOOP #######
} ####  END OF CHUNK IF CONDITION #######

if ($rem_chunk>0) {
    
    $rfc = saprfc_open($login_sap);
    $fce = saprfc_function_discover($rfc,"RFC_READ_TABLE");

    saprfc_import ($fce,"DELIMITER","*");
    saprfc_import ($fce,"NO_DATA","");
    saprfc_import ($fce,"QUERY_TABLE",$table);
    saprfc_import ($fce,"ROWCOUNT","");
    saprfc_import ($fce,"ROWSKIPS","");
    saprfc_table_init ($fce,"FIELDS");
    foreach ($field_col as $key => $value) {
        print $value;
      saprfc_table_append($fce,"FIELDS", array("FIELDNAME"=>trim($value))); 
    }

    saprfc_table_init ($fce,"OPTIONS");
    saprfc_table_append($fce,"OPTIONS", $options);
    saprfc_table_init ($fce,"DATA");
    
    $rc = @saprfc_call_and_receive ($fce);
    
    if ($rc != SAPRFC_OK)
    {
        if ($rfc == SAPRFC_EXCEPTION )
        {
            echo ("Exception raised: <br>".$table);
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Exception :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        else
        {
            echo ("Call error: <br>".$table);
             fwrite($errorlogfile, "\n".date('d-M-Y H:i:s').$table."-"."Error :".saprfc_exception($fce));
             fwrite($downloaderror, "\n".$table);
        }
        exit;
    }

    $data_row = saprfc_table_rows ($fce,"DATA");
    $field_row = saprfc_table_rows ($fce,"FIELDS");
   
    for($i=($chunk* $chunck_block)+1; $i<=$data_row;$i++)
    {
        $DATA[$i] = $a = saprfc_table_read ($fce,"DATA",$i);
        $string = NULL;
        $ex = explode("*",$DATA[$i]["WA"]);
        $string = '|';
        foreach ($ex as $key => $value) {
             $string .= trim($value).'|';
        }

        fwrite($tbl_file, "\n". $string);
        $counter++;
    }

    saprfc_function_free($fce);
    saprfc_close($rfc);

} ######## END OF REMAINING CHUNK ##########

    echo 'In '.$table.'.TXT File '.$data_row.' rows saved. <br>'; 
    fclose($tbl_file);
    echo $table.'.TXT File closed.<br>';
    echo count(file($path.$table_file));
    echo '<br><br>';
	fclose($errorlogfile);
	fclose($downloaderror);
	return;

	}
}