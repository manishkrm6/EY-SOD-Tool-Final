 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends Access_Controller {
	
	function __construct()
    {	
		// Construct the parent class
		parent::__construct();
	}
	
	// Update Users List using Excel Sheet
	public function update_client_users(){
		
		$data = [];

		$fk_analysis_id = isset($_POST['fk_analysis_id'])  ? trim(id_decode($_POST['fk_analysis_id'])) :  NULL;
		//$path = FCPATH.str_replace('.', '/', $path);
		
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
		connect_new_db($db3);
		
		$csvData = $this->import_csv_data();

		if(!empty($csvData)){
			
			$this->lib_common->truncate_table($db3,"user_details");
			$len = count($csvData);

			$sql = "INSERT INTO user_details VALUES ";
			for( $i = 1; $i < $len; $i++){
				$subSql = '';
				$subSql .= "('".implode("','",$csvData[$i])."'),";
				$sql .= $subSql;

				
			}
			
			$sql = $sql.rtrim($subSql,",");	
			//pr($sql); die;

			$result = $this->common_model->run_app_query($sql);

				if($result['success'] == 1){

				}
				else{
					//$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
					//$myfile = file_put_contents($path.'/uploads/Clients/'.$db2.'/'.$db2.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
				} 

			} // End IF

			redirect( base_url('select-client-users/'.id_encode($fk_analysis_id)) );

	} // End Function

	public function finalize_users_for_analysis($fk_analysis_id = ''){

		$data = [];

		$fk_analysis_id =$fk_analysis_id != '' ? id_decode($fk_analysis_id) :  NULL;
		connect_master_db();

		//pr($_POST);  die;


		// === Enable Disable ====
		$enable_disable = isset($_POST['enable_disable']) ? trim($_POST['enable_disable']) : NULL;
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$data['analysisInfo'] = !empty($analysisInfo) ? $analysisInfo : NULL;
		
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
		$data['clientInfo'] = !empty($clientInfo) ? $clientInfo : NULL;
		
		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
		
		connect_new_db($db3);

		if( $enable_disable == "ENABLE_ALL" ){
			
			// Update All Status to 1
			$upd_record = $this->common_model->update_entry('user_details',array('enabled' => 1),array('1' => '1'));
			$this->lib_common->truncate_table($db3,'tab_user');
			$sql = "INSERT INTO tab_user select uname from user_details"; 
			$result = $this->common_model->run_app_query($sql);	

			if($result['success'] == 1){
				
				// Total Uname in the user_details
				$sql = "Select count(uname) as total_enabled_user from user_details";
				$result = $this->common_model->run_custom_query($sql);
				$total_enabled_user = isset($result[0]['total_enabled_user']) ? $result[0]['total_enabled_user'] : 0;
				//pr($result); die;
				// On Success Update Total Users For Analysis in Master DB <list_analysis>
				connect_master_db();
				$upd_rec = $this->common_model->update_entry('list_analysis',array('total_users_for_analysis' => $total_enabled_user), array('id' => $fk_analysis_id));
				$this->session->set_flashdata('succ','Action Performed Successfully');

				$this->session->set_flashdata('succ','Action Performed Successfully');
			}


		} // End IF
		else if( $enable_disable == "DISABLE_ALL" ){

			// Update All Status to 0
			$upd_record = $this->common_model->update_entry('user_details',array('enabled' => 0),array('1' => '1'));
			$this->lib_common->truncate_table($db3,'tab_user');

			// On Success Update Total Users For Analysis in Master DB <list_analysis>
			connect_master_db();
			$upd_rec = $this->common_model->update_entry('list_analysis',array('total_users_for_analysis' => 0), array('id' => $fk_analysis_id));
			$this->session->set_flashdata('succ','Action Performed Successfully');

			

		} // End Else IF
		else{

			$uname = isset($_POST['uname']) ? $_POST['uname'] : NULL;
			$uname_str = "'".implode("','",$uname)."'";
			
			//echo $uname_str; die;

			$upd_record = $this->common_model->update_entry('user_details',array('enabled' => 0)," uname not in (".$uname_str.")");
			$upd_record = $this->common_model->update_entry('user_details',array('enabled' => 1)," uname in (".$uname_str.")");
			

			$this->lib_common->truncate_table($db3,'tab_user');
			
			$sql = "INSERT INTO tab_user select uname from user_details where uname in (".$uname_str.")";
			$result = $this->common_model->run_app_query($sql);	
			
			if($result['success'] == 1){
				
				// On Success Update Total Users For Analysis in Master DB <list_analysis>
				connect_master_db();
				$upd_rec = $this->common_model->update_entry('list_analysis',array('total_users_for_analysis' => count($uname)), array('id' => $fk_analysis_id));
				$this->session->set_flashdata('succ','Action Performed Successfully');
			}

			//var_dump($result); die;

		}

		connect_master_db();

		$update_array['is_completed'] = 1;
    	$update_array['create_datetime'] = date('Y-m-d H:i:s');
    	$upload_status_id = $this->lib_common->get_analysis_status_id('SELECT_USERS_COMPLETED');
    	$upd_rec = $this->common_model->update_entry('analysis_status_history',$update_array,array('fk_analysis_id' => $fk_analysis_id, 'fk_status_id' => $upload_status_id));

    	redirect(base_url('create-new-analysis/'.id_encode($fk_analysis_id)));

	} // End Function

	public function select_client_users_experiment($fk_analysis_id = ''){
		
		$this->load->view('clients/test_list_users');

	} // End Function
	
	public function ajax_data(){
		
		echo json_encode( $this->gen_user_data('MEkzdjZTMTMwSTN2NlM') ); die;

	}

	public function gen_user_data($fk_analysis_id = ''){
		
		//pr($_POST); die;

		$start = isset($_POST['start']) ? $_POST['start'] : 0;
		$length = isset($_POST['length']) ? $_POST['length'] : 0;

		$data = [];
		$fk_analysis_id =$fk_analysis_id != '' ? id_decode($fk_analysis_id) :  NULL;
		connect_master_db();
		
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$data['analysisInfo'] = !empty($analysisInfo) ? $analysisInfo : NULL;
		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
		$data['clientInfo'] = !empty($clientInfo) ? $clientInfo : NULL;
		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		connect_new_db($db3);
		$where = " 1 = 1 ";

		$sql = "Select u.uname, u.valid_from, u.valid_to, u.lockstatus, u.user_type, u.user_group, u.department, u.enabled
		 		from user_details u LEFT OUTER JOIN agr_users a ON 
				u.uname = a.uname
				WHERE ".$where." LIMIT $start,$length";

		$list_users = $this->common_model->run_custom_query($sql);

		$dataBatch = [];

		if(!empty($list_users)){
			$i =0;
			foreach($list_users as $key => $val){
				$dataBatch[$i++] = array_values($val);
			}	
		}
		
		//pr($dataBatch); die;
		
		return array('draw' => $start+1,'recordsTotal' => 100, 'recordsFiltered' => 100, 'data' => $dataBatch );
		
		//return array('draw' => 1,'recordsTotal' => 5,'recordsFiltered' => 25, 'data' => array(["Airi","Satou","Accountant","Tokyo","28th Nov 08","$162,700"],["Airi","Satou","Accountant","Tokyo","28th Nov 08","$162,700"] ) );

	}

	public function select_client_users( $fk_analysis_id = '' ){
		
		$data = [];
		$fk_analysis_id =$fk_analysis_id != '' ? id_decode($fk_analysis_id) :  NULL;

		connect_master_db();
		
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		
		// IF Empty Redirect to Create New Analysis
		if(empty($analysisInfo)){
			redirect(base_url('create-new-analysis'));
		}

		$data['analysisInfo'] = !empty($analysisInfo) ? $analysisInfo : NULL;
		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
		$data['clientInfo'] = !empty($clientInfo) ? $clientInfo : NULL;
		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		connect_new_db($db3);
		$where = " 1 = 1 ";

		$start_index = 0;
		$limit = 100;

		if( !empty($_POST)){
			
			$uname = isset($_POST['uname']) && !empty($_POST['uname']) ? explode(',',$_POST['uname']) : [];
			$company = isset($_POST['company']) && $_POST['company'] != "none"  ? trim($_POST['company']) : null;
			$department = isset($_POST['department']) && $_POST['department'] != "none"  ? trim($_POST['department']) : null;
			$location = isset($_POST['location']) && $_POST['location'] != "none"  ? trim($_POST['location']) : null;

			$exclude_locked_users = isset($_POST['exclude_locked_users']) && !empty($_POST['exclude_locked_users']) ? $_POST['exclude_locked_users']  : "off";
			$exclude_expired_users = isset($_POST['exclude_expired_users']) && !empty($_POST['exclude_expired_users']) ? $_POST['exclude_expired_users']  : "off";
			$exclude_expired_roles = isset($_POST['exclude_expired_roles']) && !empty($_POST['exclude_expired_roles']) ? $_POST['exclude_expired_roles']  : "off";
			$exclude_non_dialog_users = isset($_POST['exclude_non_dialog_users']) && !empty($_POST['exclude_non_dialog_users']) ? $_POST['exclude_non_dialog_users']  : "off";
			$include_custom_tcode = isset($_POST['include_custom_tcode']) && !empty($_POST['include_custom_tcode']) ? $_POST['include_custom_tcode']  : "off";


			$start_index = isset($_POST['start_index']) && !empty($_POST['start_index']) ? $_POST['start_index']  : 0;
			$end_index = isset($_POST['end_index']) && !empty($_POST['end_index']) ? $_POST['end_index']  : 100;

			$start_index = $start_index <= $end_index ? $start_index : $end_index;
			$end_index = $end_index >= $start_index ? $end_index : $start_index;

			$limit = $end_index - $start_index;

			//echo "Exclude Non Dialog Users ".$exclude_non_dialog_users; die;

			if(!empty($uname)){
				$where .= " AND user_name LIKE '%".implode("%' OR user_name LIKE '%", $uname)."%'";
			}
			if(!empty($company)){
				$where .= " AND company in ('".$company."')";
			}
			if(!empty($department)){
				$where .= " AND department in ('".$department."')";
			}
			if(!empty($location)){
				$where .= " AND location in ('".$location."')";
			}
			if( $exclude_locked_users == "on" ){
				$where .= " AND lockstatus = 0 ";
			}
			if( $exclude_expired_roles == "on" ){
				$where .= " AND DATE(a.to_dat) >= current_timestamp()";
			}
			if( $exclude_expired_users == "on" ){
				$where .= " AND DATE(valid_to) >= current_timestamp()";
			}
			if( $exclude_non_dialog_users == "on" ){
				$where .= " AND user_type = 1 ";
			}

		} // End IF Not Empty Post

		// Total Users 
		$sql = "Select count(user_name) as total_users from user_details";
		$totalUserDetails = $this->common_model->run_custom_query($sql);
		$data['total_users'] = isset($totalUserDetails[0]['total_users']) ? $totalUserDetails[0]['total_users'] : 0;

		// Total Enabled Users 
		$sql = "Select count(user_name) as total_enabled_users from user_details where enabled = 1";
		$totalUserDetails = $this->common_model->run_custom_query($sql);
		$data['total_enabled_users'] = isset($totalUserDetails[0]['total_enabled_users']) ? $totalUserDetails[0]['total_enabled_users'] : 0;

		//$list_users = $this->common_model->get_entry_by_data('user_details',false, $where,'','','',100,0);
		$sql = "Select DISTINCT (u.uname) , u.user_name, u.valid_from, u.valid_to, u.lockstatus, u.user_type, u.user_group, u.department, u.company, u.location,
		u.enabled, u.generic_id from user_details u INNER JOIN agr_users a ON 
				u.uname = a.uname
				WHERE ".$where."LIMIT $start_index, $limit";

		//echo $sql; die;


		$list_users = $this->common_model->run_custom_query($sql);
		//pr($list_users);
		//die;

		// List Location
		$sql = "Select DISTINCT location from user_details where location is not null";	
		$data['listLocation'] = $this->common_model->run_custom_query($sql);
		
		// List Company
		$sql = "Select DISTINCT company from user_details where company is not null";	
		$data['listCompany'] = $this->common_model->run_custom_query($sql);

		// List Department
		$sql = "Select DISTINCT department from user_details where department not in ('Not Specified')";	
		$data['listDepartment'] = $this->common_model->run_custom_query($sql);

		$data['list_users'] = !empty($list_users) ? $list_users : NULL;
		//$this->layout->render('clients/select_users',$data);

		//return $list_users; 
		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class' => ''],  ['link' => null, 'text' => 'SOD', 'class' => 'active'] ];
		
		$this->layout->render('clients/select_users',$data);
		//$this->load->view('clients/select_users_1',$data);
		

	} // End Function

	public function list_clients(){
		
		connect_master_db();
		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
		$data['list_clients'] = $this->common_model->get_entry_by_data('clients',false,array('1'=>'1'),'','DESC','id');
		$this->layout->render('clients/list_clients',$data);

	} // End Function

	public function select_users_for_analysis($fk_analysis_id = ''){

		$data = [];
		connect_master_db();
		
		$fk_analysis_id = id_decode($fk_analysis_id);
		$data['analysisInfo'] = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$fk_client_id = isset($data['analysisInfo']['fk_client_id']) ? trim($data['analysisInfo']['fk_client_id']) : NULL;
		$data['clientInfo'] = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));

		$db2 = isset($data['clientInfo']['client_database']) ? $data['clientInfo']['client_database'] : NULL;
		connect_new_db($db2);
		$data['list_users'] = $this->common_model->get_entry_by_data( 'user_details', false, array('1' => '1'));

		//pr($user_details); die;
		//pr($list_users); die;

		$this->layout->render('clients/select_user',$data);

	} // End Function

	public function finalize_rules($fk_analysis_id = ''){

		$data = [];
		$fk_analysis_id = id_decode($fk_analysis_id);
		
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));

		// Analysis id doesn't exist Redirect to Create New Analysis
		if(empty($analysisInfo)){
			redirect(base_url('create-new-analysis'));
		}

		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$data['fk_client_id'] =  $fk_client_id;


		$update_array = [];
		 

		$update_array['is_completed'] = 1;
        $update_array['create_datetime'] = date('Y-m-d H:i:s');
    	$upload_status_id = $this->lib_common->get_analysis_status_id('FINALIZE_RULES_COMPLETED');
		
		$upd_rec = $this->common_model->update_entry('analysis_status_history',$update_array,array('fk_analysis_id' => $fk_analysis_id, 'fk_status_id' => $upload_status_id)); 
		//echo $this->common_model->get_last_query(); die;

		//var_dump($upd_rec);

		//redirect(base_url('create-new-analysis/'.id_encode($fk_analysis_id)));

		$data['fk_analysis_id'] = $fk_analysis_id;
		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class' => ''],  ['link' => null, 'text' => 'SOD', 'class' => 'active'] ];
		$this->layout->render('rules-manager/finalize_rules',$data);


	} // End Function

	public function client_wizard($fk_analysis_id = ''){

		$data = [];

		// It tells Which Tab will be active
		
		$data['tab_active'] = 'tab_users_list';

		//$data['tab_active'] = 'tab_rule_manager';
		$where_user_details = " 1 = 1 ";

		if(isset($_POST['finalize_user_for_analysis']) &&  $_POST['finalize_user_for_analysis'] == "finalize_user_for_analysis"){

			$data['tab_active'] = 'tab_users_for_analysis';
			connect_master_db();

			$where_cond = " 1 = 1 ";

			//pr($_POST); die;

		    $company = isset($_POST['company']) ? trim($_POST['company']) : NULL;
		    $department = isset($_POST['department']) ? trim($_POST['department']) : NULL;
		    $location = isset($_POST['location']) ? trim($_POST['location']) : NULL;
		    $business_process = isset($_POST['business_process']) ? trim($_POST['business_process']) : NULL;
		    $inc_expired_users = isset($_POST['inc_expired_users']) ? trim($_POST['inc_expired_users']) : NULL;
		    $exc_locked_users = isset($_POST['exc_locked_users']) ? trim($_POST['exc_locked_users']) : NULL;
		    $exc_org_expired_users = isset($_POST['exc_org_expired_users']) ? trim($_POST['exc_org_expired_users']) : NULL;
		    $exc_expired_role_users = isset($_POST['exc_expired_role_users']) ? trim($_POST['exc_expired_role_users']) : NULL;
		    $exc_expired_users = isset($_POST['exc_expired_users']) ? trim($_POST['exc_expired_users']) : NULL;
		    $exc_non_dialog_users = isset($_POST['exc_non_dialog_users']) ? trim($_POST['exc_non_dialog_users']) : NULL;

		    $fk_client_id = isset($_POST['fk_client_id']) ? id_decode(trim($_POST['fk_client_id'])) : NULL;
		    $clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
		    
		    $db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		    //pr($clientInfo); die;

		    if(!empty($company) && $company != "none" )
				$where_cond .= " AND company = '".$company."' ";

			if(!empty($department) && $department != "none" )
				$where_cond .= " AND department = '".$department."' ";

			if(!empty($location) &&  $location != "none" )
				$where_cond .= " AND location = '".$location."' ";


			$this->lib_common->truncate_table($db2,'tab_user');
			//$sql = "INSERT INTO tab_user select uname from user_list_for_analysis where ".$where_cond;
			$sql = "INSERT INTO tab_user select uname from user_list_for_analysis where ".$where_cond;
			
			//echo $sql; die;

			$result = $this->common_model->run_app_query($sql);
			if($result['success'] == 1){
					$this->session->set_flashdata('succ','Action Performed Successfully');
			}

			/*$this->lib_common->truncate_table($db2,'user_list_for_analysis');
			$sql = "INSERT INTO user_list_for_analysis select uname from user_list_for_analysis where ".$where_cond;
			$result = $this->common_model->run_app_query($sql);*/

			


			//pr($_POST); die;

		} // End IF
		else if( isset($_POST['filter']) &&  $_POST['filter'] == "Filter" ) {

			$data['tab_active'] = 'tab_users_list';
			
			$uname = isset($_POST['uname']) ? trim($_POST['uname']) : NULL;
			$user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : NULL;
			$department = isset($_POST['department']) ? trim($_POST['department']) : NULL;
			$manager = isset($_POST['manager']) ? trim($_POST['manager']) : NULL;
			$suser = isset($_POST['suser']) ? trim($_POST['suser']) : NULL;
			$enabled = isset($_POST['enabled']) ? trim($_POST['enabled']) : NULL;


			if(!empty($uname))
				$where_user_details .= " AND uname like '%".$uname."%' ";

			if(!empty($user_name))
				$where_user_details .= " AND user_name like '%".$user_name."%' ";

			if(!empty($department))
				$where_user_details .= " AND department like '%".$department."%' ";

			if(!empty($manager))
				$where_user_details .= " AND manager like '%".$manager."%' ";

			if(!empty($suser))
				$where_user_details .= " AND suser = '$suser' ";

			if(!empty($enabled)){
				$status = ($enabled == "YES" ? 1 : 0);
				$where_user_details .= " AND enabled = '$status' ";
			}
			
			//echo $where_user_details ; die;


		} // End IF
		else if( isset($_POST['dashboard']) &&  $_POST['dashboard'] == "Submit" ){
			
			connect_master_db();
			$data['tab_active'] = 'tab_dashboard';

			$analysis_id = isset($_POST['analysis_id']) ? trim($_POST['analysis_id']) : NULL;
			$analysisInfo = $this->common_model->get_entry_by_data( 'list_analysis', true, array( 'id' => $analysis_id ) );
			$db3 =  isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
			connect_new_db($db3);
			$data['sap_report'] = $this->common_model->get_entry_by_data('sap_report',false,array( '1' => '1' ));

		}
		else if( isset($_POST['reports']) &&  $_POST['reports'] == "reports" ){
			$data['tab_active'] = 'tab_reports';
		}
		else if( isset($_POST['enable_disable']) &&  $_POST['enable_disable'] == "enable_disable" ){

			$data['tab_active'] = 'tab_users_list';
			connect_master_db();

			$action = isset($_POST['action']) ? $_POST['action'] : NULL;
			$fk_client_id = isset($_POST['fk_client_id']) ? id_decode($_POST['fk_client_id']) : NULL;
			$fk_analysis_id = isset($_POST['fk_analysis_id']) ? id_decode($_POST['fk_analysis_id']) : NULL;



			$uname = isset($_POST['uname']) ? $_POST['uname'] : NULL;
			
			$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array( 'id' => $fk_analysis_id ));
			$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

			//echo $db3; die;


			$clientInfo = $this->common_model->get_entry_by_data('clients',true,array( 'id' => $fk_client_id ));
			$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
			
			connect_new_db($db2);

			//pr($action); die;

			if( $action == "ENABLE" ){

				$update_array = [];

				/*// Step 1: Set ALL To Disable First in DB2 user_details
				$update_array['enabled']  = 0;
				$upd_record = $this->common_model->update_entry('user_details',$update_array,array('1' => '1'));*/

				// Step 2: Set status 1 to those selected users in DB2 user_details
				$update_array = [];
				$update_array['enabled'] = 1;

				$uname_str = "'".implode("','",$uname)."'";
				$where = " uname in (".$uname_str.")";

				$upd_record = $this->common_model->update_entry('user_details',$update_array,$where);

				// Step 3 Truncate DB2 tab_user
				/*$this->lib_common->truncate_table($db2,'tab_user');

				// Step 4 Insert Fresh Entry into tab_user table for Analysis
				foreach($uname as $value){
					$sql = "INSERT INTO tab_user set uname = '".trim($value)."' ";
					$res = $this->common_model->run_query($sql);
				}*/
				
				$this->session->set_flashdata('succ','Action Performed Successfully');


			} // End IF Action Enabled
			else if( $action == "ENABLE_ALL" ){

				$update_array = [];
				$update_array['enabled'] = 1;

				$upd_record = $this->common_model->update_entry('user_details',$update_array,array('1' => '1'));
				$this->session->set_flashdata('succ','Action Performed Successfully');

			}
			else if( $action == "DISABLE" ){

				$update_array = [];
				$update_array['enabled'] = 0;

				$uname_str = "'".implode("','",$uname)."'";
				$where = " uname in (".$uname_str.")";

				$upd_record = $this->common_model->update_entry('user_details',$update_array,$where);

				//echo $this->common_model->get_last_query(); die;
				$this->session->set_flashdata('succ','Action Performed Successfully');


			}
			else if( $action == "DISABLE_ALL" ){

				$update_array = [];
				$update_array['enabled'] = 0;

				$upd_record = $this->common_model->update_entry('user_details',$update_array,array('1' => '1'));
				$this->session->set_flashdata('succ','Action Performed Successfully');

			}
			else if( $action  == "SELECT_FOR_ANALYSIS" ){

				$data['tab_active'] = 'tab_users_for_analysis';

				$uname_str = "'".implode("','",$uname)."'";
				$this->lib_common->truncate_table($db2,'user_list_for_analysis');
				$this->lib_common->truncate_table($db2,'tab_user');
				$sql = "INSERT INTO user_list_for_analysis select * from user_details where uname in (".$uname_str.")";
				$result = $this->common_model->run_app_query($sql);
				if($result['success'] == 1){
					$this->session->set_flashdata('succ','Action Performed Successfully');
				}

				$sql = "INSERT INTO tab_user select uname from user_details where uname in (".$uname_str.")";
				$result = $this->common_model->run_app_query($sql);
				
				

				$update_array['is_completed'] = 1;
            	$update_array['create_datetime'] = date('Y-m-d H:i:s');
            	$upload_status_id = $this->lib_common->get_analysis_status_id('SELECT_USERS_COMPLETED');
            	$upd_rec = $this->common_model->update_entry('analysis_status_history',$update_array,array('fk_analysis_id' => $fk_analysis_id, 'fk_status_id' => $upload_status_id));

            	redirect(base_url('create-new-analysis/'.id_encode($fk_analysis_id)));

			}


		} // End IF Post Submit

		connect_master_db();

		$fk_analysis_id = id_decode($fk_analysis_id);

		//echo "Fk Analysis id ".$fk_analysis_id;

		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		
		$data['fk_analysis_id'] = $fk_analysis_id;

		$data['client_info'] = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
		$data['clients'] = $this->common_model->get_entry_by_data('clients',false,['1'=>1],'id,client_name,client_database');
		$data['list_analysis'] = $this->common_model->get_entry_by_data('list_analysis',false,array('fk_client_id' => $fk_client_id));
		
		//pr($data); die;
		//pr($data['client_info']); die;
		
		$client_database = isset($data['client_info']['client_database']) ? $data['client_info']['client_database'] : NULL;
		
		//echo $client_database; die;

		connect_new_db($client_database);

		$list_user_details = [];
		$list_tab_users = [];
		$user_list_for_analysis = [];


		if($this->lib_common->is_table_exists($client_database,'user_details'))
			//$list_user_details = $this->common_model->get_entry_by_data('user_details',false,array('1' => '1'),'','','',10,0);

			$list_user_details = $this->common_model->get_entry_by_data('user_details',false,$where_user_details );
			//$user_list_for_analysis = $this->common_model->get_entry_by_data('user_list_for_analysis',false,array('1' => '1'));

			

		
		if($this->lib_common->is_table_exists($client_database,'tab_user')){
			$list_tab_users = $this->common_model->get_entry_by_data('tab_user',false,array('1' => '1'));
			if(!empty($list_tab_users)){
				$i = 0;
				$temp = [];
				foreach ($list_tab_users as $key => $value) {
					$temp[$i] = $this->common_model->get_entry_by_data('user_details',true,array('uname'=>$value['uname']));
					$i++;
				} // End Foreach Loop
				$user_list_for_analysis = $temp;
			} // End IF
		}
			
		

		$data['list_client_users'] = !empty($list_user_details) ? $list_user_details : NULL;
		$data['list_tab_users'] = !empty($list_tab_users) ? $list_tab_users : NULL;
		$data['user_list_for_analysis'] = !empty($user_list_for_analysis) ? $user_list_for_analysis : NULL;

		//pr($data['list_client_users']); die;


		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('clients/client_wizard',$data);
		$this->load->view('inc/footer');

	} // End function


	public function save_new_client(){

		$instruction_index = isset($_POST['instruction_index'])  ? $_POST['instruction_index'] : NULL;
		$instruction_index += 1;

		$response = [];

		switch ($instruction_index) {

			case 1:
				// Save Client Basic Information in Client Table
				

				$response = [];
				$message = '<div class="col-3"><span>Client Data Saved<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            </div>';

				$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);

				break;
			case 2:
				// Create A Directory For Client
				$response = [];
				$message = '<div class="col-3"><span>Client Directory Created<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            </div>';

				$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);

				break;
			case 3:
				// Create A Log File
				$response = [];
				$message = '<div class="col-3"><span>Client Log File Created<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            </div>';

				$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				break;
			case 4:
				// Create A Client Database For Client SOD Library & Update in Master DB
				$response = [];
				$message = '<div class="col-3"><span>Client Database Created<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            </div>';

				$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				break;
			case 5:
				// Importing Library Data in Client Library Database
				$response = [];
				$message = '<div class="col-3"><span>Library Imported into Client Database<span></span></div>
                            		<div class="col-6">
                                	<div class="progress mb-0">
                                	<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                                </div>
                            </div>';

				$response = array('status' => 'PENDING', 'instruction_index' => $instruction_index, 'percentage' => '100% Completed', 'message' => $message);
				break;

			default:
				# code...
				break;
		}




		echo json_encode($response); die;



	
	}  // End Function
	

	// Using Ajax
	public function create_new_client(){

		//pr($_POST); die;
		$data = [];
		$db_name = '';

		connect_master_db();

		$data['success'] = 0;
		$data['message'] = "";

		
		

		
		if ( $this->form_validation->run('create_new_client') == TRUE ){

			$effective_date = date('Y-m-d H:i:s');

			$insert_array = [];
			$insert_array['client_name'] = isset($_POST['client_name'])  ? $_POST['client_name'] : NULL;
			$insert_array['description'] = isset($_POST['description']) && $_POST['description'] != NULL ? $_POST['description'] : $_POST['client_name'];
			$insert_array['database_type'] = isset($_POST['database_type'])  ? $_POST['database_type'] : 'SAP';
			
			$insert_array['create_datetime'] = $effective_date;
			$insert_array['create_by'] = $_SESSION['uid'];

			$insert_array['update_datetime'] = $effective_date;
			$insert_array['update_by'] = $_SESSION['uid'];

			//echo MASTER_DATABASE_PREFIX; die;
			$int_record = $this->common_model->save_entry('clients',$insert_array);
			
			if($int_record){
				
				$rowid = $int_record['id'];
				$serial_no = 'CLI000'.$rowid;

				$db_name = $insert_array['database_type'].'_'.'CLI000'.$rowid;

				// Create a directory
				mkdir(FCPATH.'uploads/Clients/'.$db_name);

				// Create a Log File
				$handle = fopen(FCPATH.'uploads/Clients/'.$db_name.'/'.$db_name."_log.log", "w");
				fclose($handle);
				// Create Database For Client SOD Library
				
				$sql = " Create Database IF NOT EXISTS ".$db_name;

				$res = $this->db->query($sql);

				if($res){

					$data['db_name'] = $db_name;

                    // Update Client Table
					connect_master_db();
					$update_array = [];

					$update_array['client_database'] = $db_name;
					$update_array['serial_no'] = $serial_no;
					$upd_record = $this->common_model->update_entry( 'clients', $update_array, array( 'id' => $rowid) );

					if($upd_record){

						$this->session->set_flashdata('succ', 'Client '.$insert_array['client_name'].' Created Successfully');
						$this->session->set_flashdata('db_name', $db_name);
						
					}

					// Further Script For Building SOD Rule Book Master Library DB
					connect_new_db($db_name);

					$file_path = FCPATH."uploads/Lib/SOD_Master/SOD_Rule_Book_Master.sql";

					$sql = file_get_contents($file_path);
					$sqls = explode(';', $sql);
					array_pop($sqls);

					foreach( $sqls as $statement){
						$statement = $statement . ";";
                		$this->common_model->run_query($statement);
					}

				} // End IF REs

			} // End IF After Int_Record
			else{
				
				
				$data['success'] = 0;
				$data['message'] = "Creation Error";
				echo json_encode($data); die;


			}

		} // End IF Form Validation
		else{
			//$this->session->set_flashdata('err', validation_errors());

			$data['success'] = 0;
			$data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
			echo json_encode($data); die;

		}

		$data['success'] = 1;
		$data['message'] = "Client Created Successfully";

		echo json_encode($data); die;

		//$data['list_clients'] = $this->common_model->get_entry_by_data('clients',false,array('1'=>'1'),'','DESC','id');
		
		//pr($data['list_clients']);die;

		/*$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('clients/index',$data);
		$this->load->view('inc/footer');*/

		//$this->layout->render('clients/list_clients',$data);
		

		//redirect(base_url('list-clients'));


	} // End Function


	public function create_new_client_old_25_Jan(){

		//pr($_POST); die;
		$data = [];
		$db_name = '';

		connect_master_db();
		
		if ( $this->form_validation->run('create_new_client') == TRUE ){

			$effective_date = date('Y-m-d H:i:s');

			$insert_array = [];
			$insert_array['client_name'] = isset($_POST['client_name'])  ? $_POST['client_name'] : NULL;
			$insert_array['description'] = isset($_POST['description']) && $_POST['description'] != NULL ? $_POST['description'] : $_POST['client_name'];
			$insert_array['database_type'] = isset($_POST['database_type'])  ? $_POST['database_type'] : 'SAP';
			
			$insert_array['create_datetime'] = $effective_date;
			$insert_array['create_by'] = $_SESSION['uid'];

			$insert_array['update_datetime'] = $effective_date;
			$insert_array['update_by'] = $_SESSION['uid'];

			//echo MASTER_DATABASE_PREFIX; die;
			$int_record = $this->common_model->save_entry('clients',$insert_array);
			
			if($int_record){
				
				$rowid = $int_record['id'];
				$serial_no = 'CLI000'.$rowid;

				$db_name = $insert_array['database_type'].'_'.'CLI000'.$rowid;

				// Create a directory
				mkdir(FCPATH.'uploads/Clients/'.$db_name);

				// Create a Log File
				$handle = fopen(FCPATH.'uploads/Clients/'.$db_name.'/'.$db_name."_log.log", "w");
				fclose($handle);
				// Create Database For Client SOD Library
				
				$sql = " Create Database IF NOT EXISTS ".$db_name;

				$res = $this->db->query($sql);

				if($res){

					$data['db_name'] = $db_name;

                    // Update Client Table
					connect_master_db();
					$update_array = [];

					$update_array['client_database'] = $db_name;
					$update_array['serial_no'] = $serial_no;
					$upd_record = $this->common_model->update_entry( 'clients', $update_array, array( 'id' => $rowid) );

					if($upd_record){

						$this->session->set_flashdata('succ', 'Client '.$insert_array['client_name'].' Created Successfully');
						$this->session->set_flashdata('db_name', $db_name);
					}
				}

			}
			else{
				$this->session->set_flashdata('err', 'Creation Error.');
			}

		} // End IF Form Validation
		else{
			$this->session->set_flashdata('err', validation_errors());
		}

		$data['list_clients'] = $this->common_model->get_entry_by_data('clients',false,array('1'=>'1'),'','DESC','id');
		
		//pr($data['list_clients']);die;

		/*$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('clients/index',$data);
		$this->load->view('inc/footer');*/

		$this->layout->render('clients/list_clients',$data);
		

		//redirect(base_url('list-clients'));

	}  // End Function

	public function update_client_detail(){

	} // End Function




} // End Class


