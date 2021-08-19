
<div class="modal" id="createNewAnalysisModal">
    
    <div class="modal-dialog">
      <div class="modal-content ">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <p class="modal-title">Create Analysis</p>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body" style="padding-left: 50px">  
          <form>
            
            <span id="spnAnalysisError" style="color:red; display:none;"></span>

            <!-- Analysis Name -->
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-4 col-form-label">Analysis Name: </label>
              <div class="col-sm-7">
                <input type="text" class="form-control" id="analysis_name" name="analysis_name" placeholder="e.g Analysis 18 Jan">
              </div>
            </div>

            <!-- Client Name -->
            <div class="form-group row">
              <label for="inputPassword3" class="col-sm-4 col-form-label">Client Name: </label>
              <div class="col-sm-7">
               <select class="form-control" id="fk_client_id" name="fk_client_id" >
                  <option value="none">--Select any Client</option>
                  <?php 
                    if(!empty($list_clients)){
                      foreach ($list_clients as $key => $value) {
                  ?>
                    <option value="<?= $value['id']; ?>"><?= $value['client_name']; ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>

            <!-- System Type -->
            <div class="form-group row">
              <label for="sel1" class="col-sm-4 col-form-label">System Type:</label>
              <div class="col-sm-7">
                <select class="form-control" id="system_type" name="system_type">
                  <option>Sap</option>
                  <option>Oracle</option>
                </select>
              </div>
            </div>

            <!-- Progress Bar Line -->
            <div class="form-group row">
              <div class="col-sm-11">
                 <div class="progress mt-4" id="db3CreationStatus" style="display:none; border-radius: 10px; background-color:#E8E8E8">
                 <div class="progress-bar bg-success" style="width:0%">0%</div>
              </div>
              </div>
            </div>
            <!-- End Progress Bar Line -->

            <!-- Create Button-->
            <div class="form-group row" style="margin-top: -15px">
              <div class="col-sm-10 offset-1 ">
                <button type="button" id="btnCreateNewAnalysis" class="font-weight-bold btn btn-light pull-right offset-1 text-dark"style="background-color:  #E8E8E8;">Create</button>
              </div>
            </div>
            <!-- Create -->


          </form>
        </div>
        
        <!-- Modal footer -->
      
        
      </div>
    </div>
  </div>