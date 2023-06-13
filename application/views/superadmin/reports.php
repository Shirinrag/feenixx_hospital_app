<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Reports</title>
      <meta content="" name="description">
      <meta content="" name="keywords">
      <!-- Favicons -->
      <?php include 'common/cssfiles.php';?>
   </head>
   <body>
      <!-- ======= Header ======= -->
      <?php include 'common/header.php';?><!-- End Header -->
      <!-- ======= Sidebar ======= -->
      <?php include 'common/sidebar.php';?><!-- End Sidebar-->
      <main id="main" class="main">
         <div class="pagetitle">
            <h1>Reports</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Reports</li>
               </ol>
            </nav>
         </div>
         <!-- End Page Title -->
         <section class="section">
            <div class="row">
                <!-- <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Add Doctor </h5>
                       
                        <?php echo form_open('superadmin/save_doctor_details', array('id'=>'save_doctor_details_form')) ?>            
                        <div class="row">                                   
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="dob" class="form-label">From Date</label>
                                 <input type="text" class="form-control input-text datepicker" id="dob" name="dob" placeholder="Enter Your Date of Birth">
                                 <span class="error_msg" id="dob_error"></span>
                              </div>
                           </div>
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="add_doctor_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                           </div>
                        </div>
                        <?php echo form_close() ?>
                        
                     </div>
                  </div>
               </div> -->
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Reports List</h5>
                        <div class="table-responsive">
                           <table class="table" id="report_table">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Addmission Date</th>       
                                 <th scope="col">Patient ID</th>
                                 <th scope="col">Patient Name</th>
                                 <th scope="col">Gender</th>
                                 <th scope="col">Contact No</th>
                                 <th scope="col">Consulting Doctor</th>
                              </tr>
                           </thead>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <!-- End #main -->
    
      <!-- ======= Footer ======= -->
      <?php include 'common/footer.php';?><!-- End Footer -->
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- Vendor JS Files -->
      <?php include 'common/jsfiles.php';?>
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/superadmin/reports.js"></script>
   </body>
</html>