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

							<table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No.</th>
                            <th class="text-center">Zcode</th>
							<th class="text-center">Description</th>
							<th class="text-center">Process</th>
							<th class="text-center">Sub Process</th>
							<th class="text-center">Type</th>
							<th class="text-center">Activity</th>
							<th class="text-center">Add Information</th>
							<th class="text-center">Transaction Code</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if ($zcodes) {
                    		$serial_number = 1;

                    		foreach ($zcodes as $key => $zcode) { ?>
                    			<tr>
                    				<td class="text-center"><?php echo ($serial_number<10)?'0'.$serial_number:$serial_number; $serial_number++; ?></td>
                    				<td><?php echo $zcode['zcode']??'NULL' ?></td>
									<td><?php echo $zcode['dsc']??'NULL' ?></td>
									<td><?php echo $zcode['proc']??'NULL' ?></td>
									<td><?php echo $zcode['subproc']??'NULL' ?></td>
									<td><?php echo $zcode['type']??'NULL' ?></td>
									<td><?php echo $zcode['activity']??'NULL' ?></td>
									<td><?php echo $zcode['add_info']??'NULL' ?></td>
									<td><?php echo $zcode['tcode']??'NULL' ?></td>
                    			</tr>
                    		<?php }
                    	} ?>
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