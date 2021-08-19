<?php $this->load->view('inc/topbar') ?>
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">
                <div class="h-100" data-simplebar>
                    <!-- User box -->
                    <div class="user-box text-center">
                        <img src="<?php echo base_url() ?>/assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                            class="rounded-circle avatar-md">
                        <div class="dropdown">
                            <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                                data-toggle="dropdown">Geneva Kennedy</a>
                            <div class="dropdown-menu user-pro-dropdown">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-user mr-1"></i>
                                    <span>My Account</span>
                                </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-settings mr-1"></i>
                                    <span>Settings</span>
                                </a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="fe-lock mr-1"></i>
                                    <span>Lock Screen</span>
                                </a>
                                <!-- item-->
                                <a href="<?php echo base_url('logout') ?>" class="dropdown-item notify-item">
                                    <i class="fe-log-out mr-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                        <p class="text-muted">Admin Head</p>
                    </div>
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <ul id="side-menu">
                            <li class="menu-title">Navigation</li>
                            <li>
                                <a href="#sidebarDashboards" data-toggle="collapse">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span> Dashboard </span>
                                </a>
                            </li>
                            
                            <!-- Begin Clients -->
                                <li>
                                    <a href="#sidebarClient" data-toggle="collapse" class="" aria-expanded="false">
                                        <i class="fas fa-bezier-curve"></i>
                                        <span> Clients </span>
                                        <span class="menu-arrow"></span>
                                    </a>

                                    <div class="collapse show" id="sidebarClient" style="">
                                        <ul class="nav-second-level">
                                            
                                            <li>
                                                <a href="<?php echo base_url('list-clients'); ?>">
                                                <i class="fas fa-bezier-curve"></i>
                                                <span> Clients List </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <!-- End Clients -->

                            <li>
                                <a href="#sidebarAnalysis" data-toggle="collapse" class="" aria-expanded="false">
                                    <i class="fas fa-chart-pie"></i>
                                    <span> Analysis </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse show" id="sidebarAnalysis" style="">
                                        <ul class="nav-second-level">
                                            
                                            <li>
                                                <a href="<?php echo base_url('create-new-analysis'); ?>">
                                                <i class="fas fa-chart-pie"></i>
                                                <span> Creat Analysis </span>
                                                </a>
                                            </li>

                                           <?php if($_SESSION['fk_user_type'] == ADMIN ){ ?> 
                                            <li>
                                                <a href="<?php echo base_url('list-archived-analysis'); ?>">
                                                <i class="fas fa-trash"></i>
                                                <span> Archived Analysis </span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?php echo base_url('sap/connections-list'); ?>">
                                                <i class="fas fa-plug"></i>
                                                <span> SAP </span>
                                                </a>
                                            </li>
                                            <?php } ?>

                                        </ul>
                                </div>



                                <!-- <a href="<?php echo base_url('create-new-analysis'); ?>">
                                    <i class="fas fa-chart-pie"></i>
                                    <span> Analysis </span>
                                </a> -->

                            </li>

                             <!-- <li>
                                <a href="#sidebarEcommerce" data-toggle="collapse" class="" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    <span> User Management </span>
                                    <span class="menu-arrow"></span>
                                </a>

                                <div class="collapse show" id="sidebarEcommerce" style="">
                                    <ul class="nav-second-level">
                                         <li>
                                            <a href="<?php echo base_url('create-new-user'); ?>">
                                            <i class="fa fa-user"></i>
                                            <span> Add New User </span>
                                            </a>
                                        </li> 
                                        <li>
                                            <a href="<?php echo base_url('user-list/1'); ?>">
                                            <i class="fa fa-list"></i>
                                            <span> Users List </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>  -->

                              <!-- <li>
                                <a href="<?php echo base_url('import-large-text-file'); ?>">
                                    <i class="mdi mdi-view-dashboard-outline"></i>
                                    <span> Import Large File </span>
                                </a>
                            </li>  --> 

                            <!-- <li>
                                <a href="<?php echo base_url('rules-manager/dashboard/1'); ?>">
                                    <i class="mdi mdi-gavel"></i>
                                    <span> Rules Manager </span>
                                </a>
                            </li> -->


                        </ul>
                    </div>
                    <!-- End Sidebar -->
                    <div class="clearfix"></div>
                </div>
                <!-- Sidebar -left -->
            </div>
            <!-- Left Sidebar End -->