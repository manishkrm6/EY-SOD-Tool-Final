<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
				<h3 class="text-center">Create New SAP Connection</h3>
				<a href="<?php echo base_url('sap/connections-list') ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>
								<?php $this->load->view('inc/after-form-submitted'); ?>

				<form action="" method="post">

								<div class="row form-group">
									<div class="col-3">Client Name <span class="float-right">:</span></div>
									<div class="col-6">
										<select name="client_id" id="process_id" class="form-control" required="true">
											<option value="">--Select Client--</option>
											<?php if ($clients) {
											foreach ($clients as $key => $client) { ?>
												<option value="<?php echo $client['id'] ?>"><?php echo $client['client_name'].' ('.$client['serial_no'].')' ?></option>
											<?php } }?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Connection Name <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="connection_name" value="" class="form-control" required="true">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">ASHOST <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="ashost" value="" class="form-control" required="true">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">SYSNR <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="sysnr" value="" class="form-control" required="true">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">Client <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="client" value="" class="form-control"required="true">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">User <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="user" value="" class="form-control" required="true">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-3">Password <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="password" value="" class="form-control" required="true">
									</div>
								</div>


								<div class="row form-group">
									<div class="col-3">Gwhost <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="gwhost" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Gwserv <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="gwserv" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Mshost <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="mshost" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">R3name <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="r3name" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Group <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="group" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Lang <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="lang" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Tsfile <span class="float-right">:</span></div>
									<div class="col-6">
										<input type="text" name="tsfile" value="" class="form-control">
									</div>
								</div>

								<div class="row form-group">
									<div class="col-3">Status <span class="float-right">:</span></div>
									<div class="col-6">
										Active <input type="radio" name="active_inactive" value="Active" checked>
										Inactive <input type="radio" name="active_inactive" value="Inactive">
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