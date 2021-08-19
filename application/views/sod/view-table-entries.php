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
    <h4 class="page-title">View Entries of <?php echo $table_name ?></h4>
    <?php $this->load->view('inc/after-form-submitted'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body indo-overflow">
                    <form action="">
                <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center" style="min-width: 70px">S.No.</th>
                            <?php foreach ($columns as $key => $column) { ?>
                                <th class="text-center"><?php echo $column['Field'] ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($table_data)) {
                            $counter = 1;
                            foreach ($table_data as $key => $table) { ?>
                                <tr>
                                <td class="text-center"><?php echo ($counter<10)?'0'.$counter:$counter; $counter++;  ?></td>
                              <?php foreach ($columns as $key => $column) { ?>
                                <td class="text-center"><?php echo $table[$column['Field']] ?></td>
                            <?php } ?>
                                </tr>
                            <?php }
                        } ?>
                    </tbody>
                </table>
                </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
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

<script type="text/javascript">
    $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>