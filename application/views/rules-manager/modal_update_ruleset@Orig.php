<style>
    input[type="file"] {
    display: none;
}
.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}

</style>
<!--browse upload popup code  POPUP Modal-->
<div class="modal" id="updateRulesetModal">
    <div class="modal-dialog">
      <div class="modal-content" style="min-height:200px;width:520px;margin-left: -10px">
        <!-- Modal Header -->
        <div class="modal-header">
        <p class="modal-title">Update Ruleset</p>
          <button type="button" class="close bg-success" data-dismiss="modal">&times;</button>
        </div>    
        <!-- Modal body -->
        <div class="modal-body">  
          <form>

                <input type="hidden"  name="analysis_id" id="analysis_id" value="<?= $fk_analysis_id; ?>" >
               

              <div class="col-sm-12" id="container" >
                <a href="<?= base_url('get-sod-dump/'.id_encode($fk_analysis_id)); ?>" id="exportFile" name="exportFile" type="button" class="btn  ml-4 font-weight-bold" style="width:160px"> <i class="fa fa-download" aria-hidden="true"></i> Download Ruleset</button>
                <!-- <button id="browseFile" type="file" name="browseFile" type="button" class="btn  ml-4 font-weight-bold">Browse File</button> -->
                
                <label id="lableFileUpload" for="file-upload" class="btn ml-4 font-weight-bold custom-file-upload" style="width:120px">
                    <i class="fa fa-cloud-upload"></i> Browse File
                </label>
                <input id="fileUpload" type="file"/>

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
        //$('#exportFile').css("background-color","#FFE600");
        $('#exportFile').css("background-color","#ddd");
        $('#browseFile').css("background-color","#ddd");
        $('#import').css("background-color","#ddd");
    })
</script>

