<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
				<h3 class="text-center">View SAP Connection Details</h3>
				<a href="<?php echo base_url('sap/connections-list') ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>
								<?php $this->load->view('inc/after-form-submitted'); ?>

								<div class="row form-group">
									<div class="col-3">Client Name <span class="float-right">:</span></div>
									<div class="col-6">
										<?php $client_id = $connection['fk_client_id'];
								$client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id],'serial_no,client_name');
								echo $client['client_name'].' ('.$client['serial_no'].')';
								 ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Connection Name <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['connection_name'] ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">ASHOST <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['ashost'] ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">SYSNR <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['sysnr'] ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">Client <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['client'] ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">User <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['user'] ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">Password <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['passwd'] ?>
									</div>
								</div>


								<div class="row form-group">
									<div class="col-3">Gwhost <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['gwhost'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Gwserv <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['gwserv'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Mshost <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['mshost'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">R3name <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['r3name'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Group <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['group'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Lang <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['lang'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Tsfile <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['tsfile'] ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Status <span class="float-right">:</span></div>
									<div class="col-6">
										<?php echo $connection['active_inactive'] ?>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>