<div class="content-page">
<div class="content">
<!-- Start Content-->
<div class="container-fluid">
<!-- start page title -->
<div class="row">
<div class="col-12">
    <?php 
        $msg = '';
        $class = '';
        if($this->session->flashdata('succ'))
        {
            $class = "text-success";
            $msg .= $this->session->flashdata('succ');
        }
        else if($this->session->flashdata('err'))
        {
            $class = "text-pink";
            $msg .= $this->session->flashdata('err');
        }
    ?>

    <div class="<?php echo $class; ?>">
        <p> <?php echo $msg; ?></p>
    </div>

    <div class="row">
        <?php 

                $database = isset($database) && $database != NULL ? $database : NULL;
                $analysis_name = isset($analysis_name) && $analysis_name != NULL ? $analysis_name : NULL;

                if( $database != NULL && $analysis_name != NULL){

                    connect_new_db($database);

                    $list_sql_files = [];
                    $list_sql_files = getTableLines();

                //pr($list_sql_files); die;

                if(!empty($list_sql_files)){

                    foreach ($list_sql_files as $key => $sql_file) {
                        
                        //echo FCPATH."uploads/sql/".$sql_file; die;

                        $file_path = FCPATH."uploads/sql/".trim($sql_file);
                        $sql = file_get_contents($file_path);

                        $sqls = explode(';', $sql);
                        array_pop($sqls);

                        // Create Log File
                        
                        //$log_file = fopen( FCPATH."uploads/sql_logs/".$analysis_name.'.log', "w"); 

                        



                        $total_statement = count($sqls);
                        
                        $current_progress = 0;

                        //outputProgress

                        foreach($sqls as $statement){
                            
                            $statement = $statement . ";";
                            
                            $this->common_model->run_query($statement);  

                            $current_progress++;

                            outputProgress($current_progress,$total_statement);

                        }
                    }

                } // End IF

                

                    connect_master_db();

                    $insert_array = [];

                    $insert_array['db_name'] = $database;
                    $insert_array['user_name'] = 'root';
                    $insert_array['password'] = '';

                    $int_record = $this->common_model->save_entry('list_analysis',$insert_array);

                    if($int_record){
                        $this->session->set_flashdata('succ',"Database Created Sucessfully.");
                    }
                    else{
                        $this->session->set_flashdata('err',"Database Creattion Failed.");  
                    }


                } // End IF

                

        ?>
    </div>

    <div class="page-title-box">
    <div class="card">
    <div class="card-body">
    <h4 class="page-title">Create New Analysis</h4>
<form class="form-horizontal" method="post" action="<?php echo base_url().'create-new-database'; ?>" enctype="form-data/multipart">
    
    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">Analysis Name <span class="float-right">:</span></label>
        <div class="col-6">
            <input type="text" class="form-control" name="analysis_name" >
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">Client Name <span class="float-right">:</span></label>
        <div class="col-6">
            <select class="form-control" name="client">
                <option value="test_client">Test Client</option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">System Types <span class="float-right">:</span></label>
        <div class="col-6">
            <select class="form-control" name="file_types">
                <option value="sap">SAP</option>
                <option value="oracle">Oracle</option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">File Types <span class="float-right">:</span></label>
        <div class="col-6">
            <select class="form-control" name="file_types">
                <option value="sql">.sql</option>
                <option value="txt">.txt</option>
            </select>
        </div>
    </div>


    


    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            <input type="submit" class="btn btn-info waves-effect waves-light" name="submit" value="Submit">
        </div>
    </div>
</form>
</div>  <!-- end card-body -->
</div>
    
    <div class="card">
            <div class="card-body">

            <h4 class="page-title">List Databases  </h4>    
            <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th class="text-center">S.No.</th>
                        
                        <th class="text-center">Database</th>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Password</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    if(!empty($list_databases)){
                        $counter = 1;
                        foreach ($list_databases as $key => $value) { 
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $counter++; ?></td>
                        <td> <?php echo $value['db_name']; ?></td>
                        <td><?= $value['user_name']; ?></td>
                        <td><?= $value['password']; ?></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>          
            </div> <!-- end card body-->
        </div> <!-- end card -->


</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->
</div> <!-- container -->
</div> <!-- content -->
</div>