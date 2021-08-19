
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-10">
      <!--code start-->
        <h4 class="text-center ">List Previous Analysis</h4>
       <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="theadd">
            <tr> 
              <th>S.No</th>
              <th >Analysis Name </th>
              <th >Database</th>
              <th >Client</th>
              <th >Create Date/Time</th>
              <th >Status</th>
              <th >Overall Status</th>
             
            </tr>
          </thead>
          <tbody >
            <?php
              if( !empty($list_analysis) ) {

                $sno = 1;
                foreach ($list_analysis as $key => $value) {

                  $fk_client_id = isset($value['fk_client_id']) ? trim($value['fk_client_id'])  : NULL;
                  $fk_analysis_id = isset($value['id']) ? $value['id'] : NULL;
                  $statusInfo = $this->common_model->get_entry_by_data('analysis_status_history',true,array('fk_analysis_id' => $fk_analysis_id,'is_completed' => 1),'','DESC','id');
                  $fk_status_id = isset($statusInfo['fk_status_id']) ? $statusInfo['fk_status_id'] : NULL;

                  $statusInfo = $this->common_model->get_entry_by_data('master_analysis_status',true,array('id' => $fk_status_id));
                  $label = isset($statusInfo['label']) ? $statusInfo['label'] : NULL;
                  



                  $clientInfo = $this->common_model->get_entry_by_data('clients',true,array('id' => $fk_client_id));
                  $clientName = isset($clientInfo['client_name']) ? trim($clientInfo['client_name']) : NULL;
              ?>
                <tr class="p-0" >
                  <td style="padding-top:0px;"><?= $sno++; ?></td>
                  <td><a href="<?= base_url().'create-new-analysis/'.id_encode($value['id']); ?>"><?= $value['analysis_name']; ?></a> </td>
                  <td><?= $value['db_name']; ?></td>
                  <td><?= $clientName; ?></td>
                  <td><?= short_date_format_ampm($value['create_datetime']); ?></td>
                  <td><?= $label; ?></td>
                  <td>
                      
                      <div class="circle_percent" data-percent="<?= $value['summary']['overall_status']; ?>">
                      <div class="circle_inner">
                        <div class="round_per"></div>
                      </div>
                    </div></td>
                  
                </tr>
            <?php } } ?>
           </tbody>
         </table>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script type="text/javascript">$(".circle_percent").each(function() {
          var $this = $(this),
          $dataV = $this.data("percent"),
          $dataDeg = $dataV * 3.6,
          $round = $this.find(".round_per");
        $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)"); 
        $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
        $this.prop('Counter', 0).animate({Counter: $dataV},
        {
          duration: 2000, 
          easing: 'swing', 
          step: function (now) {
            $this.find(".percent_text").text(Math.floor(now)+"%");
            //$this.find(".percent_text").text(parseFloat(now).toFixed(2)+"%");
          }
         
          });
        if($dataV >= 51){
          $round.css("transform", "rotate(" + 360 + "deg)");
          setTimeout(function(){
            $this.addClass("percent_more");
          },1000);
          setTimeout(function(){
            $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)");
          },1000);
        } 
      });
    </script>


    </div><!--div col 10 close-->
    <div class="col-sm-2" style="padding-right: 0px">
      <!-- Begin Sidebar -->
 
  <?php $this->load->view('Sidebar');?>
      

    </div><!--div col 2 close-->
  </div><!--row close-->
</div><!--container close-->