<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RulesManager extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}


	function dashboard($client_id){
		
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['client_id'] = $client_id;
		connect_master_db();

		$data['clients'] = $this->common_model->get_entry_by_data('clients',false,['1'=>1],'id,client_name,client_database');
		if ($this->input->post('copy_db')) {
			
			$client_db_id = $this->input->post('client_db_id');
			$client_db_idAr = explode('-',$client_db_id);
			
			$selected_client_id = $client_db_idAr[0];
			$db_name = $client_db_idAr[1];
			#connect_new_db($db_name);
			$this->load->library('Lib_common');
			$tbl_backup = $this->lib_common->backup_db_table($db_name,'E:/My Team','conflict_c');
			if ($tbl_backup) {
				echo 'done'; die();
			}

		}
		
		$this->load->view('rules-manager/rules-manager',$data);
		$this->load->view('inc/footer');	

	} // End Function

	function view_bp($client_id){
		
		$data['client_id']	=	$client_id;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		if ($this->input->post('submit')) {
			$procsAr = $this->input->post('proc');
			$update_status = $this->input->post('update_status');
			$update_array['Status'] = $update_status;
			if ($procsAr) {
				$successAr = $errorAr = [];
				foreach ($procsAr as $key => $proc) {
					$update = $this->common_model->update_entry('bus_proc',$update_array,['proc'=>$proc]);
					if ($update) {
						array_push($successAr, $update);
					} else {
						array_push($successAr, $proc);
					}
				}
				if ($successAr) {
					$message = count($successAr).' rows successfully updated.';
					$this->session->set_flashdata('succ',$message);
				} else {
					$message = count($successAr).' rows could not be updated please try again.';
					$this->session->set_flashdata('err',$message);
				}
					redirect(base_url('rules-manager/business-process/view-bp/'.$client_id));
			}
		}

		$data['bus_proc'] = $this->common_model->get_entry_by_data('bus_proc',false,['1'=>1]);
		$this->layout->render('rules-manager/business-process/view-bp',$data);


	} // End Function

	function add_new_bp($client_id){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['client_id']	=	$client_id;

		connect_master_db();

		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		if ($this->input->post()) {
			$subprocs = $this->input->post('sub_business_process');
			$insert_array['proc'] 	= $proc = 	$this->input->post('process_id');
			$insert_array['dsc'] 			=	$this->input->post('process_discription');
			$insert_array['Status'] 		=	$this->input->post('process_status');

			$insert_record = $this->common_model->save_entry('bus_proc',$insert_array,'proc');
			
			if (!empty($subprocs)) {
				foreach ($subprocs as $key => $subproc) {
					if (empty($subproc)) {
						continue;
					}

				$sub_process_insert['proc'] = $proc;
				$sub_process_insert['subproc'] 	=	$subproc;
				$insert_record = $this->common_model->save_entry('bus_subproc',$sub_process_insert,'proc');
				}
			}

			if ($insert_record) {
				$this->session->set_flashdata('succ','New entry successfully saved.');
			} else {
				$this->session->set_flashdata('err','New entry could not be saved. Please try again.');
			}
			redirect(base_url('rules-manager/business-process/add-new-bp/'.$client_id));
		}

		$this->load->view('rules-manager/business-process/add-new-bp',$data);
		$this->load->view('inc/footer');	
	}

	function get_bus_sub_process($client_id,$process_id){
		$data['client_id'] = $client_id;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);
		$sub_process = $this->common_model->get_entry_by_data('bus_subproc',false,['proc'=>$process_id],'subproc');

			if (!empty($sub_process)) {
			$options = '<select name="sub_business_process" class="form-control" required="true"><option value="">--Select Sub Process--</option>';
			foreach ($sub_process as $key => $value) {
				$options .= '<option value="'.$value['subproc'].'">'.$value['subproc'].'</option>';
			}

			$options .= '</select>';

			} else {
				
				$options = '<select name="sub_business_process" class="form-control" required="true"><option value="">--Select Sub Process--</option></select>';
			}
				echo $options;
	}

	####################### SOD RISK METHODS #######################

	function view_sod_risk($client_id){
		
		/* $this->load->view('inc/header');
		$this->load->view('inc/left-sidebar'); */

		$data['client_id'] = $client_id;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);


		$data['sod_risk'] = $this->common_model->get_entry_by_data('sod_risk',false,['1'=>1]);

		#################### CODE FOR UPDATE DATA ##################

			if ($this->input->post('submit')) {
			$riskidAr = $this->input->post('riskid');
			$update_status = $this->input->post('update_status');
			$update_array['enabled'] = $update_status;
			if ($riskidAr) {
				$successAr = $errorAr = [];
				foreach ($riskidAr as $key => $riskid) {
					$update = $this->common_model->update_entry('sod_risk',$update_array,['riskid'=>$riskid]);
					if ($update) {
						array_push($successAr, $update);
					} else {
						array_push($successAr, $proc);
					}
				}
				if ($successAr) {
					$message = count($successAr).' rows successfully updated.';
					$this->session->set_flashdata('succ',$message);
				} else {
					$message = count($successAr).' rows could not be updated please try again.';
					$this->session->set_flashdata('err',$message);
				}
					redirect(base_url('rules-manager/sod-risk/view-sod-risk/'.$client_id));
			}
		}

		#################### END OF CODE FOR UPDATE DATA ###########

		/* $this->load->view('rules-manager/sod-risk/view-sod',$data);
		$this->load->view('inc/footer');*/

		$this->layout->render('rules-manager/sod-risk/view-sod2',$data);

	} // End Function

	function add_new_sod_risk($client_id){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');

		$data['client_id'] = $client_id;
		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		$data['bus_procs'] = $this->common_model->get_entry_by_data('bus_proc',false,['Status'=>1],'proc,dsc');

		$data['activities'] = $this->common_model->get_entry_by_data('act_class',false,['1'=>1],'activity,act_desc');

		if ($this->input->post('submit')) {

			$bproc = $insert_array['bproc'] =	$this->input->post('business_process');
		    $act1 = $insert_array['act1'] =	$this->input->post('act_1');
		    $act2 = $insert_array['act2'] =	$this->input->post('act_2');
		    $act3 = $insert_array['act3'] =	$this->input->post('act_3');

			#### CHECK POINT : CHECK FOR BPROC & ACT1,ACT2 AND ACT3 EXIST IN TABLE OR NOT IF EXIST THEN NO TO DO NEW ENTRY ####

			$check = $this->common_model->get_entry_by_data('sod_risk',false,['bproc'=>$bproc,'act1'=>$act1,'act2'=>$act2,'act3'=>$act3],'riskid');

			if ($check) {
				$message = 'Duplicate entry found. Kindly try again.';
				$this->session->set_flashdata('err',$message);
				redirect(base_url('rules-manager/sod-risk/add-new-sod-risk/'.$client_id));
			}

			############### END OF CHECK POINT ##################
			
			$statement = "SELECT COUNT(`bproc`) as total_risk FROM `sod_risk` WHERE bproc = '".$bproc."'";
			$count_bproc = $this->common_model->run_custom_query($statement);
			$new_bproc_number = $count_bproc[0]['total_risk']+1;
			$new_bproc_number = sprintf("%03s", $new_bproc_number);
			$riskid = $bproc.$new_bproc_number;

			$insert_array['riskid'] =	$riskid;
		    $insert_array['riskname'] =	$this->input->post('risk_name');
		    $insert_array['dsc'] =	$this->input->post('risk_discription');
		    $insert_array['rating'] =	$this->input->post('risk_rating');
		    $insert_array['enabled'] =	$this->input->post('risk_status');
		    $insert_array['ctype'] =	'Authorization';

			$insert_record = $this->common_model->save_entry('sod_risk',$insert_array,'riskid');

			if ($insert_record) {
				$this->session->set_flashdata('succ','New entry successfully saved.');
			} else {
				$this->session->set_flashdata('err','New entry could not be saved. Please try again.');
			}
			redirect(base_url('rules-manager/sod-risk/add-new-sod-risk/'.$client_id));

		}

		$this->load->view('rules-manager/sod-risk/add-new-risk',$data);
		$this->load->view('inc/footer');	
	}

	####################### ACTIVITIES METHOD #######################

		function add_new_activity($client_id){
			$this->load->view('inc/header');
			$this->load->view('inc/left-sidebar');
			$data['client_id'] = $client_id;

			connect_master_db();
			$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
			connect_new_db($client['client_database']);

			$data['act_class_desc'] = $this->common_model->get_entry_by_data('act_class_desc',false,['1'=>1]);

			$data['bus_proc']=$this->common_model->get_entry_by_data('bus_proc',false,['1'=>1]);

			if ($this->input->post('submit')) {

			$proc = $insert_array['proc'] =	$this->input->post('business_process');
		    $subproc = $insert_array['subproc'] =	$this->input->post('sub_business_process');
		    $act_class = $insert_array['act_class'] =	$this->input->post('act_class');
		    $insert_array['act_desc'] =	$this->input->post('act_discription');

			#### CHECK POINT : CHECK FOR BPROC & ACT1,ACT2 AND ACT3 EXIST IN TABLE OR NOT IF EXIST THEN NO TO DO NEW ENTRY ####

			$check = $this->common_model->get_entry_by_data('act_class',false,['proc'=>$proc,'subproc'=>$subproc,'act_class'=>$act_class],'activity');

			if ($check) {
				$message = 'Duplicate entry found. Kindly try again.';
				$this->session->set_flashdata('err',$message);
				redirect(base_url('rules-manager/manage-activities/add-new-activity/'.$client_id));
			}

			############### END OF CHECK POINT ##################
			
			$statement = "SELECT COUNT(`proc`) as total_activities FROM `act_class` WHERE proc = '".$proc."'";
			$count_bproc = $this->common_model->run_custom_query($statement);
			$new_bproc_number = $count_bproc[0]['total_activities']+1;
			$new_bproc_number = sprintf("%02s", $new_bproc_number);
			$activityid = $proc.$new_bproc_number;

			$insert_array['activity'] =	$activityid;

			$insert_record = $this->common_model->save_entry('act_class',$insert_array,'activity');

			if ($insert_record) {
				$this->session->set_flashdata('succ','New entry successfully saved.');
			} else {
				$this->session->set_flashdata('err','New entry could not be saved. Please try again.');
			}
			redirect(base_url('rules-manager/manage-activities/add-new-activity/'.$client_id));

		}
			
			$this->load->view('rules-manager/activities/add-new-activity',$data);
			$this->load->view('inc/footer');	
		}


		function view_activities($client_id){

			//$this->load->view('inc/header');
			//$this->load->view('inc/left-sidebar');
			$data['client_id'] = $client_id;

			connect_master_db();
			$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
			connect_new_db($client['client_database']);

			$data['activities'] = $this->common_model->get_entry_by_data('act_class',false,['1'=>1]);
			$act_class_desc = $this->common_model->get_entry_by_data('act_class_desc',false,['1'=>1]);
			$act_class_descAr = [];
			foreach ($act_class_desc as $key => $desc) {
				$act_class_descAr[$desc['act_num']] = $desc['act_desc'];
			}

			$data['act_class_desc'] = $act_class_descAr;

			$this->layout->render('rules-manager/activities/view-activities2',$data);

			//$this->load->view('rules-manager/activities/view-activities',$data);
			//$this->load->view('inc/footer');	
		}

	####################### TRANSACTION CODE METHOD #######################

		function view_transaction_codes($client_id){

			//$this->load->view('inc/header');
			//$this->load->view('inc/left-sidebar');
			$data['client_id'] = $client_id;

			connect_master_db();
			$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
			connect_new_db($client['client_database']);

			$data['zcodes'] = $this->common_model->get_entry_by_data('zcodes',false,['1'=>1]);
			$this->layout->render('rules-manager/transaction-codes/view-transaction-codes2',$data);
			//$this->load->view('inc/footer');

		}

	####################### SOD RULES METHOD #######################

		function view_sod_rules($client_id){

			//$this->load->view('inc/header');
			//$this->load->view('inc/left-sidebar');
			$data['client_id'] = $client_id;

			connect_master_db();
			$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
			connect_new_db($client['client_database']);

			$data['critical_auth'] = $this->common_model->get_entry_by_data('critical_auth',false,['1'=>1]);

			if ($this->input->post('submit')) {
			$proc_tcodeAr = $this->input->post('proc_tcode');
			$update_status = $this->input->post('update_status');
			$update_array['Status'] = $update_status;
			if ($proc_tcodeAr) {
				$successAr = $errorAr = [];
				foreach ($proc_tcodeAr as $key => $proc_tcode) {
					$proc_tcode_filter = explode('-',$proc_tcode);
					$proc = $proc_tcode_filter[1];
					$tcode = $proc_tcode_filter[3];
					$update = $this->common_model->update_entry('critical_auth',$update_array,['proc'=>$proc,'tcode'=>$tcode]);
					if ($update) {
						array_push($successAr, $update);
					} else {
						array_push($successAr, $proc);
					}
				}
				if ($successAr) {
					$message = count($successAr).' rows successfully updated.';
					$this->session->set_flashdata('succ',$message);
				} else {
					$message = count($successAr).' rows could not be updated please try again.';
					$this->session->set_flashdata('err',$message);
				}
					redirect(base_url('rules-manager/sod-rules/view-sod-rules/'.$client_id));
			}
		}

			$this->layout->render('rules-manager/sod-rules/view-sod-rules2',$data);
			//$this->load->view('inc/footer');

		}

	####################### CRITICAL ACCESS METHOD #######################

	function view_critical_access_rules($client_id){
		
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['client_id'] = $client_id;
		$this->load->view('rules-manager/critical-access/critical-access-rules',$data);
		$this->load->view('inc/footer');	

	}
	
	function add_new_critical_access_rule($client_id){
		
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['client_id'] = $client_id;

		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		if ($this->input->post('submit')) {

			$insert_array['proc'] =	'';
			$insert_array['tcode'] =	$this->input->post('tcode');
			$insert_array['Status'] =	1;

			$insert_record=$this->common_model->save_entry('critical_auth',$insert_array,'tcode');

			if ($insert_record) {
				$this->session->set_flashdata('succ','New entry successfully saved.');
			} else {
				$this->session->set_flashdata('err','New entry could not be saved. Please try again.');
			}
			redirect(base_url('rules-manager/critical-access/add-new-critical-access-rule/'.$client_id));

		}

		$this->load->view('rules-manager/critical-access/add-new-critical-access-rule',$data);
		$this->load->view('inc/footer');	
	}

	####################### CONFLICTS EXCEPTIONS METHOD #######################

	function object_conflicts_exceptions($client_id){
		
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['client_id'] = $client_id;

		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		$data['object_codes'] = [];
		if ($this->input->post('search_objects')) {
			$data['tcode'] = $tcode = $this->input->post('transaction_code');
			$data['object_codes'] = $this->common_model->get_entry_by_data('conflicts_values_a',false,['tcode'=>$tcode]);
		}

		########### CODE FOR SAVE NEW OBJECTS ###############

		if ($this->input->post('add_new_objects')) {

			$successAr = $errorAr = $tcode_object_field_existAr = [];
			$insert_array['tcode'] = $tcode = $this->input->post('tcode');
			$objcts = $this->input->post('object_name');
			$field_names = $this->input->post('field_name');
			$value_names = $this->input->post('value_name');
			foreach ($objcts as $key => $object) {
				$insert_array['objct'] = $object;
				$insert_array['field'] = $field = $field_names[$key];
				$insert_array['value'] = $value_names[$key];
			
			################# CHECK FOR UNIQUE ENTRY BASED ON TCODE,OBJECT AND FILED NAME ##########
				$check_tcode_object_field = $this->common_model->get_entry_by_data('conflicts_values_a',true,['tcode'=>$tcode,'objct'=>$object,'field'=>$field]);
			################# END OF CHECK POINT #############
				if (empty($check_tcode_object_field)) {
					$insert_record = $this->common_model->save_entry('conflicts_values_a',$insert_array,'tcode');
					if ($insert_record) {
						array_push($successAr,$insert_record);
					} else {
						array_push($errorAr,$object);
					}
				} else {
					array_push($tcode_object_field_existAr,$object);
				}
			}

			$message = NULL;
			if (count($tcode_object_field_existAr)>0) {
				$message = '<b>'.count($tcode_object_field_existAr).' i.e '.implode(',', $tcode_object_field_existAr).'</b> objects and fields already exist for tcode <b>'.$tcode.' </b>.';
			}

			if ($successAr) {
				$message .= ' New entry successfully saved.';
				$this->session->set_flashdata('succ',$message);
			} else {
				$message .= ' New entry could not be saved. Please try again.';
				$this->session->set_flashdata('err',$message);
			}
			redirect(base_url('rules-manager/conflicts-exceptions/object-conflicts-exceptions/'.$client_id));
		}

		$this->load->view('rules-manager/conflicts-exceptions/object-conflicts-exceptions',$data);
		$this->load->view('inc/footer');	
	}
	
	####################### CONFLICTS EXCEPTIONS ROLES #######################

	function roles_conflicts_exceptions($client_id){
		
		//$this->load->view('inc/header');
		//$this->load->view('inc/left-sidebar');

		$data = [];
		$data['client_id'] = $client_id;

		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		$data['roles'] = $this->common_model->get_entry_by_data('conflicts_exceptions_role',false,['1'=>1]);

		//pr($data['roles']);
		//die;

		$this->layout->render('rules-manager/conflicts-exceptions/roles-conflicts-exceptions2',$data);

		//$this->load->view('rules-manager/conflicts-exceptions/roles-conflicts-exceptions',$data);
		//$this->load->view('inc/footer');

	}

	function add_new_role_conflict_exception($client_id){
		
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data = [];
		$data['client_id'] = $client_id;

		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);
		if ($this->input->post('submit')) {
			$insert_array['uname'] = $uname = $this->input->post('username');
			$insert_array['agr_name'] = $agr_name = $this->input->post('agr_name');

			############ CHECK FOR UNAME & AGR_NAME DUPLICATE ENTRY #################
			$check_uname = $this->common_model->get_entry_by_data('conflicts_exceptions_role',true,['uname'=>$uname,'agr_name'=>$agr_name]);
			############ END OF CHECK POINT ##########################################

			if (empty($check_uname)) {

				$insert_record = $this->common_model->save_entry('conflicts_exceptions_role',$insert_array,'uname');

				if ($insert_record) {
					$this->session->set_flashdata('succ','New entry successfully saved.');
				} else {
					$this->session->set_flashdata('err','New entry could not be saved. Please try again.');
				}
			} else {
				$this->session->set_flashdata('err','<b> Uname : '.$uname.' & AGR Name : '.$agr_name.'</b> Already exist. New entry could not be saved. Please try again.');
			}
			redirect(base_url('rules-manager/conflicts-exceptions/add-new-role-conflict-exception/'.$client_id));

		}
		$this->load->view('rules-manager/conflicts-exceptions/add-new-role-conflict-exception',$data);
		$this->load->view('inc/footer');
	}

################################# ADDITIONAL ACCESS CHECKS METHOD ######################################

function additional_access_checks($client_id){

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$data['client_id'] = $client_id;

		connect_master_db();
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id]);
		connect_new_db($client['client_database']);

		$data['object_codes'] = [];
		if ($this->input->post('search_objects')) {
			$data['tcode'] = $tcode = $this->input->post('transaction_code');
			$data['object_codes'] = $this->common_model->get_entry_by_data('conflicts_add_checks',false,['tcode'=>$tcode]);
		}

		########### CODE FOR SAVE NEW OBJECTS ###############

		if ($this->input->post('add_new_objects')) {

			$successAr = $errorAr = $tcode_object_field_existAr = [];
			$insert_array['tcode'] = $tcode = $this->input->post('tcode');
			$objcts = $this->input->post('object_name');
			$field_names = $this->input->post('field_name');
			$value_names = $this->input->post('value_name');
			foreach ($objcts as $key => $object) {
				$insert_array['objct'] = $object;
				$insert_array['field'] = $field = $field_names[$key];
				$insert_array['value'] = $value_names[$key];
			
			################# CHECK FOR UNIQUE ENTRY BASED ON TCODE,OBJECT AND FILED NAME ##########
				$check_tcode_object_field = $this->common_model->get_entry_by_data('conflicts_add_checks',true,['tcode'=>$tcode,'objct'=>$object,'field'=>$field]);
			################# END OF CHECK POINT #############
				if (empty($check_tcode_object_field)) {
					$insert_record = $this->common_model->save_entry('conflicts_add_checks',$insert_array,'tcode');
					if ($insert_record) {
						array_push($successAr,$insert_record);
					} else {
						array_push($errorAr,$object);
					}
				} else {
					array_push($tcode_object_field_existAr,$object);
				}
			}

			$message = NULL;
			if (count($tcode_object_field_existAr)>0) {
				$message = '<b>'.count($tcode_object_field_existAr).' i.e '.implode(',', $tcode_object_field_existAr).'</b> objects and fields already exist for tcode <b>'.$tcode.' </b>.';
			}

			if ($successAr) {
				$message .= ' New entry successfully saved.';
				$this->session->set_flashdata('succ',$message);
			} else {
				$message .= ' New entry could not be saved. Please try again.';
				$this->session->set_flashdata('err',$message);
			}
			redirect(base_url('rules-manager/additional-checks/list/'.$client_id));
		}

		$this->load->view('rules-manager/additional-checks/access-checks-list',$data);
		$this->load->view('inc/footer');	
	}


	/* function finalize_rules(){	
		$this->layout->render('rules-manager/finalize_rules');	
	} */

}