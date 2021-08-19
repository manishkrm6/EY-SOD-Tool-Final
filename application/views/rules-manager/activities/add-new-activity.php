<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/manage-activities/view-activities/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-list"></i> View Activities List</a>

							<h3 class="text-center">Add New Activity</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
							<form action="" method="post">

								<div class="row form-group">
									<div class="col-3">Busines Process <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="business_process" id="process_id" class="form-control" required="true">
											<option value="">--Select Proc--</option>
											<?php if ($bus_proc) {
											foreach ($bus_proc as $key => $proc) { ?>
												<option value="<?php echo $proc['proc'] ?>" title="<?php echo $proc['dsc'] ?>"><?php echo $proc['proc'] ?></option>
											<?php } }?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Sub Business Process <span class="pull-right">:</span></div>
									<div class="col-6" id="sub_business_process">
										<select name="sub_business_process" class="form-control" required="true">
											<option value="">--Select Sub Business Process--</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Act Class <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="act_class" class="form-control" required="true">
											<option value="">--Select Act Class--</option>
											<?php if ($act_class_desc) {
												foreach ($act_class_desc as $key => $act_class) { ?>
													<option value="<?php echo $act_class['act_num'] ?>"><?php echo $act_class['act_desc'] ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Activity Description <span class="pull-right">:</span></div>
									<div class="col-6">
										<textarea name="act_discription" class="form-control" required="true"></textarea>
									</div>
								</div>

								<div class="text-center">
									<input type="submit" name="submit" value="Submit" class="bnt btn-success">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
	$('#process_id').change(function(){
		var process_id = $(this).val();
		
		if (process_id.length!=3) {
			alert('Kindly enter 3 character unique string.');
			$(this).focus();
		}
        $.ajax({
          type:'POST',
          url:"<?= base_url('/rules-manager/business-process/get-business-sub-processes/'.$client_id.'/') ?>"+process_id,
            data:{
            		// WE ARE NOT PASSING ANY DATA HERE
                },
                success: function(data){
                	sub_processes = data;
                    $("#sub_business_process").html(data);
                },
                error:function(){
                	alert('Error in getting result, Please try again.');
                	$("#sub_business_process").htm('<select name="sub_business_process" class="form-control" required="true"><option value="">--Select Sub Process--</option></select>');
                	$(this).focus();
                }
            });    
	});
</script>