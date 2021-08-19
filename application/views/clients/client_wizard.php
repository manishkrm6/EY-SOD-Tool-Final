<?php
    $client_name = isset($client_info['client_name']) ? $client_info['client_name'] : NULL;
    $fk_client_id = isset($client_info['id']) ? $client_info['id'] : NULL;
?>
<!-- Start Content Page-->
<div class="content-page">
    <!-- Start Content-->    
    <div class="content">
        <!-- Start Container Fluid -->
        <div class="container-fluid">
            <!-- Start Row -->
            <div class="row">
                <!-- Start Col 12 -->
                <div class="col-12">
                    <!-- Start Page Title Box -->
                     <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="<?= base_url('list-clients'); ?>">Clients List</a></li>
                                    <li class="breadcrumb-item active">Manage Client</li>
                            </ol> 
                        </div>
                        <h4 class="page-title"><?= $client_name; ?></h4>
                      </div>
                      <!-- End Page Title Box -->
                        
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <form>
                                            <div id="basicwizard_not_in_use">

                                                <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-4">
                                                    <li class="nav-item">
                                                        <a href="#tab_rule_manager" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 <?= ( $tab_active == 'tab_rule_manager' ? 'active' : '' ); ?> "> 
                                                            <i class="mdi mdi-account-circle mr-1"></i>
                                                            <span class="d-none d-sm-inline">Rule Manager</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tab_users_list" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 <?= ( $tab_active == 'tab_users_list' ? 'active' : '' ); ?>">
                                                            <i class="mdi mdi-face-profile mr-1"></i>
                                                            <span class="d-none d-sm-inline">Users List</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tab_users_for_analysis" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 <?= ( $tab_active == 'tab_users_for_analysis' ? 'active' : '' ); ?>">
                                                            <i class="mdi mdi-face-profile mr-1"></i>
                                                            <span class="d-none d-sm-inline">Users For Analysis</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tab_dashboard" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 <?= ( $tab_active == 'tab_dashboard' ? 'active' : '' ); ?>">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                                            <span class="d-none d-sm-inline">Dashboard</span>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#tab_reports" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2 <?= ( $tab_active == 'tab_reports' ? 'active' : '' ); ?>">
                                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                                            <span class="d-none d-sm-inline">Reports</span>
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content b-0 mb-0 pt-0">
                                                    
                                                    <div class="tab-pane <?= ( $tab_active == 'tab_rule_manager' ? 'active' : '' ); ?>" id="tab_rule_manager">
                                                        <?php
                                                         $data = [];
                                                         $data['fk_client_id'] = $fk_client_id;
                                                         $data['clients'] = $clients;
                                                         $this->load->view('clients/wizard/rule_manager',$data); 
                                                        ?>
                                                    </div>


                                                    <div class="tab-pane <?= ( $tab_active == 'tab_users_list' ? 'active' : '' ); ?> " id="tab_users_list">
                                                        <?php
                                                        $data = [];
                                                        $data['fk_client_id'] = $fk_client_id;
                                                        $data['fk_analysis_id'] = $fk_analysis_id;
                                                        $data['list_client_users'] = $list_client_users; 
                                                        //pr($data); die;

                                                        $this->load->view('clients/wizard/client_user_list',$data); 
                                                        ?>
                                                    </div>

                                                    <div class="tab-pane <?= ( $tab_active == 'tab_users_for_analysis' ? 'active' : '' ); ?>" id="tab_users_for_analysis">
                                                        <?php
                                                        $data = [];
                                                        $data['list_tab_users'] = $user_list_for_analysis;
                                                        $this->load->view('clients/wizard/users_for_analysis',$data); 
                                                        ?>
                                                    </div>

                                                    <div class="tab-pane <?= ( $tab_active == 'tab_dashboard' ? 'active' : '' ); ?>" id="tab_dashboard">
                                                        <?php
                                                        $data = [];
                                                        $data['client_id'] = $fk_client_id;
                                                        //$data['list_analysis'] = $list_analysis;
                                                        $this->load->view('clients/wizard/dashboard',$data); 
                                                        ?>
                                                    </div>

                                                    <div class="tab-pane <?= ( $tab_active == 'tab_reports' ? 'active' : '' ); ?>" id="tab_reports">
                                                        <?php
                                                        $data = [];
                                                        $data['client_id'] = $fk_client_id;
                                                        $this->load->view('clients/wizard/reports',$data); 
                                                        ?>
                                                    </div>

                                                    <ul class="list-inline wizard mb-0">
                                                        <li class="previous list-inline-item disabled">
                                                            <a href="javascript: void(0);" class="btn btn-secondary">Previous</a>
                                                        </li>
                                                        <li class="next list-inline-item float-right">
                                                            <a href="javascript: void(0);" class="btn btn-secondary">Next</a>
                                                        </li>
                                                    </ul>

                                                </div> <!-- tab-content -->
                                            </div> <!-- end #basicwizard-->
                                        </form>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                     
                </div>
                <!-- End Col 12 -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Container Fluid -->
    </div>
    <!-- End Content -->
</div>
<!-- End Content Page -->







