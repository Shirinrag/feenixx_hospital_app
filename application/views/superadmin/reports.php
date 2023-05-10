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
                                 <!-- <th scope="col">Type of Admission</th> -->
                                 <th scope="col">Patient ID</th>
                                 <th scope="col">Patient Name</th>
                                 <th scope="col">Gender</th>
                                 <th scope="col">Contact No</th>
                                 <th scope="col">Consulting Doctor</th>
                                 <th scope="col">Cash Payment</th>
                                 <th scope="col">Card Payment</th>
                                 <th scope="col">Mediclaim Payment</th>
                                 <th scope="col">Discount Amount</th>
                                 <th scope="col">Amount Received</th>
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
      <!-- Modal -->
      
      <div class="modal fade" id="view_appointment_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">View Appointment Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
                
               <div class="modal-body">
                <div class="row">
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_patient_id" class="form-label">Patient ID</label>
                        <div><span class="message_data" id="view_patient_id"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_first_name" class="form-label">First Name</label>
                        <div><span class="message_data" id="view_first_name"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_last_name" class="form-label">Last Name</label>
                        <div><span class="message_data" id="view_last_name"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_email" class="form-label">Email</label>
                        <div><span class="message_data" id="view_email"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_contact_no" class="form-label">Contact No</label>
                        <div><span class="message_data" id="view_contact_no"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_blood_group" class="form-label">Blood Group</label>
                        <div><span class="message_data" id="view_blood_group"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_diseases" class="form-label">Diseases</label>
                        <div><span class="message_data" id="view_diseases"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_description" class="form-label">Description</label>
                        <div><span class="message_data" id="view_description"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_payment_type" class="form-label">Payment Type</label>
                        <div><span class="message_data" id="view_payment_type"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_cash_amount" class="form-label">Cash Amount</label>
                        <div><span class="message_data" id="view_cash_amount"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_online_amount" class="form-label">Online Amount</label>
                        <div><span class="message_data" id="view_online_amount"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_mediclaim_amount" class="form-label">Mediclaim Amount</label>
                        <div><span class="message_data" id="view_mediclaim_amount"></span></div>
                     </div>
                   </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_total_amount" class="form-label">Total Amount</label>
                        <div><span class="message_data" id="view_total_amount"></span></div>
                     </div>
                   </div>
                </div>
                <div class="row">
                   <div class="col-md-12">
                     <div class="form-group">
                        <label for="view_pescription" class="form-label">Pescription</label>
                        <div><span class="message_data" id="view_pescription"></span></div>
                     </div>
                   </div>
                    <div class="col-md-12">
                     <div class="form-group">
                        <label for="view_documents" class="form-label">Documents</label>
                        <div><span class="message_data" id="view_documents"></span></div>
                     </div>
                   </div>
                </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
            </div>
         </div>
      </div>
      <!-- ======= Footer ======= -->
      <?php include 'common/footer.php';?><!-- End Footer -->
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- Vendor JS Files -->
      <?php include 'common/jsfiles.php';?>
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/superadmin/reports.js"></script>
   </body>
</html>