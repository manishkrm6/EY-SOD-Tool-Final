<!DOCTYPE html>
    <html lang="en">

    <!-- BEGIN HEAD -->
    <head>

    <link rel="icon" href="<?= base_url(); ?>assets/images/favicon.png" type="image/png" sizes="16x16">
    <link href="<?= base_url(); ?>assets/css/bootstrap-material.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= base_url(); ?>assets/css/app-material.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />
    <link href="<?= base_url(); ?>assets/css/bootstrap-material-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled />
    <link href="<?= base_url(); ?>assets/css/app-material-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet"  disabled />
    <!-- icons -->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/progresscircle.css">
      
      

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                <link href="<?= base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url(); ?>assets/css/main.css" rel="stylesheet" type="text/css" />

        <!-- Begin Toggle Logout Button -->
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">



          
        <!-- bar chart start -->
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/TableBarChart.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets/js/TableBarChart.js"/></script>
        
  
        <!-- bar chart end start -->

     
        <!-- End Toggle Logout Button -->

        <!-- Base Scripts -->
        <script src="<?= base_url(); ?>assets/js/jquery/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <!-- End Base Scripts -->
    

        <!-- Vendor js -->
       <script src="<?= base_url(); ?>assets/js/vendor.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
        <script src="<?= base_url(); ?>assets/js/loader.js"></script>


        <script src="<?= base_url(); ?>assets/js/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

        <script>
          $(document).ready(function() {
            $.fn.dataTable.ext.errMode = 'throw';

      $('#example').DataTable({
        
        "dom": 'lBfrtip',
        //"dom": 'Bfrtip',
        "buttons": [
        {
            extend: 'collection',
            text: 'Export',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
                'print',
                'colvis'
            ]
        }
      ]
      
      }); 

      });

    </script>

      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
      <script src='https://kit.fontawesome.com/a076d05399.js'></script>

      <!-- </script> -->
      <script src="<?= base_url(); ?>assets/js/progresscircle.js"></script>
      <script type="text/javascript">
        $(function(){

        $('.circlechart').circlechart();

      });
      </script> 


<style type="text/css">
  ol>li{
    border: 1px solid grey;
    padding: 2px;
    margin-bottom: 4px;
  }
</style>

<style type="text/css">
  .navbar-top{background-color: ;
    margin-bottom: 0px;
    border-radius:0px;
    height:40px;
    position: relative}

    .navbar-top ul li h1{color:white; font-family:arial;font-size: 20px; font-weight: 600;
      position: absolute;top:-4px;}
</style>

<style>
.dropbtn {
  background-color: ;
  color: white;
  height:30px;
  font-size: 16px;
  border: none;
  line-height: 50%;
  width:160px;
}

.dropdown {
  position: relative;
  display: inline-block;
  background-color:;
  height:40px;
}

.dropbtn .profile{
  padding-right:11px;
}

.dropbtn .txtclr{
  color: #FFE600;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
  top:40px;
}

.dropdown-content a {
  color: black;
  padding: 5px 5px;
  text-decoration: none;
  /*text-align: center;*/
  display: block;
}



.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #;}


</style>



    <nav class="navbar navbar-top bg-dark navbar-fixed-top">

      <a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/images/ey-logo.png" alt="EY-Logo" style="width:30px;margin-top: -15px"></a>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <h1>EY SoD tool</h1>
            </li>
       </ul> 

       <div class="dropdown">
          <button class="dropbtn"><i class="fas fa-user profile"></i> <span class=" txtclr"></span><i class="fa fa-caret-down"></i></button>
          <div class="dropdown-content">
            <a href="#">My Profile</a>
            <a href="<?= base_url('logout'); ?>">Logout</a>
           
          </div>
        </div>
  </nav>
</head>


<body>
  
    <style>


.secondnav {
  overflow: ;
  background-color: ;
  border-bottom:1px solid grey;
  background-color: 
}

.secondnav a {
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 4px 45px;
  text-decoration: none;
  background-color: ;
  font-size: 15px;
  border-bottom: 3px solid transparent;
}

.secondnav span a:hover {
  border-bottom: 3px solid #FFE600;
}

.secondnav a.active {
  border-bottom: 3px solid #FFE600;

}


  .dropbtnn{
        background-color: ;
        color: black;
        padding: 4px 45px;
       /* padding-left: 10px;*/
        font-size: 15px;     
       }

       .dropbtnn:hover{
        border-bottom: 3px solid #FFE600;
       /* width:80px;*/
       }

      .dropdownn:hover {
        position: relative;
        display: inline-block;
      }


      .dropdown-contentt {
        display: none;
        position: absolute;
        background-color:white;
        min-width:180px;
        left: -10px;
        z-index: 1;
        margin-top: px;
      }

      .dropdown-contentt a {
      /*  color: black;
        text-decoration: none;      
        display: block;
        z-index: 9999;*/

        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        background-color:   #F0F0F0;
        display: block;
        text-align: left;
        border-bottom: 2px solid white;
      }

      .dropdown-contentt a:hover {background-color: #ddd;
        border-left: 3px solid #FFE600;
         margin-top:1px; 
        border-top:2px solid transparent;


        }

      .dropbtnn:hover + .dropdown-contentt, .dropdown-contentt:hover {display: block;}

      /*.secondnav .dropdown-data{
        display: none;
      }*/

      .secondnav .drophover{
        position: relative;
        display: block;
      }

        .dropdown-data {
        display: none;
        position: absolute;
        background-color:white;
        min-width:180px;
        left: -30px;
        z-index: 1;
      }

      .dropdown-data:hover {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        background-color:   #F0F0F0;
        display: block;
        text-align: left;
        border-bottom: 2px solid white;
      }


</style>
</head>
<body>
<div class="secondnav  mb-3 " style="height: 32px">

  <?php
    if( !empty($breadcrumb) ){
      foreach($breadcrumb as $key => $val){
        if( $val['link'] ){ ?>
          <span><a class="<?= $val['class']; ?>" href="<?= $val['link']; ?>" > <?= $val['text']; ?></a></span>
    <?php }
          else{ ?>
          <span><a class="<?= $val['class']; ?>" href="" ><?= $val['text']; ?></a></span>
    <?php }  ?>

  <?php } } ?>

 <!-- <span> <a href="#contact " class="drophover">Admin <i class="fa fa-caret-down"></i>
 <div class="dropdown-data">
    <a href="#">Create Client</a>
    <a href="#">Create User</a>
    <a href="#">Manage Licence</a>
  </div>
 </a></span> -->


  <div class="dropdownn">
    <button class="dropbtnn">Admin <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-contentt">
      <a href="<?= base_url('list-clients'); ?>">Clients</a>
        <a href="<?= base_url('sap/connections-list')?>">Sap Connection</a>
      <a href="<?= base_url('users-list'); ?>">Users</a>
      <a href="#">Manage Licence</a>
    </div>
  </div>

</div>




  
    <!-- BEGIN PAGE CONTENT INNER -->

    <?php $this->load->view($part_name); ?>

    <!-- END PAGE CONTENT INNER -->

</body>
</html>