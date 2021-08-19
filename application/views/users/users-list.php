<div class="content-page">
<div class="content">

<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<?php
    if( isset($path) && !empty($path) && isset($database) && !empty($database) ){

        connect_new_db($database);

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

        //echo $path; die;
        $cntr = 0;

        //pr($list_files); die;
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

                    //echo $path."/".$file_name; die;

                  
                        $cmd = "mysql -u ".DATABASE_USERNAME."  ".$database." < ".$path."/".$file_name;
                        exec($cmd); 


                    /*$sql = "";
                    $sql = file_get_contents($path."/".$file_name);
                    $sqls = explode(';', $sql);

                    // Drop Table First
                    $this->lib_common->drop_table($database,$file_name_wt_ext);

                    array_pop($sqls);
                    if(!empty($sqls)){

                        foreach($sqls as $statement){

                              $statement = $statement . ";";
                              $this->common_model->run_query($statement);

                        } // End Foreach

                    } // End IF

                    $cntr++;

                    //displayOutput("File ".$file_name_wt_ext." has been imported "."<br>");
                    outputProgress($cntr,$total_files);
                    //myFlush();*/


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

            //$this->lib_common->import_user_details_from_db3_to_db2($analysis_id);
            //$this->lib_common->import_tab_user_from_db3_to_db2($analysis_id);
            
            // Update Upload Status 
            connect_master_db();
            $upload_status_id = $this->lib_common->get_analysis_status_id('UPLOAD_COMPLETED');
            $update_array = [];
            
            $update_array['is_completed'] = 1;
            $update_array['create_datetime'] = date('Y-m-d H:i:s');

            $upd_rec = $this->common_model->update_entry('analysis_status_history',$update_array,array('fk_analysis_id' => $analysis_id, 'fk_status_id' => $upload_status_id));

            





        } // End IF

        $url = base_url('create-new-analysis/'.id_encode($analysis_id));
        echo'<script>
            window.location.href = "'.$url.'"
        </script>
        ';
        

        //redirect(base_url('users/users-list/'.id_encode($client['id'])));

    } // End Outer IF
?>

<div class="page-title-box">
    <div class="card">
    <div class="card-body">                                        
    <h4 class="page-title">Users List For <?php echo $client['client_name'] ; ?></h4>
    <?php $this->load->view('inc/after-form-submitted'); ?>
    
    <form>
        <div class="row form-group">
            <div class="col-3">User Id <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="user_id" class="form-control"></div>
        
            <div class="col-3">User Name <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="User_name" class="form-control"></div>
        </div>

        <div class="row form-group">
            <div class="col-3">Department <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="department" class="form-control"></div>
        
            <div class="col-3">Manager <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="manager_name" class="form-control"></div>
        </div>

        <div class="row form-group">
            <div class="col-3">Super User <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="super_user" class="form-control"></div>

            <div class="col-3">Enabled <span class="float-right">:</span></div>
            <div class="col-3">
                <select name="enabled" class="form-control">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
            </select></div>
        </div>

        <div class="row form-group">
            <div class="col-9 text-center"><input type="submit" name="submit" class="btn btn-success"></div>
        </div>
    </form>

    

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body indo-overflow">
                    <form action="<?= base_url('create-user-for-analysis'); ?>" method="POST" >
                <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
                            <th class="text-center">User Id</th>
                            <th class="text-center" style="min-width: 100px">User Name</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Manager</th>
                            <th class="text-center">Plant</th>
                            <th class="text-center">Enabled</th>
                            <th class="text-center">Edit</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">SUser</th>
                            <th class="text-center">Shared</th>
                            <th class="text-center">Generic</th>
                            <th class="text-center">Locked</th>
                            <th class="text-center" style="min-width: 100px">User Type</th>
                            <th class="text-center" style="min-width: 100px">Valid From</th>
                            <th class="text-center" style="min-width: 100px">Valid To</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $statusAr = [1=>'Pending',2=>'Approved',3=>'Rejected']; 
                        $serial_number = 1;
                        foreach ($users as $key => $user) { $counter = $key+1;
                            $serial_number = ($serial_number<10)?'0'.$serial_number:$serial_number;
                            $enabled = $user['enabled'] == 1 ? "Yes" : "No";
                         ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number; $serial_number++;  ?>
                                <input type="checkbox" name="uname[]" value="<?php echo $user['uname'] ?>">
                            </td>
                            <td class="text-center" title="uname : User Id"><?php echo $user['uname']  ?></td>
                            <td class="text-center" title="user_name : User Name"><?php echo $user['user_name']  ?></td>
                            <td class="text-center" title="department : Department"><?php echo $user['department']  ?></td>
                            <td class="text-center" title="manager : Manager"><?php echo $user['manager']  ?></td>
                            <td class="text-center" title="location : Location"><?php echo $user['location']  ?></td>
                            <td class="text-center" title="enabled : Enabled"><?php echo $enabled;  ?></td>
                            <td class="text-center" title="Edit <?php echo $user['uname'] ?>"><a href="<?php echo base_url('/users/edit-user-details/'.id_encode($client['id'])."/".id_encode($user['uname']))  ?>"><i class=" fas fa-pencil-alt"></i></a></td>
                            <td class="text-center" title="company : Company"><?php echo $user['company']  ?></td>
                            <td class="text-center" title="suser : SUser"><?php echo $user['suser']  ?></td>
                            <td class="text-center" title="shared_id : Shared"><?php echo $user['shared_id']  ?></td>
                            <td class="text-center" title="generic_id : Generic"><?php echo $user['generic_id']  ?></td>
                            <td class="text-center" title="lockstatus : Locked"><?php echo $user['lockstatus']  ?></td>
                            <td class="text-center" title="user_type : User Type"><?php echo $user['user_type']  ?></td>
                            <td class="text-center" title="valid_from : Valid From"><?php echo $user['valid_from']  ?></td>
                            <td class="text-center" title="valid_to : Valid To"><?php echo $user['valid_to']  ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-3">
                        <label>Choose Action</label>
                    </div>
                    <div class="col-3">
                        <select name="action">
                            <option value="ENABLED">Enabled</option>
                            <option value="DISABLED">Disabled</option>
                        </select>
                        <!-- <input type="radio" name="update_enabled" value="1"> Enabled
                        <input type="radio" name="update_enabled" value="0"> Disabled -->
                    </div>
                    <div class="col-3">
                        <input type="hidden" name="analysis_id" value="<?= id_encode($analysis_id); ?>" >
                        <input type="submit" name="submit" class="bnt btn-success">
                    </div>
                </div>
                </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>  <!-- end card-body -->
</div>
</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->

</div> <!-- container -->

</div> <!-- content -->
</div>

<script type="text/javascript">
    $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>