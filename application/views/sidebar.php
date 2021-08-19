 
 <?php 
  $fk_analysis_id = isset($fk_analysis_id) && !empty($fk_analysis_id) ? id_encode($fk_analysis_id) : null;
 ?>

<style type="text/css">
  .sidebar-wrapper{
    top: -43px;
    bottom: 0;
    right: -1;
    position: absolute;
    width: 100%;
    min-height: 576px;
  }

   .sidebar-wrapper .list-group .side__link{
    border-left:5px solid #343a40!important;
  }
/*
  .sidebar-wrapper .list-group .side__link:hover{
    border-left:5px solid #FFE600!important;
  }*/

  .sidebar-wrapper .list-group .active{border-left:5px solid #FFE600!important;}
</style>

 <!-- Begin Sidebar -->
    <div class="bg-dark border-right sidebar-wrapper">
      <div class="list-group list-group-flush" ><!-- <span class="sideline"></span> -->
        <a href="<?= base_url('list-previous-analysis'); ?>" class=" side__link  sidecolor active list-group-item list-group-item-action bg-dark text-white" style="padding-top: 20px">Select Analysis<div class="dropdown-divider dividerheight"></div><!-- <i class="sidel pull-left"></i> --></a>
        <a href="javascript:void(0);" class=" side__link sidecolor list-group-item list-group-item-action bg-dark sidebarcolor text-white">User Details <div class="dropdown-divider dividerheight "></div></a>
        <a href="javascript:void(0);" class="side__link sidecolor list-group-item list-group-item-action bg-dark text-white">Rule Book <div class="dropdown-divider dividerheight"></div></a>
        <a href="javascript:void(0);" class="side__link sidecolor  list-group-item list-group-item-action bg-dark text-white">Manage Conflicts <div class="side__link dropdown-divider dividerheight"></div></a>
        
        <?php if($fk_analysis_id != null) { ?>
        <a href="<?= base_url().'report-dashboard/'.$fk_analysis_id; ?>" class="side__link sidecolor list-group-item list-group-item-action bg-dark text-white">Report<div class="side__link dropdown-divider dividerheight"></div></a>
        <?php } else { ?>
          <a href="javascript:void(0);" class="side__link sidecolor list-group-item list-group-item-action bg-dark text-white">Report<div class="side__link dropdown-divider dividerheight"></div></a>
        <?php } ?>

        <a href="javascript:void(0);" class=" side__link sidecolor list-group-item list-group-item-action bg-dark text-white">Dashboard<div class="side__link dropdown-divider dividerheight"></div></a>
        <a href="javascript:void(0);" class="side__link sidecolor list-group-item list-group-item-action bg-dark text-white ">Mitigations<div class="dropdown-divider dividerheight"></div></a>
      </div>
    </div><!--end sidebar-->


      <!-- ===== LINK ACTIVE  ===== -->
    <script type="text/javascript"> 
      const linkColor = document.querySelectorAll('.side__link')
      function colorLink(){
      linkColor.forEach(l=> l.classList.remove('active'))
      this.classList.add('active')
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink))
    </script>
    <!-- ==== LINK ACTIVE CODE END ==== -->