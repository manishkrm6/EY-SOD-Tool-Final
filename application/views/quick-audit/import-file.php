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
  <span class="fa fa-circle-notch fa-spin fa-4x text-info"></span> Processing...
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

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <?php if (!empty($not_uploaded)) { ?>
<h4 class="page-title">Import Files</h4>
    
    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">Browse Files <span class="float-right">:</span></label>
        <div class="col-6">
            <input type="file" class="form-control" name="files[]" multiple="true">
        </div>
    </div>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            <input type="submit" class="btn btn-info waves-effect waves-light" name="upload_files" value="Upload Files">
        </div>
    </div>
  <?php } else {  ?>

    <p class="text-center"><a href="<?php echo base_url('validate-files/'.$analysis_id) ?>" class="btn btn-info">Validate Files</a></p>

    <h4 class="page-title">Start Your Import data</h4>
    <div class="form-group mb-0 justify-content-end row mt-4">
        <div class="col-6">
            <input type="button" id="btnImport" class="btn btn-success waves-effect waves-light" name="btnImport" value="Import data">
        </div>
    </div>
    <?php } ?>
</form>

</div>  <!-- end card-body -->
</div>
</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->

</div> <!-- container -->

</div> <!-- content -->
</div>

<script>
         $(function(){
            
            $('#btnImport').on('click',function(){

              
              $.ajax({
                  url: "<?php echo base_url('/import-data/'.$analysis_id); ?>", 

                  type: "GET",  
                  dataType: 'json', 
                  // data: { "type": "type" }, 
                  async:true,
                  success: function(response)
                  {
                    
                    console.log(response);
                    
                    //$('#ajax-response').append(response);

                  } //End Success
                      
                });

                $.ajax({
                  url: "<?php echo base_url('/get-import-status'); ?>", 
                  type: "GET",  
                  dataType: 'json', 
                  data: { "type": "type" }, 
                  async:true,
                  success: function(response)   
                  {
                    
                    console.log(response);
                    
                    //$('#ajax-response').append(response);

                  } //End Success
                      
                });

            });

          });
      </script>