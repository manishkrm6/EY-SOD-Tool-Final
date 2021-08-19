<div class="content-page">
<div class="content">
<!-- Start Content-->
<div class="container-fluid">
<!-- start page title -->
<div class="row">
    <?php
        // Step 6 : Create DB3 Schema For Analysis
        $database = isset($database) && $database != NULL ? $database : NULL;
        $analysis_name = isset($analysis_name) && $analysis_name != NULL ? $analysis_name : NULL;
        if( $database != NULL && $analysis_name != NULL){
            
            $this->lib_common->create_db3_schema($database,$analysis_name);

            // Step 7 Compile Procedures in DB3 
            $this->lib_common->create_db3_procedures($database);               

            // Step 8 Import DB2 (SOD Lib) into DB3 (Analysis Database)
            $this->lib_common->import_db2_into_db3($analysis_id);


            $url = base_url('create-new-analysis/'.id_encode($analysis_id));
            echo'<script>
                window.location.href = "'.$url.'"
            </script>
            ';
        
            
        } // End IF*/

    ?>

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

    

    <div class="page-title-box">
    <div class="card">
    <div class="card-body">
    <h4 class="page-title">Create New Analysis</h4>
<form class="form-horizontal" method="post" action="<?php echo base_url().'create-new-analysis-detail'; ?>" enctype="form-data/multipart">
    
    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">Analysis Name <span class="float-right">:</span></label>
        <div class="col-6">
            <input type="text" class="form-control" name="analysis_name" placeholder="e.g Analysis_29_Oct">
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">Client Name <span class="float-right">:</span></label>
        <div class="col-6">
            <select class="form-control" name="fk_client_id">
                
                <option value="none">---Select any Client--</option>
                <?php 
                    if(!empty($list_clients)){ 
                        foreach ($list_clients as $key => $value) {
                ?>
                <option value="<?= $value['id']; ?>"><?= $value['client_name']; ?></option>
                <?php } } ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">System Types <span class="float-right">:</span></label>
        <div class="col-6">
            <select class="form-control" name="system_type">
                <option value="sap">SAP</option>
                <option value="oracle">Oracle</option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">File Types <span class="float-right">:</span></label>
        <div class="col-6">
            <select class="form-control" name="file_type">
                <option value="SQL">SQL</option>
                <option value="TXT">TXT</option>
            </select>
        </div>
    </div>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            <input type="submit" class="btn btn-outline-success btn-rounded waves-effect waves-light" name="submit" value="Submit">
        </div>
    </div>
</form>
</div>  <!-- end card-body -->
</div>
    
    <?php 
        if(isset($list_analysis) && !empty($list_analysis)) { 
            $data = [];
            $data['list_analysis'] = $list_analysis;
            $this->load->view('analysis/list_analysis',$data);
        }
        else{
            echo "Currrently there is no analysis created.";
        }
    ?>
    



</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->
</div> <!-- container -->
</div> <!-- content -->
</div>