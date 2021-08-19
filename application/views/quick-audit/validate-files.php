<div class="content-page">
<div class="content">

<!-- Start Content-->
<div class="container-fluid">

<!-- start page title -->
<div class="row">
<div class="col-12">
<div class="page-title-box">
    <div class="card">
    <div class="card-body">

<h3 class="text-center"><?php echo 'Client Name : '.$client_name.' And Analysis Name : '.$analysis_name ?></h3>
  <?php $this->load->view('inc/after-form-submitted'); ?>
    <p class="text-center"><a href="<?php echo base_url('import-data/'.$analysis_id) ?>" class="btn btn-info">Start Import data</a></p>

  </div>  <!-- end card-body -->
</div>
</div>
</div>
</div>     
<!-- end page title --> 
<!-- end row -->

</div> <!-- container -->

</div> <!-- content -->
</div>

<script>
         $(function(){
            
            $('#btnImport').on('click',function(){
                
                $.ajax({
                  url: "<?php echo base_url('/importdata'); ?>", 
                  type: "GET",  
                  dataType: 'json', 
                  data: { "type": "type" }, 
                  async:true,
                  success: function(response)
                  {
                    
                    console.log(response);
                    
                    //$('#ajax-response').append(response);

                  } //End Success
                      
                });

                $.ajax({
                  url: "<?php echo base_url('/getimportstatus'); ?>", 
                  type: "GET",  
                  dataType: 'json', 
                  data: { "type": "type" }, 
                  async:true,
                  success: function(response)   
                  {
                    
                    console.log(response);
                    
                    //$('#ajax-response').append(response);

                  } //End Success
                      
                });

            });

          });
      </script>