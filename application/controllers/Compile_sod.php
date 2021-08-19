<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', '-1');

class Compile_sod extends Access_Controller {
	
	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}
	
	 public function compile_sod_risk($fk_analysis_id = ''){
		
		$data = [];
		
		$path = FCPATH.str_replace('.', '/', $path);

		$fk_analysis_id = $fk_analysis_id != '' ? id_decode($fk_analysis_id) :  NULL;
		connect_master_db();

		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$fk_client_id =  isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
        $db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL; 

		connect_new_db($db2);

		$this->lib_common->truncate_table($db2,'conflicts_c'); // turncat table conflict_c

		$sodInfo = $this->common_model->get_entry_by_data('sod_risk',false,array('1' => '1'),'riskid');
		
		 foreach($sodInfo as $riskid)
		 {
				$sql1 = "SELECT b.tcode as tcode1 from sod_risk as a LEFT JOIN actcode as b ON a.act1 = b.activity LEFT JOIN bus_proc bp ON a.bproc=bp.proc WHERE a.riskid ='".$riskid['riskid']."' AND a.enabled!='0' AND bp.Status!='0' ORDER by a.riskid ASC";
				$act1 = $this->common_model->run_custom_query($sql1);
			   
			   foreach($act1 as $row1)   
		       {
					  $sql2 = "SELECT b.tcode as tcode2 from sod_risk as a LEFT JOIN actcode as b ON a.act2 = b.activity LEFT JOIN bus_proc bp ON a.bproc=bp.proc WHERE a.riskid ='".$riskid['riskid']."' AND a.enabled!='0' AND bp.Status!='0' ORDER by a.riskid ASC";
					  $act2 = $this->common_model->run_custom_query($sql2); 
					   foreach($act2 as $row2)   
					   {
						  $sql3 = "SELECT b.tcode as tcode3 from sod_risk as a LEFT JOIN actcode as b ON a.act3 = b.activity LEFT JOIN bus_proc bp ON a.bproc=bp.proc WHERE a.riskid ='".$riskid['riskid']."' AND a.enabled!='0' AND bp.Status!='0' ORDER by a.riskid ASC";
						  $act3 = $this->common_model->run_custom_query($sql3); 
						   foreach($act3 as $row3)   
						   {
							  //permutation and combination of act1 and act2 and act3
								 $combined_var = array_unique($this->get_combinations($row1, $row2, $row3)); 
								 $commonID = $riskid['riskid']; // commanID (risk iD)
								
								     $max_ID = "SELECT max(`CONFLICTID`) as CONFLICTID FROM `conflicts_c`";
									  $max_ID_val = $this->common_model->run_custom_query($max_ID); 
									   foreach($max_ID_val as $maxwa_id)   
									   {
									        $CONFLICTID=$maxwa_id['CONFLICTID'];
										   
									   }
									  
										if(empty($CONFLICTID))
										{
										 $conflict_c_id_Generator=$commonID.'10000'.'1';
										}
										else
										{
										  $increment_ID=substr($CONFLICTID,6,6);
										  $conflict_c_id =(int)$increment_ID+1;
										
										  $conflict_c_id_Generator=$commonID.$conflict_c_id;
										}
                                       
							
								    if(is_array($combined_var))
								    {
										  foreach($combined_var as $key => $value)
										  {
											  
											 /* 
											 	echo $value[0] . ' + ';
							                  	echo $value[1] . '<br>'; 
											 	// die();
											*/
											 
											 // Activity 1
											 if ($value[0]!='')
											 {

											  $inser1 = "INSERT into conflicts_c(CONFLICTID, OBJCT, FIELD, VALUE) VALUES ('$conflict_c_id_Generator', 'S_TCODE', 'TCD', '".$value[0]."')";
			                                  $result1 = $this->common_model->run_app_query($inser1);

												if( $result1['success'] == 1 ){

												}
												else{
													
													$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result1['error_code']." Érror Message: ".$result1['error_message'];
													$myfile = file_put_contents($path.'/uploads/Clients/'.$db2.'/'.$db2.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
												}
											 }

												// Activity 2
												if($value[1]!=''){

													$inser2 = "INSERT into conflicts_c(CONFLICTID, OBJCT, FIELD, VALUE) VALUES ('$conflict_c_id_Generator', 'S_TCODE', 'TCD', '".$value[1]."')";
													$result2 = $this->common_model->run_app_query($inser2);

													if( $result2['success'] == 1 ){

													}
													else{
														$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result2['error_code']." Érror Message: ".$result2['error_message'];
														$myfile = file_put_contents($path.'/uploads/Clients/'.$db2.'/'.$db2.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
													}
												}

												// Activity 3
												if ($value[2]!='')
												{

													$inser3 = "INSERT into conflicts_c(CONFLICTID, OBJCT, FIELD, VALUE) VALUES ('$conflict_c_id_Generator', 'S_TCODE', 'TCD', '".$value[2]."')";
													$result3 = $this->common_model->run_app_query($inser3);

														if( $result3['success'] == 1 ){

														}
														else{
															$log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result3['error_code']." Érror Message: ".$result3['error_message'];
															$myfile = file_put_contents($path.'/uploads/Clients/'.$db2.'/'.$db2.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
														}

												}

												
										  }
										  
									}
					  
						   } // act3
				  
			           }   //act2
			   } // act1 
        
		 } // sod_risk
			
          redirect(base_url('create-new-analysis/'.id_encode($fk_analysis_id)));


	} // End Function
	
	    public function get_combinations(...$arrays) 
		{
			$result = array(array());
			foreach ($arrays as $property => $property_values) {
				$tmp = array();
				foreach ($result as $result_item) {
					foreach ($property_values as $property_value) {
						$tmp[] = array_merge($result_item, array($property => $property_value));
					}
				}
				$result = $tmp;
			}
			
			return $result;
		}	

} // End Class


