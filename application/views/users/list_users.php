<div class="container-fluid">
  <div class="row box">

  


    <div class="col-sm-10 bg-">
      <!--start code here-->
      <div class="col-md-12">
        <?php if($this->session->flashdata('succ')){ ?>
          <div class="alert alert-success">
            <?= $this->session->flashdata('succ'); ?>
          </div>
        <?php } ?>
      </div>
     <!--Add Client code start-->
        <div class="table-toolbar my-3">
           <div class="row">
              

              <div class="col-md-6">
                  <div class="btn-group customgrey ">
                   <!--this  is for Add Client-->
                      <a  data-toggle="modal" data-target="#addclientModal"class="btn bg- eycolor  text-black "> Add User
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
        </div> 
     <!--Add Client code end-->

       <!-- Begin Table -->
       
       <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead class="theadclr">
              <tr>
                 <th class="fontwt"  style="width:65px"><input type="checkbox" name="cb" class="checkAll"><label id="checkAll" checkedStatus="checked" for="checkAll"style="margin-bottom: 0px"></label> S.No.</th>
                  <th style="width: 170px"> User Name</th>
                  <th  style="width: 140px">First Name</th>
                  <th  style="width: 140px">Last Name</th>
                  <th  style="width: 140px">User Type</th>
                  <th  style="width: 140px">Email</th>
                  <th  style="width: 120px">Status</th>
              </tr>
          </thead>

          <tbody>
               <?php 

                  $sn = 1;
                  if(!empty($list_users)){
                    foreach ($list_users as $key => $value) {
                      
                      $fk_user_type = isset($value['fk_user_type']) ? $value['fk_user_type'] : NULL;
                      $ugroupInfo = $this->common_model->get_entry_by_data('user_types',true,array('id' => $fk_user_type));

                      $user_type = isset($ugroupInfo['type']) ? $ugroupInfo['type'] : NULL;


               ?>
               <tr class="p-0" >
                  <td style="padding-top:0px;"><input type="checkbox" id="c14" name="cb"> <label class="pull-left pt-1 pr-3"for="c14"></label>  <?= ($sn<10)?'0'.$sn:$sn ?></td>
                  <td><?= $value['user_name']; ?></td>
                  <td><?= $value['first_name']; ?></td>
                  <td><?= $value['last_name']; ?></td>
                  <td><?= $user_type; ?></td>
                  <td><?= $value['email']; ?></td>
                  <td>Active</td>               
              </tr>
              <?php $sn++; } } ?>
          </tbody>

          <!--table body end-->

       </table>

      <!-- End Table -->

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
  <div class="modal" id="addclientModal">
              <div class="modal-dialog">
                <div class="modal-content">
                
                  <!-- Modal Header -->
                  <div class="modal-header">
                  <p class="modal-title">Add New User</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  
                  <!-- Modal body -->
                  <div class="modal-body">  

                  <div id="errorMessage" style="display:none;" class="alert alert-danger">
                  </div>

                  <form id="formAddNewUser">
                      
                      <!-- First Name -->
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">First Name: </label>
                        <div class="col-sm-7">
                         <input type="text" class="form-control" name="first_name" id="first_name" />
                        </div>
                      </div>

                      <!-- Last Name -->
                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Last Name: </label>
                        <div class="col-sm-7">
                         <input type="text" class="form-control" name="last_name" id="last_name" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Email: </label>
                        <div class="col-sm-7">
                         <input type="email" class="form-control" name="email" id="email" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">User Type: </label>
                        <div class="col-sm-7">
                          <select class="form-control" id="fk_user_type" name="fk_user_type">
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">User Name: </label>
                        <div class="col-sm-7">
                         <input type="text" class="form-control" name="username" id="username" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-3 col-form-label">Password: </label>
                        <div class="col-sm-7">
                         <input type="password" class="form-control" name="password" id="password" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-10 offset-1 ">
                          <button type="submit" class="font-weight-bold btn btn-light pull-right offset-1 text-dark"style="background-color:  #E8E8E8;">Create</button>
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

    $('#formAddNewUser').on('submit', function(e){
      
      e.preventDefault();

      let url = '<?= base_url("add-new-user"); ?>';
      const formData = {
        first_name: $('#first_name').val(),
        last_name: $('#last_name').val(),
        email: $('#email').val(),
        fk_user_type: $('#fk_user_type').val(),
        username: $('#username').val(),
        password: $('#password').val()
      }

      $.ajax({
        url:url,
        method:"POST",
        data:{...formData},
        success: function(response){
          const obj = $.parseJSON(response);
          if(obj['success'] == 0){
            $('#errorMessage').show();
            $('#errorMessage').html(obj['message']);
          } 
          else if(obj["success"] == 1)     {
            window.location.reload();
          }

        },
        error: function(xhr, status, error){
          console.log(xhr.responseText);
        }

      }); // End Ajax Request 

    }); // End On Form Submit

  }); // End Doc Ready

</script>