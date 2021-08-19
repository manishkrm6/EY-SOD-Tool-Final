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
    <br>

    <?php 
        if(isset($db_name) && !empty($db_name) ){
            
            connect_new_db($db_name);

            $file_path = FCPATH."uploads/Lib/SOD_Master/SOD_Rule_Book_Master.sql";
            $sql = file_get_contents($file_path);
            $sqls = explode(';', $sql);
            array_pop($sqls);

            $total_stmt = count($sqls);
            $cur_stmt = 0;

            $perc = 0;

            foreach( $sqls as $statement){
        
                $statement = $statement . ";";
                $this->common_model->run_query($statement);
                
                $cur_stmt++;

                outputProgress($cur_stmt,$total_stmt);
            } // End Foreach Loop

        }
    ?>
    
    <div class="page-title-box">

    <!-- <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
            <li class="breadcrumb-item active">Elements</li>
        </ol>
    </div>
    <h4 class="mb-3 header-title">Client Management</h4> -->


    <div class="card">
        <div class="card-body">
            <h4 class="mb-3 header-title">Create New Client</h4>
            
            <!-- <div class="<?php echo $class; ?>">
                <p> <?php echo $msg; ?></p>
            </div> -->

            <div id="msg" class="<?= $class; ?>">
                <?php echo $msg; ?>
            </div>
            
            <div id="progress" class="text-success">
            </div>

            <form method="POST" action="<?= base_url('create-new-client'); ?>">
                
                <div class="form-group">
                    <label for="exampleInputEmail1">Client Name</label>
                    <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Enter Client Name">
                    <!-- <small id="clientNameHelp" class="form-text text-muted">E.g Apple Inc.</small> -->
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea class="form-control" name="description" ></textarea>
                    <!-- <small id="clientNameHelp" class="form-text text-muted">E.g Apple Inc.</small> -->
                </div>

                <!-- <div class="form-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="checkmeout0">
                        <label class="custom-control-label" for="checkmeout0">Check me out !</label>
                    </div>
                </div> -->

                <button type="submit" id="btnCreateClient" class="btn btn-primary waves-effect waves-light">Submit</button>
            </form>
         </div>    
    </div>
    
    <div class="card">
            <div class="card-body">

            <h4 class="header-title">List Clients</h4>
            <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th class="text-center">S.No.</th>
                        
                        <th class="text-center">Client Name</th>
                        <th class="text-center">Description</th>
                        <th class="text-center">Status</th>

                    </tr>
                </thead>
                <tbody>
                <?php
                    if(!empty($list_clients)){
                        $counter = 1;
                        foreach ($list_clients as $key => $value) { 
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $counter++; ?></td>
                        <td> <a href="<?php echo base_url('client-wizard/'.id_encode($value['id'])); ?>">
                            <?php echo $value['client_name']; ?></a></td>
                        <td><?= $value['description']; ?></td>
                        <td>Active</td>
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












