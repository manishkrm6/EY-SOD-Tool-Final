<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
 
							<h3 class="text-center">Rules Manager</h3>
								<?php $this->load->view('inc/after-form-submitted'); ?>
							<div class="row">
							
							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage Business Processes</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/business-process/view-bp/'.$client_id) ?>">View & Maintain Business Process</a></li>
											<li><a href="<?php echo base_url('rules-manager/business-process/add-new-bp/'.$client_id) ?>">Add new Business Process</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>

							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage SOD Risks</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/sod-risk/view-sod-risk/'.$client_id) ?>">View & Maintain Existing SOD Risks</a></li>
											<li><a href="<?php echo base_url('rules-manager/sod-risk/add-new-sod-risk/'.$client_id) ?>">Add New Risk</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>


							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage Activities</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/manage-activities/view-activities/'.$client_id) ?>">View & Maintain Existing Activities</a></li>
											<li><a href="<?php echo base_url('rules-manager/manage-activities/add-new-activity/'.$client_id) ?>">Add New Activity</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>

							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage Customized Transaction Codes</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/transaction-codes/view-transaction-codes/'.$client_id) ?>">View & Maintain Custom Transaction Codes</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>

							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage SOD Rules</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/sod-rules/view-sod-rules/'.$client_id) ?>">View & Maintain Existing Rules</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>

							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage Critical Access Rules</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/critical-access/critical-access-rules/'.$client_id) ?>">View & Maintain Existing Rules</a></li>

											<li><a href="<?php echo base_url('rules-manager/critical-access/add-new-critical-access-rule/'.$client_id) ?>">Add New Critical TCode</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>


							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage Conflicts Exceptions</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/conflicts-exceptions/object-conflicts-exceptions/'.$client_id) ?>">Conflicts Exceptions By Objects</a></li>
											<li><a href="<?php echo base_url('rules-manager/conflicts-exceptions/roles-conflicts-exceptions/'.$client_id) ?>">Conflicts Exceptions By Roles</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>

							<div class="col-4">
								<div class="card-box">
                                    <h4 class="header-title mb-0">Manage Additional Checks</h4>
                                    <div class="widget-chart">
                                    	<ol>
											<li><a href="<?php echo base_url('rules-manager/additional-checks/list/'.$client_id) ?>">View & Maintain Additional Access Checks</a></li>
										</ol>	
                                    </div>
                                </div>
							</div>
							
							</div>

								<h4 class="header-title mb-0">Copy Conflicts Definition:</h4>
								<form action="" method="post">
							<div class="row">
								<div class="col-4">Select Client Name:</div>
								<div class="col-4">
									<select name="client_db_id" class="form-control" required="true">
										<option value="">--Select Client--</option>
										<?php if ($clients) {
											foreach ($clients as $key => $client) {
												if (empty($client['client_database'])) {
													continue;
												}
											 ?>
												<option value="<?php echo $client['id'].'-'.$client['client_database'] ?>"><?php echo $client['client_name'] ?></option>
											<?php }
										} ?>
									</select>
								</div>
								<div class="col-4">
									<input type="submit" name="copy_db" value="Submit" class="btn btn-success">
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