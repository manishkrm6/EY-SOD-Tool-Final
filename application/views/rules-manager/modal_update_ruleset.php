
<!--browse upload popup code  POPUP Modal-->
<div class="modal" id="updateRulesetModal">
<div class="modal-dialog">
      <div class="modal-content" style="min-height:200px;width:520px;margin-left: -10px">
        <!-- Modal Header -->
        <div class="modal-header">
        <p class="modal-title">Upload Ruleset</p>
          <button type="button" class="close bg-success" data-dismiss="modal">&times;</button>
        </div>    
        <!-- Modal body -->
        <div class="modal-body">  
          <form id="formUpdateSod" enctype="multipart/form-data" >

                <input type="hidden"  name="analysis_id" id="analysis_id" value="<?= $fk_analysis_id; ?>" >
		
               <input type="hidden" name="fk_analysis_id" value="<?= id_encode($fk_analysis_id); ?>" />
              

              <div class="col-sm-12" id="container" >
			    <a href="<?= base_url('get-sod-dump/'.id_encode($fk_analysis_id)); ?>" id="exportFile" name="exportFile" type="button" class="btn  ml-4 font-weight-bold" > <i class="fa fa-download" aria-hidden="true"></i> Download</button></a>
				
                <!--<button id="uploadFile" name="uploadFile" type="button"  class="btn   ml-4 font-weight-bold">Browse File</button>-->
				  <button class="btn   ml-2 font-weight-bold"><input id="sodExcel" type="file" accept="" style="width:100px"></button>
				  
				
				<!--<button type="button" class="btn  ml-4 font-weight-bold" id="upload" name="upload">Upload File</button>-->
                <!--<button type="button" id="import" class="btn   ml-4 font-weight-bold">Import File</button>-->
				   <button type="submit"  class="btn  ml-4 font-weight-bold">Import File</button>
               
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
		  
		   <!-- <form id="formUpdateSod" enctype="multipart/form-data" >
            <input id="sodExcel" type="file" accept="" class="form-control"  />
            <input type="hidden" name="fk_analysis_id" value="<?= id_encode($fk_analysis_id); ?>" />
            <button type="submit" class="btn btn-warning" name="submit">Upload</button>
        </form>-->
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
   // $('#import').prop('disabled', true);
    
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

    let fk_analysis_id = '<?= $fk_analysis_id; ?>';  

        $('#formUpdateSod').on('submit', function(e) {
        e.preventDefault();
		 
        
        const formData = new FormData();
        // Attach file
        formData.append('file', $('#sodExcel')[0].files[0]);
        formData.append('fk_analysis_id',fk_analysis_id);

        $.ajax({
          url: "http://localhost:3001/updateSODLibrary",
          type: 'POST',
          cache: false,
          contentType: false,
          processData: false, 
          async: false, 
          data:formData,
          success: function(response)   
          {
            console.log(response);
			  
          },
             error: function(xhr, status, error){
            console.log(xhr.responseText);
          }
        }); // End Ajax



    });

    /* $('#btnTriggerAjax').on('click', function(){
        
        $.ajax({
          url: "http://localhost:3001/updateSODLibrary",
          type: 'POST',
          async: false,  
          dataType:'json',
          data:{fk_analysis_id: fk_analysis_id},
          success: function(response)   
          {
          },
          error: function(xhr, status, error){
            console.log(xhr.responseText);
          }
        }); // End Ajax

      }); // End Btn Click     */

    }); //End Doc Ready
</script>



<script type="text/javascript">
  BASE_URL = "<?php echo base_url(); ?>";
</script>

<script type="text/javascript">
  PATH = $('#path').val();
</script>

<script src="<?=base_url();?>assets/js/plupload/plupload.full.min.js"></script>
<!--<script type="text/javascript" src="<?=base_url();?>assets/js/applicationruleset.js"></script>-->




