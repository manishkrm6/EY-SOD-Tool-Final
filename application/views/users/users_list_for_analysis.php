<div class="content-page">
<div class="content">

<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">

<div class="page-title-box">
    <div class="card">
    <div class="card-body">                                        
    <h4 class="page-title">Users For Analysis: <?php echo $client['client_name'] ; ?></h4>
    <?php $this->load->view('inc/after-form-submitted'); ?>
    
    <form method="POST" action="<?= base_url('run-analysis'); ?>" >
        <div class="row form-group">
            <div class="col-3">Select Analysis<span class="float-right">:</span></div>
            <div class="col-3">
                <select name="analysis_id" class="form-control">
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
            <div class="col-9 text-center"><input type="submit" name="submit" value="Run Analysis" class="btn btn-success"></div>
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
                        //pr($users); die;

                        foreach ($users as $key => $user) { $counter = $key+1;
                            
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