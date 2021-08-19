<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/critical-access/add-new-critical-access-rule/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-plus"></i> Add New</a>

							<h3 class="text-center">Manage Critical Access Rules</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
								<form action="" method="post">
								<div class="row form-group">
									<div class="col-3">Business Process <span class="pull-right">:</span></div>
									<div class="col-6">
										<select name="business_process" class="form-control" required="true">
											<option value="">--Select Business Process--</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">TCode <span class="pull-right">:</span></div>
									<div class="col-6">
										<input type="text" name="tcode" value="" class="form-control" required="true">
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