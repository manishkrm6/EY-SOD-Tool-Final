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

<a href="<?php echo base_url('/view-tables-list/'.$client_id) ?>" class="btn btn-warning"><i class="fa fa-chevron-left"></i> Go Back</a>
<h4 class="page-title">Add New Entry In <?php echo $table_name ?></h4>
<?php $this->load->view('inc/after-form-submitted'); ?>
<form class="form-horizontal" method="post" action="">
    <?php foreach ($columns as $key => $column) { ?>
         <div class="form-group row mb-3">
            <label for="<?php echo $column['Field'] ?>" class="col-3 col-form-label"><?php echo ucfirst($column['Field']) ?> <span class="float-right">:</span></label>
            <div class="col-6">
                <input type="text" class="form-control" name="<?php echo $column['Field'] ?>">
            </div>
        </div>
    <?php } ?>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            <input type="submit" class="btn btn-info waves-effect waves-light" name="submit" value="Submit">
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