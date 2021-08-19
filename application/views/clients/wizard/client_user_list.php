<?php if(!empty($list_client_users)){ ?>
	 
     <form action="<?= base_url('client-wizard/'.id_encode($fk_analysis_id)); ?>" method="POST" >
        <div class="row form-group">
            <div class="col-3">UName <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="uname" class="form-control"></div>
        
            <div class="col-3">User Name <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="user_name" class="form-control"></div>
        </div>

        <div class="row form-group">
            <div class="col-3">Department <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="department" class="form-control"></div>
        
            <div class="col-3">Manager <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="manager" class="form-control"></div>
        </div>

        <div class="row form-group">
            <div class="col-3">Super User <span class="float-right">:</span></div>
            <div class="col-3"><input type="text" name="suser" class="form-control"></div>

            <div class="col-3">Enabled <span class="float-right">:</span></div>
            <div class="col-3">
                <select name="enabled" class="form-control">
                    <option value="YES">Yes</option>
                    <option value="NO">No</option>
            </select></div>
        </div>

        <div class="row form-group">
            <div class="col-9 text-center"><input type="submit" class="btn btn-outline-success btn-rounded waves-effect waves-light" name="filter" value="Filter" class="btn btn-success"></div>
        </div>
    </form>
<!-- Begin Row -->
<div class="row indo-overflow">
	
    <form action="<?= base_url('client-wizard/'.id_encode($fk_analysis_id)); ?>" method="POST" >

        <?php
            $options = array( 'ENABLE' => 'Enable', 'ENABLE_ALL' => 'Enable All', 'DISABLE' => 'Disable',  'DISABLE_ALL' => 'Disable All', 'SELECT_FOR_ANALYSIS' => 'Select For Analysis' );
        ?>

        <div class="form-inline">
            <div class="form-group mx-sm-3">
                <label for="inputPassword2" class="sr-only">Action</label>
                <select class="form-control" name="action" id="action" class="action" >
                    <option value="none">--Select any Action--</option>
                    <?php 
                        if( !empty($options) ) { 
                            foreach ($options as $key => $value) {
                    ?>
                    <option value="<?= $key; ?>"><?= $value; ?></option>
                    <?php } } ?>

                </select>
            </div>
            <input type="hidden" name="enable_disable" value="enable_disable" >
            <input type="hidden" name="fk_client_id" value="<?= id_encode($fk_client_id); ?>" >
            <input type="hidden" name="fk_analysis_id" value="<?= id_encode($fk_analysis_id); ?>" >
            <button type="submit" id="btnAction" class="btn btn-outline-success btn-rounded waves-effect waves-light">Submit</button>
        </div>
        <br>


    <table id="selection-datatable" class="table dt-responsive nowrap w-100">
	<!-- <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100"> -->
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
                            <th class="text-center">UName</th>
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
                        
                        foreach ($list_client_users as $key => $user) { $counter = $key+1;
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
                            <td class="text-center" title="Edit <?php echo $user['uname'] ?>"><a href="<?php echo base_url('/users/edit-user-details/'.id_encode($fk_client_id)."/".id_encode($user['uname']))  ?>"><i class=" fas fa-pencil-alt"></i></a></td>
                            <td class="text-center" title="company : Company"><?php echo $user['company']  ?></td>
                            <td class="text-center" title="suser : SUser"><?php echo $user['suser']  ?></td>
                            <td class="text-center" title="shared_id : Shared"><?php echo $user['shared_id']  ?></td>
                            <td class="text-center" title="generic_id : Generic"><?php echo $user['generic_id']  ?></td>
                            <td class="text-center" title="lockstatus : Locked"><?php echo $user['lockstatus']  ?></td>
                            <td class="text-center" title="user_type : User Type"><?php echo $user['user_type']  ?></td>
                            <td class="text-center" title="valid_from : Valid From"><?php echo $user['valid_from']  ?></td>
                            <td class="text-center" title="valid_to : Valid To"><?php echo $user['valid_to']  ?></td>
                        </tr>
                        <?php }  ?>
                    </tbody>
    </table>
	

	<!-- <div class="row">
                    <div class="col-3">
                        <label>Choose Action</label>
                    </div>
                    <div class="col-3">
                        <select name="action">
                            <option value="ENABLED">Enabled</option>
                            <option value="DISABLED">Disabled</option>
                        </select>
                        <input type="radio" name="update_enabled" value="1"> Enabled
                        <input type="radio" name="update_enabled" value="0"> Disabled
                    </div>
                    <div class="col-3">
                        <input type="hidden" name="fk_client_id" value="<?= id_encode($fk_client_id); ?>" >
                        <input type="hidden" name="users_for_analysis" value="users_for_analysis" >
                        <input type="submit" name="submit" class="bnt btn-success">
                    </div>
    </div> -->

</form>


</div>
<!-- End Row -->
<?php } else { ?>
<div class="row">
	<div class="page-title-box">
		<h4> No Records Found</h4>
	</div>
</div>
<?php } ?>

<script>
    $(function(){
        
        let total_records = '<?= count($list_client_users); ?>';
        
        if(total_records >= 100){
            
            $('select[name=selection-datatable_length]').append(`<option value="${total_records}"> 
            ${total_records} </option>`);

        }
    });
</script>




