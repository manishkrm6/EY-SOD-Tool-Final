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
    <h4 class="page-title">SOD Tables List</h4>
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
                            <th class="text-center">Table Name</th>
                            <th class="text-center">Add New</th>
                            <th class="text-center">View List</th>
                            <th class="text-center">Edit List</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($tables)) {
                            $counter = 1;
                            foreach ($tables as $key => $table) { ?>
                                <tr>
                                    <td class="text-center"><?php echo ($counter<10)?'0'.$counter:$counter; $counter++; ?>
                                    </td>
                                    <td><?php echo $table['table_name'] ?></td>
                                    <td class="text-center"><a href="<?php echo base_url('sod/add-new-entry/'.$client_id.'/'.$table['table_name']) ?>"><i class="fa fa-plus"></i></a></td>
                                    <td class="text-center"><a href="<?php echo base_url('sod/view-table-entries/'.$client_id.'/'.$table['table_name']) ?>"><i class="fa fa-list"></i></a></td>
                                    <td class="text-center"><a href="<?php echo base_url('sod/edit-entries/'.$client_id.'/'.$table['table_name']) ?>"><i class="fa fa-edit"></i></a></td>
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