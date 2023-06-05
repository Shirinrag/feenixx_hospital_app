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
                        <h5 class="card-title">Add Appointment </h5>
                        <!-- Vertical Form -->
                        <?php echo form_open('doctor/save_appointment_details', array('id'=>'save_appointment_details_form')) ?>          
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="patient_id" class="form-label required">Select Patient Id</label>
                                 <select class="form-group chosen-select-deselect" id="patient_id" name="patient_id" data-placeholder="Select Patient Id">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($patient_data as $patient_data_key => $patient_data_row) { ?>
                                    <option value="<?=$patient_data_row['id']?>"><?=$patient_data_row['patient_id'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="patient_id_error"></span>
                              </div>
                           </div>    
                           <input type="hidden" name="patient_id_1" id="patient_id_1" >                      
                              <div class="col-md-4 hide_data" style="display: none;">
                                 <div class="form-group">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <div><span class="message_data" id="first_name"></span></div>

                                 </div>
                              </div>
                              <div class="col-md-4 hide_data" style="display: none;">
                                 <div class="form-group">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <div><span class="message_data" id="last_name"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4 hide_data" style="display: none;">
                                 <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                   <div><span class="message_data" id="email"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4 hide_data" style="display: none;">
                                 <div class="form-group">
                                    <label for="contact_no" class="form-label">Contact No</label>
                                   <div><span class="message_data" id="contact_no"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4 hide_data" style="display: none;">
                                 <div class="form-group">
                                    <label for="gender" class="form-label">Gender</label>
                                    <div><span class="message_data" id="gender"></span></div>
                                 </div>
                              </div>
                              <div class="col-md-4 hide_data" style="display: none;">
                                 <div class="form-group">
                                    <label for="blood_group" class="form-label">Blood Group</label>
                                    <div><span class="message_data" id="blood_group"></span></div>
                                 </div>
                              </div>
                          
                           <div class="col-md-4">
                              <div class="form-group drop_name1">
                                 <div class="shipper_select">       
                                 <label for="fk_diseases_id" class="form-label">Select Diseases</label>
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
                              <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_diseases_model" style="font-size: 14px;font-family: serif;"><b>Add New Diseases</b></a>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="appointment_date" class="form-label required">Appointment Date</label>
                                 <input type="text" class="form-control input-text" id="appointment_date" name="appointment_date" placeholder="Enter Your Appointment Date">
                                 <span class="error_msg" id="appointment_date_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="appointment_date" class="form-label required">Appointment Time</label>
                                 <input type="time" class="form-control input-text" id="appointment_time" name="appointment_time" placeholder="Enter Your Appointment Date">
                                 <span class="error_msg" id="appointment_time_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="patient_id" class="form-label required">Select Doctor</label>
                                 <select class="form-group chosen-select-deselect" id="patient_id" name="patient_id" data-placeholder="Select Doctor">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($doctor_data as $doctor_data_key => $doctor_data_row) { ?>
                                    <option value="<?=$doctor_data_row['id']?>"><?=$doctor_data_row['first_name']." ".$doctor_data_row['last_name'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="patient_id_error"></span>
                              </div>
                           </div>  
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="appointment_date" class="form-label">Ref. Doctor Name</label>
                                 <input type="text" class="form-control input-text" id="reference_doctor_name" name="reference_doctor_name" placeholder="Enter Ref. Doctor Name">
                                 <span class="error_msg" id="reference_doctor_name_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Type of Admission</label>
                                  <select class="form-group chosen-select-deselect" id="admission_type" name="admission_type" data-placeholder="Select Type of Admission">
                                    <option value=""></option>
                                   <?php 
                                       foreach ($appointment_type as $appointment_type_key => $appointment_type_row) { ?>
                                    <option value="<?=$appointment_type_row['id']?>"><?=$appointment_type_row['type'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="admission_type_error"></span>
                              </div>
                           </div>
                           
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label">Sub-Type of Admission</label>
                                  <select class="form-group chosen-select-deselect" id="admission_sub_type" name="admission_sub_type" data-placeholder="Select Type of Admission">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="admission_sub_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Select Location</label>
                                  <select class="form-group chosen-select-deselect" id="admission_type" name="admission_type" data-placeholder="Select Location">
                                    <option value=""></option>
                                   <?php 
                                       foreach ($location_data as $location_data_key => $location_data_row) { ?>
                                    <option value="<?=$location_data_row['id']?>"><?=$location_data_row['place_name'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="admission_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Upload Medical History</label>
                                 <input type="file" class="form-control input-text" id="document" name="document[]" placeholder="Upload Medical History" multiple="multiple">
                                 <span class="error_msg" id="image_error"></span> 
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Upload Pescription</label>
                                 <input type="file" class="form-control input-text" id="pescription" name="pescription" placeholder="Upload Pescription">
                                 <span class="error_msg" id="pescription_error"></span> 
                              </div>
                           </div>
                           
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Description</label>
                                 <textarea class="form-control input-text" id="description" name="description" placeholder="Description" rows="5"></textarea>
                                 <span class="error_msg" id="description_error"></span> 
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <h5 class="card-title" style="margin-left: 15px;"><strong>Payment Details</strong></h5>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Payment Type</label>
                                  <select class="form-group chosen-select-deselect" id="payment_type" name="payment_type" data-placeholder="Select Payment Type">
                                    <option value=""></option>
                                    <option value="Cash">Cash</option>
                                    <option value="Online">Online</option>
                                 </select>
                                 <span class="error_msg" id="payment_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Online Amount</label>
                                 <input type="text" class="form-control input-text" id="online_amount" name="online_amount" placeholder="Enter Your Amount" onkeypress="return isNumberKey(event)">
                                 <span class="error_msg" id="online_amount_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Amount in Cash</label>
                                 <input type="text" class="form-control input-text" id="cash_amount" name="cash_amount" placeholder="Enter Your Amount in Cash" onkeypress="return isNumberKey(event)">
                                 <span class="error_msg" id="cash_amount_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Mediclaim Amount</label>
                                 <input type="text" class="form-control input-text" id="mediclaim_amount" name="mediclaim_amount" placeholder="Enter Your Mediclaim Amount" onkeypress="return isNumberKey(event)">
                                 <span class="error_msg" id="mediclaim_amount_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="address" class="form-label required">Bed Charges</label>
                                    <input type="text" class="form-control input-text" id="bed_charges" name="bed_charges" placeholder="Enter Bed Charges" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="bed_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="address" class="form-label required">Nursing Charges</label>
                                    <input type="text" class="form-control input-text" id="nursing_charges" name="nursing_charges" placeholder="Enter Nursing Charges" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="nursing_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="dr_visit_charges" class="form-label required">Dr. Visit Charges</label>
                                    <input type="text" class="form-control input-text" id="dr_visit_charges" name="dr_visit_charges" placeholder="Enter Dr. Visit Charges" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="dr_visit_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="dr_visit_charges" class="form-label required">1st CONSULTATION CHARGES</label>
                                    <input type="text" class="form-control input-text" id="dr_visit_charges" name="dr_visit_charges" placeholder="Enter 1st CONSULTATION CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="dr_visit_charges_error"></span>
                                 </div>
                              </div>
                               <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="surgery_charges" class="form-label required">SURGERY CHARGES</label>
                                    <input type="text" class="form-control input-text" id="surgery_charges" name="surgery_charges" placeholder="Enter SURGERY CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="surgery_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="anesthetic_charges" class="form-label required">ANESTHETIC CHARGES</label>
                                    <input type="text" class="form-control input-text" id="anesthetic_charges" name="anesthetic_charges" placeholder="Enter ANESTHETIC CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="anesthetic_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="assistanat_charges" class="form-label required">ASSISTANAT CHARGES</label>
                                    <input type="text" class="form-control input-text" id="assistanat_charges" name="assistanat_charges" placeholder="Enter ASSISTANAT CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="assistanat_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="implant_charges" class="form-label required">IMPLANT CHARGES</label>
                                    <input type="text" class="form-control input-text" id="implant_charges" name="implant_charges" placeholder="Enter IMPLANT  CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="implant_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="ot_charges" class="form-label required">OT CHARGES</label>
                                    <input type="text" class="form-control input-text" id="ot_charges" name="ot_charges" placeholder="Enter OT CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="ot_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="xray_charges" class="form-label required">XRAY CHARGES</label>
                                    <input type="text" class="form-control input-text" id="xray_charges" name="xray_charges" placeholder="Enter XRAY CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="xray_charges_error"></span>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="ecg_charges" class="form-label required">ECG CHARGES</label>
                                    <input type="text" class="form-control input-text" id="ecg_charges" name="ecg_charges" placeholder="Enter ECG CHARGES" onkeypress="return isNumberKey(event)">
                                    <span class="error_msg" id="ecg_charges_error"></span>
                                 </div>
                              </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Discount Amount</label>
                                 <input type="text" class="form-control input-text" id="discount" name="discount" placeholder="Enter Your Discount Amount" onkeypress="return isNumberKey(event)">
                                 <span class="error_msg" id="discount_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="address" class="form-label required">Total Amount</label>
                                 <input type="text" class="form-control input-text" id="total_amount" name="total_amount" placeholder="Enter Your Total Amount" onkeypress="return isNumberKey(event)">
                                 <span class="error_msg" id="total_amount_error"></span>
                              </div>
                           </div>
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="add_appointment_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                           </div>
                        </div>
                         <?php echo form_close() ?><!-- Vertical Form -->
                     </div>
                  </div>
               </div>
               <div class="col-lg-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="card-title">Patient List</h5>
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
   </div>
     
      <!-- ======= Footer ======= -->
      <?php include 'common/footer.php';?><!-- End Footer -->
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- Vendor JS Files -->
      <?php include 'common/jsfiles.php';?>
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/receptionist/appointment.js"></script>
   </body>
</html>