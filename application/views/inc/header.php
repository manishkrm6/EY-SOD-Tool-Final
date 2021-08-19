<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Welcome To i-Audit</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="i-Audit: Indovision Adudit" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon-96x96.png') ?>">
		<!-- App css -->
        <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo base_url('assets/css/bootstrap-material.min.css') ?>" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
		<link href="<?php echo base_url('assets/css/app-material.min.css') ?>" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
		<link href="<?php echo base_url('assets/css/bootstrap-material-dark.min.css') ?>" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
		<link href="<?php echo base_url('assets/css/app-material-dark.min.css') ?>" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />
		<!-- icons -->
        <?php if (isset($_SESSION['uid'])) { ?>
		<link href="<?php echo base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') ?>" rel="stylesheet" type="text/css" />
        <?php } ?>

        <!-- Vendor js -->
            <script src="<?php echo base_url('assets/js/vendor.min.js') ?>"></script>
            <footer class="footer footer-alt" <?php if (isset($_SESSION['uid'])) { ?> style="background-color: #566676;"<?php } ?>>
               <!--  <a href="https://ihrms.indovisionglobal.com/" class="text-white-50" target="_blank">Copyright @ Indovision Services Pvt. Ltd. 2020</a> -->
                <?php if (isset($_SESSION['uid'])) { ?>
                <script src="<?php echo base_url('assets/libs/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.flash.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/libs/datatables.net-select/js/dataTables.select.min.js') ?>"></script>
                <script src="<?php echo base_url('assets/js/pages/datatables.init.js') ?>"></script>

                <!-- Plugins js-->
                <script src="<?php echo base_url('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js'); ?>"></script>

                <!-- Init js-->
                <script src="<?php echo base_url('assets/js/pages/form-wizard.init.js'); ?>"></script>



                <?php } ?>
            </footer>
            <!-- App js -->
            <script src="<?php echo base_url('assets/js/app.min.js') ?>"></script>

    </head>

    <body <?php if (!isset($_SESSION['uid'])) { ?> class="authentication-bg"<?php } ?>>