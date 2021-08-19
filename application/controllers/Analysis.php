<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', '-1');

class Analysis extends Access_Controller {
	
	function __construct()
    {
    	parent::__construct();
	}

	public function analysis_dashboard($fk_analysis_id = ''){
		
		$data = [];
		$fk_analysis_id = id_decode($fk_analysis_id);

		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		
		// Check IF Analysis is completed 

		if(empty($analysisInfo))
			redirect(base_url('create-new-analysis/'));
		if( $analysisInfo['process_out_time'] == NULL )
			redirect(base_url('create-new-analysis/'.id_encode($fk_analysis_id)));

		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
		$create_datetime = isset($analysisInfo['create_datetime']) ? short_date_format($analysisInfo['create_datetime']) : NULL;
		$data['create_datetime'] = $create_datetime;
		
		connect_new_db($db3);
		
		$sql = "SELECT `column_name`, `column_value` FROM `sap_report` group by `column_name`";
		$result = $this->common_model->run_custom_query($sql);
		
		$report = [];
		if( !empty($result) ){

			foreach( $result as $key => $value){
				$report[$value['column_name']] = $value['column_value'];
			}
		}

		// Total User Analysed
$total_user_analysed = isset($report['total_user_anlaysed']) ? $report['total_user_anlaysed'] : 0;
$data['total_user_analysed'] = $total_user_analysed ;

// Total Users having Conflicts
$total_users_having_conflicts = isset($report['total_user_conflicts']) ? $report['total_user_conflicts'] : 0;
$data['user_conflicts_percentage'] = round( (($total_users_having_conflicts * 100 )/$total_user_analysed) , 2 ) ;

// Total Role Analysed
$total_role_analysed = isset($report['total_role_analysed']) ? $report['total_role_analysed'] : 0;
$data['total_role_analysed'] = $total_role_analysed ;


// Total Roles having Conflicts
$total_roles_having_conflicts = isset($report['total_role_conflicts']) ? $report['total_role_conflicts'] : 0;


if( $total_roles_having_conflicts > 0  ){
			$data['role_conflicts_percentage'] = round( (($total_roles_having_conflicts * 100 )/$total_role_analysed) , 2 ) ;
}
else{
			$data['role_conflicts_percentage'] = 0;
}

// Total Risk Analysed

$total_risk_analysed = isset($report['total_risk_analysed']) ? $report['total_risk_analysed'] : 0;
$data['total_risk_analysed'] = $total_risk_analysed ;

// Total Risk Violated
$total_risk_violated = isset($report['total_risk_violated']) ? $report['total_risk_violated'] : 0;
$data['risk_violated_percentage'] = round( (($total_risk_violated * 100 )/$total_risk_analysed) , 2 ) ;


// Total Conflicts
$total_conflicts = isset($report['total_conflicts']) ? $report['total_conflicts'] : 0;
$data['total_conflicts'] = $total_conflicts ;


// [PIE Chart] - High Conflicts
$data['high_risk'] = isset($report['high_risk']) ? $report['high_risk'] : 0;
$data['medium_risk'] = isset($report['medium_risk']) ? $report['medium_risk'] : 0;
$data['low_risk'] = isset($report['low_risk']) ? $report['low_risk'] : 0;

// [Horizontal Single Bar Graphp] - Intra Role Conflicts
$data['intra_high_risk'] = isset($report['intra_high_risk']) ? $report['intra_high_risk'] : 0;
$data['intra_medium_risk'] = isset($report['intra_medium_risk']) ? $report['intra_medium_risk'] : 0;
$data['intra_low_risk'] = isset($report['intra_low_risk']) ? $report['intra_low_risk'] : 0;

// User with SAP_ALL
$data['user_with_sap_all'] = isset($report['user_with_sap_all']) ? $report['user_with_sap_all'] : 0;

// Custom T Code
$data['custom_t_code'] = isset($report['custom_t_code']) ? $report['custom_t_code'] : 0;

// [Bar Graph] - Risk Violated
$data['risk_violated_high'] = isset($report['risk_violated_high']) ? $report['risk_violated_high'] : 0;
$data['risk_violated_medium'] = isset($report['risk_violated_medium']) ? $report['risk_violated_medium'] : 0;
$data['risk_violated_low'] = isset($report['risk_violated_low']) ? $report['risk_violated_low'] : 0;

// Total SOD Risk  [D]
$data['total_sod_risk'] = isset($report['total_sod_risk']) ? $report['total_sod_risk'] : 0;

// Total U Conflicts [E]
$data['e_risk'] = isset($report['e_risk']) ? $report['e_risk'] : 0;

// [D] - [E]  = No Conflicts
$data['no_conflicts'] = $data['total_sod_risk'] - $data['e_risk'];

$data['high_risk_percentage'] = round( ( ( $data['risk_violated_high'] * 100 ) / $data['total_sod_risk'] ), 2);
$data['medium_risk_percentage'] = round( ( ( $data['risk_violated_medium'] * 100) / $data['total_sod_risk'] ), 2);
$data['low_risk_percentage'] = round( ( ( $data['risk_violated_low'] * 100) / $data['total_sod_risk'] ), 2);
$data['no_conflicts_percentage'] = round( ( ( $data['no_conflicts'] * 100) / $data['total_sod_risk'] ), 2);

// [Top 5 Users ] in Conflicts
		$sql = "select u.uname, user_name, count(conflictid) as total_conflicts from uconflicts  u, user_details ud
		where u.uname=ud.uname group by u.uname order by count(conflictid) desc limit 5";
		$result = $this->common_model->run_custom_query($sql);

		$data['top_n_users'] = $result;

		// [Top 5 Roles ] in Intra-role Conflicts
		
		$sql = "select r.agr_name role_name, count(distinct a.uname) no_of_users, count(distinct conflictid) no_of_conflicts,
		count(distinct a.uname)*count(distinct conflictid) total_conflicts from rconflicts r
		inner join agr_users a on r.agr_name=a.agr_name inner join user_details u on a.uname=u.uname where u.user_type=1
		and u.lockstatus=0 and (u.valid_to>=current_date() or u.valid_to='00000000') and (a.to_dat>=current_date or a.to_dat='00000000')
		group by r.agr_name order by Total_conflicts desc limit 5";
		
		$result = $this->common_model->run_custom_query($sql);
		$data['top_n_roles'] = $result;
		
		// [Top 5 Risk] 
		$sql = "select RiskID, dsc 'Description', rating 'Risk_Rating', count(conflictid) 'No_of_Conflicts' from uconflicts u, sod_risk s, user_details d where left(u.conflictid,6) = s.riskid and u.uname=d.uname and d.suser=0 group by riskid, riskname, rating order by count(conflictid) desc limit 5";
		$result = $this->common_model->run_custom_query($sql);
		$data['top_n_risk'] = $result;

		// Business Process Wise Conflict

		$sql = "select RiskID, dsc 'Description', rating 'Risk_Rating', count(conflictid) 'No_of_Conflicts' from uconflicts u, sod_risk s, user_details d where left(u.conflictid,6) = s.riskid and u.uname=d.uname and d.suser=0 group by riskid, riskname, rating order by count(conflictid) desc limit 5";
		$result = $this->common_model->run_custom_query($sql);
		$data['top_n_risk'] = $result;

        // MAT[High, Medium, Low]
        $data['mat_high'] = isset($report['mat_high']) ? $report['mat_high'] : 0;
        $data['mat_medium'] = isset($report['mat_medium']) ? $report['mat_medium'] : 0;
        $data['mat_low'] = isset($report['mat_low']) ? $report['mat_low'] : 0;

        // PRD[High, Medium, Low]
        $data['prd_high'] = isset($report['prd_high']) ? $report['prd_high'] : 0;
        $data['prd_medium'] = isset($report['prd_medium']) ? $report['prd_medium'] : 0;
        $data['prd_low'] = isset($report['prd_low']) ? $report['prd_low'] : 0;

        // CRM[High, Medium, Low]
        $data['crm_high'] = isset($report['crm_high']) ? $report['crm_high'] : 0;
        $data['crm_medium'] = isset($report['crm_medium']) ? $report['crm_medium'] : 0;
        $data['crm_low'] = isset($report['crm_low']) ? $report['crm_low'] : 0;

        // OTC[High, Medium, Low]
        $data['otc_high'] = isset($report['otc_high']) ? $report['otc_high'] : 0;
        $data['otc_medium'] = isset($report['otc_medium']) ? $report['otc_medium'] : 0;
        $data['otc_low'] = isset($report['otc_low']) ? $report['otc_low'] : 0;

        // PTP[High, Medium, Low]
        $data['ptp_high'] = isset($report['ptp_high']) ? $report['ptp_high'] : 0;
        $data['ptp_medium'] = isset($report['ptp_medium']) ? $report['ptp_medium'] : 0;
        $data['ptp_low'] = isset($report['ptp_low']) ? $report['ptp_low'] : 0;

        // HRP[High, Medium, Low]
        $data['hrp_high'] = isset($report['hrp_high']) ? $report['hrp_high'] : 0;
        $data['hrp_medium'] = isset($report['hrp_medium']) ? $report['hrp_medium'] : 0;
        $data['hrp_low'] = isset($report['hrp_low']) ? $report['hrp_low'] : 0;

        // FIN[High, Medium, Low]
        $data['fin_high'] = isset($report['fin_high']) ? $report['fin_high'] : 0;
        $data['fin_medium'] = isset($report['fin_medium']) ? $report['fin_medium'] : 0;
        $data['fin_low'] = isset($report['fin_low']) ? $report['fin_low'] : 0;

        // SRM[High, Medium, Low]
        $data['srm_high'] = isset($report['srm_high']) ? $report['srm_high'] : 0;
        $data['srm_medium'] = isset($report['srm_medium']) ? $report['srm_medium'] : 0;
        $data['srm_low'] = isset($report['srm_low']) ? $report['srm_low'] : 0;

        // BAS[High, Medium, Low]
        $data['bas_high'] = isset($report['bas_high']) ? $report['bas_high'] : 0;
        $data['bas_medium'] = isset($report['bas_medium']) ? $report['bas_medium'] : 0;
        $data['bas_low'] = isset($report['bas_low']) ? $report['bas_low'] : 0;

        $this->load->View('analysis/analysis_dashboard',$data);

		


		

	} // End Function

	


	public function analysis_dashboard_current($fk_analysis_id = ''){

		$data = [];
		$fk_analysis_id = id_decode($fk_analysis_id);

		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));

		// Check IF Analysis is completed 

		if(empty($analysisInfo))
			redirect(base_url('create-new-analysis/'));
		if( $analysisInfo['process_out_time'] == NULL )
			redirect(base_url('create-new-analysis/'.id_encode($fk_analysis_id)));



		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
		$create_datetime = isset($analysisInfo['create_datetime']) ? short_date_format($analysisInfo['create_datetime']) : NULL;
		$data['create_datetime'] = $create_datetime;
		
		//pr($data); die;

		connect_new_db($db3);

		// Total User Analysed
		$sql = "select count(distinct uname) as total_user_anlaysed FROM ucompleted";
		$result = $this->common_model->run_custom_query($sql);

		//pr($result[0]['total_user_anlaysed']); die;

		$total_user_analysed = isset($result[0]['total_user_anlaysed']) ? $result[0]['total_user_anlaysed'] : 0;
		$data['total_user_analysed'] = $total_user_analysed ;

		// Total Users having Conflicts
		$sql = "select count(distinct uname) as total_user_conflicts from uconflicts";
		$result = $this->common_model->run_custom_query($sql);
		$total_users_having_conflicts = isset($result[0]['total_user_conflicts']) ? $result[0]['total_user_conflicts'] : 0;

		$data['user_conflicts_percentage'] = round( (($total_users_having_conflicts * 100 )/$total_user_analysed) , 2 ) ;
		
		// Total Role Analysed
		$sql = "select count(distinct agr_name) as total_role_analysed FROM rcompleted";
		$result = $this->common_model->run_custom_query($sql);
		
		$total_role_analysed = isset($result[0]['total_role_analysed']) ? $result[0]['total_role_analysed'] : 0;
		$data['total_role_analysed'] = $total_role_analysed ;
		
		// Total Roles having Conflicts
		$sql = "select count(distinct agr_name) as total_role_conflicts from rconflicts";
		$result = $this->common_model->run_custom_query($sql);
		$total_roles_having_conflicts = isset($result[0]['total_role_conflicts']) ? $result[0]['total_role_conflicts'] : 0;
		
		if( $total_roles_having_conflicts > 0 && $total_roles_having_conflicts > 0 ){
			$data['role_conflicts_percentage'] = round( (($total_roles_having_conflicts * 100 )/$total_role_analysed) , 2 ) ;
		}
		else{
			$data['role_conflicts_percentage'] = 0;
		}


		// Total Risk Analysed
		$sql = "select count(distinct riskid) as total_risk_analysed from sod_risk where enabled='1'";
		$result = $this->common_model->run_custom_query($sql);
		
		$total_risk_analysed = isset($result[0]['total_risk_analysed']) ? $result[0]['total_risk_analysed'] : 0;
		$data['total_risk_analysed'] = $total_risk_analysed ;

		// Total Risk Violated
		$sql = "select count(distinct left(conflictid,6)) as total_risk_violated from uconflicts";
		$result = $this->common_model->run_custom_query($sql);
		
		$total_risk_violated = isset($result[0]['total_risk_violated']) ? $result[0]['total_risk_violated'] : 0;
		$data['risk_violated_percentage'] = round( (($total_risk_violated * 100 )/$total_risk_analysed) , 2 ) ;

		// Total Conflicts
		$sql = "select count(conflictid) as total_conflicts from uconflicts";
		$result = $this->common_model->run_custom_query($sql);
		
		//echo $sql; die;

		$total_conflicts = isset($result[0]['total_conflicts']) ? $result[0]['total_conflicts'] : 0;
		$data['total_conflicts'] = $total_conflicts ;

		// [PIE Chart] - High Conflicts
		
		$sql = "select count(left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high'";
		$result = $this->common_model->run_custom_query($sql);
		
		$data['high_risk'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;
		
		// [PIE Chart] - Medium Conflicts
		$sql = "select count(left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium'";
		$result = $this->common_model->run_custom_query($sql);
		
		$data['medium_risk'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// [PIE Chart] - Low Conflicts
		$sql = "select count(left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low'";
		$result = $this->common_model->run_custom_query($sql);
		
		$data['low_risk'] = isset($result[0]['low']) ? $result[0]['low'] : 0;

		// [Horizontal Single Bar Graphp] - Intra Role Conflicts

		// High
		$sql = "select count(left(conflictid,6)) 'risk', s.rating from rconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='High'";
		$result = $this->common_model->run_custom_query($sql);
		$data['intra_high_risk'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// Medium
		$sql = "select count(left(conflictid,6)) 'risk', s.rating from rconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='Medium'";
		$result = $this->common_model->run_custom_query($sql);
		$data['intra_medium_risk'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// Low
		$sql = "select count(left(conflictid,6)) 'risk', s.rating from rconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='Low'";
		$result = $this->common_model->run_custom_query($sql);
		$data['intra_low_risk'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// User with SAP_ALL

		$sql = "select count(distinct a.uname) user_with_sap_all from agr_users a inner join user_details u on a.uname=u.uname where (u.valid_to >= curdate() or u.valid_to ='00000000')
		and agr_name like 'profile:%sap%all%' or agr_name like 'profile:%sap%new%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['user_with_sap_all'] = isset($result[0]['user_with_sap_all']) ? $result[0]['user_with_sap_all'] : 0;

		// Custom T Code

		$sql = "select count(distinct tcode) custom_t_code from tstc where tcode like 'z%' or tcode like 'y%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['custom_t_code'] = isset($result[0]['custom_t_code']) ? $result[0]['custom_t_code'] : 0;

		// [Bar Graph] - Risk Violated
		
		// High [A]
		$sql = "select count(distinct left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high'";
		$result = $this->common_model->run_custom_query($sql);
		$data['risk_violated_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// Medium [B]
		$sql = "select count(distinct left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium'";
		$result = $this->common_model->run_custom_query($sql);
		$data['risk_violated_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// Low [C]
		$sql = "select count(distinct left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low'";
		$result = $this->common_model->run_custom_query($sql);
		$data['risk_violated_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// Total SOD Risk  [D]
		$sql = "select count(distinct riskid) total_sod_risk from sod_risk where enabled='1'";
		$result = $this->common_model->run_custom_query($sql);
		$data['total_sod_risk'] = isset($result[0]['total_sod_risk']) ? $result[0]['total_sod_risk'] : 0;

		// Total U Conflicts [E]
		$sql = "select count( distinct left(conflictid,6)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID";
		$result = $this->common_model->run_custom_query($sql);
		$data['e_risk'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// [D] - [E]  = No Conflicts

		$data['no_conflicts'] = $data['total_sod_risk'] - $data['e_risk'];

		$data['high_risk_percentage'] = round( ( ( $data['risk_violated_high'] * 100 ) / $data['total_sod_risk'] ), 2);
		$data['medium_risk_percentage'] = round( ( ( $data['risk_violated_medium'] * 100) / $data['total_sod_risk'] ), 2);
		$data['low_risk_percentage'] = round( ( ( $data['risk_violated_low'] * 100) / $data['total_sod_risk'] ), 2);
		$data['no_conflicts_percentage'] = round( ( ( $data['no_conflicts'] * 100) / $data['total_sod_risk'] ), 2);

		// [Top 5 Users ] in Conflicts
		$sql = "select u.uname, user_name, count(conflictid) as total_conflicts from uconflicts  u, user_details ud
		where u.uname=ud.uname group by u.uname order by count(conflictid) desc limit 5";
		$result = $this->common_model->run_custom_query($sql);

		$data['top_n_users'] = $result;

		// [Top 5 Roles ] in Intra-role Conflicts
		
		$sql = "select r.agr_name role_name, count(distinct a.uname) no_of_users, count(distinct conflictid) no_of_conflicts,
		count(distinct a.uname)*count(distinct conflictid) total_conflicts from rconflicts r
		inner join agr_users a on r.agr_name=a.agr_name inner join user_details u on a.uname=u.uname where u.user_type=1
		and u.lockstatus=0 and (u.valid_to>=current_date() or u.valid_to='00000000') and (a.to_dat>=current_date or a.to_dat='00000000')
		group by r.agr_name order by Total_conflicts desc limit 5";
		
		$result = $this->common_model->run_custom_query($sql);
		$data['top_n_roles'] = $result;
		
		// [Top 5 Risk] 
		$sql = "select RiskID, dsc 'Description', rating 'Risk_Rating', count(conflictid) 'No_of_Conflicts' from uconflicts u, sod_risk s, user_details d where left(u.conflictid,6) = s.riskid and u.uname=d.uname and d.suser=0 group by riskid, riskname, rating order by count(conflictid) desc limit 5";
		$result = $this->common_model->run_custom_query($sql);
		$data['top_n_risk'] = $result;

		// Business Process Wise Conflict

		$sql = "select RiskID, dsc 'Description', rating 'Risk_Rating', count(conflictid) 'No_of_Conflicts' from uconflicts u, sod_risk s, user_details d where left(u.conflictid,6) = s.riskid and u.uname=d.uname and d.suser=0 group by riskid, riskname, rating order by count(conflictid) desc limit 5";
		$result = $this->common_model->run_custom_query($sql);
		$data['top_n_risk'] = $result;

		// MAT[High, Medium, Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'MAT%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['mat_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;
		
		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'MAT%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['mat_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'MAT%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['mat_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;




		// PRD [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'PRD%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['prd_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'PRD%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['prd_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'PRD%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['prd_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		// CRM [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'CRM%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['crm_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'CRM%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['crm_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'CRM%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['crm_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		// OTC [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'OTC%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['otc_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'OTC%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['otc_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'OTC%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['otc_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		// PTP [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'PTP%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['ptp_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'PTP%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['ptp_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'PTP%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['ptp_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		// HRP [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'HRP%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['hrp_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'HRP%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['hrp_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'HRP%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['hrp_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		// FIN [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'FIN%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['fin_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'FIN%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['fin_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'FIN%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['fin_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		// SRM [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'SRM%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['srm_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'SRM%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['srm_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'SRM%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['srm_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;


		// BAS [High Medium Low]

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='high' and u.conflictid like 'BAS%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['bas_high'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='medium' and u.conflictid like 'BAS%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['bas_medium'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;

		$sql = "select count(left(conflictid,3)) 'risk', s.rating from uconflicts u join sod_risk s on LEFT(U.CONFLICTID,6)=S.RISKID where s.rating='low' and u.conflictid like 'BAS%'";
		$result = $this->common_model->run_custom_query($sql);
		$data['bas_low'] = isset($result[0]['risk']) ? $result[0]['risk'] : 0;
		
		//pr($data); die;
		
		$this->load->View('analysis/analysis_dashboard',$data);

	} // End Function


	public function analysis_dashboard_old($fk_analysis_id = ''){
		
		$data = [];

		$fk_analysis_id = id_decode($fk_analysis_id);

		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		$fk_status_id = $this->lib_common->get_analysis_status_id('START_ANALYSIS_COMPLETED');
		$analysisStartedInfo = $this->common_model->get_entry_by_data('iaudit_analysis_status_history',true,array( 'fk_analysis_id' => $fk_analysis_id, 'fk_status_id' => $fk_status_id  ));
		$data['analysis_start_time'] = isset($analysisStartedInfo['create_datetime']) ? short_date_format_ampm($analysisStartedInfo['create_datetime']) : NULL;

		connect_new_db($db_name);
		$sapReportInfo = $this->common_model->get_entry_by_data('sap_report',false,array('1' => '1'));

		$ucompletedInfo = $this->common_model->get_entry_by_data('ucompleted',false,array('1' => '1'));

		$rcompletedInfo = $this->common_model->get_entry_by_data('rcompleted',false,array('1' => '1'));
		$uconflictsInfo = $this->common_model->get_entry_by_data('uconflicts',false,array('1' => '1'));
		$rconflictsInfo = $this->common_model->get_entry_by_data('rconflicts',false,array('1' => '1'));

		$data['total_user_analyzed'] = !empty($ucompletedInfo) ? count($ucompletedInfo) : 0;
		$data['total_role_analyzed'] = !empty($rcompletedInfo) ? count($rcompletedInfo) : 0;
		
		$data['total_user_conflicts'] = !empty($uconflictsInfo) ? count($uconflictsInfo) : 0;
		$data['total_role_conflicts'] = !empty($rconflictsInfo) ? count($rconflictsInfo) : 0;

		$sql = "SELECT DISTINCT `agr_name` from `rconflicts` ";
		$data['total_roles_have_conflicts']  = count($this->common_model->run_custom_query($sql));

		// Data Extracted On
		$info = $this->common_model->get_entry_by_data('inirep',true,array('repid' => 1));
		$data['data_extracted_on'] = short_date_format_ampm($info['repout']);

		// Active Dialog Users
		$info = $this->common_model->get_entry_by_data('inirep',true,array('repid' => 5));
		$data['data_extracted_on'] = short_date_format_ampm($info['repout']);

		//$data['total_conflicts'] = 

		// User with SAP All
		$sql = "SELECT DISTINCT a.uname, user_name, case lockstatus when 1 then 'Locked' else 'Not Locked' end lockstatus, case user_type when 1 then 'Dialog' else 'Non-Dialog' end user_type
				from agr_users a inner join user_details u on a.uname=u.uname
				where a.agr_name like 'Profile%sap%all%' or a.agr_name like 'profie%sap%new%'";

		$listUsersWithSAPALLAccess = $this->common_model->run_custom_query($sql);

		$data['total_users_with_sap_all_access'] = count($listUsersWithSAPALLAccess);
		
		//pr($sapReportInfo); die;
		$data['sapReportInfo'] = $sapReportInfo;

		
		//$this->layout->render('analysis/analysis_dashboard',$data);
		 $this->load->View('analysis/analysis_dashboard_new',$data);

	} // End Function


	public function analysis_dashboardnew($fk_analysis_id = ''){
		
		$data = [];

		$fk_analysis_id = id_decode($fk_analysis_id);
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		$fk_status_id = $this->lib_common->get_analysis_status_id('START_ANALYSIS_COMPLETED');
		$analysisStartedInfo = $this->common_model->get_entry_by_data('iaudit_analysis_status_history',true,array( 'fk_analysis_id' => $fk_analysis_id, 'fk_status_id' => $fk_status_id  ));
		$data['analysis_start_time'] = isset($analysisStartedInfo['create_datetime']) ? short_date_format_ampm($analysisStartedInfo['create_datetime']) : NULL;

		connect_new_db($db_name);
		$sapReportInfo = $this->common_model->get_entry_by_data('sap_report',false,array('1' => '1'));
		$ucompletedInfo = $this->common_model->get_entry_by_data('ucompleted',false,array('1' => '1'));
		$rcompletedInfo = $this->common_model->get_entry_by_data('rcompleted',false,array('1' => '1'));
		$uconflictsInfo = $this->common_model->get_entry_by_data('uconflicts',false,array('1' => '1'));
		$rconflictsInfo = $this->common_model->get_entry_by_data('rconflicts',false,array('1' => '1'));

		$data['total_user_analyzed'] = !empty($ucompletedInfo) ? count($ucompletedInfo) : 0;
		$data['total_role_analyzed'] = !empty($rcompletedInfo) ? count($rcompletedInfo) : 0;
		
		$data['total_user_conflicts'] = !empty($uconflictsInfo) ? count($uconflictsInfo) : 0;
		$data['total_role_conflicts'] = !empty($rconflictsInfo) ? count($rconflictsInfo) : 0;

		$sql = "SELECT DISTINCT `agr_name` from `rconflicts` ";
		$data['total_roles_have_conflicts']  = count($this->common_model->run_custom_query($sql));

		// Data Extracted On
		$info = $this->common_model->get_entry_by_data('inirep',true,array('repid' => 1));
		$data['data_extracted_on'] = short_date_format_ampm($info['repout']);

		// Active Dialog Users
		$info = $this->common_model->get_entry_by_data('inirep',true,array('repid' => 5));
		$data['data_extracted_on'] = short_date_format_ampm($info['repout']);

		//$data['total_conflicts'] = 

		// User with SAP All
		$sql = "SELECT DISTINCT a.uname, user_name, case lockstatus when 1 then 'Locked' else 'Not Locked' end lockstatus, case user_type when 1 then 'Dialog' else 'Non-Dialog' end user_type
				from agr_users a inner join user_details u on a.uname=u.uname
				where a.agr_name like 'Profile%sap%all%' or a.agr_name like 'profie%sap%new%'";

		$listUsersWithSAPALLAccess = $this->common_model->run_custom_query($sql);

		$data['total_users_with_sap_all_access'] = count($listUsersWithSAPALLAccess);
		
		//pr($sapReportInfo); die;
		$data['sapReportInfo'] = $sapReportInfo;
		$this->load->View('analysis/analysis_dashboard_tmplt',$data);

	} // End Function

	public function list_previous_analysis(){
		
		$data = [];
		connect_master_db();
		
		$list_analysis = $this->common_model->get_entry_by_data('list_analysis',false,array('1' => '1'),'','DESC','id',20,0);
		if(!empty($list_analysis)){
			
			foreach ($list_analysis as $key => $value) {
				
				$fk_analysis_id = isset($value['id']) ? $value['id'] : NULL;
				$list_analysis[$key]['summary'] = $this->lib_common->get_analysis_completion_summary( $value['id'] );

			} // End Foreach

		} // End IF

		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class' => ''],  ['link' => null, 'text' => 'SOD', 'class' => 'active'] ];

		//pr($data); die;

		$data['list_analysis'] = $list_analysis;
		$this->layout->render('analysis/list_previous_analysis',$data);

	} // End Function

	public function create_new_analysis_detail(){

		$data = [];

		$data['success'] = 0;
		$data['message'] = '';
		$data['fk_analysis_id'] = null;
		$data['redirect_url'] = null;
		
		if( $this->form_validation->run('create_new_analysis') == TRUE ){
			
			// Check Node Server is Running
			$response = $this->lib_common->callAPI("GET", "http://localhost:3001/getServerRunningStatus", $data);
			
			if($response == "Connection Failure"){
				
				$data['success'] = 0;
				$data['message'] = 'Node Server is not running';
				$data['fk_analysis_id'] = null;
				$data['redirect_url'] = null;

				echo json_encode($data); die;
			}


			$effective_date = date('Y-m-d H:i:s');
			connect_master_db();

			// Step 1: Get POST Variables
			$analysis_name = isset($_POST['analysis_name']) ? $_POST['analysis_name'] : NULL;
			$fk_client_id = isset($_POST['fk_client_id']) ? $_POST['fk_client_id'] : NULL;
			//$file_type = isset($_POST['file_type']) ? $_POST['file_type'] : NULL;
			$system_type = isset($_POST['system_type']) ? $_POST['system_type'] : NULL;

			// Step 2: Get Client Info
			$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
			$client_folder = $clientInfo['client_database'];


			// Step 3: Create a New Entry For Analysis
			$insert_array = [];
            $insert_array['user_name'] = DATABASE_USERNAME;
            $insert_array['password'] = DATABASE_PASSWORD;
            $insert_array['analysis_name'] = $analysis_name;
            $insert_array['fk_client_id'] = $fk_client_id;
            $insert_array['system_type'] = $system_type;
            $insert_array['create_datetime'] = $effective_date;
            $insert_array['create_by'] = $_SESSION['uid'];

            $int_record = $this->common_model->save_entry('list_analysis',$insert_array);
            $rowid = $int_record['id']; 

            // Step : Create A Entery into iaudit_analysis_status_history

            $num_analysis_status = $this->lib_common->create_analysis_status($rowid);


            // Step 4: Create db Name for Analysis

            $client_database = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
            $database = $client_database.'_A1000'.$rowid;
			
			// Step 5: Create Database For Analysis
			$sql = " Create Database IF NOT EXISTS ".$database;
			$res = $this->db->query($sql);			
			
			mkdir(FCPATH.'uploads/Clients/'.$client_folder.'/'.$database);
			//mkdir(FCPATH.'uploads/Clients/'.$client_folder.'/'.$database.'/sanitizedtxtfiles');

			// Create a Log File
			$handle = fopen(FCPATH.'uploads/Clients/'.$client_folder.'/'.$database.'/'.$database."_log.log", "w");
			fclose($handle);

			if($res){

				$update_array = [];
				$update_array['db_name'] = $database;
				$upd_record = $this->common_model->update_entry('list_analysis',$update_array,array('id' => $rowid));
			}


            $data['success'] = 1;
			$data['message'] = 'Analysis Registerd in Master Database Successfully.';
			$data['fk_analysis_id'] = $rowid;
			$data['redirect_url'] = base_url().'create-new-analysis/'.id_encode($rowid);


		} // End IF Form Validation
		else{

			$data['success'] = 0;
			$data['message'] = str_replace('</p>','',str_replace('<p>','',validation_errors()));
			$data['fk_analysis_id'] = null;
			$data['redirect_url'] = null;
					
		}

		echo json_encode($data); die;


	} // End Function

	
	
	public function create_new_analysis( $analysis_id = '' ){
		
		$data = [];
		connect_master_db();
		$analysisInfo = [];
		
		$fk_client_id = '';
		$clientInfo = [];
		$elapsed_time = '';
		
		$totalUsersForAnalysis = 0;
		
		// IF Request For Particular Analysis ID
		if( !empty($analysis_id) ){
			
			$analysis_id = id_decode($analysis_id);
			$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $analysis_id));
			$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
			
			$totalUsersForAnalysis = isset($analysisInfo['total_users_for_analysis']) ? $analysisInfo['total_users_for_analysis'] : 0;
			
			$fk_client_id = isset($analysisInfo['fk_client_id']) ?  $analysisInfo['fk_client_id'] : NULL;
			$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
			
			// Compute Analysis Time if started otherwise 
			$analysisStartDetail = $this->common_model->get_entry_by_data('analysis_status_history',true,array( 'is_completed' => 1, 'fk_status_id' => $this->lib_common->get_analysis_status_id("START_ANALYSIS_COMPLETED"), 'fk_analysis_id' => $analysis_id));
			$analysisEndDetail = $this->common_model->get_entry_by_data('analysis_status_history',true,array( 'is_completed' => 1, 'fk_status_id' => $this->lib_common->get_analysis_status_id("DASHBOARD_COMPLETED"), 'fk_analysis_id' => $analysis_id));

			$elapsed_time = 'Not Started Yet';

			$start_time = isset($analysisInfo['process_in_time']) ? $analysisInfo['process_in_time'] : NULL;
			$end_time = isset($analysisInfo['process_out_time']) ? $analysisInfo['process_out_time'] : NULL;


			if( $start_time != NULL && $end_time != NULL ){
				$elapsed_time = getTimeDifference($start_time,$end_time); 
			}
			//pr($data); die;
		}
		else{
			// IF Any Pending Analysis
			/*$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('status' => 1),'','DESC','id');
			$analysis_id = isset($analysisInfo['id']) ? $analysisInfo['id'] : NULL;
			//pr($analysisInfo); die;
			$fk_client_id = isset($analysisInfo['fk_client_id']) ?  $analysisInfo['fk_client_id'] : NULL;
			$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));*/
		}

		// Get Analysis Status
		if(!empty($analysisInfo)){
			$data = $this->lib_common->get_analysis_completion_summary( $analysisInfo['id'] );
		} 
		else { /* Otherwise All Status Will be 0 For New Analysis */
			$data = $this->lib_common->get_analysis_completion_summary();
		}

		$data['analysisInfo'] = !empty($analysisInfo) ? $analysisInfo : [];
		$data['fk_analysis_id'] = $analysis_id != NULL ? $analysis_id : NULL;
		
		$data['clientInfo'] = !empty($clientInfo) ? $clientInfo : [];
		$data['fk_client_id'] = $fk_client_id != NULL ? $fk_client_id : NULL;
		$data['elapsed_time'] = $elapsed_time;

		//pr($data['elapsed_time']); die;
		
		
		$data['list_clients'] = $this->common_model->get_entry_by_data('clients',false,array('status' => 1),'','ASC','client_name');
		$data['list_sap_connections'] = $this->common_model->get_entry_by_data('sap_connections',false,['status'=>1,'active_inactive'=>'Active']);
		$data['totalUsersForAnalysis'] = $totalUsersForAnalysis > 0 ? '('.$totalUsersForAnalysis.')': NULL;

		$data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
		
		//pr($data['breadcrumb']);
		

		$this->layout->render('analysis/create_new_analysis_m',$data);

	} // End Function

	
	public function archive_delete_analysis(){

		$error = [];
		//pr($_POST); die;

		connect_master_db();
		$action = isset($_POST['action']) ? trim($_POST['action']) : NULL;
		$ids = isset($_POST['ids']) ? trim($_POST['ids']) : NULL;
		$ids_arr = !empty($ids) ? explode(',', $ids): [];

		if( $action == 'ARCHIVE') {

			foreach ($ids_arr as   $id) {
				
				$sql = "Update iaudit_list_analysis set status = 0 where id = $id";
				$result = $this->common_model->run_app_query($sql);

				if($result['success'] == 0) {
					array_push($error, $result['error_message']);
				}

			} // End IF
		}
		else if ( $action == 'DELETE' ){

			
		}
		else if( $action == 'RESTORE' ){

			foreach ($ids_arr as   $id) {
				
				$sql = "Update iaudit_list_analysis set status = 1 where id = $id";
				$result = $this->common_model->run_app_query($sql);

				if($result['success'] == 0) {
					array_push($error, $result['error_message']);
				}


			} // End Foreach Loop

		} // End Else IF

		if( empty($error) ){
			
			$this->session->set_flashdata('succ',"Action Performed Successfully");
			echo json_encode( array('status' => 1, 'message' => "Done") );
			die;
		}
		else{
			$this->session->set_flashdata('err',"Action Could Not be Performed");
			echo json_encode( array('status' => 0, 'message' => implode(',',$error) ) );
			die;
		}


	} // End Function

	public function list_archived_analysis(){
		
		$data = [];

		connect_master_db();
		$list_analysis = $this->common_model->get_entry_by_data('list_analysis',false,array('status' => 0 ),'','DESC','id');
		$options = array('RESTORE' => 'Restore');

		$data['list_analysis'] = $list_analysis;
		$data['options'] = $options;

		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('analysis/archived_analysis',$data);
		$this->load->view('inc/footer');

	} // End Function

	public function get_analysis_status(){

		$analysis_id = isset($_POST['analysis_id']) ? trim($_POST['analysis_id']) : NULL;
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data( 'list_analysis', true, array( 'id' => $analysis_id ) );

		//pr($analysisInfo); die;

		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));

		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		// File Operation to Store Status

 		$log_content = file_get_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', LOCK_EX );
 		echo json_encode(array('content' => $log_content)); die;

	} // End Function

	public function set_analysis_status(){
		
		$analysis_id = isset($_POST['analysis_id']) ? trim($_POST['analysis_id']) : NULL;
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data( 'list_analysis', true, array( 'id' => $analysis_id ) );

		//pr($analysisInfo); die;

		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));

		$db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
		$db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;

		for ($i =0; $i <= 5000; $i++){

		}
		// File Operation to Store Status

 		$log_content = date('Y-m-d H:i:s');
 		$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , LOCK_EX);
 		
 		//$myfile = file_put_contents(FCPATH.'uploads/Clients/'.$db2.'/'.$db3.'/'.$db3.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);

 		echo json_encode(array('content' => "Write Successfull")); die;


	} // End Function


	public function import_db3_ajax(){
		
		$data = [];

		$path = isset($_POST['path1']) ? trim($_POST['path1']) : NULL;
		$database = isset($_POST['database1']) ? trim($_POST['database1']) : NULL;
		$analysis_id = isset($_POST['analysis_id1']) ? trim($_POST['analysis_id1']) : NULL;
		
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $analysis_id));

		$fk_client_id = isset($analysisInfo['fk_client_id']) ? $analysisInfo['fk_client_id'] : NULL;
		$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$fk_client_id]);
		connect_new_db($database);
		
		// ===== Below Code was resided in users-list.php view 
		$path = FCPATH.str_replace('.', '/', $path);
        $path = str_replace('\\', '/', $path);

        $list_files = get_folder_files_with_extension($path);
		$total_files = count($list_files);

		
		// Truncate All Tables in DB3
		connect_master_db();
		$list_db3_tables = $this->common_model->get_entry_by_data('rfc_read_table',false,array('status' => 1));

		if(!empty($list_db3_tables)){
			foreach ($list_db3_tables as $key => $table_detail) {
				$this->lib_common->truncate_table($database,$table_detail['file_name']);        
			}
		} // End IF

		$cntr = 0;

		if(!empty($list_files)){

            foreach ($list_files as $key => $file_name) {

                // file_name_wt_ext is table name also
                $file_ext = pathinfo($file_name,PATHINFO_EXTENSION);
                $file_name_wt_ext = explode('.', $file_name)[0];

                if( 'txt' == $file_ext ){
                    
                    $sql = "";

                    // Write after checking table exists or not
                    if( $this->lib_common->is_table_exists($database,$file_name_wt_ext) ){

                        $sql = " LOAD DATA INFILE '".$path."/".$file_name."' INTO TABLE ".$file_name_wt_ext." FIELDS TERMINATED BY  '|' LINES STARTING BY  '|'; "; 
                        $result = $this->common_model->run_app_query($sql);

                        if( $result['success'] == 1 ){
                            $cntr++;
                            outputProgress($cntr,$total_files);
                        }
                        else{
                            $log_content = short_date_format_ampm(date('Y-m-d H:i:s'))." : Error Occured, Error Code: ".$result['error_code']." Érror Message: ".$result['error_message'];
                            $myfile = file_put_contents($path.'/'.$database.'_log.log', $log_content.PHP_EOL , FILE_APPEND | LOCK_EX);
                        }


                    } // End IF

                }
                else if( 'sql' == $file_ext ){
					$cmd = "mysql -u ".DATABASE_USERNAME."  ".$database." < ".$path."/".$file_name;
					exec($cmd); 
				}
				
            } // End Foreach Loop

            // Creation Of  User Details and Other Table in Intermediate Operation Sql

            if( !in_array("user_details.sql", $list_files) &&  !in_array("user_details.txt", $list_files) ){

                $sql = "";
                $sql = file_get_contents(FCPATH.'uploads/sql/DB3_User_Details_Script.sql');
                $sqls = explode(';', $sql);

                array_pop($sqls);
                if(!empty($sqls)){
                    foreach($sqls as $statement){
                        $statement = $statement . ";";
                        $this->common_model->run_query($statement);

                    } // End Foreach

                } // End IF

            } // End IF user_details

            if( !in_array("zcodes.sql", $list_files) &&  !in_array("zcodes.txt", $list_files) ){

                $sql = "";
                $sql = file_get_contents(FCPATH.'uploads/sql/DB3_ZCodes_Script.sql');
                $sqls = explode(';', $sql);

                array_pop($sqls);
                if(!empty($sqls)){
                    foreach($sqls as $statement){
                        $statement = $statement . ";";
                        $this->common_model->run_query($statement);

                    } // End Foreach

                } // End IF

            } // End IF user_details

            // Update Upload Status 
            connect_master_db();
            $upload_status_id = $this->lib_common->get_analysis_status_id('UPLOAD_COMPLETED');
            $update_array = [];
            
            $update_array['is_completed'] = 1;
            $update_array['create_datetime'] = date('Y-m-d H:i:s');

			

            $upd_rec = $this->common_model->update_entry('analysis_status_history',$update_array,array('fk_analysis_id' => $analysis_id, 'fk_status_id' => $upload_status_id));
			
			

			$data['success'] = 1;
			$data['message'] = "Files Imported Successfully";

			echo json_encode($data); die;

		} // End IF
		


		// === End of Import Code ===== /




		


		/* $this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$this->load->view('users/users-list',$data);
		$this->load->view('inc/footer'); */


	} // End Of Import DB3 Ajax





	public function import_files($analysis_id){

		connect_master_db();
		
		$this->load->view('inc/header');
		$this->load->view('inc/left-sidebar');
		$successAr = $failAr = $notallowAr = [];

		$analysis_data = $this->common_model->get_entry_by_data('list_analysis',true,['id'=>id_decode($analysis_id)],'db_name,analysis_name,fk_client_id');

		//pr($analysis_data); die;

		$fk_client_id = trim($analysis_data['fk_client_id']);
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));

		$client_name = isset($clientInfo['client_name']) ? $clientInfo['client_name'] : NULL;
		$client_database = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		$analysis_database = trim($analysis_data['db_name']);

		$data['client_name'] = $client_name;
		$data['analysis_database'] = $analysis_database;
		$data['analysis_name'] = $analysis_data['analysis_name'];
		$data['analysis_id'] = $analysis_id;

		// Verfiy Files Available List 

		$data['folder_files'] = get_folder_files('uploads/Clients/'.$client_database.'/'.$analysis_database);
		
		$data['path'] = 'uploads.Clients.'.$client_database.'.'.$analysis_database;
		$data['database'] = $analysis_database;




		$db_files = $this->common_model->get_entry_by_data('rfc_read_table',false,['status'=>1],'file_name');

		$master_filesAr = [];

		foreach ($db_files as $key => $value) {
			array_push($master_filesAr,strtolower($value['file_name']));
		}

		$data['db_files'] = $master_filesAr;
		$data['upload_response'] = NULL;

		$data['client_id'] = $fk_client_id;
		
		$data['connections'] = $this->common_model->get_entry_by_data('sap_connections',false,['status'=>1,'active_inactive'=>'Active','fk_client_id'=>$fk_client_id],'id,connection_name,ashost,client,user');
		
		if ($this->input->post('upload_files')) {
			$files = $_FILES['files'];
			foreach ($files['name'] as $key => $file) {
				$fileAr = explode('.',$file);
				$file_name = strtolower($fileAr[0]);
				if (!in_array($file_name, $master_filesAr)) {
					array_push($notallowAr,$file);
				} else {
						
					if(trim($_FILES["files"]['tmp_name'][$key]) != NULL){
                    $post_array['userfiles['.$key.']'] = new CURLFile(trim($_FILES["files"]['tmp_name'][$key]),$_FILES["files"]['type'][$key], trim($_FILES["files"]['name'][$key]));   

                	$post_array['upload_path'] = 'uploads/clients/'.$client_name.'/'.$analysis_name.'/';
                		
                		//pr($post_array); die;

						$response = (array)json_decode($this->lib_common->callAPI('POST',base_url('/api/Fileupload/upload_new_files'),$post_array));
						
							//pr($response); die;

							if ($response['response']=='Success') {
								array_push($successAr,$file);
							} else {
								array_push($failAr,$file);
							}
					}
                }
			}

			$data['folder_files'] = get_folder_files('uploads/clients/'.$client_name.'/'.$analysis_name);
			$data['upload_response']['not_allow'] = $notallowAr;
			$data['upload_response']['success'] = $successAr;
			$data['upload_response']['fail'] 	  = $failAr;

			

			$this->load->view('analysis/import-file',$data);
			$this->load->view('inc/footer');

		} else {
			$this->load->view('analysis/import-file',$data);
			$this->load->view('inc/footer');
		}

	} // End Function



	public function import_db2_into_db3($analysis_id){

		//$analysis_id =  id_encode($analysis_id);

		connect_master_db();
		$analysis_id =  $analysis_id;

		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $analysis_id));
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $analysisInfo['fk_client_id']));
		
		//pr($analysisInfo);
		//pr($clientInfo); die;

		$db2 = $clientInfo['client_database'];
		$db3 = $analysisInfo['db_name'];


		$list_db_std_tables = $this->common_model->get_entry_by_data('sod_rule_book_table_count',false,array('1' => '1'));

		//pr($list_db_std_tables); die;

		$sql = [];
		$i = 0;

		if(!empty($list_db_std_tables)){

			foreach ($list_db_std_tables as $key => $value) {
				
				$sql = " insert into ".$db3.'.'.$value['table_name']." select * from ".$db2.'.'.$value['table_name'];
				$this->common_model->run_query($sql);  

			} // End Foreach

		} // End IF 

		//pr($sql); die;

	} // 




	public function validateClient(){

		$fk_client_id = isset($_POST['fk_client_id']) ? $_POST['fk_client_id'] : NULL;
		connect_master_db();
		
		$clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id'=>$fk_client_id));
		
		//pr($_POST); die;

		$database = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;

		if($database == NULL){
			$this->form_validation->set_message("validateClient","Client Database Not Found Cannot Process."); 
        	return false;	
		}

		// Check DB2 Database Exists
		$sql = "select count(*) as total_tables from information_schema.tables where table_schema = '".$database."'";
		$res = $this->db->query($sql);
		$res = $res->row_array();

		if( $res['total_tables'] <= 0){
			$this->form_validation->set_message("validateClient","Database doesn't exists."); 
        	return false;	
		}

		return true;

	} // End Function

	
	
} // End Class