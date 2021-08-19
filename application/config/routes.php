<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	https://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index
| my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] 	= 'login';
$route['logout'] 			 	= 'login/logout';
$route['forgot-password'] 			 	= 'login/forgot_password';
$route['password-reset-ey-sod-tool/(:any)'] = 'login/password_reset/$1';
$route['password-reset'] = 'login/password_reset';

$route['dashboard'] 		 	= 'dashboard/dashboard';
$route['404_override'] 			= '';
$route['translate_uri_dashes'] 	= FALSE;

/* ====== Unit Testing =========== */

$route['test-script'] 		 	= 'Unittesting/test_script';
$route['drop-all-database'] 		 	= 'Unittesting/drop_all_database';
$route['import-csv'] 		 	= 'Unittesting/import_csv';
$route['create-json-string'] = 'Unittesting/create_json_string';

$route['update-sod-lib'] 		 	= 'Updatesodlib/update_sod_lib';
$route['get-sod-dump/(:any)'] 		 	= 'Updatesodlib/get_sod_dump/$1';


// ======= Commented Block is Subject to Deleted (On Priority Basis) =====
/*$route['visitors/add-new'] 		= 'visitors/add_visitor';
$route['visitors-list'] 		= 'visitors/visitors_list';

$route['visitors/search']		= 'visitors/search_visitor';



$route['users/add-new'] 		= 'Users/add_user';

$route['users/update-user'] 	= 'Users/update_user';

$route['my-profile'] 			= 'Users/my_profile';

$route['users-list'] 			= 'Users/users_list';



// ====== User Role Management (Group Wise Permission ) ==== 



$route['manage-permission'] = 'Userrole/manage_permission';

$route['get-society-user-types'] = 'Userrole/get_society_user_types';

$route['get-module-against-user-type/(:any)'] = 'Userrole/get_module_against_user_type/$1';



$route['get-list-permission/(:any)/(:any)'] = 'Userrole/get_list_permission/$1/$2';

$route['save-permission'] = 'Userrole/save_permission';



// ======= User Level Permission ===== 

$route['user-level-permission'] = 'Userwisepermission/user_level_permission';
$route['list-society-users'] = 'Userwisepermission/list_society_users';
$route['get-module-against-user/(:any)'] = 'Userwisepermission/get_module_against_user/$1';
$route['get-list-permission-for-user/(:any)/(:any)'] = 'Userwisepermission/get_list_permission_for_user/$1/$2';
$route['save-user-permission'] = 'Userwisepermission/save_user_permission';*/

$route['import-files']	=	'Analysis/import_files';
$route['import-files/(:any)']	=	'Analysis/import_files/$1';
$route['validate-files/(:any)']	=	'Analysis/validate_files/$1';
$route['import-data/(:any)']	=	'Analysis/import_data/$1';

$route['sanitize-txt-files']	=	'Textfilehandler/sanitize_txt_files';



#$route['import_data']	=	'Quick_audit/import_data';
$route['users/add-new-client'] = 'Users/add_new_client';

$route['users-list'] = 'Users/users_list';
$route['add-new-user'] = 'Users/add_new_user';

$route['users/edit-user-details/(:any)/(:any)'] = 'Users/edit_user_details/$1/$2';
$route['import-data']	=	'Quick_audit/import_data';
$route['create-new-analysis'] = 'Analysis/create_new_analysis';
$route['create-new-analysis/(:any)'] = 'Analysis/create_new_analysis/$1';
$route['create-new-analysis-detail'] = 'Analysis/create_new_analysis_detail';
$route['create-new-analysis-detail-old'] = 'Analysis/create_new_analysis_detail_old';

$route['create-new-analysis-old'] = 'Analysis/create_new_analysis_old';
$route['create-user-for-analysis'] =  'Users/create_user_for_analysis';

$route['get-analysis-status'] = 'Analysis/get_analysis_status';
$route['set-analysis-status'] = 'Analysis/set_analysis_status';

$route['list-previous-analysis'] = 'Analysis/list_previous_analysis';



$route['import-text'] = 'Importcli/import_text';
$route['import-large-text-file'] = 'Importcli/import_large_text_file';

$route['import-sql/(:any)'] = 'Analysis/import_sql/$1'; // analysis id
$route['import-data-into-db3'] = 'Analysis/import_data_into_db3';
$route['archive-delete-analysis'] = 'Analysis/archive_delete_analysis';




$route['get-import-status'] = 'Importcli/get_import_status';


$route['upload-file-js/(:any)'] = 'Upload/upload_file/$1';

$route['upload-db3-sql/(:any)'] = 'Upload/upload_db3_sql/$1';

/* ===== Create a New Client ====== */

$route['list-clients'] = 'Clients/list_clients';


$route['create-new-client'] = 'Clients/create_new_client';
$route['save-new-client'] = 'Clients/save_new_client';

$route['check-status'] =  'Clients/check_status';


$route['create-new-user'] = 'Users/create_new_user';
$route['user-list'] = 'Users/user_list';
$route['select-user'] = 'Users/select_user';

$route['users-list-for-analysis/(:any)'] = 'Users/users_list_for_analysis/$1';
$route['import-db2-into-db3/(:any)'] = 'Analysis/import_db2_into_db3/$1';

/* ==== Analysis ====== */

$route['analysis-wizard/(:any)'] = 'Analysis/analysis_wizard/$1';
$route['client-wizard/(:any)'] = 'Clients/client_wizard/$1';
$route['import-db3'] = 'Analysis/import_db3';
$route['import-db3-ajax'] = 'Analysis/import_db3_ajax';

$route['run-analysis'] = 'Analysis/run_analysis';
$route['testfn'] = 'Analysis/testfn';

$route['analysis-dashboard/(:any)'] = 'Analysis/analysis_dashboard/$1';
$route['analysis-dashboardnew/(:any)'] = 'Analysis/analysis_dashboardnew/$1';

//$route['report-dashboard'] = 'Analysis/report_dashboard';

/* ====== Analysis Reports ============== */
$route['report-dashboard/(:any)'] = 'Reportsanalysis/report_dashboard/$1';
$route['get-users-analyzed-report/(:any)'] = 'Reportsanalysis/get_users_analyzed_report/$1';
$route['get-user-with-sap-all/(:any)'] = 'Reportsanalysis/get_user_with_sap_all/$1';
$route['get-access-to-profile/(:any)'] = 'Reportsanalysis/get_access_to_profile/$1';
$route['get-user-with-tcode-access/(:any)'] = 'Reportsanalysis/get_user_with_tcode_access/$1';
$route['get-users-with-cross-client-access/(:any)'] = 'Reportsanalysis/get_users_with_cross_client_access/$1';
$route['get-users-with-custom-tcodes/(:any)'] = 'Reportsanalysis/get_users_with_custom_tcodes/$1';
$route['get-sap-critical-basis-parameters/(:any)'] = 'Reportsanalysis/get_sap_critical_basis_parameters/$1';
$route['get-roles-in-conflicts/(:any)'] = 'Reportsanalysis/get_roles_in_conflicts/$1';
$route['get-roles-with-tcode-access/(:any)'] = 'Reportsanalysis/get_roles_with_tcode_access/$1';
$route['get-transaction-level-sod-conflicts/(:any)'] = 'Reportsanalysis/get_transaction_level_sod_conflicts/$1';
$route['get-transcation-level-sod-conflicts-by-user/(:any)'] = 'Reportsanalysis/get_transcation_level_sod_conflicts_by_user/$1';
$route['get-root-cause-analysis/(:any)'] = 'Reportsanalysis/get_root_cause_analysis/$1';
$route['get-access-to-s-tabu-s-develop/(:any)'] = 'Reportsanalysis/get_access_to_s_tabu_s_develop/$1';


$route['select-users-for-analysis/(:any)'] = 'Clients/select_users_for_analysis/$1';

$route['select-client-users/(:any)'] = 'Clients/select_client_users/$1';
$route['finalize-users-for-analysis/(:any)'] = 'Clients/finalize_users_for_analysis/$1';
$route['update-client-users'] = 'Clients/update_client_users';
$route['list-archived-analysis'] = 'Analysis/list_archived_analysis';

/* ===== SOD ROUTES ====== */

$route['view-tables-list/(:any)'] 				= 'SOD/view_tables_list/$1';
$route['sod/add-new-entry/(:any)/(:any)'] 		= 'SOD/add_new_entry/$1/$2';
$route['sod/view-table-entries/(:any)/(:any)'] 	= 'SOD/view_table_entries/$1/$2';
$route['sod/edit-entries/(:any)/(:any)'] 		= 'SOD/edit_entries/$1/$2';

/* ===== Rules Manager ====== */

$route['rules-manager/dashboard/(:any)'] 					= 'rules-manager/RulesManager/dashboard/$1';
$route['rules-manager/add-new-entry/(:any)/(:any)'] 		= 'rules-manager/RulesManager/add_new_entry/$1/$2';
$route['rules-manager/view-table-entries/(:any)/(:any)'] 	= 'rules-manager/RulesManager/view_table_entries/$1/$2';
$route['rules-manager/edit-entries/(:any)/(:any)'] 			= 'rules-manager/RulesManager/edit_entries/$1/$2';

$route['rules-manager/business-process/view-bp/(:any)'] 	= 'rules-manager/RulesManager/view_bp/$1';
$route['rules-manager/business-process/add-new-bp/(:any)'] 	= 'rules-manager/RulesManager/add_new_bp/$1';
$route['rules-manager/sod-risk/view-sod-risk/(:any)'] 		= 'rules-manager/RulesManager/view_sod_risk/$1';
$route['rules-manager/sod-risk/add-new-sod-risk/(:any)'] 	= 'rules-manager/RulesManager/add_new_sod_risk/$1';

$route['rules-manager/manage-activities/view-activities/(:any)'] 				= 'rules-manager/RulesManager/view_activities/$1';
$route['rules-manager/manage-activities/add-new-activity/(:any)'] 				= 'rules-manager/RulesManager/add_new_activity/$1';
$route['rules-manager/transaction-codes/view-transaction-codes/(:any)'] 		= 'rules-manager/RulesManager/view_transaction_codes/$1';
$route['rules-manager/transaction-codes/add-new-transaction-code/(:any)'] 		= 'rules-manager/RulesManager/add_new_transaction_code/$1';

$route['rules-manager/sod-rules/view-sod-rules/(:any)'] 		= 'rules-manager/RulesManager/view_sod_rules/$1';

$route['rules-manager/critical-access/critical-access-rules/(:any)'] 				= 'rules-manager/RulesManager/view_critical_access_rules/$1';
$route['rules-manager/critical-access/add-new-critical-access-rule/(:any)'] 		= 'rules-manager/RulesManager/add_new_critical_access_rule/$1';

$route['rules-manager/conflicts-exceptions/object-conflicts-exceptions/(:any)'] 	= 'rules-manager/RulesManager/object_conflicts_exceptions/$1';
$route['rules-manager/conflicts-exceptions/roles-conflicts-exceptions/(:any)'] 		= 'rules-manager/RulesManager/roles_conflicts_exceptions/$1';

$route['rules-manager/conflicts-exceptions/add-new-role-conflict-exception/(:any)'] = 'rules-manager/RulesManager/add_new_role_conflict_exception/$1';
$route['rules-manager/additional-checks/list/(:any)'] = 'rules-manager/RulesManager/additional_access_checks/$1';

######priyanka#########

$route['rules-manager/finalize-rules'] = 'rules-manager/RulesManager/finalize_rules';
$route['finalize-rules/(:any)'] = 'Clients/finalize_rules/$1';

################# CODE DONE BY DINESH ######################

$route['sap/connections-list'] 					= 'sap/sap/connections_list';
//$route['sap/create-new-connection'] 			= 'sap/sap/create_new_connection';
$route['sap/save-new-connection-ajax'] = 	'sap/sap/save_new_connection_ajax';

$route['sap/edit-connection-details/(:any)'] 	= 'sap/sap/edit_connection_details/$1';
$route['sap/view-connection-details/(:any)'] 	= 'sap/sap/view_connection_details/$1';
$route['sap/delete-connection/(:any)'] 			= 'sap/sap/delete_connection/$1';

$route['sap/create-connection/(:any)'] 			= 'sap/sap/create_connection/$1';
$route['sap/create-connection-ajax/(:any)'] 			= 'sap/sap/create_connection_ajax/$1';

$route['sap/import-data/(:any)/(:any)/(:any)'] 	= 'sap/sap/import_data/$1/$2/$3';
$route['sap/import-data-ajax'] 	= 'sap/sap/import_data_ajax';


/* ====== comppile SOD ============== */
$route['compile-sod/(:any)'] = 'Compile_sod/compile_sod_risk/$1';




