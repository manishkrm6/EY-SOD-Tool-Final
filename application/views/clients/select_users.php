

 <style>
.accordion {
  background-color: #FFE600;
  color: #444;
  cursor: pointer;
  padding: 8px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
  font-weight: bold;
  text-align: center;
}

.active, .accordion:hover {
  background-color: ;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}
/*
.active:after {
  content: "\2212";
}
*/
.accordionpanel {
  background-color: ;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}

</style>

<style>
.form-control {
    display: block;
    width: 108%;
    margin-top:-3px; 
    margin-left: -5px;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
<style>
.form-controll {
    display: block;
    width: 109%;
    margin-top:-3px; 
    margin-left: -15px;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.padnglft{padding-left:30px;}

.fcc{margin-left:px;}
</style>

<?php
  $fk_analysis_id = isset($analysisInfo['id']) ? $analysisInfo['id'] : NULL;
  $fk_client_id = isset($clientInfo['id']) ? $clientInfo['id'] : NULL;
  $uname = isset($_POST['uname']) ? $_POST['uname'] : NULL;

?>

<?php
    $start_index = isset($_POST['start_index']) ? trim($_POST['start_index']) : null;
    $end_index = isset($_POST['end_index']) ? trim($_POST['end_index']) : null;
    
    $exclude_locked_users = isset($_POST['exclude_locked_users']) && !empty($_POST['exclude_locked_users']) ? "checked"  : "";
		$exclude_expired_users = isset($_POST['exclude_expired_users']) && !empty($_POST['exclude_expired_users']) ? "checked"  : "";
		$exclude_expired_roles = isset($_POST['exclude_expired_roles']) && !empty($_POST['exclude_expired_roles']) ? "checked"  : "";
		$exclude_non_dialog_users = isset($_POST['exclude_non_dialog_users']) && !empty($_POST['exclude_non_dialog_users']) ? "checked"  : "";
    $include_custom_tcode = isset($_POST['include_custom_tcode']) && !empty($_POST['include_custom_tcode']) ? "checked"  : "";    


?>



<div class="container-fluid">
  <div class="row box">
    <div class="col-sm-10 bg-">
      <!--start code here-->
       <h4 class="font-bold font-weight-bold">Select User</h4>
       
<button class="accordion">Filter User List</button>
<div class="accordionpanel">
    <form action="<?= base_url('select-client-users/'.id_encode($fk_analysis_id)); ?>" method="POST" >
        <div class="row">
        
        
         <div class="col filbox">
            <select class="form-control" name="company" >
              <option value="none">--Select any Company--</option>
                <?php 
                  if(!empty($listCompany)){
                    foreach($listCompany as $val){
                ?>
                <option value="<?= $val['company']; ?>"><?= $val['company']; ?></option>
                <?php } } ?>
            </select>
         </div>

         <div class="col filbox">
            <select class="form-controll" name="department" >
              <option value="none">--Select any Department--</option>
                <?php 
                  if(!empty($listDepartment)){
                    foreach($listDepartment as $val){
                ?>
                <option value="<?= $val['department']; ?>"><?= $val['department']; ?></option>
                <?php } } ?>
            </select>
          </div>

           <div class="col  filbox"><label class="pl-2 mt-1 font-weight-normal">Exclude non dialog Users </label>
          <input type="checkbox" id="c3" name="exclude_non_dialog_users" <?= $exclude_non_dialog_users; ?> > <label class="pull-right pt-2" for="c3" ></label></div>

           <div class="col  filbox "><label class="pl-2 mt-1 font-weight-normal">Include Custum T-code</label>
          <input type="checkbox" id="c4" <?= $include_custom_tcode; ?> name="include_custom_tcode"> <label class="pull-right pt-2 pr-3" for="c4" ></label></div>
      </div>
      <div class="row">
        <div class="col  filbox">
            <select class="form-control" name="location" >
              <option value="none">--Select any Location--</option>
                <?php 
                  if(!empty($listLocation)){
                    foreach($listLocation as $val){
                ?>
                <option value="<?= $val['location']; ?>"><?= $val['location']; ?></option>
                <?php } } ?>
            </select>
        </div>

         <div class="col filbox"><label class="pl-2 mt-1 font-weight-normal" for="c5">Exclude expire users</label> 
          
          <input type="checkbox"   id="c6" <?= $exclude_expired_users; ?> name="exclude_expired_users"  > <label class="pull-right pt-2 " for="c6" ></label></div>

           <div class="col  filbox"><label class="pl-2 mt-1 font-weight-normal">Exclude expire role for users</label>
          <input type="checkbox" id="c7" <?= $exclude_expired_roles; ?> name="exclude_expired_roles"> <label class="pull-right pt-2" for="c7" ></label></div>

           <div class="col  filbox"><label class="pl-2 mt-1 font-weight-normal">Exclude locked Users</label>
          <input type="checkbox" id="c8" <?= $exclude_locked_users; ?>  name="exclude_locked_users"> <label class="pull-right pt-2 pr-3" for="c8" ></label></div>
      </div>

      <div class="row mt-1">
        <div class="col-sm-3">
          <div class="form-group">
         <input class="form-controll input-sm  padnglft"  name="uname" value="<?= $uname; ?>" type="text" placeholder="Enter U-Name To Filter">
        </div>
        </div>
		
		 <div class="col-sm-3">
          <div class="form-group">
         <input class="form-controll input-sm fcc "   name="start_index" type="number"  value="<?= $start_index; ?>" placeholder="Start From">
        </div>
        </div>
		
		<div class="col-sm-3">
          <div class="form-group">
         <input class="form-controll input-sm fcc"  name="end_index" type="number" value="<?= $end_index; ?>" placeholder="Start To">
        </div>
        </div>

        <div class="col-sm-3 customgrey">
       <button class="btn btn font-weight-bold " type="submit" style="float: right;">Filter</button>
        </div>
      </div>

        <!--  <div class="col-sm-3">
         <div class="form-group txtsz">
         <input class="form-control input-sm "  name="uname" value="<?= $uname; ?>" type="text" placeholder="Enter U-Name To Filter">
        </div>
      </div>
        <div class="row customgrey">
       <button class="btn btn font-weight-bold  mt-4" type="submit" style="margin-left:285px">Filter</button></div> -->

     </form>
</div>

     <hr class="solid" style=" border-top: 1px solid #bbb;">

<!--  ACCORDATION JS CODE START -->
<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>

<!-- FIRST FORM -->
<form class="form-inline " action = "<?= base_url().'update-client-users/';?>" method="POST" enctype="multipart/form-data">
            <div class="form-group mx-sm-3 mb-3">
              <input type="file" class="form-control" name="userfile" >
              <input type="hidden" name="fk_analysis_id" value="<?= id_encode($fk_analysis_id); ?>" />
            </div>
            <button type="submit" class="btn text-dark lightgry mb-2"name="update_users">Upload</button>
        </form>
         <!-- FIRST FORM END-->


 <!--  ACCORDATION JS CODE END -->
 <!--Radio button -->
    <form action = "<?= base_url().'finalize-users-for-analysis/'.id_encode($fk_analysis_id); ?>" method="POST" >

      <div class="container mb-3" style="margin-left: -20px">
        <div class="col-sm-9">

          <input type="checkbox" name="cb" class="checkAll"><label id="checkAll" checkedStatus="checked" for="checkAll"style="margin-bottom: 0px"><span class="pl-2 mr-5 sufont" >Select All</span></label>

           <input type="checkbox" name="enable_disable" id="enable_all" value="ENABLE_ALL" > <label class="" for="enable_all" ><span class="pl-2 mr-5 sufont">Enable All</span> </label> 

            <input  type="checkbox" id="disable_all" name="enable_disable" value="DISABLE_ALL"> <label class=" pt-2" for="disable_all" ><span class="pl-2 sufont">Disable All</span> </label>

            <span class="text-dark ml-5 sufont"><i class=" text-dark fas fa-user  pr-2"></i>Total Users : <?= $total_users; ?></span>

            <span class="text-dark ml-5 sufont"><i class=" fas fa-user pr-3 eycolorr"></i>Enabled Users : <?= $total_enabled_users; ?></span>
        </div>

        <div class="col-sm-3 customgrey ">
          <button type="submit" class="pull-right bg-info suser ml-3" >Finalize User</button>
        
        </div>
    </div>

  <style>
  #example_wrapper .btn{
    background-color:white!important;
  }
</style>

<style>thead tr th{white-space:nowrap;}</style>
       <!--table code start --> 
       <table id="example" class="table table-striped table-bordered tblee" style="width:100%">
        <thead class="theadclr">
            <tr>
               <th class="fontwt idd"><!-- <input type="checkbox" name="cb" class="checkAll"><label id="checkAll" checkedStatus="checked" for="checkAll"style="margin-bottom: 0px"></label> --></th>
                <th style="width:110px">User Name</th>
                <th class="vf">Valid From</th>
                <th class="vt">Valid To</th>
                <th class="lc">Lock Status</th>
                <th class="ut">User Type</th>
                <th  class="ug">User Group</th>
                <th  class="dt">Department</th>
                <th  class="gi">Generic ID<!-- <i  class="fa fa-0x fa-filter fl"> --></th>
                <th>Enabled</th>
            </tr>
        </thead>
        <tbody >

            <?php 
              if( !empty($list_users) ){ 
                
                $sn = 1;

                foreach($list_users as $userDetail){ 

                  $lock_status = isset($userDetail['lockstatus']) &&  $userDetail['lockstatus'] == 1 ? 'Locked': 'Not Locked';
                  $user_type = isset($userDetail['user_type']) &&  $userDetail['user_type'] == 1 ? 'Dialog': 'Non-Dialog';

                  $valid_from = isset($userDetail['valid_from']) && $userDetail['valid_from'] !="00000000"  ? short_date_format($userDetail['valid_from']) : "00000000";
                  $valid_to = isset($userDetail['valid_to']) && $userDetail['valid_to'] !="00000000"  ? short_date_format($userDetail['valid_to']) : "00000000";
                  

                  $enabled = isset($userDetail['enabled']) ? $userDetail['enabled'] : 0;
                  $enabled = $enabled == 1 ? 'Yes': 'No';

                ?>
                  
                  <tr class="p-0" >
                    <td style="padding-top:6px;"><input type="checkbox" id="c<?php echo $sn+20 ?>" name="uname[]" value="<?= $userDetail['uname']?>"> <label class="pull-left pt-1 pr-2"for="c<?php echo $sn+20 ?>"></label>  <?= ($sn<10)?'0'.$sn:$sn ?></td>
                    <td><?= $userDetail['user_name']; ?></td>
                    <td><?= $valid_from; ?></td>
                    <td><?= $valid_to; ?></td>
                    
                    <td><?= $lock_status; ?></td>
                    <td><?= $user_type; ?></td>
                    <td><?= $userDetail['user_group']; ?></td>
                    <td><?= $userDetail['department']; ?></td>
                    <td><?= $userDetail['generic_id']; ?></td>
                    <td><?= $enabled; ?></td>
                  </tr>

            <?php $sn++;  } } ?>
          </tbody>
        </table>
  </form>

    <!--code-->
    </div><!--div col 10 close-->

    <div class="col-sm-2 pr-0">
      <!-- Begin Sidebar -->
 
  <?php $this->load->view('Sidebar');?>
      

    </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->
          
    
    <script>
      
      function clickEnableAll(){
        $('#enable_all').prop('checked',true);
        $('#disable_all').prop('checked',false);
      }

      function clickDisableAll(){
        $('#disable_all').prop('checked',true);
        $('#enable_all').prop('checked',false);
      }

      $(function(){

        $('#enable_all').on('change', function(){
          clickEnableAll();
        });

        $('#disable_all').on('change', function(){
          clickDisableAll();
        });
      });
    </script>

    <script>

      let isPost = '<?= !empty($_POST) ? 1 : 0 ?>';
      console.log("isPost Value ", isPost);
      $(function(){
         if(isPost == 1)
            $('.accordionpanel').css({'max-height':'137px'});

      });

    </script>

    <script>
      $(function(){
        
        let optionsSet = [200,300,400,500,1000,1500,2000,2500,3000,4000,5000,6000,7000,8000,9000,10000];

        optionsSet.map( (num) => {
          
          $('select[name=example_length]').append(`<option value="${num}"> 
            ${num} </option>`);

        })
        
       /*  if(total_records >= 100){
            
            $('select[name=example_length]').append(`<option value="${total_records}"> 
            ${total_records} </option>`);

        } */

      });
    </script>              

  <script>
    $(function(){
      $('div .xyz').click(function () { 
        
        checkedState = $(this).prop('checked');
        $(this).parent('div').children('.xyz:checked').each(function () {
            console.log("Uncheck Please");
            $(this).prop('checked', false);
        });

        $(this).prop('checked', checkedState);

      });

    });
  </script>

  

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
    </script>




