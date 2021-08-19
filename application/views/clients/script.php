<script>

    var instruction_index = 0;
    var status = '';
    var analysis_id = '';
    var url = '<?= base_url("save-new-client"); ?>';
    var message = '';

    $(function(){
        
        $('#btnCreateClient').on('click',function(){
            
            // Show Card Progres Div
            $('#cardProgress').show();
            // Show Role Build Div
            $('#divProgressSaveClient').show();

            //return false;

            

                $.ajax({
                    url: url, 
                    type: "POST",  
                    dataType: 'json',
                    data: {instruction_index:0},    
                    success: function(response, textStatus, jqXHR)   
                    {
                        if( response['instruction_index'] != "")
                            instruction_index = response['instruction_index'];

                        if( response['status'] != "")
                            status = response['status'];

                        if(status == 'ERROR')
                            $('#divProgressSaveClient').html(response['message']);  
                        else
                            $('#divProgressSaveClient').html(response['message']);  


                        // Instruction Index 1
                        
                        // Show Role Build (Script 1)
                        $('#divProgressCreateClientDirectory').show();

                         $.ajax({
                            url: url, 
                            type: "POST",  
                            dataType: 'json',
                            data: {instruction_index:1},    
                            success: function(response, textStatus, jqXHR)   
                            {
                                if( response['instruction_index'] != "")
                                    instruction_index = response['instruction_index'];

                                if( response['status'] != "")
                                    status = response['status'];

                                if(status == 'ERROR')
                                    $('#divProgressCreateClientDirectory').html(response['message']);  
                                else
                                    $('#divProgressCreateClientDirectory').html(response['message']);  

                                
                                // Instruction Index 2
                                // Show Role Build (Script 2)

                                $('#divProgressCreateClientLogFile').show();

                                $.ajax({
                                    url: url, 
                                    type: "POST",  
                                    dataType: 'json',
                                    data: {instruction_index:2},    
                                    success: function(response, textStatus, jqXHR)   
                                    {
                                        if( response['instruction_index'] != "")
                                            instruction_index = response['instruction_index'];

                                        if( response['status'] != "")
                                            status = response['status'];

                                        if(status == 'ERROR')
                                            $('#divProgressCreateClientLogFile').html(response['message']);  
                                        else
                                            $('#divProgressCreateClientLogFile').html(response['message']);  

                                        // Instruction Index 3
                                        // Show Role Build (Script 3)

                                        $('#divProgressCreateClientDatabase').show();

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
                                                    $('#divProgressCreateClientDatabase').html(response['message']);  
                                                else
                                                    $('#divProgressCreateClientDatabase').html(response['message']);  


                                                $('#divProgressImportLibraryData').show();

                                                // Show Role Analysis1 
                                                

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
                                                            $('#divProgressImportLibraryData').html(response['message']);  
                                                        else
                                                            $('#divProgressImportLibraryData').html(response['message']);  

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
