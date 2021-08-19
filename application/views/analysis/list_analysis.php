<!-- Begin List Analysis Card -->
    <div class="card">
            <div class="card-body">
            <?php
                $data = []; 
                $data['options'] = $options;
                $this->load->view('generic/action_dropdown',$data);
            ?>
            <h4 class="page-title">List Analysis   </h4>    
            <table id="selection-datatable" class="table dt-responsive nowrap w-100">
            <!-- <table id="datatable-buttons" class="table table-bordered table-striped dt-responsive nowrap w-100"> -->
                <thead>
                    <tr>
                        <th class="text-center" style="min-width: 70px">S.No. <input type="checkbox" name="checkboxall" id="checkAll"></th>
                        <th class="text-center">Analysis Name</th>
                        <th class="text-center">Client Name</th>
                        <th class="text-center">System Type</th>
                        <th class="text-center">Create Date Time</th>
                        <th class="text-center">Upload File</th>
                    </tr>
                </thead>
                <tbody>
                <?php

                    connect_master_db();
                    

                    /*pr($list_databases);
                    die;*/

                    if(!empty($list_analysis)){
                        $counter = 1;

                        //pr($list_analysis); die;

                        foreach ($list_analysis as $key => $value) { 
                            
                            $fk_client_id = isset($value['fk_client_id']) ? $value['fk_client_id'] : NULL;
                            $clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id'=>$fk_client_id));
                            $client_name = isset($clientInfo['client_name']) ? $clientInfo['client_name'] : NULL;



                    ?>
                    <tr>
                        <td class="text-center"><?php echo $counter++;  ?>
                            <input type="checkbox" class="analysis_ids" name="analysis_ids[]" value="<?= $value['id']; ?>">
                        </td>
                        
                        <td> <a href="<?= base_url('analysis-wizard/'.id_encode($value['id'])); ?>"><?php echo $value['analysis_name']; ?></a></td>
                        <td><?= $client_name; ?></td>
                        <td><?= $value['system_type']; ?></td>
                        <td><?= short_date_format_ampm($value['create_datetime']); ?></td>
                        <!-- <td><a href="<?= base_url('import-sql/'.id_encode($value['id'])) ?>">Import SAP DB </a></td> -->
                        <td><a href="<?= base_url('import-files/'.id_encode($value['id'])) ?>">Upload File</a></td>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>          
            </div> <!-- end card body-->
    </div>
<!-- End List Analysis Card --> 

<script>
    $(function(){
        let total_records = '<?= count($list_analysis); ?>';
        if(total_records >= 100){
            $('select[name=selection-datatable_length]').append(`<option value="${total_records}"> 
            ${total_records} </option>`);
        }
    });
</script>

<script>
    $(function(){

        $('#btnAction').on('click',function(){

            let allVals = [];
            let ids = '';
            let action = '';

            $('input:checkbox[class=analysis_ids]:checked').each(function() {
                allVals.push($(this).val());
            });
            ids = allVals.join(", ");
            action = $('#action').val();

            console.log(ids);
            console.log(action);

            url = '<?php echo base_url()."archive-delete-analysis"; ?>';

            if( ids !="" && action != "none" ){
                if(confirm('Are you sure you want to proceed?')){
                    
                    $.ajax({
                        url: url, 
                        type: "POST",  
                        dataType: 'json',
                        data: {ids: ids,action:action},    
                        success: function(response, textStatus, jqXHR)   
                        {
                            location.reload();
                        }, 
                        error: function(xhr, status, error){
                            console.log(xhr.responseText);
                        }
                    });

                }
                else{
                    return false;
                }
                    
            } // End IF
            else{
                alert('Select any Record and Action');
                return false;
            }
            


        });
    });
</script>