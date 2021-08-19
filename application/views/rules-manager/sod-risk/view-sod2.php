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

     <!--Add Client code start-->
        <div class="table-toolbar my-3">
           <div class="row">
              <div class=" customgrey col-md-12">
                  <div class="btn-group ">
                   <!--this  is for Add Client-->
                   <a href="<?php echo base_url('rules-manager/sod-risk/add-new-sod-risk/'.$client_id) ?>" class="btn btn-info"> Add New
                        <i class="fa fa-plus text-success pr-5"></i>
                       </a>
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
       <!-- Begin Table -->      
       <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead class="theadclr fontwt ">
              <tr>
                 <th class=""  style="width:10%;line-height: 1.1857143;"><input type="checkbox" name="cb" class="checkAll">
                  <label id="checkAll" checkedStatus="checked" for="checkAll" class="m-0 p-0">
                  </label> &nbsp; S.No.</th>
                    <th>riskid </th>
                    <th>act1 </th>
                    <th>act2 </th>
                    <th>act3 </th>
                    <th>bproc </th>
                    <th>riskname </th>
                    <th>dsc </th>
                    <th>rating </th>
                    <th>ctype </th>
                    <th>Status </th>
              </tr>
          </thead>
          <tbody>

          <?php 
            if ( !empty($sod_risk) ) {

                $serial_number = 1;
                foreach ($sod_risk as $key => $risk) { ?>
              <tr class="p-0">
                    
                    <td style="padding-top:px;">
                        <input type="checkbox" name="proc[]" value="<?php echo $risk['riskid'] ?>"><label class="pull-left pt-1 pr-3"for="c14"><?php echo ($serial_number<10)?'0'.$serial_number:$serial_number; $serial_number++; ?></label>
                    </td>
                    <td><?php echo $risk['riskid'] ?></td>
                    <td><?php echo $risk['act1']??'NULL' ?></td>
                    <td><?php echo $risk['act2']??'NULL' ?></td>
                    <td><?php echo $risk['act3']??'NULL' ?></td>
                    <td><?php echo $risk['bproc'] ?></td>
                    <td><?php echo $risk['riskname'] ?></td>
                    <td><?php echo $risk['dsc'] ?></td>
                    <td><?php echo $risk['rating'] ?></td>
                    <td><?php echo $risk['ctype'] ?></td>
                    <td class="text-center"><?php echo($risk['enabled']==1)?'<span class="badge bg-soft-success text-success badge-outline-success">Active</span>':'<span class="badge bg-soft-warning text-warning badge-outline-warning">Inactive</span>'  ?></td>

			   </tr>
              <?php } } ?>
          </tbody>
          <!--table body end-->
       </table><!-- End Table -->

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

<script>
  
  $(function(){

    $('#btnCreateNewClient').on('click',function(){
      
      const client_name = $('#client_name').val();
      const description = $('#description').val();
      const url = '<?php echo base_url("create-new-client"); ?>';

      $('#btnCreateNewClient').hide();
      $('#loader').show();


       $.ajax({
          url: url,
          type: 'POST',
          async: true,  
          dataType:'json',
          data:{client_name:client_name,description:description},
          success: function(response)   
          {
            if(response.success == 1){
              window.location.href= '<?php echo base_url("list-clients"); ?>';
            }
            else{
              $('#loader').hide();
              $('#btnCreateNewClient').show();

              $('#spnCreateClientError').show();
              $('#spnCreateClientError').text(response.message);

            }

          },
          error: function(xhr, status, error){
            console.log(xhr.responseText);
          }
      }); 

    });
  });
</script>