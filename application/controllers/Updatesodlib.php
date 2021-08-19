<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatesodlib extends Access_Controller {
	
	function __construct()
    {	
		// Construct the parent class
		parent::__construct();
	}

	public function get_sod_dump($fk_analysis_id = ''){
		
		$data = [];
		connect_master_db();
		$fk_analysis_id = isset($fk_analysis_id) ? id_decode(trim($fk_analysis_id)) : NULL;
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));

		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
		connect_new_db($db2);

		$dispatch = [];
		// Act Code
			$dispatch['actcode'] = $this->common_model->get_entry_by_data('actcode',false,array('1' => '1'));
		// Bus Proc
			$dispatch['bus_proc'] = $this->common_model->get_entry_by_data('bus_proc',false,array('1' => '1'));
		// SOD RISK
			$dispatch['sod_risk'] = $this->common_model->get_entry_by_data('sod_risk',false,array('1' => '1'));
			
		$this->dump_sod($dispatch,FCPATH.'/uploads/sod_dump.xlsx');
		
	} // End Function

	public function update_sod_lib(){

		$data = [];
		//$path = FCPATH.str_replace('.', '/', $path);

		if( !empty($_POST) ){
			
			connect_master_db();
			$fk_analysis_id = isset($_POST['fk_analysis_id']) ? id_decode(trim($_POST['fk_analysis_id'])) : [];
			
			$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
			$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
			$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
			
			//pr($clientInfo); die;

			$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
			connect_new_db($db2);
			$sheetNames = $this->get_sheet_names();

			$cntr = 0;
			
			//pr($sheetNames); die;
			
			if( !empty($sheetNames)){
				
				foreach($sheetNames as $sheet){

					$csvData = $this->get_excel_data_by_sheet_name($sheet);

					// Truncate Table
					$this->lib_common->truncate_table($db2,$sheet);
					$len = count($csvData);

					
					if(!empty($csvData)){
						
						//pr($csvData); die;
						$sql = "INSERT INTO $sheet VALUES ";
						$subSql = '';
						$pointer = null;

						for ( $i = 1;  $i < $len; $i++){

							$subSql .= "('".implode("','",$csvData[$i])."'),";
							if( $i % 1000 == 0 ){
								
								$pointer = $i;

								$sql = $sql.rtrim($subSql,",");
								$result = $this->common_model->run_app_query($sql);

								if($result['success'] == 0){
									$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
									$myfile = file_put_contents($path.'/uploads/Clients/'.$db2.'/'.$db2.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
								}

								$sql = "INSERT INTO $sheet VALUES ";
								$subSql ="";
							}

						} // For Loop */

						if( $pointer < $len){

							$sql = "INSERT INTO $sheet VALUES ";
							$subSql = "";

							for( $i = $pointer + 1; $i < $len; $i++){
								$subSql .= "('".implode("','",$csvData[$i])."'),";
							}
							
							$sql = $sql.rtrim($subSql,",");
							$result = $this->common_model->run_app_query($sql);
							if($result['success'] == 0){
								$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
								$myfile = file_put_contents($path.'/uploads/Clients/'.$db2.'/'.$db2.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
							}

						}
						

					} // End IF

					// Insert Data
					$cntr++;
				}

			} // End IF

			redirect(base_url('finalize-rules/'.id_encode($fk_client_id)));

		} // End IF Post

	} // End function


} // End Class


