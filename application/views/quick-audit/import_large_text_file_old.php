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
    
    <div class="form-group row mb-3">
        <label id="lblUploadStatus" class="col-3 col-form-label"></label>
        <label for="files" class="col-3 col-form-label">Browse Files <span class="float-right">:</span></label>
        <div class="col-6">
            <!-- <input type="file" class="form-control" name="files[]"> -->
            <a id="uploadFile" name="uploadFile" href="javascript:;">Select file</a>
        </div>
        <div class="col-6">
            <a id="upload" href="javascript:;" class="btn btn-danger">Upload files</a>
        </div>
    </div>

    <input type="hidden" id="file_ext" name="file_ext" value="<?=substr( md5( rand(10,100) ) , 0 ,10 )?>">
    <div id="console"></div>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            
            <!-- <input type="submit" class="btn btn-info waves-effect waves-light" name="submit" value="Submit"> -->
            <button type="button" class="btn btn-info waves-effect waves-light" name="btnUpload" id="btnUpload">Upload</button>
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
    BASE_URL = "<?php echo base_url();?>";

</script>

<script src="<?php echo base_url(); ?>assets/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/application.js"></script>-->

<script>

var datafile = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'uploadFile', // you can pass in id...
    container: document.getElementById('container'), // ... or DOM Element itself
    chunk_size: '1mb', 
    //url : BASE_URL + 'upload/uploadtoserver',
    url : BASE_URL + 'upload-file-js',
    max_file_count: 1,

    //ADD FILE FILTERS HERE
    filters : {
        /* mime_types: [
                {title : "XML files", extensions : "xml"},
            ]
        */
    }, 

    // Flash settings
    flash_swf_url : BASE_URL + 'public/js/plupload/Moxie.swf',

    // Silverlight settings
    silverlight_xap_url : BASE_URL + 'public/js/plupload/Moxie.xap',
     

    init: {
        PostInit: function() {
            document.getElementById('filelist').innerHTML = '';  
            document.getElementById('upload').onclick = function() {
            datafile.start();
                return false;
            };
        },

        FilesAdded: function(up, files) {
            plupload.each(files, function(file) {
                document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
            });
        },

        UploadProgress: function(up, file) {
            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
        },

        Error: function(up, err) {
            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
        }
    }
});

datafile.init();

</script>


<script>
    /*$(function(){
        alert('Hi');
        $('#btnUpload').on('click',function(){
            
            sendRequest();
            
            function sendRequest(){
                 
                 $.ajax({
                    method: "GET",
                    url: '<?php echo base_url()."get-import-status" ?>',
                    success: function(response){
                        $('#lblUploadStatus').html(response);
                    },
                    error: function (jqXHR, exception) {
                         var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#lblUploadStatus').html(msg);
                    },
                    complete: function() {
                        
                        // Schedule the next request when the current one's complete
                        //setInterval(sendRequest, 10000); // The interval set to 5 seconds

                    }


                }); // End Ajax

                

            } // End Function

            //setInterval(sendRequest, 10000);
        });
    });*/
</script>
