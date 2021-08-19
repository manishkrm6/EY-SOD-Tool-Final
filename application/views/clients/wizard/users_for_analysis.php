<?php 
    if(!empty($list_tab_users)) { ?>

    <!-- Start Progress Card -->
    <div class="row" id="cardProgress" style="display:none;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                        <!--  -->
                        <div class="col-12 form-group" id="divProgressTabUser" style="display:none;" >
                            <div class="col-3"><span>Preparing Tab User For Analysis..<span></span></div>
                            <div class="col-6">
                                <div class="progress mb-0">
                                <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Build -->
                        <div class="col-12 form-group" id="divProgressRoleBuild" style="display:none;" >
                            <div class="col-3"><span>Generating Role Build Data..<span></span></div>
                            <div class="col-6">
                                <div class="progress mb-0">
                                <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Role Analysis -->
                         <div class="col-12 form-group" id="divProgressRoleAnalysis" style="display:none;" >
                            <div class="col-3"><span>Generating Role Analysis Data..<span></span></div>
                            <div class="col-6">
                                <div class="progress mb-0">
                                <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                </div>
                            </div>
                        </div>

                        <!-- User Analysis -->
                        <div class="col-12 form-group" id="divProgressUserAnalysis" style="display:none;" >
                            <div class="col-3"><span>Generating User Analysis Data..<span></span></div>
                            <div class="col-6">
                                <div class="progress mb-0">
                                <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Root Cause Analysis -->
                        <div class="col-12 form-group" id="divProgressRootCauseAnalysis" style="display:none;" >
                            <div class="col-3"><span>Generating Root Cause Analysis..<span></span></div>
                            <div class="col-6">
                                <div class="progress mb-0">
                                <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Report Data -->
                        <div class="col-12 form-group" id="divProgressGeneralReport" style="display:none;">
                            <div class="col-3"><span>Generating Dashboard Data..<span></span></div>
                            <div class="col-6">
                                <div class="progress mb-0">
                                <div class="progress-bar" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100">5%</div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Progress Card -->

    


    
        <span id="spnMessage"></span>
        
        <div class="row form-group">
            <div class="col-3">Select Analysis<span class="float-right">:</span></div>
            <div class="col-3">
                <select id="analysis_id" name="analysis_id" class="form-control">
                    <option value="none">--Select Analysis</option>
                    <?php
                        if(!empty($list_analysis)){
                            foreach ($list_analysis as $key => $value) {
                    ?>
                    <option value="<?= $value['id']; ?>"><?= $value['analysis_name']. '( '.$value['db_name'].')'; ?></option>
                    <?php } }  ?>
                    
                </select>
            </div>
            
            

        </div>

        <div class="row form-group">
            <div class="col-9 text-center ">
                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#standard-modal">Finalize User</button> 
                
            </div>
        </div>

        <div class="row form-group">
            <div class="col-9 text-center"><input type="button" id="btnRunAnalysis" name="submit" value="Run Analysis" class="btn btn-success"></div>
        </div>
    


<!-- Begin Row -->
	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body indo-overflow">
                    <form action="<?= base_url('create-user-for-analysis'); ?>" method="POST" >
                        <table id="key-datatable" class="table dt-responsive nowrap w-100">
                <!-- <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100"> -->
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No. </th>
                            <th class="text-center">User Id</th>
                            <th class="text-center" style="min-width: 100px">User Name</th>
                            <th class="text-center">Department</th>
                            <th class="text-center">Manager</th>
                            <th class="text-center">Plant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $statusAr = [1=>'Pending',2=>'Approved',3=>'Rejected']; 
                        $serial_number = 1;
                        
                        //pr($list_tab_users); die;

                        foreach ($user_list_for_analysis as $key => $user) { $counter = $key+1;
                            
                            $serial_number = ($serial_number<10)?'0'.$serial_number:$serial_number;
                            $enabled = $user['enabled'] == 1 ? "Yes" : "No";




                         ?>
                        <tr>
                            <td class="text-center"><?php echo $serial_number; $serial_number++;  ?>
                            </td>
                            <td class="text-center" title="uname : User Id"><?php echo $user['uname']  ?></td>
                            <td class="text-center" title="user_name : User Name"><?php echo $user['user_name']  ?></td>
                            <td class="text-center" title="department : Department"><?php echo $user['department']  ?></td>
                            <td class="text-center" title="manager : Manager"><?php echo $user['manager']  ?></td>
                            <td class="text-center" title="location : Location"><?php echo $user['location']  ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
<!-- End Row -->

    


<?php 
    
    $this->load->view('clients/wizard/script'); 
    

} else { ?>
<div class="row">
    <div class="page-title-box">
        <h4> No Records Found</h4>
    </div>
</div>

<?php } ?>

<?php $this->load->view('clients/wizard/user_filter_modal'); ?>



<script>
    $(function(){
        
        let total_records = '<?= count($list_tab_users); ?>';
        
        if(total_records >= 100){
            
            $('select[name=key-datatable_length]').append(`<option value="${total_records}"> 
            ${total_records} </option>`);

        }
    });
</script>

