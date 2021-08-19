<!-- Begin Modal-->
  <div class="modal" id="sapConnectionModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
        <p class="modal-title">Upload Data</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>    
        <!-- Modal body -->
        <div class="modal-body">  

        <form action="<?php echo base_url('sap/create-connection/'.id_encode($fk_client_id)) ?>" method="post">
            <div class="form-group row justify-content-center   ">
              <div class="col-sm-10">
               <lable   class="btn  col-sm-12 py-2 text-dark" style="background-color: #FFE600;font-weight:bolder">Choose Sap Connection</label>
              </div>
            </div>
             <!--Select code -->
          <div class="form-group row justify-content-center ">

           <div class="col-sm-10">
            <select class="form-control" id="connection_id" name="connection_id">
              <?php


                if(!empty($list_sap_connections)){
                  foreach ($list_sap_connections as $key => $value) {
                    
                    $sap_client_id = isset($value['fk_client_id']) ? $value['fk_client_id'] : NULL;
                    $sapClientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $sap_client_id));
                    $sap_client_name= isset($sapClientInfo['client_name']) ? $sapClientInfo['client_name'] : NULL;
					
					

              ?>
                <option value="<?= $value['id']; ?>"><?= $value['connection_name'].' ('.$sap_client_name.')'; ?></option>
              <?php } } ?>
                   
            </select>
        </div>
        </div> <!--Slect code end -->
            <div class="form-group row">
              <div class="col-sm-10 offset-1 ">
                <input type="hidden" id="analysis_id" name="analysis_id" value="<?= $fk_analysis_id; ?>" />
                <input type="hidden" id="client_id" name="client_id" value="<?= $fk_client_id; ?>" />

                <button type="button" id="btnCreateConnection" name="sap_import" value="Connect" class="font-weight-bold btn btn-light pull-right offset-1 text-dark"style="background-color:  #E8E8E8;">Select</button>
				
				<button style="display:none;" type="button" id="btnImportData" value="importData" class="font-weight-bold btn btn-light pull-right offset-1 text-dark"style="background-color:  #E8E8E8;">Import Data</button>
				
				
              </div>
			  
			  <div id ="connectionLoader" style="display:none;" class="col-sm-2 offset-10">
                <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
             </div>
			 
            </div>
          </form>
		  
		  <div id="connectionMesssage" class="alert alert-info" style="display:none;">
               
          </div> 
		  
			  
        </div>  <!-- sap modal body end -->
      </div> <!-- sap modal Content end -->
    </div> <!-- sap modal dialog end -->
  </div>
<!-- End Modal -->


<script>
	$(function(){
		
		$('#btnImportData').on('click', function(){
				
			let url = '<?= base_url()."sap/import-data-ajax" ?>';
			
			const analysis_id = $('#analysis_id').val();
		  const client_id = $('#client_id').val();
		  const connection_id = $('#connection_id').val();
		  
			$('#connectionLoader').show();
			
			$.ajax({
				url: url,
				type: 'POST',
				dataType:'json',
				data:{sap_import:"Connect", analysis_id:analysis_id,client_id:client_id,connection_id:connection_id},
				success: function(response)   
				{
					$('#connectionLoader').hide();
					$('#connectionMesssage').html(response.message);
					
					
					//console.log(response);
				},
				error: function(xhr, status, error){
					//console.log(xhr.responseText);
				},
			
			}); // End Ajax Block 
			
		  
		}); // End Sap Import Click
		
	}); // End Document Ready
	
</script>

<script>
	$(function(){
		
		$('#btnCreateConnection').on('click',function(){
			
		  
		  const url = '<?php echo base_url("sap/create-connection-ajax/".id_encode($fk_client_id)) ?>';
		  const analysis_id = $('#analysis_id').val();
		  const client_id = $('#client_id').val();
		  const connection_id = $('#connection_id').val();
		  
		  $('#connectionLoader').show();
		  $('#btnCreateConnection').hide();
		  
		  //console.log("Connection Loader ");
		  
		  $.ajax({
			url: url,
			type: 'POST',
			async: false,  
			dataType:'json',
			data:{sap_import:"Connect", analysis_id:analysis_id,client_id:client_id,connection_id:connection_id},
			success: function(response)   
			{
				
				$('#connectionLoader').hide();
				$('#connectionMesssage').show();
				$('#connectionMesssage').html('Connection successfull');
				$('#btnImportData').show();
				
				
				//console.log(response);
			},
			error: function(xhr, status, error){
				//console.log(xhr.responseText);
			},
			
		  }); // End Ajax Block 
		  
		  
		  
		}); // End Import Button Click event
		
	}); // End Document Ready
	
</script>
