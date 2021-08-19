

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10">
      <!--code start-->
      
      
      <?php if($fk_client_id == ''){ ?>
        <div class="alert alert-danger alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
          Client Not Found
        </div>
      <?php } ?>

     <!--1st-->
        <div class="row">
          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage Business Processes:</li>
                <li><a href="<?= base_url('rules-manager/business-process/view-bp/'.$fk_client_id); ?>" >View and Maintain Business Processes</a></li>
                <li><a href="<?= base_url('rules-manager/business-process/add-new-bp/'.$fk_client_id); ?>">Add New Business Processes</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage SoD Risks:</li>
                <li><a href="<?= base_url('rules-manager/sod-risk/view-sod-risk/'.$fk_client_id); ?>">View and Maintain Existing SoD Risks</a></li>
                <li><a href="<?= base_url('rules-manager/sod-risk/add-new-sod-risk/'.$fk_client_id); ?>">Add New Risk</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->


          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage Activities:</li>
                <li><a href="<?= base_url('rules-manager/manage-activities/view-activities/'.$fk_client_id); ?>">View and Maintain Existing Activities</a></li>
                <li><a href="<?= base_url('rules-manager/sod-risk/add-new-sod-risk/'.$fk_client_id); ?>">Add New Activity</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->
        </div>
        <!--/.row-->

        <!--2nd row-->
         <div class="row">
          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage Customized Transaction Codes:</li>
                <li><a href="<?= base_url('rules-manager/transaction-codes/view-transaction-codes/'.$fk_client_id); ?>">View and Customized Transaction Codes</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage SoD Rules:</li>
                <li><a href="<?= base_url('rules-manager/sod-rules/view-sod-rules/'.$fk_client_id); ?>">View and Maintain Existing Rules</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->


          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage Critical Access Rules:</li>
                <li><a href="<?= base_url('rules-manager/critical-access/add-new-critical-access-rule/'.$fk_client_id); ?>">View and Maintain Existing Rules</a></li>
                <li><a href="<?= base_url('rules-manager/critical-access/add-new-critical-access-rule/'.$fk_client_id); ?>">Add New Critical Code</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->      
        </div>
        <!--/.row-->
        <!--2nd row end-->


        <!--3rd row end-->
         <div class="row"style="margin-top: -28px">
          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
             
                <ul class="fa-ul ">
                <li class="eycolor">Manage Conflict Exceptions:</li>
                <li><a href="<?= base_url('rules-manager/conflicts-exceptions/object-conflicts-exceptions/'.$fk_client_id); ?>">Conflict Exception by Object</a></li>
                <li><a href="<?= base_url('rules-manager/conflicts-exceptions/roles-conflicts-exceptions/'.$fk_client_id); ?>">Conflict Exception by Role</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->

          <div class="col-lg-4 bg- col-md-3 col-sm-12 col-xs-12">
            <div class="info-box blue-bg">
                <ul class="fa-ul ">
                <li class="eycolor">Manage Additional Checks:</li>
                <li><a href="<?= base_url('rules-manager/conflicts-exceptions/object-conflicts-exceptions/'.$fk_client_id); ?>">View and Maintain Additional Access Checks</a></li>
                <li><a href="<?= base_url('rules-manager/conflicts-exceptions/roles-conflicts-exceptions/'.$fk_client_id); ?>">Add New Business Processes:</a></li>
              </ul>
            </div>
            <!--/.info-box-->
          </div>
          <!--/.col-->
        </div>
        <!--/.row-->
        <!--3rd row end-->
        
        <!-- <form id="formUpdateSod" enctype="multipart/form-data" >
            <input id="sodExcel" type="file" accept="" class="form-control"  />
            <input type="hidden" name="fk_analysis_id" value="<?= id_encode($fk_analysis_id); ?>" />
            <button type="submit" class="btn btn-warning" name="submit">Upload</button>
        </form>-->

        <!-- <form method="POST" action ="<?= base_url('update-sod-lib'); ?>" enctype="multipart/form-data" >
            <input  type="file" name="userfile" />
            <input type="hidden" name="fk_analysis_id" value="<?= id_encode($fk_analysis_id); ?>" />
            <button type="submit" class="btn btn-warning" name="submit">Update RuleSet</button>
        </form> -->

       

        <!-- Copy Conflict button code start-->
        <div class="row pull-right mt-5 mb-5 customgrey">

          <div class="mr-3 conflict">
            <a data-toggle="modal" data-target="#updateRulesetModal" class="btn  col-lg-12 pull-right lightgry"> Update Ruleset</a></div>
           <div>
        
           <a class="btn  col-lg-12 pull-right lightgry mr-2" href="<?= base_url('create-new-analysis/'.id_encode($fk_analysis_id)); ?>" >Use Default Ruleset</a></div>
           <div>
          
          <a href="<?= base_url('compile-sod/'.id_encode($fk_analysis_id));?>" class="btn  col-lg-12 pull-right float:right mb-5 lightgry " >Recreate Ruleset</a> </div>
          
        </div>
        <!--button code end-->
    <!--body code close col 10-->
    </div><!--div col 10 close-->


      <div class="col-sm-2" style="padding-right: 0px">
        <!-- Begin Sidebar -->
        <?php $this->load->view('Sidebar');?>
      </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->

<?php include_once(APPPATH.'views/rules-manager/modal_update_ruleset.php'); ?>  

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