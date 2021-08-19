<form method="POST" action="<?= base_url('run-analysis'); ?>" >
        <span id="spnMessage"></span>
        
        <div class="row form-group">
            <div class="col-3">Select Analysis<span class="float-right">:</span></div>
            <div class="col-3">
                <select id="analysis_id" name="analysis_id" class="form-control">
                    <option value="none">--Select Analysis</option>
                    <?php
                        if(!empty($list_analysis)){
                            foreach ($list_analysis as $key => $value) {
                    ?>
                    <option value="<?= $value['id']; ?>"><?= $value['analysis_name']. '( '.$value['db_name'].')'; ?></option>
                    <?php } }  ?>
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-9 text-center"><input type="button" id="reportAnalysis" name="submit" value="Run Analysis" class="btn btn-success"></div>
        </div>
</form>