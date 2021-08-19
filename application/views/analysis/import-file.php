<?php ob_implicit_flush(1); ?>
<div class="content-page">
<div class="content">

<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box">
    <div class="card">
    <div class="card-body">


<h3 class="text-center"><?php echo 'Client Name : '.$client_name.' And Analysis Name : '.$analysis_name ?></h3>
<?php $this->load->view('inc/after-form-submitted'); ?>
<h4 class="page-title">Imported Files List:</h4> 
<div class="row">
  <div class="col-10">
<ol style="column-count: 4">
<?php 
  $not_uploaded = [];
foreach ($db_files as $key => $file) { 
  $file_status = ' <label class="dripicons-cross" style="color:red"></label>'; 
  if (in_array($file,$folder_files)) { 
    $file_status = ' <label class="dripicons-checkmark" style="color:green"></label>'; 
  } else {
    array_push($not_uploaded, $file);
  }  ?> 
    <li><?= $file.' <span class="badge badge-info">10/100</span> '.$file_status ?></li> <?php } ?> </ol>
</div>
<div class="col-2">
  <!-- <span class="fa fa-circle-notch fa-spin fa-4x text-info"></span> Processing... -->
</div>
</div>
<div id="ajax-response"></div>


<?php if($upload_response){
    # START CODE FOR LIST OF FILES NOT MATCHED WITH OUR DATABASE MASTER
    if ($upload_response['not_allow']) { ?>
            <div class="alert alert-warning">
                <p>Following Files are not matched with our database master:</p>
                <ol>
                <?php
                    foreach ($upload_response['not_allow'] as $key => $file) { ?>
                        <li><?= $file ?></li>
                    <?php } ?>
                </ol>
            </div>
                <?php } 
                 # START CODE FOR LIST OF FILES SUCCESSFULLY UPLOADED
        if ($upload_response['success']) { ?>
            <div class="alert alert-success">
                <p>Following Files are successfully uploaded:</p>
                <ol>
                <?php
                    foreach ($upload_response['success'] as $key => $file) { ?>
                        <li><?= $file ?></li>
                    <?php } ?>
                </ol>
            </div>
    
    <?php }
      # START CODE FOR LIST OF FILES FAIL TO UPLOAD
     if ($upload_response['fail']) { ?>
            <div class="alert alert-danger">
                <p>Following Files are successfully uploaded:</p>
                <ol>
                <?php
                    foreach ($upload_response['fail'] as $key => $file) { ?>
                        <li><?= $file ?></li>
                    <?php } ?>
                </ol>
            </div>
                <?php } 
    } ?>




</div>  <!-- end card-body -->
</div>
  


  <!-- Begin Card -->

    <div class="card">
    <div class="card-body">
    <h4 class="page-title">Upload Files</h4>

    <div class="text-center">
      <!-- Button trigger modal -->
      <?php if (!isset($_GET['cid'])) { ?>
<button type="button" class="btn btn-info" data-toggle="modal" data-target="#sap_connection">
  Make SAP Connection
</button>
      <?php } else { ?> 
        <a href="<?php echo base_url('sap/import-data/'.id_encode($client_id).'/'.$_GET['analysis_id'].'/'.$_GET['cid']) ?>" class="btn btn-success">Import SAP Data</a>
      <?php } ?>

<!-- Modal -->
<div class="modal fade" id="sap_connection" tabindex="-1" role="dialog" aria-labelledby="sap_connectionTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sap_connectionTitle">Connect With SAP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if ($connections) { ?>
        <form action="<?php echo base_url('sap/create-connection/'.id_encode($client_id)) ?>" method="post">
          <input type="hidden" name="analysis_id" value="<?php echo $analysis_id ?>">
          <input type="hidden" name="client_id" value="<?php echo id_encode($client_id) ?>">
          <table class="table table-hover table-bordered">
            <tr>
              <th>S.No.</th>
              <th>Connection Name</th>
              <th>Ahost</th>
              <th>Client</th>
              <th>User</th>
            </tr>
          <?php $counter = 1; foreach ($connections as $key => $connection) { ?>
            <tr>
              <td class="text-center">
                <input type="radio" name="connection_id" value="<?php echo $connection['id'] ?>"> 
                <?php echo ($counter<10)?'0'.$counter:$counter; $counter++ ?></td>
              <td><?php echo $connection['connection_name'] ?></td>
              <td><?php echo $connection['ashost'] ?></td>
              <td><?php echo $connection['client'] ?></td>
              <td><?php echo $connection['user'] ?></td>
            </tr>
          <?php } ?>
          </table>
          <div class="text-center">
            <input type="submit" name="sap_import" class="btn btn-success" value="Connect">
          </div>
        </form>
        <?php } else { ?>
          <div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> No SAP connection found for this client.</div>
        <?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
    </div>

<form class="form-horizontal" method="post" action="<?php echo base_url().'create-new-analysis'; ?>" enctype="form-data/multipart">

    <label id="lblUploadStatus" class="col-3 col-form-label"></label> 
        

        <div class="row">
          <div id="filelist"></div>
        </div>

          <div class="row">
            <div class="col-9" id="container">
              <button id="uploadFile" name="uploadFile" type="button" class="btn btn-blue waves-effect waves-light">Browse File</button>
            </div>
          </div>
          <br>
      
         <input type="hidden"  name="analysis_id" id="analysis_id" value="<?= id_decode($analysis_id); ?>" >
         <input type="hidden"  name="path" id="path" value="<?= $path; ?>" >
         <input type="hidden"  name="database" id="database" value="<?= $database; ?>" >

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-12">
            <button type="button" id="upload" class="btn btn-info" name="upload">Upload Files</button> 
            
            

        </div>
    </div>

</form>
      
      <br>
      <form action = "<?= base_url('sanitize-txt-files'); ?>" method="POST" >

          <input type="hidden"  name="path1" id="path1" value="<?= $path; ?>" >
          <input type="hidden"  name="database1" id="database1" value="<?= $database; ?>" >
          <input type="hidden"  name="analysis_id1" id="analysis_id1" value="<?= $analysis_id; ?>" >
          <button type="submit"  class="btn btn-info" name="sanitize">Sanitize Files</button>
      </form>
      <br>
      <form action = "<?= base_url('import-db3'); ?>" method="POST" >

          <input type="hidden"  name="path1" id="path1" value="<?= $path; ?>" >
          <input type="hidden"  name="database1" id="database1" value="<?= $database; ?>" >
          <input type="hidden"  name="analysis_id1" id="analysis_id1" value="<?= $analysis_id; ?>" >

          <button type="submit"  class="btn btn-info" name="import">Import Files</button>
      </form>
    

</div>  <!-- end card-body -->
</div>


  <!-- End Card -->

</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->

</div> <!-- container -->

</div> <!-- content -->
</div>

<script type="text/javascript">
   BASE_URL = "<?php echo base_url(); ?>";
</script>

<script type="text/javascript">
  PATH = $('#path').val();
</script>

<script src="<?=base_url();?>assets/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>

<script type="text/javascript">
  $(function(){
      $('#import').on('click',function(){

          $.ajax({
             url: '<?= base_url("import-data-into-db3"); ?>', 
             type: "POST",  
             data: {path: $('#path').val(), database: $('#database').val()},    
            success: function(response, textStatus, jqXHR)   
            {
                if(response['status'] == "success") 
                {
                    
                }
                else if(response['status'] == "fail"){
                    alert(response['error']);
                    //$('#loader').modal('hide');
                }
            },
             error: function(jqXHR, textStatus, errorThrown){
                //if fails 
            }
      });// End Ajax Block

      });
  });
</script>