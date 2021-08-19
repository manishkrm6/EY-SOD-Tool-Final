<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Unittesting extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}
	
	public function create_json_string(){

		$data = [];

		$data[0] = array(

			"Version" => "1.1",
			"TranDtls" => array (
				"TaxSch" => "GST", 
				"SupTyp" => "B2B",
				"IgstOnIntra" => "N",
				"RegRev" => "N",
				"EcmGstin" => null
			),
			"DocDtls" => array(
				"Typ" => "INV",
				"No" => "DL210301180",
				"Dt" => "09/03/2021"
			),
			"SellerDtls" => array(
				"Gstin" => "07AADCI1037P1ZF",
				"LglNm" => "INDOVISION SERVICES PVT LTD",
				"Addr1" => "CENTRUM MALL",
				"Addr2" => null,
				"Loc" => "DELHI",
				"Pin" => 110030,
				"Stcd" => "07",
				"Ph" => null,
				"Em" => null
			),
			"BuyerDtls" => array(
				"Gstin" => "07AAECI0621E1Z5",
				"LglNm" => "IDIGISYS PVT LTD",
				"Addr1" => "PARYAVARN COMPLEX",
				"Addr2" => null,
				"Loc" => "DELHI",
				"Pin" => 110030,
				"Pos" => "07",
				"Stcd" => "07",
				"Ph" => null,
				"Em" => null
			),
			"ValDtls" => array(
				"AssVal" => 1,
				"IgstVal" => 0,
				"CgstVal" => 0.09,
				"SgstVal" => 0.09,
				"CesVal" => 0,
				"StCesVal" => 0,
				"Discount" => 0,
				"OthChrg" => 0,
				"RndOffAmt" => 0,
				"TotInvVal" => 1.18
			),
			"RefDtls" => array(
				"InvRm" => "NICGEPP"
			),
			"ItemList" => array(
				  array(
				  "SlNo" => "1",
				  "PrdDesc" => "MANPOWER",
				  "IsServc" => "Y",
				  "HsnCd" => "998336",
				  "Qty" => 1,
				  "FreeQty" => 0,
				  "Unit" => "NOS",
				  "UnitPrice" => 1,
				  "TotAmt" => 1,
				  "Discount" => 0,
				  "PreTaxVal" => 0,
				  "AssAmt" => 1,
				  "GstRt" => 18,
				  "IgstAmt" => 0,
				  "CgstAmt" => 0.09,
				  "SgstAmt" => 0.09,
				  "CesRt" => 0,
				  "CesAmt" => 0,
				  "CesNonAdvlAmt" => 0,
				  "StateCesRt" => 0,
				  "StateCesAmt" => 0,
				  "StateCesNonAdvlAmt" => 0,
				  "OthChrg" => 0,
				  "TotItemVal" => 1.18
				)
			)

		);
		
		$json_string = json_encode($data); 

		$myfile = file_put_contents(FCPATH.'uploads/invoice.json', $json_string.PHP_EOL, FILE_APPEND | LOCK_EX);
		
		


	} // End Function

	public function update_sod_lib(){
		
		if( !empty($_POST) ){
			
			$sheetNames = $this->get_sheet_names();
			if(!empty($sheetNames)){

				foreach($sheetNames as $val){
					$csv_data = $this->import_csv_data($val);
					pr($csv_data); 
				}
			}
		}

	}

	public function import_csv(){
		
		if( !empty($_POST) ){
			
			connect_new_db('sap_cli0007');

			$csv_data = $this->import_csv_data();

			//pr($csv_data); die;
			 // Act Class Import

			//pr(count($csv_data)); die;

			if(!empty($csv_data)){
				
				foreach ($csv_data as $key => $value) {
					
					$insert_array = [];

					// Conflicts_C 

					$sql = 'INSERT into `conflicts_c` SET `CONFLICTID` = "'.trim($value[0]).'",';
					$sql .= ' `OBJCT` = "'.$value[1].'",';
					$sql .= ' `FIELD` = "'.$value[2].'",';
					$sql .= ' `VALUE` = "'.$value[3].'"';

					


					// == Act Code == 

					/*$sql = 'INSERT into `actcode` SET `activity` = "'.trim($value[0]).'",';
					$sql .= ' tcode = "'.$value[1].'"';*/

					// ==== Sod Risk ==== */

					/*$sql = 'INSERT into `sod_risk` SET `riskid` = "'.trim($value[0]).'",';
					$sql .= ' act1 = "'.$value[1].'",';
					$sql .= ' act2 = "'.$value[2].'",';
					$sql .= ' act3 = "'.$value[3].'",';
					$sql .= ' riskname = "'.$value[4].'",';
					$sql .= ' dsc = "'.$value[5].'",';
					$sql .= ' rating = "'.$value[6].'",';
					$sql .= ' bproc = "'.$value[7].'",';
					$sql .= ' enabled = "'.$value[8].'",';
					$sql .= ' ctype = "'.$value[9].'"';*/



					// ==== ACT Class === */

					/*$sql = 'INSERT into `act_class` SET `activity` = "'.trim($value[0]).'",';
					$sql .= ' act_desc = "'.$value[1].'",';
					$sql .= ' act_class = "'.$value[2].'",';
					$sql .= ' proc = "'.$value[3].'",';
					$sql .= ' subproc = "'.$value[4].'"';*/

					// ==== Bus Proc === */

					/*$sql = 'INSERT into `bus_proc` SET `proc` = "'.trim($value[0]).'",';
					$sql .= ' dsc = "'.$value[1].'",';
					$sql .= ' Status = "'.$value[2].'"';*/





					$res = $this->common_model->run_app_query($sql);


				}



			} // End IF

		}

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('unittesting/import_csv');
		$this->load->view('inc/footer');


	} // End Function



	public function drop_all_database(){

		connect_master_db();
		
		$sql = " SELECT CONCAT('DROP DATABASE `',schema_name,'` ;') AS `stmt`
  		FROM information_schema.schemata
 		WHERE schema_name LIKE 'sap\_%'
		ORDER BY schema_name   ";

		//echo $sql; die;
		$sqls = [];

		$result = $this->common_model->run_custom_query($sql);
		
		if(!empty($result)){

			foreach ($result as $key => $value) {
				
				$tmp_sql = $value['stmt']; 
				$res = $this->common_model->run_app_query($tmp_sql);
				
			}
		}

		die;

		

 
 	} // End Function

	public function test_script(){

		//connect_new_db('sap_cli00023_a100069');
		connect_master_db();

		$this->lib_common->import_user_details_from_db3_to_db2(1);
            $this->lib_common->import_tab_user_from_db3_to_db2(1);




	} // End Function

	function run_analysis(){
		
		$analysis_id = isset($_POST['analysis_id']) ? trim($_POST['analysis_id']) : NULL;
		$instruction_index = isset($_POST['instruction_index']) ? intval(trim($_POST['instruction_index'])) : NULL;

		$instruction_index += 1;


		$response = [];


		$data = [];
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data( 'list_analysis', true, array( 'id' => $analysis_id ) );
		//pr($analysisInfo); die;
		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		connect_new_db($db3);

		// Execution Stack Step 1

		switch ( $instruction_index ) {
			
			case 1:
				//break;
				// Truncate tab_user From DB3
				
				    $this->lib_common->truncate_table($db3,"tab_user");
					$this->lib_common->copy_table($db2,$db3,"tab_user");

					$this->lib_common->truncate_table($db3,"user_details");
					$this->lib_common->copy_table($db2,$db3,"user_details");

					// File Operation to Store Status
					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : DB2 And DB3 Database are now ready for executing Procedures ";
					$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL, FILE_APPEND | LOCK_EX);
				
					$response = [];

					$message = '<div class="col-3"><span>Tab User Completed<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            	</div>';

					$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				
				break;

			case 2:
				//break;
				// Role Build Procedure Call

				$response = [];
				$message = '';

				$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 1 Procedure ";
		 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				$sql = "call usp_Role_Build1('".$db3."',NULL,NULL,NULL,0,0,0)";
					
				$result = $this->common_model->run_app_query($sql);
				
				if($result['success'] == 1){
					
					$message = '<div class="col-3"><span>Generating Role Build Data..<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">33%</div>
                                	</div>
                            	</div>';	
				}
				else{
					$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' <span></span></div>';

				}

					
                $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '33% Completed', 'message' => $message);

				break;

			case 3:
				
				//break;
				$response = [];
				$message = '';

				$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 2 Procedure ";
		 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				$sql = "call usp_Role_Build2('".$db3."',NULL,NULL,NULL,0,0,0)";
				$result = $this->common_model->run_app_query($sql);

				if($result['success'] == 1){

					$message = '<div class="col-3"><span>Generating Role Build Data..<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100">66%</div>
                                	</div>
                            	</div>';

				}
				else{

					$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' </span></div>';

					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
					$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
				}
                $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '66% Completed', 'message' => $message);
                 break;
			case 4:
				//break;
				$response = [];
				$message = '';

				$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 3 Procedure ";
		 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				$sql = "call usp_Role_Build3('".$db3."',NULL,NULL,NULL,0,0,0)";
				$result = $this->common_model->run_app_query($sql);

				if($result['success'] == 1){
					$message = '<div class="col-3"><span>Role Build Completed.<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                	</div>
                            </div>';	
				}
				else{

					$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' </span></div>';
					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
					$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
				}
				

				$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '66% Completed', 'message' => $message);

				break;

			case 5:
				//break;
				$response = [];
				$message = '';

					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Analysis Procedure ";
		 			$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

					$sql = "call usp_role_analysis1('TAS')";
					$result = $this->common_model->run_app_query($sql);

					if($result['success'] == 1){
						
						$message = '<div class="col-3"><span>Executing Role Analysis..<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                                	</div>
                            		</div>';
					}
					else{
						
						$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
						$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
					}
					
                    $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '50% Completed', 'message' => $message);
					break;

			case 6:
				
				//break;
				$message = "";

				$response = [];

					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Role Analysis Completed ";
		 			$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

					$sql = "call usp_role_analysis2('TAS')";
					$result = $this->common_model->run_app_query($sql);
					if($result['success'] == 1){
						
						$message = '<div class="col-3"><span>Role Analysis Completed.<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                	</div>
                            		</div>';
					}
					else{

						$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' </span></div>';
						$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
						$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

					}
					
                    $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
					break;

				

			case 7:
				
				//break;
				$response = [];
				$message = "";

				$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing User Analysis ";
	 			$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				$sql = "call usp_User_Analysis('TAS',0,0,'".$db3."')";
				$result = $this->common_model->run_app_query($sql);

				if(	$result['success'] == 1 ){

					$message = '<div class="col-3"><span>User Analysis Completed <span></span></div>
                        		<div class="col-6">
                            	<div class="progress mb-0">
                            	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            	</div>
                        		</div>';

				}
				else{

					$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' </span></div>';
					
					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
					$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				}

                $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				break;

			case 8:
				
				$response = [];
				$message = "";

				$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Root Cause Analysis ";
	 			$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				$sql = "call usp_Root_Cause_Analysis(0)";
				$result = $this->common_model->run_app_query($sql);

				if($result['success'] == 1){
					$message = '<div class="col-3"><span>Root Cause Analysis Completed <span></span></div>
                        		<div class="col-6">
                            	<div class="progress mb-0">
                            	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            	</div>
                        		</div>';	
				}
				else{

					$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' </span></div>';
					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
					$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				}
				

                $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				break;

			case 9:
				
				$response = [];
				$message = "";

				$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing General Report";
	 			$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				$sql = "call Generate_report('".$db3."')";
				$this->common_model->run_app_query($sql);

				if($result['success'] == 1){

					$message = '<div class="col-3"><span>General Report Completed <span></span></div>
                        		<div class="col-6">
                            	<div class="progress mb-0">
                            	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                            	</div>
                        		</div>';
				}
				else{

					$message = '<div class="col-3"><span style="color:red;">Error Code: '.$result['error_code'].' Error Message: '.$result['error_message'].' </span></div>';

					$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
					$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

				}

                $response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				break;

			default:
				# code...
				break;

		} // End Switch Statement

		echo json_encode($response); die;

		/*$command = "php ".FCPATH."index.php Runanalysiscli shell_run_analysis $analysis_id";
		exec($command);*/

	} // End Function

} // End Class


