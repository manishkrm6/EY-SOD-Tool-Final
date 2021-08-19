<!-- Standard modal content -->
    <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('client-wizard/'.id_encode($fk_client_id)); ?>" method="POST" >
                    <div class="modal-header">
                        <h4 class="modal-title" id="standard-modalLabel">Analysis</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                <div class="modal-body">
                   <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Select Company</h4>
                                    <!-- <p class="sub-header">
                                        Custom <code>&lt;select&gt;</code> menus need only a custom class, <code>.custom-select</code> to trigger the custom styles.
                                    </p> -->
                                     <select class="custom-select" name="company">
                                        <option value="none">--Select Company--</option>
                                        <option value="Google">Google</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="Apple Inc.">Apple Inc.</option>
                                    </select>

                                </div> 

                                <div class="col-md-6">
                                    <h4 class="header-title">Select Department</h4>
                                    <select class="custom-select" name="department">
                                        <option value="none">--Select Department--</option>
                                        <option value="HR">HR</option>
                                        <option value="Accountant">Accountant</option>
                                    </select>
                                </div> 
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title">Select Location</h4>
                                    <!-- <p class="sub-header">
                                        Custom <code>&lt;select&gt;</code> menus need only a custom class, <code>.custom-select</code> to trigger the custom styles.
                                    </p> -->
                                     <select class="custom-select" name="location">
                                        <option value="none">--Select Location--</option>
                                        <option value="Pune">Pune</option>
                                        <option value="Hyderabad">Hyderabad</option>
                                    </select>
                                </div> 

                                <div class="col-md-6">
                                    <h4 class="header-title">Select Business Process</h4>
                                    <select class="custom-select" name="business_process">
                                        <option value="none">--Select Business Process--</option>
                                        <option value="HR">HR</option>
                                        <option value="Accountant">Accountant</option>
                                    </select>
                                </div> 
                            </div>
                            
                            <div class="row">
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="inc_expired_users" id="inc_expired_users">
                                            <label class="custom-control-label" for="inc_expired_users">Include Expired Users</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="exc_locked_users" id="exc_locked_users">
                                            <label class="custom-control-label" for="exc_locked_users">Exclude Locked Users</label>
                                        </div> 
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="exc_org_expired_users" id="exc_org_expired_users">
                                            <label class="custom-control-label" for="exc_org_expired_users">Exclude Organization expired Users</label>
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-md-6">

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="exc_expired_role_users" id="exc_expired_role_users">
                                            <label class="custom-control-label" for="exc_expired_role_users">Exclude Expired Roles For Users</label>
                                        </div> 

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="exc_expired_users" id="exc_expired_users">
                                            <label class="custom-control-label" for="exc_expired_users">Exclude Expired Users</label>
                                        </div> 

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="exc_non_dialog_users" id="exc_non_dialog_users">
                                            <label class="custom-control-label" for="exc_non_dialog_users">Exclude Non-Dialog Users</label>
                                        </div> 
                                    </div>
                                 </div>
                            </div>

                        </div> <!-- end card-body-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <input type="hidden" name="fk_client_id" value="<?= id_encode($fk_client_id); ?>" >
                    <input type="hidden" name="finalize_user_for_analysis" value="finalize_user_for_analysis" >

                    <button type="submit" class="btn btn-primary">Finalize</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
