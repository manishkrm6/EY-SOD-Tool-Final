<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Runanalysiscli extends CI_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
		$this->load->model('common_model');	

	} // End function

	function shell_exec_example(){

	} // End Function

	function test_chron_job(){

		/*if ($this->is_cli_request())
        {*/
        	$log_content = date('Y-m-d H:i:s')." Chron Job Test Successfull ";
			$myfile = file_put_contents(FCPATH.'uploads/test_log.log', $log_content.PHP_EOL, FILE_APPEND | LOCK_EX);

		//}

		die;

	} // End File


	function shell_run_analysis($analysis_id){
		
		$data = [];
		
		connect_master_db();

		$analysisInfo = $this->common_model->get_entry_by_data( 'list_analysis', true, array( 'id' => $analysis_id ) );

		//pr($analysisInfo); die;

		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));

		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		// File Operation to Store Status

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : DB2 And DB3 Database are now ready for executing Procedures ";
		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL, LOCK_EX);

 		//$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

		connect_new_db($db3);

		// Truncate tab_user From DB3
		$this->lib_common->truncate_table($db3,"tab_user");
		$this->lib_common->copy_table($db2,$db3,"tab_user");

		$this->lib_common->truncate_table($db3,"user_details");
		$this->lib_common->copy_table($db2,$db3,"user_details");

		
		// Role Build Procedure Call

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 1 Procedure ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call usp_Role_Build1('".$db3."',NULL,NULL,NULL,0,0,0)";
		$this->common_model->run_query($sql);
		//die;

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 2 Procedure ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call usp_Role_Build2('".$db3."',NULL,NULL,NULL,0,0,0)";
		$this->common_model->run_query($sql);

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 3 Procedure ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call usp_Role_Build3('".$db3."',NULL,NULL,NULL,0,0,0)";
		$this->common_model->run_query($sql);

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Build Part 3 Completed ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		// Count Total Role Build
		$sql = "select count(*) as total_role_build from role_build ";
		$result = $this->common_model->run_custom_query($sql);

		$data['total_role_build'] = isset($result[0]['total_role_build']) ? $result[0]['total_role_build'] : 0;

		// File Operation to Store Role Build

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Total Role Build ".$data['total_role_build'];
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		



		// Role Analysis Procedure Call

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Role Analysis ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call usp_role_analysis('TAS')";
		$this->common_model->run_query($sql);

		// Count Total Role Completed
		$sql = "select count(*) as total_rcompleted from rcompleted ";
		$result = $this->common_model->run_custom_query($sql);

		$data['total_rcompleted'] = isset($result[0]['total_rcompleted']) ? $result[0]['total_rcompleted'] : 0;

		// Count Total R Conflicts
		$sql = "select count(*) as total_rconflicts from rconflicts ";
		$result = $this->common_model->run_custom_query($sql);
		$data['total_rconflicts'] = isset($result[0]['total_rconflicts']) ? $result[0]['total_rconflicts'] : 0;

		
		// File Operation to Store Role Analysis Status

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : ".$data['total_rcompleted']." total Rcompleted ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

 		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : ".$data['total_rconflicts']." total Rconflicts ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);


		// User Analysis Procedure Call

 		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing User Analysis ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call usp_User_Analysis('TAS',0,0,'".$db3."')";
		$this->common_model->run_query($sql);

		// Count Total U Conflicts
		$sql = "select count(*) as total_uconflicts from uconflicts ";
		$result = $this->common_model->run_custom_query($sql);
		$data['total_uconflicts'] = isset($result[0]['total_uconflicts']) ? $result[0]['total_uconflicts'] : 0;

		// File Operation to Store User Analysis Status

		$log_content = short_date_format(date('Y-m-d H:i:s'))." : ".$data['total_uconflicts']." total Uconflicts ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);


		// Root Cause Analysis Procedure Call

 		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Root Cause Analysis ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call usp_Root_Cause_Analysis(0)";
		$this->common_model->run_query($sql);

		// Count Total rep_tcode_level_sod_with_role
		$sql = "select count(*) as total_rep_tcode_level_sod_with_role from total_rep_tcode_level_sod_with_role ";
		$result = $this->common_model->run_custom_query($sql);
		$data['total_rep_tcode_level_sod_with_role'] = isset($result[0]['total_rep_tcode_level_sod_with_role']) ? $result[0]['total_rep_tcode_level_sod_with_role'] : 0;


		// File Operation to Store Root Cause Analysis Status

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : ".$data['total_rep_tcode_level_sod_with_role']." total Uconflicts ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);


		// General Report Procedure Call

 		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Executing Dashboard General Report Procedure ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);

		$sql = "call Generate_report('".$db3."')";
		$this->common_model->run_query($sql);

		// Count Total rep_tcode_level_sod_with_role
		$sql = "select count(*) as total_rep_org_access from rep_org_access ";
		$result = $this->common_model->run_custom_query($sql);
		$data['total_rep_org_access'] = isset($result[0]['total_rep_org_access']) ? $result[0]['total_rep_org_access'] : 0;

		// File Operation to Store General Report Status

		$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : ".$data['total_rep_org_access']." total Rep Org Access ";
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);


		
		die;
		


	} // End Function

} // End Class