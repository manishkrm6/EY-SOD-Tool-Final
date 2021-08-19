<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

							<h3 class="text-center">View & Manage Customized Transaction Codes</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
								<form action="" method="post">
							<table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
                            <th class="text-center">Process</th>
							<th class="text-center">Transaction Code</th>
							<th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if ($critical_auth) {
                    		$serial_number = 1;

                    		foreach ($critical_auth as $key => $auth) { ?>
                    			<tr>
                    				<td class="text-center"><?php echo ($serial_number<10)?'0'.$serial_number:$serial_number; $serial_number++; ?> <input type="checkbox" name="proc_tcode[]" value="<?php echo 'proc-'.$auth['proc'].'-tcode-'.$auth['tcode'] ?>"></td>
									<td><?php echo $auth['proc']??'NULL' ?></td>
									<td><?php echo $auth['tcode']??'NULL' ?></td>
									<td class="text-center"><?php echo($auth['Status']==1)?'<span class="badge bg-soft-success text-success badge-outline-success">Active</span>':'<span class="badge bg-soft-warning text-warning badge-outline-warning">Inactive</span>'  ?></td>
                    			</tr>
                    		<?php }
                    	} ?>
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