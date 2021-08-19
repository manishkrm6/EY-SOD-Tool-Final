<div class="content-page">
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box">
				    <div class="card">
					    <div class="card-body">
							<h3 class="text-center">Importing Data from SAP</h3>
							<a href="<?php echo $redirect_url ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a><br><br>
							<?php $this->load->view('inc/after-form-submitted'); ?>
							<ol>
							<?php if($messages){
								foreach ($messages as $key => $message) { ?>
									<li><?php echo $message ?></li>
								<?php }
							} ?>
							</ol>
							<a href="<?php echo $redirect_url ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<script type="text/javascript">
      window.onload = setupRefresh;

      function setupRefresh() {
          setInterval("refreshFrame();", 15000);
      }
      function refreshFrame() {
        parent.files.location.reload();
      }
</script>