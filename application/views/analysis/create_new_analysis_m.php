  <!-- Top Level Div Grey with black text -->
  <?php
      $fk_analysis_id = isset($fk_analysis_id) && !empty($fk_analysis_id) ? $fk_analysis_id: NULL;
      
      $db2 = isset($clientInfo['client_database']) ? $clientInfo['client_database'] : NULL;
      $db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
      $path = 'uploads.Clients.'.$db2.'.'.$db3;
      $database = $db3;
      //echo "Clien Id ".id_encode($fk_client_id); die;

  ?>
  
  <!-- Begin Container Fluid -->
     <div class="row bg-">
        <div class="col-10 bg-">    
     <div class="container-fluid">

  <!-- Begin Container Fluid -->
  <!-- test start-->  
      <div class="container-fluid mll bg- creatanatop"  >
        
        <!-- Below Row Contains all Cards --> 
        <div class="row ">
          <!-- Begin Card 1 Extract -->
              <div class="col-sm-3 bg-">
                  <div class="card bg- ca1">
                    <div class="chea">Extract</div>
                      <!-- Begin Card Body -->
                      <div class="card-body bg circl">
                        <div class="circlechart " id="extract_status" data-percentage="<?= $extract_status; ?>" style="margin-left:10px">
                           Completed
                        </div>
                          <p class="cpara"></p>
                          <label class="container progcirltext">
                              <?php if(empty($fk_analysis_id)) { ?>
                                <a data-toggle="modal" data-target="#createNewAnalysisModal"><p class="cp">Enter analysis details</p></a>
                              <?php }else{ ?>
                                <p class="cp">Enter analysis details</p>
                              <?php } ?>

                              <input  type="checkbox" <?php if( 1 == $status_analysis_detail ) { ?> checked="checked" <?php } ?> >
                              <span class="checkmark"></span>
                            </label>
                          <label class="container progcirltext">
                             <!-- <a href="<?= base_url('import-files/'.id_encode($fk_analysis_id) ); ?>"><p class="cp">Upload From File</p></a> --> 
                            <a data-toggle="modal" data-target="#uploadInterfaceModal" ><p class="cp">Upload From File</p></a>

                            <input type="checkbox" <?php if( 1 == $status_upload ) { ?> checked="checked" <?php } ?> >
                            <span class="checkmark"></span>
                          </label>
                      </div>
                      <!-- End Card Body -->
                  </div>
                  <p class="ylw"><img src="<?= base_url(); ?>assets/images/cardsidepic.png" class="hw"></p>
              </div>
          <!-- End Card 1 Extract -->


          <!-- Begin Card 2 Configure -->

          <div class="col-sm-3 ">
            <div class="card ca1">
              <div class="chea">Configure</div>
              <div class="card-body circl">
                    <div class="circlechart" id="configure_status" data-percentage="<?= $configure_status; ?>"style="margin-left:6px">Completed</div>
                     <p class="cpara"></p>
                      <label class="container progcirltext">
                        
                        <!-- <a href="<?= base_url('client-wizard/'.id_encode($fk_analysis_id)); ?>"><p class="cp">Select User</p></a> -->
                        <a href="<?= base_url('select-client-users/'.id_encode($fk_analysis_id)); ?>"><p class="cp">Select User <?= $totalUsersForAnalysis; ?> </p></a>
                         <input type="checkbox" <?php if( 1 == $status_select_users ) { ?> checked="checked" <?php } ?> >
                        <span class="checkmark"></span>
                      </label>

                      <label class="container progcirltext">
                        <a href="<?= base_url('finalize-rules/'.id_encode($fk_analysis_id)); ?>" > 
                        <p class="cp">Finalise rules </p></a>

                      <input type="checkbox" <?php if( 1 == $status_finalize_rules ) { ?> checked="checked" <?php } ?> >
                      <span class="checkmark"></span>
                    </label>
          

                   <label class="container progcirltext"><p class="cp"> <a   id="start_analysis" data-fk_analysis_id = "<?= $fk_analysis_id; ?>">Start Analysis</a></p>
                    <input type="checkbox" id="chbx_start_analysis" <?php if( 1 == $status_start_analysis ) { ?> checked="checked" <?php } ?> >
                    <span class="checkmark"></span>
                  </label>
            </div>
          </div>
              <p class="ylw"><img src="<?= base_url(); ?>assets/images/cardsidepic.png" class="hw"></p>
        </div>
        <!-- End Card 2 Configure -->


        <!-- Begin Card 3 Analysis -->
        <div class="col-sm-3">
         <div class="card ca1">
            <div class="chea">Analysis</div>
            <div class="card-body circl">
               <div class="circlechart" id="analysis_status" id="analysis_status" data-percentage="<?= $analysis_status; ?>"style="margin-left:10px">Completed</div>
                  <p class="cpara"></p>
                  <label class="container progcirltext">
                    <p class="cp">Analysis Preparation</p>
                     <input type="checkbox" id="chbx_analysis_prep" <?php if( 1 == $status_analysis_preparation ) { ?> checked="checked" <?php } ?> >
                     <span class="checkmark"></span>
                  </label>

                <label class="container progcirltext"><p class="cp">Role Analysis</p>
                 <input type="checkbox" id="chbx_role_analysis" <?php if( 1 == $status_role_analysis ) { ?> checked="checked" <?php } ?> >
                 <span class="checkmark"></span>
               </label>

              <label class="container progcirltext"><p class="cp">User Analysis</p>
                <input type="checkbox" id="chbx_user_analysis" <?php if( 1 == $status_user_analysis ) { ?> checked="checked" <?php } ?> >
                <span class="checkmark"></span>
              </label>

              <label class="container progcirltext"><p class="cp">Enforce Org Check</p>
                <input type="checkbox" id="chbx_root_cause_analysis" <?php if( 1 == $status_enforce_org_check ) { ?> checked="checked" <?php } ?> >
                <span class="checkmark"></span>
              </label>
            </div>
         </div>
              <p class="ylw"><img src="<?= base_url(); ?>assets/images/cardsidepic.png" class="hw"></p> 
        </div>
        <!-- End Card 3 Analysis -->

        <!-- Begin Card 4 Reports -->
        <div class="col-sm-3">
          <div class="card ca1">
            <div class="chea">Reports</div>
            <div class="card-body circl">
               <div class="circlechart" id="status_all_reports" data-percentage="<?= $status_all_reports; ?>"style="margin-left:10px">Completed</div>
                 <p class="cpara"></p>
                  <label class="container progcirltext"><p class="cp"><a href="<?= base_url().'analysis-dashboard/'.id_encode($fk_analysis_id); ?>">Dashboard</a></p>
                    <input type="checkbox" id="chbx_dashbaord"  <?php if( 1 == $status_dashboard ) { ?> checked="checked" <?php } ?> >
                    <span class="checkmark"></span>
                  </label>
                </div>
            </div>
        </div><!--card4 end-->
        </div><!--card-row end-->
        <!-- End Card 4 Reports -->


     <!--    start analysis -->
       <!--code progress bar circle-->
      <!-- <?php if( $status_finalize_rules == 1 ){ ?>
        
        <div id="divStartAnalysis" class="col-sm-2 offset-10 pl-5">
          <button id="start_analysis"  data-fk_analysis_id = "<?= $fk_analysis_id; ?>" type="button" class="btn btn-warning sa">Start Analysis</button>
        </div>

      <?php } // End IF  ?> -->
     <!--    start analysis -->
       
      <div class="col-sm-12  mb-3">
        <div class="col-sm-8 ">
           <!-- Begin Procedure's Messages while executing -->
        <div class=>
          <span class="clavel" id="proc_message"></span>
        </div>
      <!-- End of Messages while Executing -->

        </div>

       <!--  STOP ANALYSIS CODE START -->
         <div class="col-sm-4 b">
             <div id="divStopAnalysis" class=" pull-right customgrey">
          <button id="btnStopAnalysis suser" onclick="myFundel()" data-pid = "<?= getmypid(); ?>" type="button" class="btn  sa">Stop Analysis</button>
      </div>
         </div><!--STOP ANALYSIS CODE END -->
      </div>

      <!-- Begin Progress Bar for Overall Status -->
        <div class="col-sm-12 bg">
          <div id="overall_status" class="progress bg"style="background:#DCDCDC;border-radius: 50px;width:1016px;margin-left:12px">
            <div class="progress-bar bg-success barr" style="width: <?= $overall_status; ?>%;" >
              <?= $overall_status; ?>%
            </div>
          </div>
        </div>  
      <!-- End Progress Bar for Overall Status -->


         <?php
        
        $analysis_name = isset($analysisInfo['analysis_name']) ? $analysisInfo['analysis_name'] : NULL;
        $db3 = isset($analysisInfo['db_name']) ? $analysisInfo['db_name'] : NULL;
        $client_name = isset($clientInfo['client_name']) ? $clientInfo['client_name'] : NULL;
        $analysis_create_datetime = isset($analysisInfo['create_datetime']) ?  short_date_format_ampm($analysisInfo['create_datetime']) : NULL;
        
        $user_analyzed = NULL;
        $role_anlyzed = NULL;

        
      ?>

      <div class="col-sm-12">
        <form>
        <div class="col-sm-3 " style="border-right:1px solid grey">           
          <label class="clavel">Database: </label><span class="clavel"><?= $db3; ?></span><br>
          <label class="clavel">Analysis Name: </label><span class="clavel"><?= $analysis_name; ?></span><br>
          <label class="clavel">Client: </label><span class="clavel" ><?= $client_name; ?></span><br>
          <label class="clavel">Date: </label><span class="clavel" ><?= $analysis_create_datetime ; ?></span><br>
        </div>
         <div class="col-sm-4">
          <label  class="clavel">Time Elapsed: </label><span class="clavel" id="time_elapsed"><?= $elapsed_time; ?></span><br>
          <label  class="clavel">Role Build: </label><span class="clavel" id="role_build">0/0</span><br>
          <label  class="clavel">Users Analysed: </label><span class="clavel" id="users_analysed">0/0</span><br>
          <label  class="clavel">Role Analysed: </label> <span class="clavel" id="role_analysed">0/0</span>
        </div>
        </form>
         <div class="col-sm-5">        
           <div class="col-sm-5 bg-light ml-5 shadowbox" >
         <p class="font-weight-bold pt-3">Role Conflict Count</p><br>
         <h4 class="text-danger font-weight-bold text-center"><span id="rconflicts">0</span></h4>
      </div>
       <div class="col-sm-5 bg-light ml-3 pull-right shadowbox" >
         <p class="font-weight-bold pt-3">User Conflict Count</p><br>
         <h4 class="text-danger font-weight-bold text-center"><span id="uconflicts">0</span></h4>
      </div>
        </div>

      </div>

      


    </div><!-- End col 10 Container Fluid -->
       </div><!--col 10 body close div-->
     </div><!--col 10 body close div-->

     <!-- Modal Popup Create New Analysis -->
      <?php include_once(APPPATH.'views/analysis/modal_create_new_analysis.php'); ?>
    <!-- Modal Popup Upload File Interface -->
      <?php include_once(APPPATH.'views/analysis/modal_upload_interface.php'); ?>
    <!-- Modal SAP Connection  -->
      <?php include_once(APPPATH.'views/analysis/modal_sap_connection.php'); ?>  
    <!-- Modal Upload Files  -->
      <?php include_once(APPPATH.'views/analysis/modal_upload_files.php'); ?>    

    
    
    <!-- Begin Sidebar -->
    <div class="col-2">
    <?php
        
        $data = [];
        $data['fk_analysis_id'] = $fk_analysis_id;
        $this->load->view('sidebar',$data); 
        
    ?>
      
    </div>
    <!--end sidebar-->

</div><!--main body first row close-->

<?php include_once(APPPATH.'views/analysis/script.php'); ?> 

  
  <script>
function myFundel() {
  alert("Do You Want To Stop Analysis!");
}
</script>
  

  

  
  

  

  


  