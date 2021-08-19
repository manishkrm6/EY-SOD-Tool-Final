<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">

					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/business-process/add-new-bp/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>
							<h3 class="text-center">View & Manage Business Process</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
								    <form action="" method="post">
                <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                        	<th>S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
                        	<th class="text-center">Business Process ID</th>
                        	<th class="text-center">Description</th>
                        	<th class="text-center">Status</th>
						</tr>
					</thead>
					<tbody>
							<?php 
							$serial_number = 1;
							foreach ($bus_proc as $key => $process) { ?>
								<tr>
									<td class="text-center"><?php echo ($serial_number<10)?'0'.$serial_number:$serial_number; $serial_number++; ?>
										<input type="checkbox" name="proc[]" value="<?php echo $process['proc'] ?>">
									</td>
									<td><?php echo $process['proc'] ?></td>
									<td><?php echo $process['dsc'] ?></td>
									<td class="text-center"><?php echo($process['Status']==1)?'<span class="badge bg-soft-success text-success badge-outline-success">Active</span>':'<span class="badge bg-soft-warning text-warning badge-outline-warning">Inactive</span>'  ?></td>
								</tr>
							<?php } ?>
					</tbody>
				</table>
				<br>
                    <div class="row">
					<div class="col-1">Status : </div>
					<div class="col-2"><input type="radio" name="update_status" value="1" checked> Active 
						<input type="radio" name="update_status" value="0"> Inactive
					</div>
					<div class="col-1">
						<input type="submit" name="submit" value="Submit" class="btn btn-success">
					</div>
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