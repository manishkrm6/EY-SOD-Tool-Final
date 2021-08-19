<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>
							<h3 class="text-center">View & Manage Additional Access Checks</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
							<form action="" method="post">
								<div class="row form-group">
									<div class="col-3">Enter Transaction Code :</div>
									<div class="col-6">
										<input type="text" name="transaction_code" class="form-control" required="true">
										<p><i>Specify comma separated values in the value column for fields</i></p>
									</div>
									<div class="col-3">
										<input type="submit" name="search_objects" class="btn btn-success">
									</div>
								</div>
							</form>
								<?php if (!empty($tcode) && !empty($object_codes)) { ?>
							<form action="" method="post">
								<input type="hidden" name="tcode" value="<?php echo $tcode??NULL ?>">
									<h4 class="text-center">Selected Tcode : <?php echo $tcode??NULL ?></h4>
								<div class="row">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>S.No.</th>
												<th>Authorization Object</th>
												<th>Field</th>
												<th>Value</th>
											</tr>
										</thead>
										<tbody>
									<?php
									$counter = 1; foreach ($object_codes as $key => $obcodes) { ?>
											<tr>
												<td class="text-center"><?php echo ($counter<10)?'0'.$counter:$counter; $counter++; ?></td>
												<td class="text-center"><?php echo $tcode ?></td>
												<td><?php echo $obcodes['field'] ?></td>
												<td><?php echo $obcodes['value'] ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
									<div class="row">
										<div class="col-11" id="object_container">
											<div class="row">
												<div class="offset-2 col-3"><input type="text" name="object_name[]" placeholder="Object Name" class="form-control"></div>

												<div class="col-3"><input type="text" name="field_name[]" placeholder="Field Name" class="form-control"></div>

												<div class="col-3"><input type="text" name="value_name[]" placeholder="Value Name" class="form-control"></div>
											</div>
										</div>
										<div class="col-1"><a href="javascript:void(0)" id="add_more"><i class="fa fa-plus"></i></a></div>
									</div>
									<br>
									<div class="text-center">
										<input type="submit" name="add_new_objects" class="btn btn-success">
									</div>
							</form>
							<?php } else {
								if (isset($tcode)) { ?>
								<div class="alert alert-danger">
									<b><?php echo $tcode ?></b> transaction code not found. Please try again.
								</div>
							<?php } } ?>
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
		$('#object_container').append('<br><div class="row"><div class="offset-2 col-3"><input type="text" name="object_name[]" placeholder="Object Name" class="form-control"></div><div class="col-3"><input type="text" name="field_name[]" placeholder="Field Name" class="form-control"></div><div class="col-3"><input type="text" name="value_name[]" placeholder="Value Name" class="form-control"></div><div class="col-1"><a href="javascript:void" class="delete_it"><i class="fa fa-minus fa-2x text-danger"></i></a></div></div>');
	});

	$("#object_container").on('click','.delete_it',function(){
            $(this).parent().parent().remove();
    });

</script>
