<div class="container-fluid">
  <div class="row box">
    <div class="col-sm-10 bg-">
      <!--start code here-->

     <!--Add Client code start-->
      <div class="table-toolbar my-3">
         <div class="row">
            <div class="col-md-6">
                <div class="btn-group ">
                 <!--this  is for Add Client-->
                    <a  data-toggle="modal" data-target="#addnewconnectionmodal"class="btn col-lg-12 eycolor  text-dark "> Add New Connection
                      <i class="fa fa-plus"></i>
                     </a>

                     <!--modal css code start here-->
                       <style type="text/css">
                        .modal-header{
                          position: relative;
                          height: 40px;
                        }
                         .modal-header .close{
                            color: ;
                          line-height: 1px; 
                        }

                        .modal-title{
                            color: ;
                          line-height: 10px; 
                          font-weight: 600;
                          font-size: 18px;   
                        }

                    /*@media (min-width: 768px){
                     .modal-dialog {
                      width: 600px;
                      margin: 160px auto;
                  }

                  }*/
                </style>   <!--modal css code end here-->

              

                 </div>
             </div>
          </div>
      </div> <!--Add Client code end-->
       <!--table code start-->
       <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead class="theadclr">
            <tr>
               <th class="fontwt"  style="width:65px"><input type="checkbox" name="cb" class="checkAll"><label id="checkAll" checkedStatus="checked" for="checkAll"style="margin-bottom: 0px"></label> S.No.</th>
                <th style="width: 170px"> Client Name</th>
                <th  style="width: 140px">Connection Name</th>
                <th  style="width: 120px">Ashost</th>
                <th  style="width: 120px">SYSNR</th>
                <th  style="width: 120px">Client</th>
                <th  style="width: 120px">Username</th>
                <th  style="width: 120px">Status</th>
                <th  style="width: 120px">Action</th>
            </tr>
        </thead>
        <tbody>
                      <?php $counter = 1; foreach ($connections as $key => $connection) { ?>
                        <tr>
                          <td><input type="checkbox" name="connection_id[]" value="<?php echo $connection['id'] ?>"> <?php echo ($counter<10)?'0'.$counter:$counter ?></td>
                <td><?php $client_id = $connection['fk_client_id'];
                $client = $this->common_model->get_entry_by_data('clients',true,['id'=>$client_id],'serial_no,client_name');
                echo $client['client_name'].' ('.$client['serial_no'].')';
                 ?></td>
                <td><?php echo $connection['connection_name'] ?></td>
                <td><?php echo $connection['ashost'] ?></td>
                <td><?php echo $connection['sysnr'] ?></td>
                <td><?php echo $connection['client'] ?></td>
                <td><?php echo $connection['user'] ?></td>
                <!--<td><?php echo $connection['gwhost'] ?></td>
                <td><?php echo $connection['gwserv'] ?></td>
                <td><?php echo $connection['mshost'] ?></td>
                <td><?php echo $connection['r3name'] ?></td>
                <td><?php echo $connection['group'] ?></td>
                <td><?php echo $connection['lang'] ?></td>
                <td><?php echo $connection['tsfile'] ?></td> -->
                <td class="text-center"><?php echo $connection['active_inactive'] ?></td>
                <td><a href="<?php echo base_url('sap/edit-connection-details/'.id_encode($connection['id'])) ?>" class="btn btn-info">Edit</a></td>
                <!-- <td><a href="<?php echo base_url('sap/view-connection-details/'.id_encode($connection['id'])) ?>" class="btn btn-success">View</a></td>
                <td><a href="<?php echo base_url('sap/delete-connection/'.id_encode($connection['id'])) ?>" class="btn btn-danger">Delete</a></td> -->
                        </tr>
                      <?php $counter++; } ?>
                    </tbody>
        </table><!--table end-->

       
        <div class="row pull-right mt-5 mb-5">
          <div class="mr-4 ">
          <button class="btn btn- col-lg-12 pull-right eycolor">Create Connection</button></div>
           <div>
          <button class="btn btn- col-lg-12 pull-right float:right mb-5 eycolor mr-3" >Delete Connection</button> </div>
        </div>



        <!--js datatable code-->
       <script type="text/javascript">
            $(document).ready(function() {
            $('#example').DataTable();
        } );
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
                <div class="modal" id="addnewconnectionmodal">
                  <div class="modal-dialog">
                    <div class="modal-content">
                    
                      <!-- Modal Header -->
                      <div class="modal-header">
                      <p class="modal-title">Add Sap Connection</p>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      
                      <!-- Modal body -->
                      <div class="modal-body">  
                      <form>
                          <div class="form-group row">
                            <label for="ab" class="col-sm-4 col-form-label">Client Name: </label>
                            <div class="col-sm-7">
                             <select class="form-control" name="client_id" id="client_id">
                                <option value="none">--Select any Client--</option>
                                <?php if ($clients) {
                                  foreach ($clients as $key => $client) { ?>
                                    <option value="<?php echo $client['id'] ?>"><?php echo $client['client_name'].' ('.$client['serial_no'].')' ?></option>
                                  <?php } }?>
                              </select>
                            </div>
                          </div>

                           <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Connection Name: </label>
                            <div class="col-sm-7">
                              <input type="text" id="connection_name" name="connection_name" value="" class="form-control" required="true">
                            </div>
                          </div>

                            <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">ASHOST: </label>
                            <div class="col-sm-7">
                              <input type="text" id="ashost" name="ashost" value="" class="form-control" required="true">
                            </div>
                          </div>

                            <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">SYSNR: </label>
                            <div class="col-sm-7">
                              <input type="text" id="sysnr" name="sysnr" value="" class="form-control" required="true">
                            </div>
                          </div>

                            <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">CLIENT: </label>
                            <div class="col-sm-7">
                              <input type="text" id="" name="client" value="" class="form-control"required="true">
                            </div>
                          </div>

                            <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">USER: </label>
                            <div class="col-sm-7">
                              <input type="text" id="user" name="user" value="" class="form-control" required="true">
                            </div>
                          </div>

                            <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">PASSWORD: </label>
                            <div class="col-sm-7">
                              <input type="text" id="password" name="password" value="" class="form-control" required="true">
                            </div>
                          </div>

                       <div class="form-group row">
                          
                          </div>
                          <div class="form-group row">
                            <div class="col-sm-10 offset-1 ">
                              <button type="button" id="btnSaveConnection"  class="font-weight-bold col-lg-5 btn btn-light pull-right offset-1 text-dark"style="background-color:  #E8E8E8;">Save Connection</button>
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
			 
       $('#btnSaveConnection').on('click',function(){

           const url = '<?= base_url(); ?>sap/save-new-connection-ajax';
           const client_id = $('#client_id').val();
           const connection_name = $('#connection_name').val();
           const ashost = $('#ashost').val();
           const sysnr = $('#sysnr').val();
           const client = $('#client').val();
           const user = $('#user').val();
           const password = $('#password').val();


           $.ajax({
              
              url: url,
              type: 'POST',
              dataType:'json',
              data:{client_id:client_id,connection_name:connection_name,ashost:ashost,sysnr:sysnr,client:client,user:user,password:password},
              success: function(response)   
              {
                 if(response.success == 1 )
                  window.location.reload();
                /*$('#connectionLoader').hide();
                $('#connectionMesssage').html(response.message);*/
                
                
                console.log(response);
              },
              error: function(xhr, status, error){
                //console.log(xhr.responseText);
              },
            
            }); // End Ajax Block 


       }); // End Save Button Click

		}); // End Document Ready
	</script>

			
			
			