<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', '-1');

class Textfilehandler extends CI_Controller {

	function __construct()
    {
    	// Construct the parent class
		parent::__construct();
	}

    public function test_sanitize_txt_files(){
        
        connect_master_db();
        $currentAnalysisInfo = $this->common_model->get_entry_by_data('runing_txt_sanitization',true,array('status' => 1));
        
        if( !empty($currentAnalysisInfo) )
            $upd_record = $this->common_model->update_entry('runing_txt_sanitization',array('status' => 2),array('id' => $currentAnalysisInfo['id']));

        $content = date('Y-m-d H:i:s')." Executed At ";
        $myfile = file_put_contents(FCPATH.'uploads/test2_log.log', $content.PHP_EOL , FILE_APPEND | LOCK_EX);

        die;

    
    } // End Function
    
    public function  sanitize_txt_files(){
        
        $data = [];

        $data['success'] = 0;
        $data['message'] = '';

        $analysis_id = isset($_POST['analysis_id1']) ? $_POST['analysis_id1'] : NULL;
        
        $path = isset($_POST['path1']) ? $_POST['path1'] : NULL;
		$path = FCPATH.str_replace('.', '/', $path);
        $path = str_replace('\\', '/', $path);

        // Get All Files With Mentioned Extension from a directory
        $list_files = get_folder_files_with_extension($path,"txt");
        $total_files = count($list_files);

        connect_master_db();

        if(!empty($list_files)){

        	$cntr = 1;

        	foreach ($list_files as $key => $file_name) {
        		
        		// file_name_wt_ext is table name also
                $file_ext = pathinfo($file_name,PATHINFO_EXTENSION);
                $file_name_wt_ext = explode('.', $file_name)[0];

                if( 'txt' == $file_ext ){

                	$rules = [];
                    $rules = $this->lib_txtuploadrule->get_columns_rule(strtoupper($file_name_wt_ext));

                    $import_param = [];
                    $import_param['target_columns'] = $rules['target_columns'];
                    $import_param['date_column_indexes'] = $rules['date_column_indexes'];
                    $import_param['target_file'] = $path."/".$file_name;
                    $import_param['destination_file'] = $path."/temp.txt";
                    $import_param['file_name'] = strtoupper($file_name_wt_ext);

                    //pr($import_param); die;
                    $num_saved_entry = $this->lib_txtupload->import_textdb($import_param);

                    if($num_saved_entry > 0){

                        // Update Progress Status in <import_db3_message>
                        $insert_array = [];
                        $insert_array['fk_analysis_id'] = $analysis_id;
                        $insert_array['progress'] =  round( ( ( $cntr / $total_files) * 100),2);
                        $insert_array['message'] = $import_param['file_name']." File is done ";

                        $this->common_model->save_entry('import_db3_message',$insert_array);

                        unlink($import_param['target_file']);
                        rename($import_param['destination_file'],$path.'/'.$file_name);
                    }

                    //outputProgress($cntr,$total_files);

                    // Update Progress Status in <import_db3_message>
                    if($cntr == $total_files){

                        sleep(2);

                        $sql = "delete from iaudit_import_db3_message where fk_analysis_id = ".$analysis_id;
                        $result = $this->common_model->run_app_query($sql);

                        break;
                        //pr($result); die;

                    } // End IF

                        $cntr++;

                } // End IF

            } // End Foreach Loop
            
            
            





            $data['success'] = 1;
            $data['message'] = 'Done';

            echo json_encode($data); die;

        } // End IF


        $data['success'] = 0;
        $data['message'] = 'Failed';

        echo json_encode($data); die;

    } // End Function 
    
	public function sanitize_txt_files_old_25_Jan_2021(){
		
		//pr($_POST); die;

		$analysis_id = isset($_POST['analysis_id1']) ? $_POST['analysis_id1'] : NULL;

		$path = isset($_POST['path1']) ? $_POST['path1'] : NULL;
		$path = FCPATH.str_replace('.', '/', $path);
        $path = str_replace('\\', '/', $path);

        $list_files = get_folder_files_with_extension($path);

        $total_files = count($list_files);

        //pr($list_files); die;

        if(!empty($list_files)){

        	$cntr = 1;

        	foreach ($list_files as $key => $file_name) {
        		
        		// file_name_wt_ext is table name also
                $file_ext = pathinfo($file_name,PATHINFO_EXTENSION);
                $file_name_wt_ext = explode('.', $file_name)[0];

                if( 'txt' == $file_ext ){

                	$rules = [];
                    $rules = $this->lib_txtuploadrule->get_columns_rule(strtoupper($file_name_wt_ext));

                    $import_param = [];
                    $import_param['target_columns'] = $rules['target_columns'];
                    $import_param['date_column_indexes'] = $rules['date_column_indexes'];
                    
                    $import_param['target_file'] = $path."/".$file_name;
                    $import_param['destination_file'] = $path."/temp.txt";

                    //pr($import_param); die;
                    
                    $num_saved_entry = $this->lib_txtupload->import_textdb($import_param);	
                    if($num_saved_entry > 0){
                        
                        unlink($import_param['target_file']);
                        rename($import_param['destination_file'],$path.'/'.$file_name);
                    }

                    outputProgress($cntr,$total_files);
                    $cntr++;

                }

        	} // End Foreach Loop

        } // End IF


        redirect(base_url('import-files/'.id_encode($analysis_id)));



	} // End Function

	
} // End Class


