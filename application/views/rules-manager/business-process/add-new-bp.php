<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/business-process/view-bp/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-list"></i> View Business Process List</a>

							<h3 class="text-center">Add New Business Process</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
							<form action="" method="post">
								
								<div class="row form-group">
									<div class="col-3">Process ID <span class="pull-right">:</span></div>
									<div class="col-6">
										<input type="text" name="process_id" id="process_id" value="" class="form-control" required="true">
									</div>
									<i>Enter a 3 character unique string</i>
								</div>

								<div class="row form-group">
									<div class="col-3">Process Description <span class="pull-right">:</span></div>
									<div class="col-6">
										<textarea name="process_discription" class="form-control" required="true"></textarea>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Process Status <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="process_status" class="form-control" required="true">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Sub Process <span class="pull-right">:</span></div>
									<div class="col-6" id="sub_process_container">
										<div class="row">
											<div class="col-12">
												<input name="sub_business_process[]" class="form-control">
											</div>
										</div>
									</div>
									<div class="col-3">
										<a href="javascript:void(0)" id="add_more"><i class="fa fa-plus"></i></a>
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

	$('#add_more').click(function(){
		$('#sub_process_container').append('<br><div class="row form-group"><div class="col-11"><input name="sub_business_process[]" class="form-control"></div> <div class="col-1"><a href="javascript:void" class="delete_it"><i class="fa fa-minus fa-2x text-danger"></i></a></div></div>');
	});

	$("#sub_process_container").on('click','.delete_it',function(){
            $(this).parent().parent().remove();
        });

	$('#process_id').focusout(function(){
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