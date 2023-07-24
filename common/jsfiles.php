 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
 <script src="<?=base_url()?>assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?=base_url()?>assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/quill/quill.min.js"></script>
  <!-- <script src="<?=base_url()?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 
  <script src="<?=base_url()?>assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?=base_url()?>assets/vendor/php-email-form/validate.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/chosen.jquery.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/init.js"></script>
  <script src="<?=base_url()?>assets/plugins/chosen/prism.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> -->
  <script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>
  <!-- Template Main JS File -->
  <script src="<?=base_url()?>assets/js/main.js"></script>
<script src="<?=base_url()?>assets/js/button-inline-loader.js"></script>
  <script src="<?=base_url()?>assets/view_js/form.js"></script>
  <script type="text/javascript">
      setTimeout(function(){
             document.getElementById('loader').style.visibility="hidden";
        },1000);
    $(document).ready(function() {
      resizeChosen();
      jQuery(window).on('resize', resizeChosen);
//       $('.summernote').summernote({
//   airMode: true
// });

     

    });
    function resizeChosen() {
        $(".chosen-container").each(function() {
            $(this).attr('style', 'width: 100%');
        });
    }
    $(".datepicker").datepicker({ 
       format: 'dd-mm-yyyy',
        autoclose: true, 
        todayHighlight: true,
        endDate: "today",
    });


//   $(document).ready(function() {
//   $('.summernote').summernote();
//   height:150;
// });
    var frontend_path ="<?=base_url();?>"; 
  </script>