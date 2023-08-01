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
                        <?php echo form_open('receptionist/save_appointment_details', array('id'=>'save_appointment_details_form')) ?>          
                        <div class="row">
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="patient_id" class="form-label required">Select Contact No</label>
                                 <select class="form-group chosen-select-deselect" id="patient_id" name="patient_id" data-placeholder="Select Contact No">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($patient_data as $patient_data_key => $patient_data_row) { ?>
                                    <option value="<?=$patient_data_row['id']?>"><?=$patient_data_row['contact_no'] ?></option>
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
                                 <label for="doctor_id" class="form-label required">Select Doctor</label>
                                 <select class="form-group chosen-select-deselect" id="doctor_id" name="doctor_id" data-placeholder="Select Doctor">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($doctor_data as $doctor_data_key => $doctor_data_row) { ?>
                                    <option value="<?=$doctor_data_row['id']?>"><?=$doctor_data_row['first_name']." ".$doctor_data_row['last_name'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="doctor_id_error"></span>
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
                                 <label for="address" class="form-label required">Type of Addmission</label>
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
                           <div class="col-md-4" id="hide_admission_sub_type" style="display: none;">
                              <div class="form-group">
                                 <label for="address" class="form-label">Sub-Type of Admission</label>
                                 <select class="form-group chosen-select-deselect" id="admission_sub_type" name="admission_sub_type" data-placeholder="Select Type of Admission">
                                    <option value=""></option>
                                 </select>
                                 <span class="error_msg" id="admission_sub_type_error"></span>
                              </div>
                           </div>
                           <div class="col-md-4" id="hide_fk_visit_location_id" style="display: none;">
                              <div class="form-group">
                                 <label for="fk_visit_location_id" class="form-label required">Select Location</label>
                                 <select class="form-group chosen-select-deselect" id="fk_visit_location_id" name="fk_visit_location_id" data-placeholder="Select Location">
                                    <option value=""></option>
                                    <?php 
                                       foreach ($location_data as $location_data_key => $location_data_row) { ?>
                                    <option value="<?=$location_data_row['id']?>"><?=$location_data_row['place_name'] ?></option>
                                    <?php  }
                                       ?>
                                 </select>
                                 <span class="error_msg" id="fk_visit_location_id_error"></span>
                              </div>
                           </div>
                           <!-- <div class="col-md-4" id="hide_deposite_amount" style="display: none;">
                              <div class="form-group">
                                 <label for="last_name" class="form-label required">Deposite Amount</label>
                                 <input type="text" class="form-control input-text" id="deposite_amount" name="deposite_amount" placeholder="Enter Deposite Amount" multiple="multiple">
                                 <span class="error_msg" id="deposite_amount_error"></span> 
                              </div>
                           </div> -->
                           <div class="col-md-4">
                              <div class="form-group">
                                 <label for="last_name" class="form-label">Upload Medical History</label>
                                 <input type="file" class="form-control input-text" id="document" name="document[]" placeholder="Upload Medical History" multiple="multiple">
                                 <span class="error_msg" id="image_error"></span> 
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="add_appointment_button" data-loading-text="<i class='bi bi-person-add'></i> Loading">Submit</button>
                           </div>
                        </div>
                        <?php echo form_close() ?><!-- Vertical Form -->
                     </div>
                  </div>
               </div>
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
                                    <th scope="col">Reschedule Appointment</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Download Invoice</th>
                                    <th scope="col">Download Discharge Summary</th>
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
               <?php echo form_open('receptionist/save_diseases', array('id'=>'save_diseases_form')) ?> 
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
                  <button type="submit" class="btn btn-primary" id="add_appointment_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Save</button>
               </div>
               <?php echo form_close() ?>
            </div>
         </div>
      </div>
      <div class="modal fade" id="view_appointment_model" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Appointment Details</h5>
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
                           <label for="doctor_id" class="form-label required">Doctor Name</label>
                           <div><span class="message_data" id="view_doctor"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="appointment_date" class="form-label">Ref. Doctor Name</label>
                           <div><span class="message_data" id="view_reference_doctor_name"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="address" class="form-label required">Type of Addmission</label>
                           <div><span class="message_data" id="view_type_of_addmission"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4" id="hide_sub_type_of_addmission" style="display:none;">
                        <div class="form-group">
                           <label for="address" class="form-label required">Sub-Type of Addmission</label>
                           <div><span class="message_data" id="view_sub_type_of_addmission"></span></div>
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
                     <div class="col-md-3" id="hide_date_of_discharge">
                        <div class="form-group">
                           <input type="hidden" name="edit_fk_appointment_id" id="edit_fk_appointment_id" class="form-control"> 
                           <label for="date_of_discharge" class="form-label required">Date of Discharge</label>
                           <input type="text" class="form-control input-text" id="date_of_discharge" name="date_of_discharge" placeholder="Enter Date of Discharge">
                           <span class="error_msg" id="date_of_discharge_error"></span>
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
                  <div id="hide_surgery_data">
                        <hr>
                        <?php echo form_open('receptionist/add_surgery_details', array('id'=>'add_surgery_details_form')) ?> 
                         <h3>Surgery Details</h3> 
                        <div id="show_surgery_details">
                        </div>
                        <div class="row" id="hide_surgery_data_details">
                          
                           <input type="hidden" name="surgery_fk_appointment_id" id="surgery_fk_appointment_id" class="form-control"> 
                           <div class="col-md-3">
                              <div class="form-group">
                                 <label for="surgery_date" class="form-label required">Date</label>
                                 <input type="text" class="form-control input-text surgery_date" id="surgery_date_0" name="surgery_date[]" placeholder="Enter Date">
                                 <span class="error_msg" id="surgery_date_error"></span>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <button id="addRows_surgery_details" type="button" class="btn btn-info btn-sm" style="height: 44%; width: 28%; margin-top: 30%; background: #0ec53e9c"><i class="bi bi-plus-lg"></i>
                              </button>
                              <input type="hidden" class="form-control"  name="surgey_count_details" id="surgey_count_details" value="0">
                           </div>
                           <!-- <hr> -->
                           <div id="Surgery_details_append"></div>
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="add_surgery_details_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                           </div>
                        </div>
                        <?php echo form_close() ?>
               </div>
                  <hr>
                  <?php echo form_open('receptionist/add_appointment_advance_payment_details', array('id'=>'add_appointment_advance_payment_details_form')) ?> 
                  <div id="show_advance_amount">
                  </div>
                  <div class="row" id="hide_advance_charge_data">
                     <h3>Advanced Payment</h3>
                     <input type="hidden" name="advance_fk_patient_id" id="advance_fk_patient_id" class="form-control"> 
                     <input type="hidden" name="advance_fk_appointment_id" id="advance_fk_appointment_id" class="form-control"> 
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="form-label">
                           Advance Amount
                           </label>
                           <input type="text" class="form-control input-text" name="advance_amount[]" id="advance_amount_0" placeholder="Enter Advance Amount">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label class="form-label">
                           Payment Type
                           </label>
                           <select class="form-group chosen-select-deselect" id="advance_payment_type_0" name="advance_payment_type[]" data-placeholder="Select Payment Type">
                              <option value=""></option>
                              <?php 
                                 foreach ($payment_type as $payment_type_key => $payment_type_row_1) { ?>
                              <option value="<?= $payment_type_row_1['id'] ?>"><?=$payment_type_row_1['payment_type'] ?></option>
                              <?php }
                                 ?>
                           </select>
                           <span class="error_msg" id="advance_payment_type_error"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="date" class="form-label required">Date</label>
                           <input type="text" class="form-control input-text advance_payment_date" id="advance_payment_date_0" name="advance_payment_date[]" placeholder="Enter Date">
                           <span class="error_msg" id="advance_payment_date_error"></span>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <button id="addRows_advance_payment" type="button" class="btn btn-info btn-sm" style="height: 44%; width: 28%; margin-top: 30%; background: #0ec53e9c"><i class="bi bi-plus-lg"></i>
                        </button>
                        <input type="hidden" class="form-control"  name="advance_count" id="advance_count_details" value="0">
                     </div>
                     <!-- <hr> -->
                     <div id="Advance_Charges_append"></div>
                     <div class="text-center">
                        <button type="submit" class="btn btn-primary button_style" id="add_appointment_advance_payment_details_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                     </div>
                  </div>
                  <?php echo form_close() ?>
                  <hr>
                  <h3>Charges Details</h3>
                  <?php echo form_open('receptionist/add_appointment_charges_details', array('id'=>'add_appointment_charges_details_form')) ?> 
                  <div class="row">
                     <input type="hidden" name="fk_patient_id" id="fk_patient_id" class="form-control"> 
                     <input type="hidden" name="fk_appointment_id" id="fk_appointment_id" class="form-control"> 
                  </div>
                  <div class="row">
                     <div id="show_charges_amount_1">
                     </div>
                  </div>
                  <div class="row" id="hide_add_charges">
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="charges" class="form-label">Select Charges</label>
                           <select class="form-group chosen-select-deselect charges" id="charges_0" name="charges[]" data-placeholder="Select Charges">
                              <option value=""></option>
                              <?php 
                                 foreach ($charges_data as $charges_data_key => $charges_data_row) { ?>
                              <option value="<?= $charges_data_row['id'] ?>"><?=$charges_data_row['charges_name'] ?></option>
                              <?php }
                                 ?>
                           </select>
                           <span class="error_msg" id="charges_error"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group"> 
                           <label for="dr_name" class="form-label">Dr. Name</label>
                           <input type="text" name="dr_name[]" id="dr_name_0" class="form-control input-text dr_name" placeholder="Enter Dr. Name">
                           <span class="error_msg" id="dr_name_error"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group"> 
                           <label for="amount" class="form-label">Amount</label>
                           <input type="text" name="amount[]" id="amount_0" class="form-control input-text amount_charges" placeholder="Enter Amount">
                           <span class="error_msg" id="amount_error"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="unit" class="form-label">Units</label>
                           <input type="text" name="unit[]" id="unit_0" class="form-control input-text unit_charges" placeholder="Enter Unit">
                           <span class="error_msg" id="unit_error"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="unit" class="form-label">Total Amount</label>
                           <input type="text" name="total_amount[]" id="total_amount_0" class="form-control input-text total_amount_charges" placeholder="Enter Total Amount">
                           <span class="error_msg" id="total_amount_error"></span>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="date" class="form-label required">Date</label>
                           <input type="text" class="form-control input-text date_payment" id="date_0" name="date[]" placeholder="Enter Your Date">
                           <span class="error_msg" id="date_error"></span>
                        </div>
                     </div>
                     <div class="col-md-2">
                        <button id="addRows" type="button" class="btn btn-info btn-sm" style="height: 44%; width: 28%; margin-top: 30%; background: #0ec53e9c"><i class="bi bi-plus-lg"></i>
                        </button>
                        <input type="hidden" class="form-control"  name="count" id="count_details" value="0">
                     </div>
                     <!-- <hr> -->
                     <div id="Charges_append"></div>
                     <div class="text-center">
                        <button type="submit" class="btn btn-primary button_style" id="add_appointment_charges_payment_details_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                     </div>
                  </div>
                  <?php echo form_close() ?>
                  <hr>
                  <div id="hide_payment_details_data">
                     <h3>Payment Details</h3>
                     
                     <?php echo form_open('receptionist/add_appointment_final_payment_details', array('id'=>'add_appointment_final_payment_details_form'))?>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="address" class="form-label required">Grand Total </label>
                              <div><span id="total_amount_payable"></span></div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="address" class="form-label required">Total Advance Amount Paid</label>
                              <div><span id="advance_grand_total"></span></div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="address" class="form-label required">Remaining Amount</label>
                              <div><span id="grand_total"></span></div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div id="show_final_payment_details"></div>
                     </div>
                     <div class="row" id="hide_payment_details_data_1">
                        <input type="hidden" name="final_fk_appointment_id" id="final_fk_appointment_id" class="form-control">
                        <input type="hidden" name="final_fk_patient_id" id="final_fk_patient_id" class="form-control">
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="view_payment_type" class="form-label">Payment Type</label>
                              <select class="form-group chosen-select-deselect" id="final_payment_type" name="final_payment_type" data-placeholder="Select Payment Type">
                                 <option value=""></option>
                                 <?php 
                                    foreach ($payment_type as $payment_type_key => $payment_type_row) { ?>
                                 <option value="<?= $payment_type_row['id'] ?>"><?=$payment_type_row['payment_type'] ?></option>
                                 <?php }
                                    ?>
                              </select>
                              <span class="error_msg" id="final_payment_type_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="final_amount" class="form-label">Amount</label>
                              <input type="text" class="form-control input-text" id="final_amount" name="final_amount" placeholder="Enter Your Amount" onkeypress="return isNumberKey(event)">
                              <span class="error_msg" id="final_amount_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="mediclaim_amount" class="form-label">Mediclaim Amount</label>
                              <input type="text" class="form-control input-text" id="mediclaim_amount" name="mediclaim_amount" placeholder="Enter Your Mediclaim Amount" onkeypress="return isNumberKey(event)">
                              <span class="error_msg" id="mediclaim_amount_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="total_paid_amount" class="form-label">Total Amount</label>
                              <input type="text" class="form-control input-text" id="total_paid_amount" name="total_paid_amount" placeholder="Enter Your Total Paid Amount" onkeypress="return isNumberKey(event)" readonly>
                              <span class="error_msg" id="mediclaim_amount_error"></span>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group">
                              <label for="address" class="form-label">Discount Amount</label>
                              <input type="text" class="form-control input-text" id="discount" name="discount" placeholder="Enter Your Discount Amount">
                              <span class="error_msg" id="discount_error"></span>
                           </div>
                        </div>
                        <div class="text-center">
                           <button type="submit" class="btn btn-primary button_style" id="update_patient_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                        </div>
                     </div>
                     <?php echo form_close() ?>
                     <hr>
                     <div id="hide_discharge_summary">
                        <h3>Discharge Summary</h3>
                        <?php echo form_open('receptionist/update_discharge_summary', array('id'=>'update_discharge_summary_form'))?>
                        <div class="row">
                           <div class="col-md-12">
                              <input type="hidden" name="update_appointment_id" id="update_appointment_id">
                              <div class="form-group">
                                 <label for="date" class="form-label required">Discharge Summary</label>
                                 <textarea name="discharge_summary" id="discharge_summary" cols="30" rows="100"></textarea>
                              </div>
                           </div>
                           <div class="text-center">
                              <button type="submit" class="btn btn-primary button_style" id="update_discharge_summary_button"data-loading-text="<i class='fa fa-spinner fa-spin'></i> Loading">Submit</button>
                           </div>
                        </div>
                        <?php echo form_close() ?>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
               <?php echo form_close() ?>
            </div>
         </div>
      </div>
      <div class="modal fade" id="reschedule_appointment" tabindex="-1">
         <div class="modal-dialog modal-xl">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit Appointment Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <?php echo form_open('receptionist/reschedule_appointment', array('id'=>'reschedule_appointment_form')) ?> 
               <div class="modal-body">
                  <div class="row">
                     <input type="hidden" name="fk_appointment_id" id="fk_appointment_id" class="form-control"> 
                     <input type="hidden" name="update_id" id="update_id" class="form-control"> 
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="update_patient_id" class="form-label">Patient ID</label>
                           <div><span class="message_data" id="update_patient_id"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="update_first_name" class="form-label">First Name</label>
                           <div><span class="message_data" id="update_first_name"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="update_last_name" class="form-label">Last Name</label>
                           <div><span class="message_data" id="update_last_name"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="update_email" class="form-label">Email</label>
                           <div><span class="message_data" id="update_email"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="update_contact_no" class="form-label">Contact No</label>
                           <div><span class="message_data" id="update_contact_no"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="update_blood_group" class="form-label">Blood Group</label>
                           <div><span class="message_data" id="update_blood_group"></span></div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="appointment_date" class="form-label required">Appointment Date</label>
                           <input type="text" class="form-control input-text" id="update_appointment_date" name="update_appointment_date" placeholder="Enter Your Appointment Date">
                           <span class="error_msg" id="appointment_date_error"></span>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="appointment_date" class="form-label required">Appointment Time</label>
                           <input type="time" class="form-control input-text" id="update_appointment_time" name="update_appointment_time" placeholder="Enter Your Appointment Date">
                           <span class="error_msg" id="update_appointment_time_error"></span>
                        </div>
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
      <!-- ======= Footer ======= -->
      <?php include 'common/footer.php';?><!-- End Footer -->
      <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <!-- Vendor JS Files -->
      <?php include 'common/jsfiles.php';?>
      <script type="text/javascript" src="<?=base_url()?>assets/view_js/receptionist/appointment.js"></script>
   </body>
</html>