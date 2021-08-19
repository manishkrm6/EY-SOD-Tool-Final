<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSS files -->
    <link href="<?=base_url('assets/dashboard-theme/')?>dist/libs/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/dashboard-theme/')?>dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/dashboard-theme/')?>dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/dashboard-theme/')?>dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/dashboard-theme/')?>dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="<?=base_url('assets/dashboard-theme/')?>dist/css/demo.min.css" rel="stylesheet"/>
    <!--CUSTOM DASHBOARD CSS LINK-->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/dashboard-theme/')?>dashboard.custom.css">
    <!--CUSTOM DASHBOARD CSS LINK END-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> 
    
     <style type="text/css">
      table thead{
    /*    text-align:center;
      }
*/}
      table td{
      /*  text-align:center;*/
      }
     </style>
  </head>
  <body class="antialiased" cz-shortcut-listen="true">
    <div class="page">
    
      <div class="content">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <!-- dashboard title -->               
                <h2 class="page-title">
                  Analysis Dashboard
                </h2>           
              </div>
               <!-- Page link actions start -->
               <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?= base_url(); ?>" class="btn btn-primary">  
                  <i class="fa fa-fw fa-home"></i>               
                    Home
                  </a>
                   <a href="#" onclick="window.history.back();" class="btn btn-primary">  
                   <i class="fa fa-angle-double-left" style="padding-right:5px" ></i>             
                    Back
                  </a>                 
                </div>
              </div><!--page link action close-->
            </div>
          </div>
          <div class="row row-deck row-cards">
             <!--row 1 card1-->
            <div class="col-sm-6 col-lg-3">
                <!--card 1 start -->
              <div class="card dashborder">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">User Analysed</div>
                  </div>
                  <div class="h1 mb-3 text-primary"><?= $total_user_analysed; ?></div>
                  <div class="d-flex mb-2">
                    <div>User in conflicts</div>
                    <div class="ms-auto">
                      <span class="text-dark d-inline-flex align-items-center lh-1">
                        <?= $user_conflicts_percentage; ?>% 
                      </span>
                    </div>
                  </div>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-blue" style="width: <?= $user_conflicts_percentage; ?>%" role="progressbar" aria-valuenow="<?= $user_conflicts_percentage; ?> " aria-valuemin="0" aria-valuemax="<?= $user_conflicts_percentage; ?>">
                      <span class="visually-hidden"><?= $user_conflicts_percentage; ?>%Complete</span>
                    </div>
                  </div>
                </div>
              </div>  
              <!--card close-->
            </div>
            <!--row 1 card1 end-->
            <!--row 1 card2-->
            <div class="col-sm-6 col-lg-3">
                <!--card 1 start -->
              <div class="card dashborder">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Roles Analysed</div>
                  </div>
                  <div class="h1 mb-3 text-primary"><?= $total_role_analysed; ?></div>
                  <div class="d-flex mb-2">
                    <div>Roles in conflicts</div>
                    <div class="ms-auto">
                      <span class="text-dark d-inline-flex align-items-center lh-1">
                        <?= $role_conflicts_percentage; ?>% 
                      </span>
                    </div>
                  </div>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-blue" style="width: <?= $role_conflicts_percentage; ?>%" role="progressbar" aria-valuenow="<?= $role_conflicts_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                      <span class="visually-hidden"><?= $role_conflicts_percentage; ?>% Complete</span>
                    </div>
                  </div>
                </div>
              </div>  
              <!-- card2 close-->
            </div>
            <!--row 1 card2 end-->
          <!--row 1 card3-->
            <div class="col-sm-6 col-lg-3">
                <!--card 3 start -->
              <div class="card dashborder">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Risk Analysed</div>
                  </div>
                  <div class="h1 mb-3 text-primary"><?= $total_risk_analysed; ?></div>
                  <div class="d-flex mb-2">
                    <div>Risks Violated</div>
                    <div class="ms-auto">
                      <span class="text-dark d-inline-flex align-items-center lh-1">
                      <?= $risk_violated_percentage; ?>%
                      </span>
                    </div>
                  </div>
                  <div class="progress progress-sm">
                    <div class="progress-bar bg-blue" style="width: <?= $risk_violated_percentage; ?>%" role="progressbar" aria-valuenow="<?= $risk_violated_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                      <span class="visually-hidden"><?= $risk_violated_percentage; ?>% Complete</span>
                    </div>
                  </div>
                </div>
              </div> 
               <!--row 1 card3 close-->
            </div>
            <!--row 1 card4-->
           <!--row 1 card4-->
            <div class="col-sm-6 col-lg-3">
                <!--card 1 start -->
              <div class="card dashborder">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Conflicts</div>
                  </div>
                  <div class="h1 mb-3 text-primary"><?= $total_conflicts; ?></div>
                  
                  <div class="d-flex mb-2">
                    <div class="ms-auto">
                      <span class="text-dark d-inline-flex align-items-center lh-1">
                        As on <?= $create_datetime; ?>
                      </span>
                    </div>
                  </div>

                </div>
              </div>  <!-- card4 close-->
            </div>
            <!--row 1 card4 end-->

            <!--  ROW 2 START -->
            
            <div class="col-lg-6">
              <div class="row row-cards">
                <div class="col-12">
                  <div class="card">
                    <div class="card-body" style="position: relative;">
                      <h3 class="card-title">Role Conflicts</h3>
                      <!--stacked bar-->                     
                      <figure class="highcharts-figure">
                        <div id="container"></div>

                      </figure>

                     </div>
                  </div>
                </div>
              </div>
            </div>
              <!--card donut start -->                 
            <div class="col-lg-3">             
              <div class="card">
                <div class="card-body">
                <h3>Total Conflicts</h3>
                  <div class="d-flex align-items-center ">
                       <div id="chart-total-sales"></div>
                       <div class="tconflict mt-5" >
                        <i class="fa fa-circle color1 circlesize "></i><span class="textsize">High</span><br>
                        <i class="fa fa-circle color2 circlesize mr-1"></i><span class="textsize">Medium</span><br>
                        <i class="fa fa-circle color3 circlesize mr-1"></i><span class="textsize">Low</span>
                       </div>
                       <!-- <label class="m-3">
                          <span  class="fa fa-circle mb-2 p-1 color1 dashfont"></span>High<br><span class="fa fa-circle mb-2 p-1 color2 dashfont"></span>Medium<br>
                          <span class="fa fa-circle mb-2 p-1 colorex dashfont"></span>Low
                      </label>   -->  
                                                       
                  </div>  
                </div>
              </div>
            </div>  <!--card donut end -->

          <!--   User with SAP_ALL start --> 
             <div class="col-lg-3">
                <!-- ROW 2 card 5 start -->
                <div class="col-lg-12">
                <div class="row">
              <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                  </div>
                  <div class="h1 mb-3 text-primary text-center pb-1"><?= $user_with_sap_all ;?></div>
                  <h3 class="text-center">User with SAP_ALL</h3>                
                </div>
              </div>
              </div>
              </div>
              <div class="row mt-3">
              <div class="col-lg-12">
              <div class="card">                
                <div class="card-body">
                  <div class="d-flex align-items-center">
                  </div>
                  <div class="h1 mb-3 text-primary text-center"><?= $custom_t_code; ?></div>
                  <h3 class="text-center">Custom T-Code</h3>
                </div>
              </div>
            </div>
          </div>
          </div>
            </div>          
          <!--   User with SAP_ALL end -->
             <style type="text/css">
              #myChart4{
                width: 444px!important;
                margin-left:-30px;  
              }
            </style>

            <!--GRAPH START Business Process wise  Conflict-->
            <div class="col-lg-6">
             <div class="card">
               <div class="card-body">
                  <h3 class="card-title">Business Process wise  Conflict</h3>
                  <div class="wrapperchart">
                     <canvas id="myChart4" width="540" height="400" style="display: block;"></canvas>
                  </div>
                  <div class="text-center">
                     <span  class="fa fa-circle mb-2  color1 circlesize"></span>
                     <span class="textsize">High</span>
                      <span class="fa fa-circle mb-2 color2 circlesize"></span>
                      <span class="textsize">Medium</span>
                      <span class="fa fa-circle mb-2 color3 circlesize"></span>
                      <span class="textsize">Low</span>
                   </div>
                      <!--GRAPH END-->
                    </div>
                  </div>
            </div>

           
            <div class="col-lg-6">
              <div class="row row-cards row-deck">

                <!--RISK VOITED START-->
                <div class="col-sm-12">
                   <div class="card">
                    <div class="card-body">
                     <h3 class="card-title">Risk Violated</h3>
                      <div class="progress progress-separated mb-3" style="height:18px;border-radius: 18px">
                        <div class="progress-bar bg-primary" role="progressbar" style="width:  <?= $high_risk_percentage >= 3 ? $high_risk_percentage : 3; ?>%"><?= $risk_violated_high; ?></div>
                        <div class="progress-bar bg-info" role="progressbar" style="width: <?= $medium_risk_percentage >= 3 ? $medium_risk_percentage : 3; ?>%"><?= $risk_violated_medium; ?></div>
                        <div class="progress-bar riskvioted3 " role="progressbar" style="width:<?= $low_risk_percentage >= 3  ? $low_risk_percentage : 3; ?>%;"><?= $risk_violated_low; ?></div>
                        <div class="progress-bar riskvioted4 " role="progressbar" style="width: <?= $no_conflicts_percentage >= 3 ? $no_conflicts_percentage : 3; ?>%;"><?= $no_conflicts; ?></div>
                      </div>
                    
                       <div class="text-center ">
                      <span  class="fa fa-circle circlesize mb-2 color1"></span>
                      <span class="textsize">High</span>
                      <span class="fa fa-circle  circlesize mb-2  color2"></span>
                      <span class="textsize">Medium</span>
                      <span class="fa fa-circle  circlesize mb-2  riskcolor3"></span>
                      <span class="textsize">Low</span>
                      <span class="fa fa-circle circlesize  mb-2  color4"></span>
                      <span class="textsize">No Conflicts</span>
                   </div>
                    </div>                    
                  </div>
                </div>
                 <!--RISK VOITED end-->



                <!-- Top 5 Users in Conflicts START-->
                <div class="col-sm-12">
                  <div class="card">
                  	 <div class="card-header">
                  <h3 class="card-title">Top 5 Users in Conflicts</h3>
                </div>
                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                  <div class="divide-y-4">
                    <div>
                      <div class="row">
                      <!--table Top 5 Risk in Conflicts start-->
                       <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>User id</th>
                              <th>User Name</th>
                              <th class="text-center">Conflicts</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                               if(!empty($top_n_users)){
                                 $sno = 1;
                                 foreach($top_n_users as $key => $val){
                            ?>
                              <tr>
                                  <td><?= $sno++; ?></td>
                                  <td><?= $val['uname']; ?></td>
                                  <td><?= $val['user_name']; ?></td>
                                  <td class="text-center"><?= $val['total_conflicts']; ?></td>
                              </tr>
                            <?php } } ?>
                          </tbody>
                        </table>
                      <!--table Top 5 Risk in Conflicts start-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!--TABLE END CODE-->
          </div>
        </div>
        <!--col6 close-->

        <!--TOP 5 RISK IN CONFLICT CODE START HERE-->
          <div class="col-md-6">
              <div class="card">
              	 <div class="card-header">
                  <h3 class="card-title">  Top 5 Risk in Conflicts</h3>
                </div>
                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                  <div class="divide-y-4">
                    <div>
                      <div class="row">
                      <!--table Top 5 Risk in Conflicts start-->
                       <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Risk ID</th>
                              <th>Risk</th>
                              <th class="text-center">Conflicts</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            <?php
                              if( !empty($top_n_risk)){
                                $sno = 1;
                                foreach($top_n_risk as $key => $val){
                                  //pr($val);
                            ?>
                              <tr>
                              <td><?= $sno++; ?></td>
                              <td><?= $val['RiskID']; ?></td>
                              <td><?= $val['Description']; ?></td>
                              <td class="text-center"><?= $val['No_of_Conflicts']; ?></td>
                            </tr>
                            <?php } } ?>
                          </tbody>
                        </table>
                      <!--table  end-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--TOP 5 RISK IN CONFLICT CODE END HERE-->
               
            <!--TABLE COL 6 R0W LAST Top 5 Roles with Intra-role conflicts START-->
            <div class="col-md-6 col-lg-6">
               <div class="card">
               	 <div class="card-header">
                  <h3 class="card-title">  Top 5 Roles with Role conflicts</h3>
                </div>
                <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                  <div class="divide-y-4">
                    <div>
                      <div class="row">
                      <!--table  start-->
                       <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Role</th>
                              <th>Users</th>
                              <th>Conflicts</th>
                              <th>Total Conflicts</th>
                            </tr>
                          </thead>
                          <tbody>
                            
                            <?php 
                              if(!empty($top_n_roles)){
                                $sno = 1;
                                foreach( $top_n_roles as $key => $val ){
                              ?>
                              <tr>
                              <td><?= $sno++; ?></td>
                              <td><?= $val['role_name']; ?></td>
                              <td class="text-center"><?= $val['no_of_users']; ?></td>
                              <td class="text-center"><?= $val['no_of_conflicts']; ?></td>
                              <td class="text-center"><?= $val['total_conflicts']; ?></td>
                            </tr>
                            <?php } } ?>
                            
                          </tbody>
                        </table>
                      <!--table  END-->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           <!--DIV Top 5 Roles with Intra-role conflicts  END-->        
          </div><!--row close-->
        </div>     
      </div>
    </div>
   
    <!--JS CODE START HERE-->
    <script src="<?=base_url('assets/dashboard-theme/')?>/dist/libs/apexcharts/dist/apexcharts.min.js"></script>

    <script src="<?=base_url('assets/dashboard-theme/')?>/dist/js/trafficbar.min.js"></script>

     <!--VERTICAL STACK GRAPH LINK-->
     <script src="<?=base_url('assets/dashboard-theme/')?>/dist/js/horizontalstack.min.js"></script>
      <!--VERTICAL STACK GRAPH LINK-->
   
    <!-- INTRA ROLE CONFLICT HORIZONTAL STACK CODE START HERE-->
    <script type="text/javascript">
  Highcharts.chart('container', {
  chart: {
    type: 'bar'
  },
  title: {
    text: ''
  },
  xAxis: {
    categories: ['']
  },
  yAxis: {
    min: 0,
    title: {
      text: ''
    }
  },
  legend: {
    reversed: true
  },
  plotOptions: {
    series: {
      stacking: 'normal'
    }
  },
  series: [{
    name: 'Low Severity',
    data: [<?= $intra_low_risk; ?>]
  }, {
    name: 'Medium Severity',
    data: [<?= $intra_medium_risk; ?>]
  }, {
    name: 'High Severity',
    data: [<?= $intra_high_risk; ?>]
  }]
});
</script>
    <!--INTRA ROLE CONFLICT HORIZONTAL STACK CODE END HERE -->
   
<!-- Business Process wise  Conflict VERTICAL STACKED GRAPH START-->
   <script type="text/javascript">
  var ctx = document.getElementById("myChart4").getContext('2d');
  var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["MAT","PRD","CRM","OTC","PTP","HRP","FIN","SRM","BAS"],
    datasets: [{
      label: 'High Severity',
      backgroundColor: "#206bc4",
      data: [<?= $mat_high; ?>, <?= $prd_high; ?>, <?= $crm_high; ?>, <?= $otc_high; ?>, <?= $ptp_high; ?>, <?= $hrp_high; ?>, <?= $fin_high; ?>, <?= $srm_high; ?>, <?= $bas_high; ?>],
    }, {
      label: 'Medium Severity',
      backgroundColor: "#6e9fda",
      data: [<?= $mat_medium; ?>, <?= $prd_medium; ?>, <?= $crm_medium; ?>, <?= $otc_medium; ?>, <?= $ptp_medium; ?>, <?= $hrp_medium; ?>, <?= $fin_medium; ?>, <?= $srm_medium; ?>, <?= $bas_medium; ?>],
    }, {
      label: 'Low Severity',
      backgroundColor: "#c7daf0",
      data: [<?= $mat_low; ?>, <?= $prd_low; ?>, <?= $crm_low; ?>, <?= $otc_low; ?>, <?= $ptp_low; ?>, <?= $hrp_low; ?>, <?= $fin_low; ?>, <?= $srm_low; ?>, <?= $bas_low; ?>],
    },
    ],
  },
options: {
    tooltips: {
      displayColors: true,
      callbacks:{
        mode: 'x',
      },
    },
    scales: {
      xAxes: [{
        stacked: true,
        gridLines: {
          display: false,
        }
      }],
      yAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
        },
        type: 'linear',
      }]
    },
    responsive: true,
    maintainAspectRatio: false,
    legend: { position: '' },
  }
});

</script>
   <!--Business Process wise  Conflict VERTICAL STACKED GRAPH START -->

   <!--TOTAL CONFLICT DONUT CODE JS START HERE-->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        window.ApexCharts && (new ApexCharts(document.getElementById('chart-total-sales'), {
          chart: {
            type: "donut",
            fontFamily: 'inherit',
            width:150,
            height: 150,
            sparkline: {
              enabled: true
            },
            animations: {
              enabled: false
            },
          },
          fill: {
            opacity: 1,
          },
          series: [<?= $high_risk; ?>, <?= $medium_risk; ?>, <?= $low_risk; ?>],
          labels: ["High", "Medium", "Low"],
          grid: {
            strokeDashArray: 4,
          },
          colors: ["#206bc4", "#6e9fd9", "#c7daf0"],
          legend: {
            show: false,
          },
          tooltip: {
            fillSeriesColor: false
          },
        })).render();
      });
      // @formatter:on
    </script>
     <!--TOTAL CONFLICT donut chart js code end--> 