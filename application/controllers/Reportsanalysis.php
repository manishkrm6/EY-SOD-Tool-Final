<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', '-1');

class Reportsanalysis extends Access_Controller {
    
    function __construct()
    {
        parent::__construct();
	} 
    
    public function report_dashboard($fk_analysis_id = ''){
        
        $data = [];
        
        $fk_analysis_id = id_decode($fk_analysis_id);
		connect_master_db();
		$analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
		$db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;

        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('analysis/report_dashboard',$data);
	}

    // [Report] - Get Transcation Level SOD Conflicts
    public function get_transcation_level_sod_conflicts_by_user($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();
        
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $result = $this->common_model->get_entry_by_data('transaction_level_sod_conflicts_by_users',false,array('1' => '1'));
        $data['list'] = $result;
        
        //pr($data); die;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
        $this->layout->render('reports/transaction_level_sod_conflicts_by_users',$data);
        
    } // End Function

    // [Report] - Get Transcation Level SOD Conflicts
    public function get_transaction_level_sod_conflicts($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();

        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $result = $this->common_model->get_entry_by_data('transaction_level_sod_conflicts',false,array('1' => '1'));
        $data['list'] = $result;
        
        //pr($data); die;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/transaction_level_sod_conflicts',$data);


    } // End Function

    // [Report] - Role T Code Access

    public function get_roles_with_tcode_access($fk_analysis_id = ''){

        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "SELECT DISTINCT AGR_NAME ROLE,OBJCT OBJECT,FIELD,REPLACE(R.FROM,'%','*') `FROM`,REPLACE(R.TO,'__%','*') `TO`
        FROM ROLE_BUILD R
        WHERE R.OBJCT='S_TCODE' AND FIELD='TCD' AND (REPLACE(R.FROM,'%','*') LIKE '%*%' OR REPLACE(R.TO,'__%','*') LIKE '%*%')";
        
        $result = $this->common_model->run_custom_query($sql);
        $data['list'] = $result;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
        
        $this->layout->render('reports/roles_with_tcode_access',$data);

    } // End Function

    // [Report] - Roles in Conflict

    public function get_roles_in_conflicts($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "select r.agr_name Role_Name, count(distinct a.uname) No_of_Users, count(distinct conflictid) No_of_Conflicts, count(distinct a.uname)*count(distinct conflictid) Total_Conflicts from rconflicts r inner join agr_users a on r.agr_name=a.agr_name inner join user_details u on a.uname=u.uname group by r.agr_name order by Total_conflicts desc";
        
        $result = $this->common_model->run_custom_query($sql);

        $data['list'] = $result;
        //pr($data); die;
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/roles_in_conflicts',$data);

    } // End Function


    // [Report] - SAP Critical Base Parameters

    public function get_sap_critical_basis_parameters($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "SELECT hostname,parname,parvalue FROM pahi
        where parstate='A' and parname in
        ('login/min_password_digits','login/min_password_specials','login/min_password_diff','login/min_password_lng',
        'login/failed_user_auto_unlock','login/fails_to_user_lock','rdisp/rfc_max_own_login','Auth/object_disabling_active',
        'login/password_history_size','login/no_automatic_user_sapstar')";
        
        $result = $this->common_model->run_custom_query($sql);

        $data['list'] = $result;
        //pr($data); die;

        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
        
        $this->layout->render('reports/sap_critical_basis_parameters',$data);

    } // End Function

    // [Report] - Users With Custom TCode

    public function get_users_with_custom_tcodes($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "select distinct u.uname, ud.user_name, ud.valid_to, case ud.lockstatus when 1 then 'Locked' else 'Not Locked' end lockstatus,
        case ud.user_type when 0 then 'Non-Dialog' else 'Dialog' end user_type, tcode
        from user_tcode u inner join user_details ud on u.uname=ud.uname
        where u.tcode in ('SE16', 'SE16N')
        and ud.lockstatus='0'
        and ud.user_type='1'";
        
        $result = $this->common_model->run_custom_query($sql);

        $data['list'] = $result;
        //pr($data); die;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/users_with_custom_tcodes',$data);

    } // End Function

    // [Report] - Users With Cross Client Access

    public function get_users_with_cross_client_access($fk_analysis_id = ''){

        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "select distinct uname, r.agr_name, r.objct, r.field,replace(r.from,'%','*') `From`,replace(r.to,'__%','*') `To`
        from agr_users a inner join role_build r on a.agr_name=r.agr_name
        where r.objct='s_tabu_CLI' limit 0,100";
        
        $result = $this->common_model->run_custom_query($sql);

        $data['list'] = $result;
        //pr($data); die;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/users_with_cross_client_access',$data);

    } // End Function


    // [Report] - User With TCode Access

    public function get_user_with_tcode_access($fk_analysis_id = ''){

        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "select distinct uname, r.agr_name, r.objct, r.field,replace(r.from,'%','*') `From`,replace(r.to,'__%','*') `To`
        from agr_users a inner join role_build r on a.agr_name=r.agr_name
        where r.objct='s_tabu_dis' and field ='ACTVT' and '02' between r.from and r.to limit 0,100";
        
        $result = $this->common_model->run_custom_query($sql);

        $data['list'] = $result;
        //pr($data); die;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/users_with_tcode_access',$data);

    } // End Function
    
    // [Report] - Access to Profile

    public function get_access_to_profile($fk_analysis_id = ''){

        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "select distinct u.uname User_ID, ud.User_Name, ud.valid_to User_Validity,
        case ud.lockstatus when 1 then 'Locked' else 'Not Locked' end Lock_Status,
        case ud.User_Type when 0 then 'Non-Dialog' else 'Dialog' end User_Type
        from AGR_USERS u inner join user_details ud on u.uname=ud.uname
        where (ud.valid_to >= curdate() or ud.valid_to ='00000000')
        and u.AGR_NAME in ('PROFILE:S_A.SYSTEM')
        and ud.lockstatus='0'
        and ud.user_type='1'
        order by u.uname";
        
        $result = $this->common_model->run_custom_query($sql);

        $data['list'] = $result;
        //pr($data); die;
        
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/access_to_profile',$data);

    } // End Function
    
    // [Report] - User With SAP_ALL

    public function get_user_with_sap_all($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        $sql = "Select distinct a.uname as UserID , u.uname as User_Name, (CASE u.`lockstatus` WHEN '0' THEN 'Not Locked' ELSE 'Locked' END) as Lock_Status, (CASE u.`user_type` WHEN '0' THEN 'Non-Dialog' ELSE 'Dialog' END) as User_Type,  u.valid_to as Valid_To from agr_users a inner join user_details u on a.uname=u.uname where (u.valid_to >= curdate() or u.valid_to ='00000000') and lockstatus='0' and user_type='1' and a.agr_name like 'Profile%sap%all%' or a.agr_name like 'profie%sap%new%'";
        $result = $this->common_model->run_custom_query($sql);
        
        //pr($result); die;

        $data['list'] = $result;
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/users_with_sap_all',$data);

    } // End Function

    // [Report] - Access To S_TABU & S_DEVELOP
    public function get_access_to_s_tabu_s_develop($fk_analysis_id = ''){

        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        //$sql = "select distinct uc.uname, ud.user_name, ud.valid_from, ud.valid_to FROM ucompleted as uc INNER JOIN user_details as ud ON ud.uname= uc.uname"; 

        $sql = "select distinct a.uname as User_ID, ud.user_name as User_name, r.agr_name as ROLE, r.objct as Object, r.field,replace(r.from,'%','*') `From`,replace(r.to,'__%','*') `To`
        from agr_users a
        inner join role_build r on a.agr_name=r.agr_name
        INNER JOIN user_details ud ON ud.uname=a.uname
        INNER JOIN act_val as av ON r.from=av.val and av.excl='1'
        where (r.objct='S_DEVELOP' or r.objct='S_TABU_DIS') and r.field='actvt'";
        
        $result = $this->common_model->run_custom_query($sql);
        $data['list'] = $result;
        
        //pr($result); die;
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/access_to_s_tabu_s_develop',$data);

    } // End Function

    // [Report] - Root Cause Analysis

    public function get_root_cause_analysis($fk_analysis_id = ''){

        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        //$sql = "select distinct uc.uname, ud.user_name, ud.valid_from, ud.valid_to FROM ucompleted as uc INNER JOIN user_details as ud ON ud.uname= uc.uname"; 

        $sql = "SELECT DISTINCT rc.`UNAME` as UserID, ud.user_name as User_Name, rc.`TCODE` as TCode, rc.`AGR_NAME` as Role, 
        rc.`OBJCT` as Object, rc.`AUTH` as Profile, rc.field as Field, replace(rc.from,'%','*') `From`, 
        replace(rc.to,'__%','*') `To` FROM `root_cause_org` as rc INNER JOIN role_build as rb ON rc.`AGR_NAME`= rb.AGR_NAME 
        AND rc.AUTH=rb.AUTH INNER JOIN user_details as ud ON rc.`UNAME`=ud.uname";

        
        $result = $this->common_model->run_custom_query($sql);
        $data['list'] = $result;
        
        //pr($result); die;
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];

        $this->layout->render('reports/root_cause_analysis',$data);

    } // End Function

    // [Report] - User Analyzed
    public function get_users_analyzed_report($fk_analysis_id = ''){
        
        $data = [];
        connect_master_db();
        $fk_analysis_id = !empty($fk_analysis_id) ? id_decode($fk_analysis_id) : NULL;
        $analysisInfo = $this->common_model->get_entry_by_data('list_analysis',true,array('id' => $fk_analysis_id));
        
        $db_name = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $data['fk_analysis_id'] = $fk_analysis_id;
        
        connect_new_db($db_name);
        //$sql = "select distinct uc.uname, ud.user_name, ud.valid_from, ud.valid_to FROM ucompleted as uc INNER JOIN user_details as ud ON ud.uname= uc.uname"; 

        $sql = "SELECT t.`uname`, t.`user_name`, t.`valid_to`, t.`lockstatus`, t.SOD_RISK, c.SOD_CONFLICTS  FROM (SELECT a.`uname`, a.`user_name`, a.`valid_to`, a.`lockstatus`, b.riskid_COUNT as SOD_RISK FROM `user_details`as a LEFT JOIN (SELECT count(DISTINCT(left(CONFLICTID,6))) as riskid_COUNT, UNAME FROM `uconflicts` group by UNAME order by UNAME DESC) as b ON a.uname=b.UNAME order by 'SOD RISK' DESC) as t
        left JOIN  tab_user_bkp as tb ON t.UNAME=tb.uname
        LEFT JOIN (SELECT UNAME, COUNT(CONFLICTID) as SOD_CONFLICTS from uconflicts group by UNAME order by CONFLICTID) as c 
        ON t.uname=c.UNAME  where t.uname=tb.uname order by c.SOD_CONFLICTS DESC";
        
        $result = $this->common_model->run_custom_query($sql);
        $data['list'] = $result;
        
        //pr($result); die;
        $data['breadcrumb'] = [ ['link' => base_url(), 'text' => 'Home', 'class'=>''],  ['link' => null, 'text' => 'SOD', 'class'=> 'active' ] ];
        
        $this->layout->render('reports/users_analyzed',$data);

    } // End Function

} // End Class