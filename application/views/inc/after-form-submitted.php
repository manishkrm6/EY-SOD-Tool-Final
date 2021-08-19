<?php                         
    $succ_msg = '';
    $err_msg = '';
    $succ_class = '';
    $err_class = '';

    if($this->session->flashdata('succ'))
    {
        $succ_class = "alert alert-success alert-dismissible fade show";
        $succ_msg .= $this->session->flashdata('succ');
    }
    
    if($this->session->flashdata('err'))
    {
            $err_class = "alert alert-danger alert-dismissible fade show";
            $err_msg .= $this->session->flashdata('err');
    }
?>

<div class="<?php echo $succ_class; ?>" role="alert">
    <p> <?php echo $succ_msg; ?></p>
</div>

<div class="<?php echo $err_class; ?>" role="alert">
    <p> <?php echo $err_msg; ?></p>
</div>
