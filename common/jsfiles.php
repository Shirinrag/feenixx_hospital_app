 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
 <script src="<?=base_url()?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?=base_url()?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/quill/quill.min.js"></script>
  <!-- <script src="<?=base_url()?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  <script src="<?=base_url()?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/chosen.jquery.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/init.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/prism.js"></script>
  <!-- Template Main JS File -->
  <script src="<?=base_url()?>assets/js/main.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      resizeChosen();
      jQuery(window).on('resize', resizeChosen);
    });
    function resizeChosen() {
        $(".chosen-container").each(function() {
            $(this).attr('style', 'width: 100%');
        });
    }
     $(".datepicker").datepicker({ 
       format: 'yyyy-mm-dd',
        autoclose: true, 
        todayHighlight: true
  });
  
    var frontend_path ="<?=base_url();?>";

    
 
  </script>