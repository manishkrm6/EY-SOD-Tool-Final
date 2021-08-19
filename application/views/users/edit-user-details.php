<div class="content-page">
<div class="content">

<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box">


    <div class="card">
    <div class="card-body">

<a href="<?php echo base_url('/users/users-list/'.$client_id) ?>" class="btn btn-warning"><i class="fas fa-chevron-left"></i> Go Back</a>

 <br>
<br>
<span title="User Name"><strong>User Name:</strong> <?php echo $user['user_name'] ?> </span><br>
<span title="UName"><strong>UName:</strong> <?php echo $user['uname'] ?> </span><br> 


<!-- <h5 class="page-title">Update <span title="User Name">User Name: <?php echo $user['user_name'] ?> UName: <?php echo $user['uname']; ?></span> Details</h5> -->

<form class="form-horizontal" method="post" action="">

     <div class="form-group row">
        <label for="department" class="col-2 col-form-label">Department <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" class="form-control" name="department" value="<?php echo $user['department'] ?>">
        </div>

        <label for="manager_name" class="offset-1 col-2 col-form-label">Manager Name <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" class="form-control" name="manager_name" value="<?php echo $user['manager'] ?>">
        </div>
    </div>

     <div class="form-group row">
        <label for="company_name" class="col-2 col-form-label">Company Name <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" class="form-control" name="company_name" value="<?php echo $user['company'] ?>">
        </div>
    
        <label for="location" class="offset-1  col-2 col-form-label">Location <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" class="form-control" name="location" value="<?php echo $user['location'] ?>">
        </div>
    </div>

      <div class="form-group row">
        <label for="suser" class="col-2 col-form-label">SUser <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="suser" value="<?php echo $user['suser'] ?>">
        </div>

        <label for="shared" class="offset-1 col-2 col-form-label">Shared <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="shared" value="<?php echo $user['shared_id'] ?>">
        </div>
    </div> 

      <div class="form-group row">
        <label for="generic" class="col-2 col-form-label">Generic <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="generic" value="<?php echo $user['generic_id'] ?>">
        </div>

        <label for="locked" class="offset-1 col-2 col-form-label">Locked <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="locked" value="<?php echo $user['lockstatus'] ?>">
        </div>
    </div> 

    <div class="form-group row">
        <label for="user_type" class="col-2 col-form-label">User Type <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="user_type" value="<?php echo $user['user_type'] ?>">
        </div>

        <label for="valid_from" class="offset-1 col-2 col-form-label">Valid From <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="valid_from" value="<?php echo $user['valid_from'] ?>">
        </div>
    </div>

    <div class="form-group row">
        <label for="valid_to" class="col-2 col-form-label">Valid To <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="text" readonly = "readonly" class="form-control" name="valid_to" value="<?php echo $user['valid_to'] ?>">
        </div>

        <label for="enabled" class="offset-1 col-2 col-form-label">Enabled <span class="float-right">:</span></label>
        <div class="col-3">
            <input type="radio" name="enabled" value="1" <?php echo ($user['enabled']==1)?'checked':'' ?>> Yes
            <input type="radio" name="enabled" value="0" <?php echo ($user['enabled']==0)?'checked':'' ?>> No
        </div>
    </div>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            <input type="submit" class="btn btn-info waves-effect waves-light" name="update" value="Submit">
        </div>
    </div>
</form>

</div>  <!-- end card-body -->
</div>
</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->

</div> <!-- container -->

</div> <!-- content -->
</div>