<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Login Form</title>

    <!-- Icons font CSS-->
    <link href="<?= base_url(); ?>assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url(); ?>assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="<?= base_url(); ?>assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="<?= base_url(); ?>assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="<?= base_url(); ?>assets/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <?php
        $cookie_user_name = get_cookie('el_rem_user_name') !="" ? get_cookie('el_rem_user_name') : NULL; 
        $cookie_password = get_cookie('el_rem_password') !="" ? get_cookie('el_rem_password') : NULL;
    ?>
    <div class="page-wrapper bg-gra-01 p-t-180 p-b-100 font-poppins">
        <div class="wrapper wrapper--w780">
            <div class="card card-3">
                <div class="card-heading"><!-- <p>@ 2020 EY All Rights Reserved Terms Of Use Privacy Statement</p> --></div>
                <div class="card-body">
                    <h2 class="title"></h2>
                    <form method="POST">
                        
                    <?php if( $this->session->flashdata('succ') ){ ?>
                        <div class ="alert alert-success">
                            <?= $this->session->flashdata('succ'); ?>
                         </div>
                    <?php } ?>

                        <?php if( $this->session->flashdata('err') ){ ?>
                         <div class ="alert alert-danger">
                            <?= $this->session->flashdata('err'); ?>
                         </div>
                        <?php } ?>

                        <div class="input-group">
                            <input class="input--style-3" type="text" placeholder="User Name" name="username" value="<?= $cookie_user_name; ?>" id="username" placeholder="User Name" >
                        </div>
                        <div class="input-group">
                            <input class="input--style-3" type="password" value="<?= $cookie_password; ?>" placeholder="Password" id="password" name="password">
                        </div>
                        <div class="p-t-10">
                            <button class="btn btn--pill btn--green" type="submit">Login</button>
                        </div><br>
                        <div class="row">
                             <style type="text/css">input[type="checkbox"] + label:before {
                            border: 1px solid gray;
                            content: "\00a0";
                            display: inline-block;
                            font: 13px/1em sans-serif;
                            height: 13px;
                            vertical-align: top;
							 width: 13px; }
							 .frgtpass:hover{color:yellow!important;
							}
							</style>
                             <input type="checkbox" <?= ($cookie_user_name != NULL) ? "Checked" : NULL ; ?> id="remember" name="remember" style="height: 5px;width:5px">
                    <label class="pull-right pl-2" for="remember" ></label><span style="color:white;padding-left: 6px;margin-top:-1px;font-size: 13px;font-family: arial">Remember Me</span>
                           <label ><a href="#" data-toggle="modal" data-target="#forgot_password_modal" class="pull-right frgtpass" style="color:white;font-size: 13px;margin-left:60px;padding-left:12px">Forgot Password?</a></label>
                        </div><a href="">
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="<?= base_url(); ?>assets/vendor/select2/select2.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/datepicker/moment.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="<?= base_url(); ?>assets/js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->

<!-- Begin Forgot Password Modal pop up -->
    <div id="forgot_password_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <div class="text-center mt-2 mb-4">
                        <a href="javascript:void();" class="text-success">
                            <span><img src="<?= base_url();?>assets/images/pic2.png" alt="" height="80"></span>
                        </a>
                    </div>

                    <form id="formForgotPassword"   class="px-3">
                        <div class="form-group">
                        <label> <strong>Enter Your Email Address to Reset Your Password.</strong> </label>
                        </div>

                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input class="form-control" type="email" id="email" name="email" required="" placeholder="admin@admin.com">
                        </div>

                        <div id ="loader" style="display:none;" class="col-sm-2 offset-10">
                            <div class="spinner-border ml-auto" role="status" aria-hidden="true"></div>
                        </div>
                        
                        <div class="form-group text-center ">
                            <button type="submit" id="submit" class="btn suser grey">Submit</button>
                            <button type="button" onclick="window.location.reload();"class="btn btn-light" data-dismiss="modal">Close</button>
                        </div>

                    </form>

                    <script>
                        $(function(){
                            let url = '<?= base_url("forgot-password"); ?>';
                            $('#formForgotPassword').on('submit', function(e){
                                
                                e.preventDefault();
                                
                                $('#loader').show();
                                $('#submit').hide();

                                $.ajax({
                                    url:url,
                                    method:"POST",
                                    data:{email: $('#email').val()},
                                    success: function(response){
                                        //console.log(response);
                                        var response = $.parseJSON(response);

                                        if(response['success'] == 1){
                                            console.log("Success");
                                            window.location.reload(); 
                                        }
                                            
                                    },
                                    error: function(xhr, status, error){
                                        console.log(xhr.responseText);
                                    }
                                }); // End Ajax Request
                            }); // End Form Submit
                        }); // End Doc Ready
                    </script>

                </div>
            </div><!-- /.modal-content -->
        </div>
    </div>
<!-- End Forgot Password Modal pop up -->