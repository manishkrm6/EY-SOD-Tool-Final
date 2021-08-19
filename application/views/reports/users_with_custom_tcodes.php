  <!--modal css code start here-->
  <!--modal css code end here-->
<style>
  #example_wrapper .btn{
    background-color:white!important;
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

     <!--Add Client code start-->
        <div class="table-toolbar my-3">
           <div class="row">
              <div class=" customgrey col-md-12">
                  <div class="btn-group ">
                   <!--this  is for Add Client-->
                      <!-- <a  data-toggle="modal" data-target="#addclientModal"class="btn col-sm-10 font-weight-bold "> Add Client 
                        <i class="fa fa-plus text-success pr-5"></i>
                       </a> -->
                   </div>
                    <div class="btn-group ">
                   <!--this  is for Add Client-->
                      <!-- <a class="btn col-sm-10 font-weight-bold  "> Delete Client 
                        <i class="fa fa-trash text-danger pr-5"></i>
                       </a> -->
                   </div>
               </div>
            </div>
        </div> 
     <!--Add Client delete client code end-->
      <div style="overflow-x:auto;">          
       <!-- Begin Table -->      
       <table id="example" class="table table-striped table-bordered" style="overflow:auto">
          <thead class="theadclr fontwt" style="white-space:nowrap!important;overflow:auto!important">
          
              <tr>
                 <th>S.No.</th>
                  <th> User ID</th>
                  <th>User Name</th>
                  <th>Valid To</th>
                  <th>Lock Status</th>
                  <th>User Type</th>
                  <th>TCode</th>
              </tr>
          </thead>
          <tbody>
               <?php 

                  $sn = 1;
                  if(!empty($list)){
                    foreach ($list as $key => $value) {
               ?>
               <tr class="p-0" >
                  <td style="padding-top:px;">
                    <!-- <input type="checkbox" id="c14" name="cb"> --> 
                    <label class="pull-left pt-1 pr-3"for="c14"></label> <?=($sn<10)?'0'.$sn:$sn ?></td>
                  <td><?= $value['uname']; ?></td>
                  <td><?= $value['user_name']; ?></td>
                  <td><?= $value['valid_to']; ?></td>
                  <td><?= $value['lockstatus']; ?></td>
                  <td><?= $value['user_type']; ?></td>
                  <td><?= $value['tcode']; ?></td>
              </tr>
              <?php $sn++; } } ?>
          </tbody>
          <!--table body end-->
       </table><!-- End Table -->
     </div>

        <!--js datatable code-->
       <script type="text/javascript">
            $(document).ready(function() {
              $('#example').DataTable();
            });
      </script> 
       <!--js datatable code end-->
    <!--code-->
    </div><!--div col 10 close-->

     <!--js checkbox code-->
    <script type="text/javascript">
        $("#checkAll").click(function () {

          if ($(".checkAll").is(":checked")){
            $('.checkAll').removeAttr('checked');
              $("table tr td input[type='checkbox']").each(function() {
              this.checked = false;
            });

            } else {
              $('.checkAll').attr('checked','true');
              $("table tr td input[type='checkbox']").each(function() {
              this.checked = true;
            });
          }
      });
    </script> <!--js checkbox code end-->

    <div class="col-sm-2 pr-0">
      <!-- Begin Sidebar -->
 
    <?php $this->load->view('Sidebar');?>
      
    </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->


    <!-- Enter analysis detail popup create analysis Modal -->
  <div class="modal" id="addclientModal">
              <div class="modal-dialog">
                <div class="modal-content">
                
                  <!-- Modal Header -->
                  <div class="modal-header">
                  <p class="modal-title">Add New Client</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  
                  <!-- Modal body -->
                  <div class="modal-body">  
                    
                    <form method="POST" action="<?= base_url('create-new-client'); ?>">

                    <span id="spnCreateClientError" style="color:red; display:none;"></span>

                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Client Name: </label>
                        <div class="col-sm-7">
                         <input type="text" class="form-control" name="client_name" id="client_name" />
                        </div>
                      </div>

                    <div class="form-group row">
                    <label for="sel1" class="col-sm-3 col-form-label">Description:</label>
                     <div class="col-sm-7 ">
                       <textarea class="form-control" rows="2" id="description" name="description"></textarea>
                  </div>
                  </div>

                   <div class="form-group row">
                      
                   <div id ="loader" style="display:none;" class="col-sm-2 offset-10">
                      <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                   </div>


                      <!-- <div class="col-sm-11">
                        <div class="progress mb-0" style="border-radius: 10px; background-color:#E8E8E8">
                          <div class="progress-bar bg-success" style="width:25%">25%</div>
                        </div>
                      </div> -->

                      </div>
                      <div class="form-group row mt-0">
                        <div class="col-sm-10 offset-">
                          <button type="button" id="btnCreateNewClient" class="font-weight-bold btn btn-light pull-right offset-1 text-dark"style="background-color:#ddd;margin-top: -5px">Create</button>
                        </div>
                      </div>
                    </form>
                  </div> 
                </div>
              </div>
  </div>
<!--end code of create analysis popup-->



