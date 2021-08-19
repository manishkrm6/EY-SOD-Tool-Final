<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/conflicts-exceptions/add-new-role-conflict-exception/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>
							<h3 class="text-center">View & Manage Roles Conflicts Exceptions</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>

                <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                        	<th>S.No.</th>
                        	<th class="text-center">Username</th>
                        	<th class="text-center">AGR Name</th>
						</tr>
					</thead>
					<tbody>
							<?php 
							$serial_number = 1;
							if (!empty($roles)) {
							foreach ($roles as $key => $role) { ?>
								<tr>
									<td class="text-center"><?php echo ($serial_number<10)?'0'.$serial_number:$serial_number; $serial_number++; ?>
										<input type="checkbox" name="proc[]" value="<?php echo $process['proc'] ?>">
									</td>
									<td><?php echo $process['proc'] ?></td>
									<td><?php echo $process['dsc'] ?></td>
									<td class="text-center"><?php echo($process['Status']==1)?'<span class="badge bg-soft-success text-success badge-outline-success">Active</span>':'<span class="badge bg-soft-warning text-warning badge-outline-warning">Inactive</span>'  ?></td>
								</tr>
							<?php } } ?>
					</tbody>
				</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>