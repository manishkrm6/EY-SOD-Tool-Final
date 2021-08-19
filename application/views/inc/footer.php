</div><!-- END wrapper This was start in inc/topbar.php-->
<?php $this->load->view('inc/right-sidebar') ?>
    </body>
</html>
<script type="text/javascript">
    $("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
    });
</script>