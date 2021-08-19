
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10">
      <!--code start-->

        <div class="row">
          <div class="col-12">
            <p class="bg-dark  p-2 ml-5 mt-0 rprthead ">Advance Reports
              <i class="fa fa-1x fa-download p-1 fl"></i>
               <input type="checkbox" id="c0" name="cb"> 
               <label class="pull-right pt-1 pr-1" for="c0" >
            </p>
          <div class="row mt-3">
              <div class="col-6">
                <ol class="list-ic vertical olcls">
                  <li class="pl-2 crd-text" > 
                    <i class="line"></i> <span></span> <a href="<?= base_url('get-sap-critical-basis-parameters/'.id_encode($fk_analysis_id)); ?>">SAP Critical Basis Parameters</a>
                    <input type="checkbox" id="c1" name="cb">
                    <label class="pull-right pt-" for="c1" ></label>
                  </li>
                  <li class="pl-2 crd-text"> 
                     <i class="line"></i> <span></span> SAP Basis Authorization Check
                     <input type="checkbox" id="c2" name="cb">
                      <label class="pull-right pt-" for="c2" ></label>
                  </li>
                </ol>
              </div>  
              <div class="col-6">
                  <ol class="list-ic vertical olcls">
                     <li  class="pl-2 crd-text" ><i class="line"></i><span></span>SAP Access Report 
                      <input type="checkbox" id="c3" name="cb"> <label class="pull-right pt-" for="c3" ></label></li>

                      <li  class="pl-2 crd-text" ><i class="line"></i><span></span><a href="<?= base_url('get-root-cause-analysis/'.id_encode($fk_analysis_id)); ?>">Root Cause Analysis</a>
                      <input type="checkbox" id="c4" name="cb"> <label class="pull-right pt-" for="c4" ></label></li>
                  </ol>
              </div>
          </div>
        </div>
      </div>
      <!--advanced report close code here-->
      <!--second row heading start here-->
        <div class="row mt-2">
          <div class="col-12">
              <p class="bg-dark  p-2 ml-5 mt-0 rprthead ">User Reports
                <i class="fa fa-1x fa-download p-1 fl"></i>
                <input type="checkbox" id="ch2" name="cb">
                <label class="pull-right pt-1 pr-1" for="ch2" >
              </p>
            <div class="row mt-3">
              <div class="col-6">
               <ol  class="list-ic vertical olcls">
                 <li  class="pl-2 crd-text"> 
                    <i class="line"></i>
                    <span></span><a href="<?= base_url('get-transcation-level-sod-conflicts-by-user/'.id_encode($fk_analysis_id)); ?>">Transaction Level SoD Conflicts by Users</a>  
                    <input type="checkbox" id="c5" name="cb"> 
                    <label class="pull-right pt-" for="c5" ></label>
                 </li>
                 <li  class="pl-2 crd-text"> <span></span>User Wise Conflicting transactions
                   <input type="checkbox" id="c6" name="cb">
                    <label class="pull-right pt-" for="c6" ></label> 
                 </li>
                <li  class="pl-2 crd-text"> <span></span>Critical Authorizations by Users 
                  <input type="checkbox" id="c7" name="cb"> 
                  <label class="pull-right pt-" for="c7" ></label>
                </li>

                <li  class="pl-2 crd-text" > <span></span><a href="<?= base_url('get-users-with-custom-tcodes/'.id_encode($fk_analysis_id)); ?>">Custom T- Codes by Users</a>
                 <input type="checkbox" id="c8" name="cb"> 
                 <label class="pull-right pt-" for="c8" ></label>
                </li>
               <li  class="pl-2 crd-text"> <span></span><a href="<?= base_url('get-user-with-tcode-access/'.id_encode($fk_analysis_id)); ?>">Users T-Code Access</a><input type="checkbox" id="c9" name="cb"> <label class="pull-right pt-" for="c9" ></label></li>

              <li  class="pl-2 crd-text"> <span></span><a href="<?= base_url('get-users-with-cross-client-access/'.id_encode($fk_analysis_id)); ?>">Cross Company Code Access</a> <input type="checkbox" id="c10" name="cb"> <label class="pull-right pt-" for="c10" ></label></li>

               <li  class="pl-2 crd-text" > <i class="line"></i><span></span>User Org Matrix
                 <input type="checkbox" id="c11" name="cb"> <label class="pull-right pt-" for="c11" ></label>
               </li>
            </ol>
          </div>

           <div class="col-6">
            <ol class="list-ic vertical olcls">
              <li  class="pl-2 crd-text" ><i class="line"></i> <span></span>User Conflicts by SoD Risks
                <input type="checkbox" id="c12" name="cb"> <label class="pull-right pt-" for="c12" ></label></li>

              <li  class="pl-2 crd-text" > <span></span><a href="<?= base_url('get-access-to-profile/'.id_encode($fk_analysis_id)); ?>">Access to Profile</a>
                 <input type="checkbox" id="c13" name="cb"> <label class="pull-right pt-" for="c13" ></label></li>

              <li  class="pl-2 crd-text"> <span></span>Critical Authorization By T-Codes
                <input type="checkbox" id="c14" name="cb"> <label class="pull-right pt-" for="c14" ></label></li>

              <li  class="pl-2 crd-text" > <span></span><a href="<?= base_url('get-access-to-s-tabu-s-develop/'.id_encode($fk_analysis_id)); ?>">Access to S_TABU_DIS & S_DEVELOP</a>
                <input type="checkbox" id="c15" name="cb"> <label class="pull-right pt-" for="c15" ></label></li>

              <li  class="pl-2 crd-text" > <span></span>Conflict Definition Used in Analysis <input type="checkbox" id="c16" name="cb"> <label class="pull-right pt-" for="c16" ></label></li>

              <li  class="pl-2 crd-text" > <span></span><a href="<?= base_url('get-user-with-sap-all/'.id_encode($fk_analysis_id)); ?>">Users With SAP ALL</a>
                 <input type="checkbox" id="c17" name="cb"> <label class="pull-right pt-" for="c17" ></label></li>

              <li  class="pl-2 crd-text" ><i class="line"></i> <span></span><a href="<?= base_url('get-users-analyzed-report/'.id_encode($fk_analysis_id)); ?>">Users Analyzed</a> <input type="checkbox" id="c18" name="cb"> <label class="pull-right pt-" for="c18" ></label></li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-12">
        <p class="bg-dark  p-2 mt-0 ml-5 rprthead ">Role Reports
          <i class="fa fa-1x fa-download p-1 fl"></i>
          <input type="checkbox" id="ch3" name="cb">
          <label class="pull-right pt-1 pr-1" for="ch3" ></label>
        </p>

        <div class="row mt-3">
          <div class="col-6">
            <ol class="list-ic vertical olcls">
              <li  class="pl-2 crd-text"><i class="line"></i> <span></span><a href="<?= base_url('get-transaction-level-sod-conflicts/'.id_encode($fk_analysis_id)); ?>">Transaction Level SoD Conflicts by Role</a>
               <input type="checkbox" id="c20" name="cb"> 
               <label class="pull-right pt-" for="c20" ></label></li>

              <li  class="pl-2 crd-text"> <span></span><a href="<?= base_url('get-roles-in-conflicts/'.id_encode($fk_analysis_id)); ?>">Roles in Conflict</a>
                 <input type="checkbox" id="c21" name="cb"> <label class="pull-right pt-" for="c21" ></label></li>

              <li  class="pl-2 crd-text"><i class="line"></i> <span></span>Cross Company Code Access 
                <input type="checkbox" id="c22" name="cb"> <label class="pull-right pt-" for="c22" ></label></li>
             </ol>
          </div>

          <div class="col-6">
            <ol class="list-ic vertical olcls">
                <li  class="pl-2 crd-text" ><i class="line"></i> <span></span>Roles Attached to Users
                  <input type="checkbox" id="c23" name="cb"> <label class="pull-right pt-" for="c23" ></label></li>

                <li  class="pl-2 crd-text" > <span></span><a href="<?= base_url('get-roles-with-tcode-access/'.id_encode($fk_analysis_id)); ?>">Role T-Code Access</a> <input type="checkbox" id="c24" name="cb"> <label class="pull-right pt-" for="c24" ></label></li>
                
                <li  class="pl-2 crd-text"><i class="line"></i> <span></span>Role wise conflicting transactions <input type="checkbox" id="c25" name="cb"> <label class="pull-right pt-" for="c25" ></label>
               </li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    </div><!--div col 10 close-->
    <div class="col-sm-2" style="padding-right: 0px">
      <!-- Begin Sidebar -->
 
  <?php $this->load->view('Sidebar');?>
      

    </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->