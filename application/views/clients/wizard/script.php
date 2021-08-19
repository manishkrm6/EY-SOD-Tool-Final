<script>

    var instruction_index = 0;
    var status = '';
    var analysis_id = '';
    var url = '<?= base_url("run-analysis"); ?>';
    var message = '';

    $(function(){
        
        $('#btnRunAnalysis').on('click',function(){
            
            // Show Card Progres Div
            $('#cardProgress').show();
            // Show Role Build Div
            $('#divProgressTabUser').show();

            //return false;

            analysis_id = $('#analysis_id').val(); 

                $.ajax({
                    url: url, 
                    type: "POST",  
                    dataType: 'json',
                    data: {analysis_id: analysis_id,instruction_index:0},    
                    success: function(response, textStatus, jqXHR)   
                    {
                        if( response['instruction_index'] != "")
                            instruction_index = response['instruction_index'];

                        if( response['status'] != "")
                            status = response['status'];

                        if(status == 'ERROR')
                            $('#divProgressTabUser').html(response['message']);  
                        else
                            $('#divProgressTabUser').html(response['message']);  


                        // Instruction Index 1
                        
                        // Show Role Build (Script 1)
                        $('#divProgressRoleBuild').show();

                         $.ajax({
                            url: url, 
                            type: "POST",  
                            dataType: 'json',
                            data: {analysis_id: analysis_id,instruction_index:1},    
                            success: function(response, textStatus, jqXHR)   
                            {
                                if( response['instruction_index'] != "")
                                    instruction_index = response['instruction_index'];

                                if( response['status'] != "")
                                    status = response['status'];

                                if(status == 'ERROR')
                                    $('#divProgressRoleBuild').html(response['message']);  
                                else
                                    $('#divProgressRoleBuild').html(response['message']);  

                                
                                // Instruction Index 2
                                // Show Role Build (Script 2)

                                $.ajax({
                                    url: url, 
                                    type: "POST",  
                                    dataType: 'json',
                                    data: {analysis_id: analysis_id,instruction_index:2},    
                                    success: function(response, textStatus, jqXHR)   
                                    {
                                        if( response['instruction_index'] != "")
                                            instruction_index = response['instruction_index'];

                                        if( response['status'] != "")
                                            status = response['status'];

                                        if(status == 'ERROR')
                                            $('#divProgressRoleBuild').html(response['message']);  
                                        else
                                            $('#divProgressRoleBuild').html(response['message']);  

                                        // Instruction Index 3
                                        // Show Role Build (Script 3)

                                        $.ajax({
                                            url: url, 
                                            type: "POST",  
                                            dataType: 'json',
                                            data: {analysis_id: analysis_id,instruction_index:3},    
                                            success: function(response, textStatus, jqXHR)   
                                            {
                                                if( response['instruction_index'] != "")
                                                    instruction_index = response['instruction_index'];

                                                if( response['status'] != "")
                                                    status = response['status'];

                                                if(status == 'ERROR')
                                                    $('#divProgressRoleBuild').html(response['message']);  
                                                else
                                                    $('#divProgressRoleBuild').html(response['message']);  


                                                // Show Role Analysis1 
                                                $('#divProgressRoleAnalysis').show();

                                                $.ajax({
                                                    url: url, 
                                                    type: "POST",  
                                                    dataType: 'json',
                                                    data: {analysis_id: analysis_id,instruction_index:4},    
                                                    success: function(response, textStatus, jqXHR)   
                                                    {
                                                        if( response['instruction_index'] != "")
                                                            instruction_index = response['instruction_index'];

                                                        if( response['status'] != "")
                                                            status = response['status'];

                                                        if(status == 'ERROR')
                                                            $('#divProgressRoleAnalysis').html(response['message']);  
                                                        else
                                                            $('#divProgressRoleAnalysis').html(response['message']);  

                                                        
                                                        // Show Role Analysis 2
                                                        
                                                        $.ajax({
                                                            url: url, 
                                                            type: "POST",  
                                                            dataType: 'json',
                                                            data: {analysis_id: analysis_id,instruction_index:5},    
                                                            success: function(response, textStatus, jqXHR)   
                                                            {
                                                                if( response['instruction_index'] != "")
                                                                    instruction_index = response['instruction_index'];

                                                                if( response['status'] != "")
                                                                    status = response['status'];

                                                                if(status == 'ERROR')
                                                                    $('#divProgressRoleAnalysis').html(response['message']);  
                                                                else
                                                                    $('#divProgressRoleAnalysis').html(response['message']); 


                                                                // Show User Analysis
                                                                $('#divProgressUserAnalysis').show();
                                                                
                                                                $.ajax({
                                                                    url: url, 
                                                                    type: "POST",  
                                                                    dataType: 'json',
                                                                    data: {analysis_id: analysis_id,instruction_index:6},    
                                                                    success: function(response, textStatus, jqXHR)   
                                                                    {
                                                                        if( response['instruction_index'] != "")
                                                                            instruction_index = response['instruction_index'];

                                                                        if( response['status'] != "")
                                                                            status = response['status'];

                                                                        if(status == 'ERROR')
                                                                            $('#divProgressUserAnalysis').html(response['message']);  
                                                                        else
                                                                            $('#divProgressUserAnalysis').html(response['message']); 


                                                                        // Show Root Cause Analysis
                                                                        $('#divProgressRootCauseAnalysis').show();

                                                                        $.ajax({
                                                                        url: url, 
                                                                        type: "POST",  
                                                                        dataType: 'json',
                                                                        data: {analysis_id: analysis_id,instruction_index:7},    
                                                                        success: function(response, textStatus, jqXHR)   
                                                                        {
                                                                            if( response['instruction_index'] != "")
                                                                                instruction_index = response['instruction_index'];

                                                                            if( response['status'] != "")
                                                                                status = response['status'];

                                                                            if(status == 'ERROR')
                                                                                $('#divProgressRootCauseAnalysis').html(response['message']);  
                                                                            else
                                                                                $('#divProgressRootCauseAnalysis').html(response['message']); 

                                                                            // Show General Report
                                                                            $('#divProgressGeneralReport').show();

                                                                            $.ajax({
                                                                                url: url, 
                                                                                type: "POST",  
                                                                                dataType: 'json',
                                                                                data: {analysis_id: analysis_id,instruction_index:8},    
                                                                                success: function(response, textStatus, jqXHR)   
                                                                                {
                                                                                    if( response['instruction_index'] != "")
                                                                                        instruction_index = response['instruction_index'];

                                                                                    if( response['status'] != "")
                                                                                        status = response['status'];

                                                                                    if(status == 'ERROR')
                                                                                        $('#divProgressGeneralReport').html(response['message']);  
                                                                                    else
                                                                                        $('#divProgressGeneralReport').html(response['message']);
                                                                                }, 
                                                                                error: function(xhr, status, error){
                                                                                    console.log(xhr.responseText);
                                                                                }
                                                                            });


                                                                        },
                                                                        error: function(xhr, status, error){
                                                                            console.log(xhr.responseText);
                                                                        }
                                                                    });



                                                                    },
                                                                    error: function(xhr, status, error){
                                                                        console.log(xhr.responseText);
                                                                    }
                                                                });
                                                            },
                                                            error: function(xhr, status, error){
                                                                console.log(xhr.responseText);
                                                            }
                                                        });

                                                    },
                                                    error: function(xhr, status, error){
                                                        console.log(xhr.responseText);
                                                    }

                                                });



                                            },
                                            error: function(xhr, status, error){
                                                console.log(xhr.responseText);
                                            }
                                        });

                                    },
                                    error: function(xhr, status, error){
                                        console.log(xhr.responseText);
                                    }
                                });




                            },
                            error: function(xhr, status, error){
                                console.log(xhr.responseText);
                            }
                        });

                    },
                    error: function(xhr, status, error){
                        console.log(xhr.responseText);
                    }
                });

            
            

               

        }); // End Btn Click Event

    }); // End Doc Ready
        
    </script>
