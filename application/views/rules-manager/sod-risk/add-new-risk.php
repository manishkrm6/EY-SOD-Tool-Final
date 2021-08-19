<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/sod-risk/view-sod-risk/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-list"></i> View SOD Risk List</a>

							<h3 class="text-center">Add New SOD Risk</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
							<form action="" method="post">
								<div class="row form-group">
									<div class="col-3">Business Process <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="business_process" class="form-control" required="true">
											<option value="">--Select Business Process--</option>
											<?php if ($bus_procs) {
												foreach ($bus_procs as $key => $bus_proc) { ?>
													<option value="<?php echo $bus_proc['proc'] ?>" title="<?php echo $bus_proc['dsc'] ?>"><?php echo $bus_proc['proc'] ?></option>
												<?php }
											} ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Activity 1 <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="act_1" class="form-control" required="true">
											<option value="">--Select Activity 1--</option>
											<?php if ($activities) {
											foreach ($activities as $key => $activity) { ?>
												<option value="<?php echo $activity['activity'] ?>" title="<?php echo $activity['act_desc'] ?>"><?php echo $activity['activity'] ?></option>
											<?php } }?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Activity 2 <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="act_2" class="form-control" required="true">
											<option value="">--Select Activity 2--</option>
											<?php if ($activities) {
											foreach ($activities as $key => $activity) { ?>
												<option value="<?php echo $activity['activity'] ?>" title="<?php echo $activity['act_desc'] ?>"><?php echo $activity['activity'] ?></option>
											<?php } }?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Activity 3 <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="act_3" class="form-control" required="true">
											<option value="">--Select Activity 3--</option>
											<?php if ($activities) {
											foreach ($activities as $key => $activity) { ?>
												<option value="<?php echo $activity['activity'] ?>" title="<?php echo $activity['act_desc'] ?>"><?php echo $activity['activity'] ?></option>
											<?php } }?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Risk Name <span class="pull-right">:</span></div>
									<div class="col-6">
										<input type="text" name="risk_name" value="" class="form-control" required="true">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Risk Description <span class="pull-right">:</span></div>
									<div class="col-6">
										<textarea name="risk_discription" class="form-control" required="true"></textarea>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Risk Rating <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="risk_rating" class="form-control" required="true">
											<option value="">--Select Risk Rating--</option>
											<?php foreach (RISK_RATING as $key => $value) {?>
												<option value="<?php echo $value ?>"><?php echo $value ?></option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Risk Status <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="risk_status" class="form-control" required="true">
											<option value="1">Active</option>
											<option value="0">Inactive</option>
										</select>
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