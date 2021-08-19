<!--browse upload popup code  POPUP Modal-->
  <div class="modal" id="browseForUploadModal">
    <div class="modal-dialog">
      <div class="modal-content" style="min-height:200px;width:520px;margin-left: -10px">
        <!-- Modal Header -->
        <div class="modal-header">
        <p class="modal-title">Upload Data</p>
          <button type="button" class="close bg-success" data-dismiss="modal">&times;</button>
        </div>    
        <!-- Modal body -->
        <div class="modal-body">  
          <form>

                <input type="hidden"  name="analysis_id" id="analysis_id" value="<?= $fk_analysis_id; ?>" >
                <input type="hidden"  name="path" id="path" value="<?= $path; ?>" >
                <input type="hidden"  name="database" id="database" value="<?= $database; ?>" > 

              <div class="col-sm-12" id="container" >
                <button id="uploadFile" name="uploadFile" type="button" class="btn  ml-4 font-weight-bold">Browse File</button>
                <button type="button" class="btn  ml-2 font-weight-bold" id="upload" name="upload">Upload File</button>
                <button type="button" id="sanitize" class="btn   ml-2 font-weight-bold">Sanitize File</button>
                <button type="button" id="import" class="btn   ml-2 font-weight-bold">Import File</button>
              </div>

             <div class="col-sm-12  py-3">
             <div id ="myLoader" style="display:none;" class="col-sm-2 offset-10">
                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
             </div>

                <!-- <h5 class="mt-3">Data Input Completion Status</h5> -->
               <br /> 
               <div class="progress ml-4 mt-4" id="progress" style="display:none; border-radius: 10px; background-color:#E8E8E8;width:425px">
                  <div class="progress-bar bg-success" style="width:5%">0%</div>
               </div> 

               <!-- Status For Upload File -->
              <label id="lblUploadStatus" class="col-3 col-form-label"></label> 
               <div class="row">
                  <div id="filelist"></div>
                </div>

               <div id="msgSuccess" class="alert alert-info" style="display:none;">
                  <!-- <strong>Note!</strong> Sanitize File write your text here...  -->
              </div> 
            </div>
          </form>
        </div><!-- Modal body end -->
      </div><!-- Modal content end -->
    </div><!-- Modal Dialog end -->
  </div>
<!--browse upload popup end modal here -->

<script>
  $(function(){
    
    $('#uploadFile').css("background-color","#FFE600");
    $('#upload').css("background-color","#ddd");
    //$('#upload').prop('disabled', true);
    
    $('#sanitize').css("background-color","#ddd");
    $('#sanitize').prop('disabled', true);

    $('#import').css("background-color","#ddd");
    $('#import').prop('disabled', true);
    
    // On Select
    $("input:file").change(function (){  
      
      //$('#upload').prop('disabled',false);  
      $('#upload').css("background-color","#FFE600");
      
      
      $('#uploadFile').css("background-color","#ddd");

    });

    $('#upload').on('click',function(){
      
      $('#upload').css("background-color","#ddd");
      $('#sanitize').css("background-color","#FFE600");
      $('#sanitize').prop('disabled', false);
      
      $('#import').css("background-color","#FFE600");
      $('#import').prop('disabled', false);

    });

  });
</script>


<script>
  
  $(function(){
    
    var intervalForUpload = null;

      $('#import').on('click',function(){
          
          $('#uploadFile').prop('disabled', true);
          $('#uploadFile').css("background-color","#ddd");

          $('#upload').prop('disabled', true);
          $('#upload').css("background-color","#ddd");

          $('#sanitize').prop('disabled', true);
          $('#sanitize').css("background-color","#ddd");
          
          $('#import').prop('disabled', true); 
          
          $('#filelist').hide();

          $('#progress').show();
          //alert("Hello Hi");
          
          

          //return false;

          $.ajax({

              // "import-db3-ajax"
             url: 'http://localhost:3001/importDB3?fk_analysis_id='+$('#analysis_id').val(), 
             type: "GET",  
             //data: { path1: $('#path').val(), database1: $('#database').val(), analysis_id1: $('#analysis_id').val()},    
             async:true,
             dataType: 'jsonp',
             success: function(response, textStatus, jqXHR)   
             {
                
                //console.log(response);
                
                //if(response.success == 1)
                  //window.location.reload();

             },
             error: function(jqXHR, textStatus, errorThrown){

             }

          });// End Ajax Block 

          intervalForUpload = setInterval( () => { 
            $.ajax({
              url: 'http://localhost:3001/importDB3/getImportStatus?fk_analysis_id='+$('#analysis_id').val(), 
              type: "GET",  
              dataType: 'jsonp',
             success: function(response, textStatus, jqXHR)   
             {
                let overall_status_html = '<div class="progress-bar bg-success" style="width: '+ ( response.progress >= 5 ? response.progress : 5) +'%;" >'+response.progress+'%</div>';
                $('#progress').html(overall_status_html);
                if(response.progress == 100){
                  clearInterval(intervalForUpload);
                   window.location.reload();
                }
             },
             error: function(jqXHR, textStatus, errorThrown){

             }

            }); 
          },1000);


      }); // End Import Button On Click

  }); // End Doc Ready

</script>


<script>
  
  $(function(){
    
    $('#sanitize').on('click',function(){
      
      $('#filelist').hide();
      $('#progress').show();

      //return false;

      $.ajax({
             
             url: '<?= base_url("sanitize-txt-files"); ?>', 
             type: "POST",  
             data: { path1: $('#path').val(), database1: $('#database').val(), analysis_id1: $('#analysis_id').val()},    
             async:true,
             dataType: 'json',
             success: function(response, textStatus, jqXHR)   
             {
                if(response.success == 1)
                  clearInterval(intervalForUpload);

             },
             error: function(jqXHR, textStatus, errorThrown){

             }

          });// End Ajax Block

          intervalForUpload = setInterval( () => { 
            $.ajax({
              url: 'http://localhost:3001/importDB3/getImportStatus?fk_analysis_id='+$('#analysis_id').val(), 
              type: "GET",  
              dataType: 'jsonp',
             success: function(response, textStatus, jqXHR)   
             {
                let overall_status_html = '<div class="progress-bar bg-success" style="width: '+ ( response.progress >= 5 ? response.progress : 5) +'%;" >'+response.progress+'%</div>';
                $('#progress').html(overall_status_html);
                if(response.progress == 100){
                  clearInterval(intervalForUpload);
                   //window.location.reload();
                }
             },
             error: function(jqXHR, textStatus, errorThrown){

             }

            }); 
          },1000);



    }); // End Sanitize Button Click Handler

  }); // End Document Ready
</script>



<script type="text/javascript">
  BASE_URL = "<?php echo base_url(); ?>";
</script>

<script type="text/javascript">
  PATH = $('#path').val();
</script>

<script src="<?=base_url();?>assets/js/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="<?=base_url();?>assets/js/application.js"></script>


