
<form method="POST" action="<?= base_url('client-wizard/'.id_encode($fk_client_id)); ?>" >
        <span id="spnMessage"></span>
        <?php
            $analysis_id = isset($_POST['analysis_id']) ? trim($_POST['analysis_id']) : NULL;
        ?>
        <div class="row form-group">
            <div class="col-3">Select Analysis<span class="float-right">:</span></div>
            <div class="col-3">
                <select id="analysis_id" name="analysis_id" class="form-control">
                    <option value="none">--Select Analysis</option>
                    <?php
                        if(!empty($list_analysis)){
                            foreach ($list_analysis as $key => $value) {
                    ?>
                    <option value="<?= $value['id']; ?>"
                    <?php if( $value['id'] == $analysis_id ) { ?> Selected <?php } ?>
                    ><?= $value['analysis_name']. '( '.$value['db_name'].')'; ?></option>
                    <?php } }  ?>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-9 text-center"><input type="submit" id="dashboard" name="dashboard" value="Submit" class="btn btn-success"></div>
        </div>
</form>

<!-- Start Row -->
<div class="row">
    <!-- Begin Column 1 -->
    <div class="col-lg-6">
        <div class="card-box">
            
            <!-- <h4 class="header-title">Extraction & Statistical Information</h4> -->
            <p>
                <b>Data Extracted On:</b> 18-Nov-2020
            </p>
            <p>
                <b>Total No Of Users:</b> 2682
            </p>
            <p>
                <b>Locked Users:</b> 2008
            </p>
            <p>
                <b>Expired Users:</b> 738
            </p>
            <p>
                <b>Active Users:</b> 670
            </p>
            <p>
                <b>Total No Of Roles:</b> 11319
            </p>
            
            <p>
                <b>Unassigned Roles:</b> 5207
            </p>

            <p>
                <b>Active Roles:</b> 5207
            </p>

            <p>
                <b>No Of Customized Transcation Codes:</b> 5207
            </p>

            <p>
                <b>No Of Rules For Customized Transcation Codes:</b> 5207
            </p>
            
        </div>


    </div> 
    <!-- End Column 1 -->

    <!-- Begin Column 2 -->
    <div class="col-lg-6">
        <div class="card-box">
            
            <!-- <h4 class="header-title">Extraction & Statistical Information</h4> -->
            <p>
                <b>Date Of Analysis:</b> 19-Nov-2020
            </p>
            <p>
                <b>Users Analyzed:</b> 2
            </p>
            <p>
                <b>Roles Analyzed:</b> 64
            </p>
            <p>
                <b>Users Not Logged on to SAP System:</b> 147
            </p>
            <p>
                <b>Users Not Logged on in Last 6 Months:</b> 1444
            </p>
            <p>
                <b>Users who  have not changed password:</b> 0
            </p>
            <p>
                <b>Users who  have not changed password </b>

            </p>
            <p>
                <b> in Last 6 Months:</b> 100
            </p>
            <p>
                <b>Users with SAP_ALL & SAP_NEW Access:</b> 21
            </p>
            <p>
                <b>Users with Card * in S_TCODE:</b> 43
            </p>


        </div>
    </div> 
    <!-- End Column 2 -->

</div>

<!-- End Row -->



