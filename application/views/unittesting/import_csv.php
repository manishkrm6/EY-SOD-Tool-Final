<div class="content-page">
<div class="content">
<!-- Start Content-->
<div class="container-fluid">
<!-- start page title -->
<div class="row">
    
<div class="col-12">
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

    <div class="<?php echo $class; ?>">
        <p> <?php echo $msg; ?></p>
    </div>

    

    <div class="page-title-box">
    <div class="card">
    <div class="card-body">
    <h4 class="page-title">Import CSV</h4>
<form class="form-horizontal" method="post" action="<?php echo base_url().'import-csv'; ?>" enctype="multipart/form-data">
    
    <div class="form-group row mb-3">
        <label for="files" class="col-3 col-form-label">Analysis Name <span class="float-right">:</span></label>
        <div class="col-6">
            <input type="file" class="form-control" name="userfile" >
        </div>
    </div>

    <div class="form-group mb-0 justify-content-end row">
        <div class="col-6">
            <input type="submit" class="btn btn-outline-success btn-rounded waves-effect waves-light" name="submit" value="Submit">
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