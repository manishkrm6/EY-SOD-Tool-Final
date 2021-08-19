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

                                        
<h4 class="page-title">Import Large Text File</h4>

<form class="form-horizontal" method="post" action="" enctype="form-data/multipart">
    
    <div id="body" class="form-group row mb-3">
        <label id="lblUploadStatus" class="col-3 col-form-label"></label>
        
        <label for="files" class="col-3 col-form-label">Browse Files <span class="float-right">:</span></label>
        
        <div id="filelist">Your browser doesn't have Flashs, Silverlight or HTML5 support.</div>

        
            <div class="col-6" id="container">
                <!-- <input type="file" class="form-control" name="files[]"> -->
                <!-- <a id="uploadFile" name="uploadFile" href="javascript:;">Select file</a> -->

        <button id="uploadFile" name="uploadFile" type="button" class="btn btn-info waves-effect waves-light">Select File</button>

            </div>
        

        

        <div class="col-6">
            <!-- <a id="upload" href="javascript:;" >Upload files</a> -->
            
            <button id="upload" name="upload" type="button" class="btn btn-info waves-effect waves-light">Upload File</button>

        </div>
    </div>

    <input type="hidden" id="file_ext" name="file_ext" value="<?=substr( md5( rand(10,100) ) , 0 ,10 )?>">
        <div id="console"></div>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            
            <!-- <input type="submit" class="btn btn-info waves-effect waves-light" name="submit" value="Submit"> -->
            <!-- <button type="button" class="btn btn-info waves-effect waves-light" name="btnUpload" id="btnUpload">Upload</button> -->
        </div>
    </div>
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

<script type="text/javascript">
    BASE_URL = "<?php echo base_url();?>"
</script>
<script src="<?=base_url();?>assets/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>

</body>
</html>