<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn col-sm-10 font-weight-bold" ><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/sod-risk/add-new-sod-risk/'.$client_id) ?>" class="btn btn-info" ><i class="fa fa-plus"></i> Add New</a>

							<h3 class="text-center">View & Manage SOD Risks</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>

								 <form action="" method="post">
							<table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
                            <th>riskid </th>
							<th>act1 </th>
							<th>act2 </th>
							<th>act3 </th>
							<th>bproc </th>
							<th>Status </th>
							<th>riskname </th>
							<th>dsc </th>
							<th>rating </th>
							<th>ctype </th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php if ($sod_risk) {
                    		$serial_number = 1;
                    		foreach ($sod_risk as $key => $risk) { ?>
                    			<tr>
                    				<td class="text-center"><?php echo $serial_number; $serial_number++;  ?>
                    					<input type="checkbox" name="riskid[]" value="<?php echo $risk['riskid'] ?>">
                    				</td>
                    				<td><?php echo $risk['riskid'] ?></td>
									<td><?php echo $risk['act1']??'NULL' ?></td>
									<td><?php echo $risk['act2']??'NULL' ?></td>
									<td><?php echo $risk['act3']??'NULL' ?></td>
									<td><?php echo $risk['bproc'] ?></td>
									<td class="text-center"><?php echo($risk['enabled']==1)?'<span class="badge bg-soft-success text-success badge-outline-success">Active</span>':'<span class="badge bg-soft-warning text-warning badge-outline-warning">Inactive</span>'  ?></td>
									<td><?php echo $risk['riskname'] ?></td>
									<td><?php echo $risk['dsc'] ?></td>
									<td><?php echo $risk['rating'] ?></td>
									<td><?php echo $risk['ctype'] ?></td>
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