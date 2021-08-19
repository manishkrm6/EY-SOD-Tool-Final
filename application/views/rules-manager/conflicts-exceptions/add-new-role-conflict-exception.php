<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
					    	<a href="<?php echo base_url('client-wizard/'.id_encode($client_id)); ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>

					    	<a href="<?php echo base_url('rules-manager/conflicts-exceptions/roles-conflicts-exceptions/'.$client_id) ?>" class="btn btn-info"><i class="fa fa-list"></i> View Business Process List</a>

							<h3 class="text-center">Add New Roles Conflict Exception</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
							<form action="" method="post">
								
								<div class="row form-group">
									<div class="col-3">Username <span class="pull-right">:</span></div>
									<div class="col-6">
										<input type="text" name="username" id="username" value="" class="form-control" required="true">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">AGR Name <span class="pull-right">:</span></div>
									<div class="col-6">
										<input type="text" name="agr_name" id="agr_name" value="" class="form-control" required="true">
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