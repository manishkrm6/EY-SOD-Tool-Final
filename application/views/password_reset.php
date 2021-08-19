  <!--modal css code start here-->
                         <!--modal css code end here-->
<style>
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
  padding: 3px;padding-left: 5px;padding-bottom: px !important;}

table.dataTable thead .sorting:before, table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:before, table.dataTable thead .sorting_desc_disabled:after {
    position: absolute;
    bottom: 0.3em;
    display: block;
    opacity: 0.3;
}
</style>

<div class="container-fluid">
  <div class="row box">
      <?php
          $msg = '';
          $class = '';
          if($this->session->flashdata('succ'))
          {
              $class = "text-success";
              $msg .= $this->session->flashdata('succ');
          }
          else if($this->session->flashdata('err'))
          {
              $class = "text-pink";
              $msg .= $this->session->flashdata('err');
          }
      ?>
      <br>
      
        <!-- Error Messages -->
          <!-- <div id="msg" class="<?= $class; ?>">
            <?php //echo $msg; ?>
          </div> -->

    <div class="col-sm-10 bg-">
      <!--start code here-->
		
		<!-- Form Reset Start -->
		
			<form method="POST" action="<?= base_url('password-reset'); ?>">
                    <span id="spnCreateClientError" style="color:red; display:none;"></span>

                      <div class="form-group row">
                          <label for="inputPassword3" class="col-sm-3 col-form-label">New Password: </label>
                          <div class="col-sm-7">
                          <input type="text" class="form-control" name="new_password" id="new_password" />
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="inputPassword3" class="col-sm-3 col-form-label">Confirm Password: </label>
                          <div class="col-sm-7">
                          <input type="text" class="form-control" name="confirm_password" id="confirm_password" />
                          </div>
                      </div>


                      <div class="form-group row mt-0">
                        <div class="col-sm-10 offset">
                          <input type="hidden" name="uid" value="<?= $uid; ?>" />
                          <button type="submit" id="btnCreateNewClient" class="font-weight-bold btn btn-light pull-right offset-1 text-dark"style="background-color:#ddd;margin-top: -5px;margin-left:550px">Reset</button>
                        </div>
                      </div>
                    </form>
					
		<!-- Form Reset End -->
     
	 
       

       
       <!--js datatable code end-->
    <!--code-->
    </div><!--div col 10 close-->

    
    <div class="col-sm-2 pr-0">
      <!-- Begin Sidebar -->
 
    
      
    </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->


   