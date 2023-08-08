<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Appointment</title>
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
            <h1>Appointment</h1>
            <nav>
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Appointment</li>
               </ol>
            </nav>
         </div>
         <!-- End Page Title -->
         <section class="section">
            <div class="row">
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Appointment List</h5>
                        <div class="table-responsive">
                           <table class="table" id="appointment_table">
                           <thead>
                              <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Doctor Name</th>
                                 <th scope="col">Patient ID</th>
                                 <th scope="col">Patient Name</th>
                                 <th scope="col">Email</th>
                                 <th scope="col">Contact</th>
                                 <th scope="col">Appointment Date</th>
                                 <th scope="col">Appointment Time</th>
                                 <th scope="col">Action</th>
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
       <div class="modal fade" id="add_diseases_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Add New Diseases</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <?php echo form_open('doctor/save_diseases', array('id'=>'save_diseases_form')) ?> 
                      <div class="modal-body">                             
                        <div class="row">
                           <input type="hidden" name="edit_id" id="edit_id" class="form-control">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="diseases" class="form-label required">Diseases</label>
                                 <input type="text" class="form-control input-text" id="diseases" name="diseases" placeholder="Enter Diseases">
                                 <span class="error_msg" id="diseases_error"></span>
                              </div>
                           </div>
                        </div>    
                    </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="add_diseases_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Save</button>
               </div>
               <?php echo form_close() ?>
            </div>
         </div>
      </div>
      <div class="modal fade" id="view_appointment_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Update Appointment Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
                  <?php echo form_open('doctor/update_appointment_details_doctor', array('id'=>'update_appointment_details_form')) ?> 
               <div class="modal-body">
                <div class="row">
                  <input type="hidden" name="edit_id" id="edit_appointment_id" class="form-control input-text">
                  <input type="hidden" name="patient_id_1" id="patient_id_1" class="form-control input-text">
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
                        <select class="form-group chosen-select-deselect" id="fk_diseases_id" name="fk_diseases_id" data-placeholder="Select Diseases">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($diseases_data as $diseases_data_key => $diseases_data_row) { ?>
                                    <option value="<?=$diseases_data_row['id']?>"><?=$diseases_data_row['diseases_name'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="fk_diseases_id_error"></span>
                                 </div>
                              </div>
                   <div class="col-md-4">
                     <div class="form-group">
                        <label for="view_pescription" class="form-label">Pescription</label>
                         <input type="file" class="form-control input-text" id="pescription" name="pescription" placeholder="Upload Pescription">
                                 <span class="error_msg" id="pescription_error"></span>
                        <div><span class="message_data" id="view_pescription"></span></div>
                     </div>                               
                   </div>
                   <div class="col-md-4">
                            <button type="button" id="start-camera">Start Camera</button>
                           <video id="video" width="100" height="100" autoplay></video>
                           <button type="button" id="click-photo">Click Photo</button>
                           <canvas id="canvas" width="100" height="100"></canvas> 
                            <img src="" id="newimg" class="top" />
                           <input type="hidden" id="click_file_name" name="click_file_name">
                     </div>
                <div class="row">
                   <div class="col-md-12">
                      <div class="form-group">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control input-text" id="edit_description" name="edit_description" placeholder="Description" rows="3"></textarea>
                                 <span class="error_msg" id="edit_description_error"></span> 
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
                  <button type="submit" class="btn btn-primary" id="update_patient_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Update</button>
               </div>
                <?php echo form_close() ?>
            </div>
         </div>
      </div>
   </div>     
      <!-- ======= Footer ======= -->
      <?php include 'common/footer.php';?><!-- End Footer -->
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- Vendor JS Files -->
      <?php include 'common/jsfiles.php';?>
       <script type="text/javascript" src="https://unpkg.com/webcam-easy/dist/webcam-easy.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/doctor/appointment.js"></script>
      <script type="text/javascript">
         
      </script>
   </body>
</html>