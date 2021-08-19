<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/manage-activities/add-new-activity/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>

							<h3 class="text-center">View & Manage Activities</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>

							<table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No.</th>
                            <th class="text-center">Activity </th>
							<th class="text-center">Activity Desc </th>
							<th class="text-center">Act Class </th>
							<th class="text-center">Process </th>
							<th class="text-center">Sub Process </th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if ($activities) {
                    		$serial_number = 1;
                    		#pr($act_class_desc[1]); die();
                    		foreach ($activities as $key => $activity) { ?>
                    			<tr>
                    				<td class="text-center"><?php echo $serial_number; $serial_number++;  ?></td>
                    				<td><?php echo $activity['activity'] ?></td>
									<td><?php echo $activity['act_desc']??'NULL' ?></td>
									<td><?php echo $act_class_desc[$activity['act_class']] ?></td>
									<td><?php echo $activity['proc']??'NULL' ?></td>
									<td><?php echo $activity['subproc'] ?></td>
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