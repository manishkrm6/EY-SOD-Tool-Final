<!-- Create New Analysis -->

<script>
  
  $(function(){

    var intervalForCreateAnalysis = null;
    
    $('#btnCreateNewAnalysis').on('click',function(){
      
      $('#btnCreateNewAnalysis').hide();
      
      const analysis_name = $('#analysis_name').val();
      const fk_client_id = $('#fk_client_id').val();
      const system_type = $('#system_type').val();
      const url = '<?= base_url("create-new-analysis-detail");?>';
          
      $.ajax({
          url: url,
          type: 'POST',
          async: false,  
          dataType:'json',
          data:{analysis_name:analysis_name,fk_client_id:fk_client_id,system_type:system_type},
          success: function(response)   
          {
            
                if(response.success == 0){
                    
                    $('#spnAnalysisError').show();
                    $('#spnAnalysisError').text(response.message);
                    $('#btnCreateNewAnalysis').show();
                }
                else{

                      $('#db3CreationStatus').show();
                
                      let fk_analysis_id = response.fk_analysis_id;
                      let redirect_url = response.redirect_url;

                      // Ajax That Tells Node to generate DB3 Schema & Import DB2 into DB3
                      $.ajax({

                          url: 'http://localhost:3001/createNewAnalysis?fk_analysis_id='+fk_analysis_id,
                          type: 'GET',
                          async: true,  
                          dataType:'jsonp',
                          success: function(response){

                          }, 
                          error: function(xhr, status, error){
                            console.log(xhr.responseText);
                          }
                      });

                      // Ajax That Regularly Fetch Status which is thrown by Node 
                      intervalForCreateAnalysis =  setInterval( function(){

                        $.ajax({
                          
                          url: 'http://localhost:3001/createNewAnalysis/getStatus?fk_analysis_id='+fk_analysis_id,
                          type: 'GET',
                          async: true,  
                          dataType:'jsonp',
                          success: function(response){
                            //console.log(response);
                            let overall_status_html = '<div class="progress-bar bg-success" style="width: '+response.progress+'%;" >'+response.progress+'%</div>';
                            $('#db3CreationStatus').html(overall_status_html);

                            if(response.progress == 100){
                              clearInterval(intervalForCreateAnalysis);
                              window.location.href=redirect_url;

                            }
                              
                          }, 
                          error: function(xhr, status, error){
                            console.log(xhr.responseText);
                          }
                        });


                      },1000);


              } // End Else


          }, // End Outer Ajax Success
          error: function(xhr, status, error){
              
              $('#spnAnalysisError').show();
              $('#spnAnalysisError').text(xhr.responseText);
              $('#btnCreateNewAnalysis').show();
            
          }

        }); // End Outer Ajax


      }); // End Block On Click Create New Analysis Btn

    }); // End Doc Ready
  </script>

  <!-- Script for Circles in Progress -->
  <script>
    $(".circle_percent").each(function() {

        var $this = $(this),
        $dataV = $this.data("percentage"),
        $dataDeg = $dataV * 3.6,
        $round = $this.find(".round_per");

        $round.css("transform", "rotate(" + parseInt($dataDeg + 180) + "deg)"); 
        $this.append('<div class="circle_inbox"><span class="percent_text"></span></div>');
        $this.prop('Counter', 0).animate({Counter: $dataV},
        {
          duration: 2000, 
          easing: 'swing', 
          step: function (now) {
                $this.find(".percent_text").text(Math.ceil(now)+"%");
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

  <script>
    $("input:checkbox").click(function() { return false; });
  </script>

  <!-- Script for Run Analysis -->
  
  <script>

    $(function(){
      
      var refreshIntervalId = null;

      $('#btnStopAnalysis').on('click',function(){
        
        
        $('#divStopAnalysis').hide();
        clearInterval(refreshIntervalId);
        $('#loader').show();
        $('#proc_message').html("Aborting Runing Process...");


        let pid = $(this).attr('data-pid');
        

        $.ajax({
          url: 'http://localhost:3000/killAnalysis?pid='+pid, 
          type: 'GET',  
          dataType: 'jsonp',
          async:false,
          success: function(response)   
          {
            if(response.status == 1){
              
              //$('#loader').hide();
              //$('#proc_message').html("Analysis has been Stopped...");
              //$('#divStartAnalysis').show();

            }

          },
          error: function(xhr, status, error){
            console.log(xhr.responseText);
          }

        }); // End Ajax

      }); // End on Stop Analysis Click

      $('#start_analysis').on('click',function(){

        let fk_analysis_id = $(this).attr('data-fk_analysis_id');
        let url = '<?= base_url("run-analysis"); ?>';

        $('#chbx_start_analysis').attr('checked',true);

        // Show Loader
        //$('#divStartAnalysis').hide();
        //$('#loader').show();

        $.ajax({
          
          url: 'http://localhost:3001/runNodeAnalysis?fk_analysis_id='+fk_analysis_id,
          type: 'GET',  
          dataType: 'jsonp',
          async:true,
          success: function(response)   
          {
            //console.log(response.elapsed_time);
            //$('#time_elapsed').text(response.elapsed_time);
          },
          error: function(xhr, status, error){
            //console.log(xhr.responseText);
          }

        });


        refreshIntervalId =  setInterval( function(){
          
          // To be deleted
          //clearInterval(refreshIntervalId);

          $.ajax({

              url: 'http://localhost:3001/getStatus?analysis_id=<?= $fk_analysis_id; ?>', 
              type: 'GET',  
              dataType: 'jsonp',
              success: function(response)   
              {
                
                console.log(response);

                if( ! response.shouldRequestForProgress )
                  clearInterval(refreshIntervalId);
                  
                if(response.message !== "Failed"){

                  if( response.progress_summary.chbx_start_analysis === 1){
                      //$('#loader').hide();
                      //$('#divStopAnalysis').show();
                      $('#chbx_start_analysis').attr('checked',true);
                  } 
                  if( response.progress_summary.chbx_analysis_prep === 1)
                    $('#chbx_analysis_prep').attr('checked',true);
                  if( response.progress_summary.chbx_role_analysis === 1)
                    $('#chbx_role_analysis').attr('checked',true);
                  if( response.progress_summary.chbx_user_analysis === 1)
                    $('#chbx_user_analysis').attr('checked',true);
                  if( response.progress_summary.chbx_root_cause_analysis === 1)
                    $('#chbx_root_cause_analysis').attr('checked',true);
                  if( response.progress_summary.chbx_dashbaord === 1)
                    $('#chbx_dashbaord').attr('checked',true);
                  if( response.progress_summary.chbx_reports === 1)
                    $('#chbx_reports').attr('checked',true);

                  console.log(response.progress_summary);

                    $('#time_elapsed').html(response.elapsed_time);
                    $('#role_build').html(response.total_role_build);
                    $('#role_analysed').html(response.total_rcompleted);
                    $('#users_analysed').html(response.total_ucompleted);
                    $('#rconflicts').html(response.total_rconflicts);
                    $('#uconflicts').html(response.total_uconflicts);
                    $('#proc_message').html(response.proc_message);
                  
                    $('#extract_status .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.extract_status+',100');
                    $('#extract_status .circle-chart__percent').text(response.progress_summary.extract_status+"%");

                    $('#configure_status .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.configure_status+',100');
                    $('#configure_status .circle-chart__percent').text(response.progress_summary.configure_status+"%");

                    $('#analysis_status .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.analysis_status+',100');
                    $('#analysis_status .circle-chart__percent').text(response.progress_summary.analysis_status+"%");

                    $('#status_all_reports .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.status_all_reports+',100');
                    $('#status_all_reports .circle-chart__percent').text(response.progress_summary.status_all_reports+"%");

                    //$('#extract_status').data('percentage',response.progress_summary.extract_status);
                    //$('#configure_status').data('percentage',response.progress_summary.configure_status);
                    //$('#analysis_status').data('percentage',response.progress_summary.analysis_status);
                    //$('#status_all_reports').data('percentage',response.progress_summary.status_all_reports);

                    let overall_status_html = '<div class="progress-bar bg-success barr" style="width: '+response.progress_summary.overall_status+'%;" >'+response.progress_summary.overall_status+'%</div>';
                  
                    $('#overall_status').html(overall_status_html);

                    if( response.progress_summary.chbx_dashbaord === 1){
                        clearInterval(refreshIntervalId);
                    }

                    



                } // End IF

              },
              error: function(xhr, status, error){
                console.log(xhr.responseText);
              }
            
              }); // End Ajax

           }, 500 ); // End Set Interval

        /*$.ajax({
          
          url: url,
          type: 'POST',  
          dataType: 'json',
          async:true,
          data: { analysis_id: fk_analysis_id,instruction_index:0 },
          success: function(response)   
          {
            //console.log(response.elapsed_time);
            //$('#time_elapsed').text(response.elapsed_time);
          },
          error: function(xhr, status, error){
            console.log(xhr.responseText);
          }
        
          }); //*/
          
      }); // End ON Button Click
      
      

      refreshIntervalId =  setInterval( function(){
          
          // To be deleted
          //clearInterval(refreshIntervalId);

          $.ajax({

              url: 'http://localhost:3001/getStatus?analysis_id=<?= $fk_analysis_id; ?>', 
              type: 'GET',  
              dataType: 'jsonp',
              success: function(response)   
              {
                
                console.log(response);

                if( ! response.shouldRequestForProgress )
                  clearInterval(refreshIntervalId);
                  
                if(response.message !== "Failed"){

                  if( response.progress_summary.chbx_start_analysis === 1){
                      //$('#loader').hide();
                      //$('#divStopAnalysis').show();
                      $('#chbx_start_analysis').attr('checked',true);
                  } 
                  if( response.progress_summary.chbx_analysis_prep === 1)
                    $('#chbx_analysis_prep').attr('checked',true);
                  if( response.progress_summary.chbx_role_analysis === 1)
                    $('#chbx_role_analysis').attr('checked',true);
                  if( response.progress_summary.chbx_user_analysis === 1)
                    $('#chbx_user_analysis').attr('checked',true);
                  if( response.progress_summary.chbx_root_cause_analysis === 1)
                    $('#chbx_root_cause_analysis').attr('checked',true);
                  if( response.progress_summary.chbx_dashbaord === 1)
                    $('#chbx_dashbaord').attr('checked',true);
                  if( response.progress_summary.chbx_reports === 1)
                    $('#chbx_reports').attr('checked',true);

                  console.log(response.progress_summary);

                    $('#time_elapsed').html(response.elapsed_time);
                    $('#role_build').html(response.total_role_build);
                    $('#role_analysed').html(response.total_rcompleted);
                    $('#users_analysed').html(response.total_ucompleted);
                    $('#rconflicts').html(response.total_rconflicts);
                    $('#uconflicts').html(response.total_uconflicts);
                    $('#proc_message').html(response.proc_message);
                  
                    $('#extract_status .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.extract_status+',100');
                    $('#extract_status .circle-chart__percent').text(response.progress_summary.extract_status+"%");

                    $('#configure_status .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.configure_status+',100');
                    $('#configure_status .circle-chart__percent').text(response.progress_summary.configure_status+"%");

                    $('#analysis_status .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.analysis_status+',100');
                    $('#analysis_status .circle-chart__percent').text(response.progress_summary.analysis_status+"%");

                    $('#status_all_reports .circle-chart__circle').attr('stroke-dasharray',response.progress_summary.status_all_reports+',100');
                    $('#status_all_reports .circle-chart__percent').text(response.progress_summary.status_all_reports+"%");

                    //$('#extract_status').data('percentage',response.progress_summary.extract_status);
                    //$('#configure_status').data('percentage',response.progress_summary.configure_status);
                    //$('#analysis_status').data('percentage',response.progress_summary.analysis_status);
                    //$('#status_all_reports').data('percentage',response.progress_summary.status_all_reports);

                    let overall_status_html = '<div class="progress-bar bg-success barr" style="width: '+response.progress_summary.overall_status+'%;" >'+response.progress_summary.overall_status+'%</div>';
                  
                    $('#overall_status').html(overall_status_html);

                    if( response.progress_summary.chbx_dashbaord === 1){
                        clearInterval(refreshIntervalId);
                    }

                } // End IF

              },
              error: function(xhr, status, error){
                console.log(xhr.responseText);
              }
            
              }); // End Ajax

           }, 500 ); // End Set Interval


    }); // End Document Ready Fn

  </script>

