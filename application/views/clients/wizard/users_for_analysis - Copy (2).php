<?php 
    if(!empty($list_tab_users)) { ?>

    <form method="POST" action="<?= base_url('run-analysis'); ?>" >
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
            <div class="col-9 text-center"><input type="button" id="btnRunAnalysis" name="submit" value="Run Analysis" class="btn btn-success"></div>
        </div>
    </form>

<!-- Begin Row -->
	<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body indo-overflow">
                    <form action="<?= base_url('create-user-for-analysis'); ?>" method="POST" >
                <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
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

                        foreach ($list_tab_users as $key => $user) { $counter = $key+1;
                            
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
    <script>
     
    var instruction_index = 0;
    var status = 'PENDING';
    var analysis_id = '';
    var url = '<?= base_url("run-analysis"); ?>';

    $(function(){
        
        $('#btnRunAnalysis').on('click',function(){
            
            analysis_id = $('#analysis_id').val(); 
            
            function runAnalysis(){
                
                $.ajax({
                    url: url, 
                    type: "POST",  
                    dataType: 'json',
                    async:false,
                    data: {analysis_id: analysis_id,instruction_index:instruction_index},    
                    success: function(response, textStatus, jqXHR)   
                    {
                        instruction_index = response['instruction_index'];
                        status = response['status'];
                        if(status == 'ERROR')
                            $('#spnMessage').html(response['message']);  
                        else
                            $('#spnMessage').html(response['percentage']);  

                    },
                    complete : function (event,xhr,options) {
                        
                        if(status == 'PENDING')
                            runAnalysis();
                        else if(status == 'COMPLETED')
                            return false;
                    },
                    error: function(xhr, status, error){
                        //if fails 
                        let err = eval("(" + xhr.responseText + ")");
                        console.log(err);
                    }
                });

            } // End Function

            runAnalysis();

        }); // End Btn Click Event

    }); // End Doc Ready
        
    </script>

    

<?php } else { ?>
<div class="row">
    <div class="page-title-box">
        <h4> No Records Found</h4>
    </div>
</div>

<?php } ?>